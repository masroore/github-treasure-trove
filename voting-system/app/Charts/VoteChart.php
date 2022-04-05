<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Nominations;
use App\Models\Votes;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class VoteChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public ?string $name = 'votes';

    public ?string $routeName = 'votes';

    public function handler(Request $request): Chartisan
    {
        $labels = [];
        $count = [];

        $nominees = Nominations::where('season_id', $request->season)
            ->where('group_id', $request->group)
            ->where('stage_id', $request->stage)
            ->where('status', 0)
            ->get();

        $totalVotes = Votes::where('stage_id', $request->stage)
            ->where('season_id', $request->season)
            ->where('group_id', $request->group)
            ->where('status', 0)
            ->count();

        foreach ($nominees as $item) {
            $votes = Votes::where('artist_id', $item->artist->id)
                ->where('stage_id', $request->stage)
                ->where('season_id', $request->season)
                ->where('group_id', $request->group)
                ->where('status', 0)
                ->count();

            $percentage = $votes > 0 && $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;

            $labels[] = $item->artist->name;
            $count[] = $votes;
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('', $count);
    }
}
