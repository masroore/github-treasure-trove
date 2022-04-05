<?php

namespace App\Http\Controllers;

use App\Adv;
use DataTables;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('advertisements.view'), 403, __('User does not have the right permissions.'));

        $adv = Adv::select('id', 'layout', 'position', 'status')->get();

        if ($request->ajax()) {
            return DataTables::of($adv)
                ->addIndexColumn()->addColumn('layout', function ($row) {
                    return $row->layout;
                })->addColumn('pos', function ($row) {
                    if ('beforeslider' == $row->position) {
                        return $position = 'Before Slider';
                    }
                    if ('abovenewproduct' == $row->position) {
                        return $position = 'Above New Product Widget';
                    }
                    if ('abovetopcategory' == $row->position) {
                        return $position = 'Above Top Category Widget';
                    }
                    if ('abovelatestblog' == $row->position) {
                        return $position = 'Above Blog Widget';
                    }
                    if ('abovefeaturedproduct' == $row->position) {
                        return $position = 'Above Featured Product Widget';
                    }
                    if ('afterfeaturedproduct' == $row->position) {
                        return $position = 'After Featured Product Widget';
                    }
                })
                ->addColumn('status', 'admin.adv.status')
                ->addColumn('action', 'admin.adv.action')
                ->rawColumns(['layout', 'pos', 'status', 'action'])
                ->make(true);
        }

        return view('admin.adv.index', compact('adv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('advertisements.create'), 403, __('User does not have the right permissions.'));

        return view('admin.adv.add');
    }

    public function selectLayout(Request $request)
    {
        abort_if(!auth()->user()->can('advertisements.view'), 403, __('User does not have the right permissions.'));

        $request->validate(['layout' => 'required'], ['layout.required' => 'Select a layout first !']);

        if (isset($request->layout)) {
            $layout = ucfirst($request->layout);
            if ('Three Image Layout' == $layout || 'Two non equal image layout' == $layout || 'Two equal image layout' == $layout || 'Single image layout' == $layout) {
                return view('admin.adv.layout', compact('layout'));
            }

            return redirect()->route('adv.create')
                ->with('warning', __('404 ! Layout not found !'));
        }

        return redirect()
            ->route('adv.create')
            ->with('warning', __('Layout not selected !'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('advertisements.create'), 403, __('User does not have the right permissions.'));
        $layout = $request->layout;
        $newadv = new Adv();
        $input = $request->all();
        $input['layout'] = $layout;
        $input['position'] = $request->position;

        if (isset($request->status)) {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }

        if ('Three Image Layout' == $layout) {
            if ($file = $request->file('image1')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;
            }

            if ($file = $request->file('image2')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image2'] = $name;
            }

            if ($file = $request->file('image3')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image3'] = $name;
            }

            if ('linkbycat' == $request->img1linkby) {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ('linkbycat' == $request->img2linkby) {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }

            if ('linkbycat' == $request->img3linkby) {
                $input['cat_id3'] = $request->cat_id3;
                $input['pro_id3'] = null;
                $input['url3'] = null;
            } elseif ('linkbypro' == $request->img3linkby) {
                $input['pro_id3'] = $request->pro_id3;
                $input['cat_id3'] = null;
                $input['url3'] = null;
            } elseif ('linkbyurl' == $request->img3linkby) {
                $input['pro_id3'] = null;
                $input['cat_id3'] = null;
                $input['url3'] = $request->url3;
            }
        } elseif ('Two non equal image layout' == $layout) {
            if ($file = $request->file('image1')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images/adv', $name);
                $input['image1'] = $name;
            }

            if ($file = $request->file('image2')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images/adv', $name);
                $input['image2'] = $name;
            }

            if ('linkbycat' == $request->img1linkby) {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ('linkbycat' == $request->img2linkby) {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }
        } elseif ('Two equal image layout' == $layout) {
            if ($file = $request->file('image1')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(822, 303, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;
            }

            if ($file = $request->file('image2')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 303, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image2'] = $name;
            }

            if ('linkbycat' == $request->img1linkby) {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ('linkbycat' == $request->img2linkby) {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }
        } elseif ('Single image layout' == $layout) {
            if ($file = $request->file('image1')) {
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(1247, 520, function ($constraint): void {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;
            }

            if ('linkbycat' == $request->img1linkby) {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbypro' == $request->img2linkby) {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ('linkbyurl' == $request->img2linkby) {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }
        } else {
            return redirect()
                ->route('adv.create')
                ->with('warning', 'Invalid Layout !');
        }

        $newadv->create($input);

        return redirect()->route('adv.index')
            ->with('added', __('Advertisement has been created !'));
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('advertisements.edit'), 403, __('User does not have the right permissions.'));
        $adv = Adv::find($id);

        return view('admin.adv.edit', compact('adv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('advertisements.edit'), 403, __('User does not have the right permissions.'));

        $adv = Adv::find($id);

        if (isset($adv)) {
            $layout = $adv->layout;
            $input = $request->all();
            $input['layout'] = $layout;
            $input['position'] = $request->position;

            if (isset($request->status)) {
                $input['status'] = 1;
            } else {
                $input['status'] = 0;
            }

            if ('Three Image Layout' == $layout) {
                if ($file = $request->file('image1')) {
                    if ('' != $adv->image1 && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {
                    if ('' != $adv->image2 && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image2'] = $name;
                }

                if ($file = $request->file('image3')) {
                    if ('' != $adv->image3 && file_exists(public_path() . '/images/layoutads/' . $adv->image3)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image3);
                    }

                    $img = Image::make($file);
                    $destinationPath = public_path() . '/images/layoutads/';
                    $name = time() . $file->getClientOriginalName();
                    $img->resize(396, 396, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image3'] = $name;
                }

                if ('linkbycat' == $request->img1linkby) {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbypro' == $request->img1linkby) {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbyurl' == $request->img1linkby) {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ('linkbycat' == $request->img2linkby) {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbypro' == $request->img2linkby) {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbyurl' == $request->img2linkby) {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }

                if ('linkbycat' == $request->img3linkby) {
                    $input['cat_id3'] = $request->cat_id3;
                    $input['pro_id3'] = null;
                    $input['url3'] = null;
                } elseif ('linkbypro' == $request->img3linkby) {
                    $input['pro_id3'] = $request->pro_id3;
                    $input['cat_id3'] = null;
                    $input['url3'] = null;
                } elseif ('linkbyurl' == $request->img3linkby) {
                    $input['pro_id3'] = null;
                    $input['cat_id3'] = null;
                    $input['url3'] = $request->url3;
                }
            } elseif ('Two non equal image layout' == $layout) {
                if ($file = $request->file('image1')) {
                    if ('' != $adv->image1 && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(822, 303, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {
                    if ('' != $adv->image2 && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image2'] = $name;
                }

                if ('linkbycat' == $request->img1linkby) {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbypro' == $request->img1linkby) {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbyurl' == $request->img1linkby) {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ('linkbycat' == $request->img2linkby) {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbypro' == $request->img2linkby) {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbyurl' == $request->img2linkby) {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }
            } elseif ('Two equal image layout' == $layout) {
                if ($file = $request->file('image1')) {
                    if ('' != $adv->image1 && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(609, 342, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {
                    if ('' != $adv->image2 && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(609, 342, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image2'] = $name;
                }

                if ('linkbycat' == $request->img1linkby) {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbypro' == $request->img1linkby) {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbyurl' == $request->img1linkby) {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ('linkbycat' == $request->img2linkby) {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbypro' == $request->img2linkby) {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ('linkbyurl' == $request->img2linkby) {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }
            } elseif ('Single image layout' == $layout) {
                if ($file = $request->file('image1')) {
                    if ('' != $adv->image1 && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(1247, 520, function ($constraint): void {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;
                }

                if ('linkbycat' == $request->img1linkby) {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbypro' == $request->img1linkby) {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ('linkbyurl' == $request->img1linkby) {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }
            } else {
                return redirect()
                    ->route('adv.create')
                    ->with('warning', __('Invalid Layout !'));
            }

            $adv->update($input);

            return redirect()->route('adv.index')
                ->with('added', __('Advertisement has been Updated !'));
        }

        return redirect()
            ->route('adv.index')
            ->with('warning', __('404 Adv Not found !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('advertisements.delete'), 403, __('User does not have the right permissions.'));

        $adv = Adv::find($id);

        if (isset($adv)) {
            if ('Three Image Layout' == $adv->layout) {
                if ('' != $adv->image1) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

                if ('' != $adv->image2) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }

                if ('' != $adv->image3) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image3)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image3);
                    }
                }
            } elseif ('Two non equal image layout' == $adv->layout) {
                if ('' != $adv->image1) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

                if ('' != $adv->image2) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }
            } elseif ('Two Equal Image Layout' == $adv->layout) {
                if ('' != $adv->image1) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

                if ('' != $adv->image2) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }
            } elseif ('Single Image Layout' == $adv->layout) {
                if ('' != $adv->image1) {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }
            }
            $adv->delete();

            return back()
                ->with('deleted', __('Advertisement has been deleted !'));
        }

        return back()
            ->with('warning', __('404 Advertisement not found !'));
    }
}
