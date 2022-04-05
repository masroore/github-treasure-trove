<?php

namespace App\Http\Controllers\Back\Api1;

use App\Http\Controllers\Controller;
use App\Models\Back\Marketing\Slider\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $sliders = $request['data'] ?? 0;
        $group = $request['group'] ?? 0;

        Log::info($request);

        if ($sliders) {
            $dir = config('filesystems.disks.slider.root') . $group;
            $path = config('filesystems.disks.slider.url') . $group;

            $this->cleanState($dir, $group);

            foreach ($sliders as $slider) {
                Image::make($slider['file_url'])->save($dir . '/' . $slider['filename']);

                $slider['image'] = $path . '/' . $slider['filename'];

                $stored[] = Slider::store($slider, $group);
            }

            return response()->json(['success' => 'Fotografija uspješno postavljena!', 'data' => $stored]);
        }

        return response()->json(['error' => 'Greška kod postavljanja fotografije! Pokušajte ponovo.']);
    }

    /**
     * @param $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($group)
    {
        $sliders = Slider::where('group_id', $group)->get();

        for ($i = 0; $i < \count($sliders); ++$i) {
            $path = asset($sliders[$i]->image);
            $type = pathinfo($path, \PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $sliders[$i]->baseimage = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return response()->json($sliders);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * @param $directory
     * @param $group
     *
     * @return bool
     */
    private function cleanState($directory, $group)
    {
        Slider::where('group_id', $group)->delete();

        if (!File::exists($directory)) {
            File::makeDirectory($directory);
        }

        return File::cleanDirectory($directory);
    }
}
