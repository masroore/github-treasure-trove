<?php

namespace App\Console\Commands;

use App\MiniBetting;
use App\MiniBetType;
use App\MiniEvent;
use App\MiniEventSchedule;
use App\MiniResult;
use App\MiniSport;
use App\MoneyList;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetNamed extends Command
{
    protected $signature = 'get:named {game}';

    protected $description = 'Named Get';

    private $game;

    private $url = [];

    public function __construct()
    {
        parent::__construct();
        $this->url['ladder'] = 'http://ladder.named.com/result_list?callback=jQuery' . time() . '&_=' . time();
        $this->url['dari'] = 'http://daridari.named.com/result?_=' . time();
        // $this->url['racing'] = 'http://named.com/data/games/racing/result.json?date=' . time() ;
        $this->url['racing'] = 'http://named.com/data/games/racing/rank_result.json?date=' . time();
        $this->url['powerball'] = 'http://ntry.com/data/json/games/powerball/result.json?_=' . time();
    }

    public function handle(): void
    {
        $game = $this->argument('game');

        if ($game == 'build') {
            $this->makeEvents();
        } elseif ($game == 'closing') {
            $this->closing();
        } else {
            for ($i = 0; $i < 5; ++$i) {
                $ret = $this->doMain($game);

                sleep(2);
            }
            $this->closing();
        }
    }

    public function closing(): void
    {
        $sports = MiniSport::all();
        foreach ($sports as $sport) {
            echo $sport->name . "\n";

            echo $sport->id . "\n";

            if ($sport->id == 4) {

          // DB::enableQueryLog();
            }

            $results = MiniResult::where('mini_sport_id', $sport->id)
                ->where('status', 'waiting')
                ->orderBy('event_date', 'desc')
                ->orderBy('round', 'desc')
                ->limit(4)
                ->get();

            if ($sport->id == 4) {

          // dd(DB::getQueryLog());

          // dd($results->toArray());
            }

            foreach ($results as $result) {
                echo 'result ======= ' . $result->id . "\n";

                $events = MiniEvent::where('mini_sport_id', $sport->id)
                    ->where('mini_event_schedule_id', $result->mini_event_schedule_id)
                    ->where('round', $result->round)
                    ->where('event_date', $result->event_date)
                    ->get();

                echo '---- events' . "\n";

                foreach ($events as $event) {
                    echo 'event_id = ' . $result->event_id . "\n";
                    $bettings = MiniBetting::where('mini_sport_id', $sport->id)
                        ->where('mini_event_id', $event->id)
                        ->where('round', $event->round)->get();

                    foreach ($bettings as $betting) {
                        echo 'betting_id = ' . $betting->id . "\n";

                        $mini_bet_type_id = $betting->mini_bet_type_id;
                        $this->checkWinLose($sport->name, $betting, $mini_bet_type_id, $result);
                    }
                    $event->status = 'closed';
                    $event->save();
                }

                $result->status = 'closed';
                $result->save();
            }
        }
    }

    public function checkWinLose($sport_name, $betting, $bet_type_id, $result): void
    {
        $json = json_decode($result->result, true);

        $bet_type = MiniBetType::find($bet_type_id);

        if ($sport_name == 'ladder') {
            if ($bet_type->key === 'oe') {
                if ($betting->side == strtolower($json['oe'])) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key === 'line') {
                if ($betting->side == $json['lines']) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            }
        } elseif ($sport_name == 'dari') {
            if ($bet_type->key === 'oe') {
                if ($betting->side == strtolower($json['oe'])) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key === 'line') {
                if ($betting->side == $json['lines']) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            }
        } elseif ($sport_name == 'racing') {
            if ($bet_type->key === 'oe') {
                $ranks = explode(',', $json['rank']);

                if ($ranks[0] % 2 == 0 && $betting->side == 'even') {
                    $this->winMoney($betting);
                } elseif ($ranks[0] % 2 == 1 && $betting->side == 'odd') {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key == 'pick') {
                $ranks = explode(',', $json['rank']);
                if ($ranks[0] == $betting->side) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            }
        } elseif ($sport_name == 'powerball') {
            if ($bet_type->key === 'pow_ball_oe') {
                if ($betting->side == $this->kortoEng(strtolower($json['pow_ball_oe']))) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key == 'pow_ball_unover') {
                if ($betting->side == $this->kortoEng(strtolower($json['pow_ball_unover']))) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key == 'def_ball_oe') {
                if ($betting->side == $this->kortoEng(strtolower($json['def_ball_oe']))) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key == 'pow_ball_oe_unover') {
                $oe = $this->kortoEng(strtolower($json['pow_ball_oe']));
                $uo = $this->kortoEng(strtolower($json['pow_ball_unover']));

                if ($betting->side == $oe . '_' . $uo) {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            } elseif ($bet_type->key == 'def_ball_sum_unover') {
                $balls = $json['ball'];
                array_pop($balls);

                $sum = 0;
                foreach ($balls as $ball) {
                    $sum += (int) $ball;
                }
                if ($sum >= 15 && $sum <= 72 && $betting->side == 'under') {
                    $this->winMoney($betting);
                } elseif ($sum >= 73 && $sum <= 130 && $betting->side == 'over') {
                    $this->winMoney($betting);
                } else {
                    $betting->status = 'closed';
                    $betting->result = 'lose';
                    $betting->save();
                }
            }

            // {"event_date":"2019-08-15","round":2,"pow_ball_oe":"\uc9dd","pow_ball_unover":"\uc5b8\ub354","def_ball_sum":"67","def_ball_unover":"\uc5b8\ub354","def_ball_size":"\uc911","def_ball_section":"E"}
        }

        // {"event_date":"2019-08-13","round":"74","side":"RIGHT","lines":"4","oe":"EVEN"}

      // if(  $bet_type->key === "oe"  ) {
      //   if(  in_array( $sport_name , ["ladder", "dari" ] ) ) {

      //     if( $betting->side == strtolower( $json["oe"]) ){

      //         $this->winMoney( $betting);
      //     } else {

      //         $betting->status ="closed";
      //         $betting->result ="lose";
      //         $betting->save();
      //     }

      //   } elseif( $sport_name=="racing") {
      //       $ranks = explode(",",  $json["rank"] );

      //       if( $ranks[0] % 2 == 0 && $betting->side =="even" ){
      //           $this->winMoney( $betting);
      //       } elseif( $ranks[0] % 2 == 1 && $betting->side =="odd" ){
      //           $this->winMoney( $betting);
      //       } else {
      //           $betting->status ="closed";
      //           $betting->result ="lose";
      //           $betting->save();
      //       }

      //   } elseif( $sport_name=="powerball") {

      //   }
      // } elseif( $bet_type->key =="line") {
      //     if(  in_array( $sport_name , ["ladder", "dari" ] ) ) {
      //         if( $betting->side == $json["lines"] ){
      //           $this->winMoney( $betting);
      //         } else {
      //           $betting->status ="closed";
      //           $betting->result ="lose";
      //           $betting->save();
      //         }

      //     } elseif( $sport_name=="powerball") {

      //     }

      // } elseif( $bet_type->key =="uo") {
      //     if(  in_array( $sport_name , ["ladder", "dari" ] ) ) {

      //     } elseif( $sport_name=="powerball") {

      //     }

      // } elseif( $bet_type->key =="pick") {
      //     if(  in_array( $sport_name , ["ladder", "dari" ] ) ) {

      //     } elseif( $sport_name=="racing") {
      //         $ranks = explode(",",  $json["rank"] );
      //         if( $ranks[0] == $betting->side  ){
      //             $this->winMoney( $betting);
      //         } else {
      //           $betting->status ="closed";
      //           $betting->result ="lose";
      //           $betting->save();
      //         }
      //     } elseif( $sport_name=="powerball") {

      //     }
      // }
    }

    public function kortoEng($str)
    {
        switch ($str) {
        case '언더':
          $ret = 'under';

          break;
        case '오버':
          $ret = 'over';

          break;

        case '홀':
          $ret = 'odd';

          break;
        case '짝':
          $ret = 'even';

          break;
        case '3줄':
          $ret = 3;

          break;
        case '4줄':
          $ret = 4;

          break;

        default:
          $ret = $str;

          break;
      }

        return $ret;
    }

    public function winMoney($betting): void
    {
        echo 'winMoney ' . "\n";
        $rewards = (int) ((float) $betting->odds * (float) $betting->amount);

        $betting->rewards = $rewards;
        $betting->status = 'closed';
        $betting->result = 'win';
        $betting->save();

        $user = User::find($betting->user_id);

        if ($betting->chip == 'coin') {
            $user->coins = $user->coins + $rewards;
        } elseif ($betting->chip == 'point') {
            $user->coins = $user->coins + $rewards;
        }
        $user->save();

        $money_list = MoneyList::create([
            'user_id' => $user->id,
            'betting_id' => $betting->id,
            'type' => '당첨',
            'amount' => $betting->amount,
        ]);
    }

    public function doMain($game)
    {
        $response = $this->getRemoteApi($this->url[$game]);

        if (!$response) {
            $code = 'error';
            $msg = ' no API Data ';

            return false;
        }

        echo 'game : ' . $game . "\n";

        if ($game == 'ladder') {
            $mini_sport_id = 1;
            $json = $this->callLadder($game, $response);
        } elseif ($game == 'dari') {
            $mini_sport_id = 2;
            $json = $this->callDari($game, $response);
        } elseif ($game == 'racing') {
            $mini_sport_id = 3;
            $json = $this->callRacing($game, $response);
        } elseif ($game == 'powerball') {
            $mini_sport_id = 4;
            $json = $this->callPowerBall($game, $response);
        }

        return $this->saveDB($mini_sport_id, $game, $json);
    }

    public function saveDB($mini_sport_id, $game, $json)
    {
        $data_string = json_encode($json);

        $mini_event_schedule = MiniEventSchedule::where('mini_sport_id', $mini_sport_id)->where('round', (int) $json['round'])->first();

        $result = MiniResult::firstOrCreate(
            ['mini_sport_id' => $mini_sport_id, 'mini_event_schedule_id' => $mini_event_schedule->id, 'game' => $game, 'event_date' => $json['event_date'], 'round' => $json['round']],
            ['result' => $data_string]
        );

        return $result;
    }

    public function callPowerBall($game, $response)
    {

      // {
        // date: "2019-08-14",
        // times: "915793",
        // date_round: 283,
        // ball: [
        // 9,
        // 14,
        // 23,
        // 8,
        // 3,
        // "7"
        // ],
        // pow_ball_oe: "홀",
        // pow_ball_unover: "오버",
        // def_ball_sum: "57",
        // def_ball_oe: "홀",
        // def_ball_unover: "언더",
        // def_ball_size: "소",
        // def_ball_section: "C"
        // }

        $vdata = json_decode($response, true);

        $out = [];
        $out['event_date'] = $vdata['date'];
        $out['round'] = $vdata['date_round'];
        $out['ball'] = $vdata['ball'];

        $out['pow_ball_oe'] = $vdata['pow_ball_oe'];

        $out['pow_ball_unover'] = $vdata['pow_ball_unover'];

        $out['def_ball_oe'] = $vdata['def_ball_oe'];

        $out['def_ball_unover'] = $vdata['def_ball_unover'];

        $out['def_ball_size'] = $vdata['def_ball_size'];
        $out['def_ball_section'] = $vdata['def_ball_section'];

        return $out;
    }

    public function callLadder($game, $response)
    {
        $start_string = '({';
        $end_string = '});';
        $str = '{' . getStringBetween($response, $start_string, $end_string) . '}';
        $vdata = json_decode($str, true);

        $data = $vdata['data'][0];

        $out = [];
        $out['event_date'] = $data['d'];
        $out['round'] = $data['r'];
        $out['side'] = $data['s'];
        $out['lines'] = $data['l'];
        $out['oe'] = $data['o'];

        return $out;

        // foreach( $datum as $data){
      //   $out['date']  = $data['d'];
      //   $out['round']  = $data['r'];

      //   $out['side']  = $data['s'];
      //   $out['lines']  = $data['l'];
      //   $out['oe']  = $data['o'];

      // }
    }

    public function callDari($game, $response)
    {
        // {"d":"2019-06-30","r":"131","s":"RIGHT","l":"4","o":"EVEN"}
        // Convert JSON string to Array
        $data = json_decode($response, true);
        $out = [];
        $out['event_date'] = $data['d'];
        $out['round'] = $data['r'];
        $out['side'] = $data['s'];
        $out['lines'] = $data['l'];
        $out['oe'] = $data['o'];

        return $out;

        // [d] => 2019-06-30
      // [r] => 143
      // [s] => RIGHT
      // [l] => 3
      // [o] => ODD
    }

    public function repl($str)
    {
        return str_replace('snail', '', $str);
    }

    public function callRacing($game, $response)
    {
        $data = json_decode($response, true);

        $out = [];
        $out['event_date'] = $data['reg_date'];
        $out['round'] = $data['turn'];
        // $out['rank'] = $data['rank'];

        $tmp = [];

        $r1 = $this->repl($data['rank1']);
        $r2 = $this->repl($data['rank2']);
        $r3 = $this->repl($data['rank3']);
        $r4 = $this->repl($data['rank4']);

        $out['rank'] = implode(',', [$r1, $r2, $r3, $r4]);

        return $out;

        // reg_dt
      // round
      // rank
    }

    public function getRemoteApi($url)
    {
        $client = new Client();
        $res = $client->request('GET', $url, [
            // 'auth' => ['user', 'pass']
        ]);
        $status = $res->getStatusCode();
        // "200"
        // echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        if ($status == '200') {
            return $res->getBody();
        }

        return false;
    }

    public function makeEvents(): void
    { // 하루에 한번 실행
        $today = date('Y-m-d H:i:s');

        $sports = MiniSport::all()->pluck('name');

        $sports = ['ladder', 'dari', 'racing', 'powerball'];

        foreach ($sports as $game) {
            if ($game == 'ladder') {
                $mini_sport_id = 1;
                $max_round = 288;
                $add_min = 5;
            } elseif ($game == 'dari') {
                $mini_sport_id = 2;
                $max_round = 480;
                $add_min = 3;
            } elseif ($game == 'racing') {
                $mini_sport_id = 3;
                $max_round = 480;
                $add_min = 3;
            } elseif ($game == 'powerball') {
                $mini_sport_id = 4;
                $max_round = 288;
                $add_min = 5;
            }

            // ##### 중요.... 실제 운영시 today - > tomorrow 로 변경할것..
            //
            //
            if ($game == 'powerball') {
                $event_time = Carbon::today()->startOfDay()->addMinutes(-2);
            } else {
                $event_time = Carbon::today()->startOfDay();
            }

            $event_date = Carbon::today()->toDateString();
            // $event_time = Carbon::tomorrow()->startOfDay();

            for ($i = 1; $i <= $max_round; ++$i) {
                $event_time = $event_time->addMinutes($add_min);
                $round = $i;

                $mini_bet_types = MiniBetType::where('mini_sport_id', $mini_sport_id)->get();

                $schedule_time = $event_time->toTimeString();
                $mini_event_schedule = MiniEventSchedule::firstOrCreate(
                    ['mini_sport_id' => $mini_sport_id, 'game' => $game, 'schedule_time' => $schedule_time, 'round' => $round,
                    ]
                );

                foreach ($mini_bet_types as $mini_bet_type) {
                    MiniEvent::firstOrCreate(
                        ['mini_sport_id' => $mini_sport_id,
                            'mini_event_schedule_id' => $mini_event_schedule->id,
                            'game' => $game,
                            'event_date' => $event_date,
                            'event_time' => $event_time,
                            'round' => $round,
                            'mini_bet_type_id' => $mini_bet_type->id,
                            'side1_odd' => $mini_bet_type->side1_odd,
                            'side2_odd' => $mini_bet_type->side2_odd,
                            'side3_odd' => $mini_bet_type->side3_odd,
                            'side4_odd' => $mini_bet_type->side4_odd,
                        ]
                    );
                }
            }
        }
    }
}
