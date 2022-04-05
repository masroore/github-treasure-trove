<?php

//
// https://github.com/nesk/PuPHPeteer
//
// https://github.com/nesk/puphpeteer

// composer require nesk/puphpeteer
// npm install @nesk/puphpeteer

// https://packagist.org/packages/aktuba/php-puppeteer

// composer require aktuba/php-puphpeteer
// npm install @nesk/puphpeteer

namespace App\Console\Commands;

use App\Betting;
use App\BetType;
use App\Event;
use App\EventInfo;
use App\Models\EventListHtml;
use App\MoneyList;
use App\OddLink;
use App\Result;
use App\ResultListHtml;
use App\Sport;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use Sunra\PhpSimple\HtmlDomParser;

// try {
//     $page->tryCatch->goto('invalid_url');
// } catch (Node\Exception $exception) {
//     // Handle the exception...
// }

// 배당칸 만들기
//   단승 1착에 갯수만큼
//   복승  1,2,착에 갯수만큼
//   쌍승  복승과 동일
//   삼복승 1,2,3 착에 갯수만큼
//   삼쌍승 -> 삼복승과 동일
//   복승조합/ 쌍승조합 / 삼복승조합 - > 1착에 갯수만큼
//
class ParseEvent extends Command
{
    protected $signature = 'parse:event {mode}';

    protected $description = 'Command description';

    protected $mainPage = 'http://ssm28.com/Pages/Main.aspx';

    protected $loginPage = 'http://ssm28.com/Pages/Login.aspx';

    protected $page;

    protected $activeSports;

    protected $allSports;

    protected $betting_link;

    public function __construct()
    {
        parent::__construct();
        // $this->allSports = $this->getSports();
        $this->activeSports = [];
        $this->betting_link = 'http://ssm28.com/Pages/Bet/Betting.aspx?RaceCode=';
    }

    public function handle(): void
    {
        $mode = $this->argument('mode');
        if ($mode == 'init') {
            $this->init();
            $this->getEventList();
            $this->getResultList();
            $this->goBettingSite();
        } elseif ($mode == 'result') {
            $this->init();
            $this->getEventList();
            $this->getResultList();
            $this->doClosing();
        } elseif ($mode == 'closing') {
            $this->doClosing();
        } elseif ($mode == 'test') {

            // $this->init();
            // $this->goBettingSite();
        }

        // $event_id = 39 ;
        // $event = Event::find($event_id);
        // $result = Result::where('event_id', $event_id)->first();

        // $user = User::where('id', $event->user_id)->first();
        // $this->doClosing($event, $result);

        // $this->frameTest();
    }

    public function goBettingSite(): void
    {
        $url = 'http://ssm28.com/Pages/Bet/Betting.aspx?idx=';
        // $events = Event::where('event_date', date('Y-m-d'))->where('betting_avail', 'Y')->orderBy('event_time', 'asc')->get();

        $events = Event::where('event_date', date('Y-m-d'))->orderBy('event_time', 'asc')->get();
        foreach ($events as $event) {
            $html = $this->getIframeHTML($event);

            // echo $html ;
            // echo '\n\n';
            // $html = $this->page->querySelector( $selector_content )->getProperty('innerHTML')->jsonValue(); ;
        }
    }

    public function getIframeHTML($event): void
    {
        $frame_id = '#ifr_Bedang';
        $table_id = '#div_Bedang_Content';
        $url = 'http://ssm28.com/Pages/Bet/Betting.aspx?idx=' . $event->reference_id;

        echo 'url = ' . $url . "\n\n";

        $this->page->goto($url);
        sleep(4);

        $vt = [];
        $vt['event_id'] = $event->id;

        $vt['int_Temp_Buy_Money'] = $this->page->evaluate('int_Temp_Buy_Money');
        $vt['str_Choice_Seng_Sik'] = $this->page->evaluate('str_Choice_Seng_Sik');
        $vt['str_Race_Stay'] = $this->page->evaluate('str_Race_Stay');
        $vt['str_Cash_Point'] = $this->page->evaluate('str_Cash_Point');

        $vt['str_Player_Count'] = $this->page->evaluate('str_Player_Count');
        $vt['str_Cancel_Num'] = $this->page->evaluate('str_Cancel_Num');
        $vt['str_RaceID'] = $this->page->evaluate('str_RaceID');
        $vt['str_RaceCode'] = $this->page->evaluate('str_RaceCode');
        $vt['str_RaceRound'] = $this->page->evaluate('str_RaceRound');

        $vt['str_RacePlace'] = $this->page->evaluate('str_RacePlace');
        $vt['str_RaceDate'] = $this->page->evaluate('str_RaceDate');
        $vt['str_JM_Place_Code'] = $this->page->evaluate('str_JM_Place_Code');
        $vt['str_JJ_Place_Code'] = $this->page->evaluate('str_JJ_Place_Code');
        $vt['str_JR_Place_Code'] = $this->page->evaluate('str_JR_Place_Code');

        $vt['str_JB_Place_Code'] = $this->page->evaluate('str_JB_Place_Code');
        $vt['str_OddsAddress'] = $this->page->evaluate('str_OddsAddress');
        $vt['str_RaceSettlement'] = $this->page->evaluate('str_RaceSettlement');

        $event_info = EventInfo::updateOrCreate(
            ['event_id' => $vt['event_id']],
            [
                'int_Temp_Buy_Money' => $vt['int_Temp_Buy_Money'],
                'str_Choice_Seng_Sik' => $vt['str_Choice_Seng_Sik'],
                'str_Race_Stay' => $vt['str_Race_Stay'],
                'str_Cash_Point' => $vt['str_Cash_Point'],

                'str_Player_Count' => $vt['str_Player_Count'],
                'str_Cancel_Num' => $vt['str_Cancel_Num'],
                'str_RaceID' => $vt['str_RaceID'],
                'str_RaceCode' => $vt['str_RaceCode'],
                'str_RaceRound' => $vt['str_RaceRound'],

                'str_RacePlace' => $vt['str_RacePlace'],
                'str_RaceDate' => $vt['str_RaceDate'],
                'str_JM_Place_Code' => $vt['str_JM_Place_Code'],
                'str_JJ_Place_Code' => $vt['str_JJ_Place_Code'],
                'str_JR_Place_Code' => $vt['str_JR_Place_Code'],

                'str_JB_Place_Code' => $vt['str_JB_Place_Code'],
                'str_OddsAddress' => $vt['str_OddsAddress'],
                'str_RaceSettlement' => $vt['str_RaceSettlement'],
            ]
        );

        // video iframe 꺼 분석
        $frame_id = '#ifr_Movie';
        // http://blue.ssm56.com/Pages/Odds_JR.aspx?RaceDate=2019-08-08&RacePlace=시즈오카&RaceRound=1&Combine=ss

        $frame_video = $this->page->querySelector($frame_id);
        $frame_video_url = $frame_video->getProperty('src')->jsonValue();

        $event->video_link = $frame_video_url;
        $event->save();

        // iframe 꺼 분석
        $frame_id = '#ifr_Bedang';
        // http://blue.ssm56.com/Pages/Odds_JR.aspx?RaceDate=2019-08-08&RacePlace=시즈오카&RaceRound=1&Combine=ss

        $frame = $this->page->querySelector($frame_id);
        $url_simple_tmp = $frame->getProperty('src')->jsonValue();

        $url_simple = explode('?', $url_simple_tmp);
        $bet_type_url = $url_simple[0];
        $qq = $url_simple[1];
        parse_str($qq, $data);

        $bet_type_id = '#div_SengSik_Btn_Con';
        $html = $this->page->querySelector($bet_type_id)->getProperty('innerHTML')->jsonValue();

        $dom = HtmlDomParser::str_get_html($html);
        $divs = $dom->find('div');

        $bet_type_btns = [];
        foreach ($divs as $div) {
            if ($div->id == 'div_Btn_DS') {
                $bet_type_btns[] = 'ds';
            } elseif ($div->id == 'div_Btn_BS') {
                $bet_type_btns[] = 'bs';
            } elseif ($div->id == 'div_Btn_SS') {
                $bet_type_btns[] = 'ss';
            } elseif ($div->id == 'div_Btn_SBS') {
                $bet_type_btns[] = 'sbs';
            } elseif ($div->id == 'div_Btn_SSS') {
                $bet_type_btns[] = 'sss';
            } elseif ($div->id == 'div_Btn_BSJ') {
                $bet_type_btns[] = 'bsj';
            } elseif ($div->id == 'div_Btn_SSJ') {
                $bet_type_btns[] = 'ssj';
            } elseif ($div->id == 'div_Btn_SBJ') {
                $bet_type_btns[] = 'sbj';
            }
        }

        foreach ($bet_type_btns as $btn) {
            $bet_type = BetType::where('key', $btn)->first();

            if (in_array($event->sport->id, [5, 6, 7]) && in_array($btn, ['bsj', 'ssj', 'sbj'])) {
                if ($btn == 'bsj') {
                    $data['Combine'] = 'bs';
                } elseif ($btn == 'ssj') {
                    $data['Combine'] = 'ss';
                } elseif ($btn == 'sbj') {
                    $data['Combine'] = 'sbs';
                }
            } else {
                $data['Combine'] = $btn;
            }

            $q = http_build_query($data);
            $url_iframe = $bet_type_url . '?' . $q;

            $odd_link = OddLink::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'bet_type_id' => $bet_type->id,
                    'bet_type_key' => $btn,
                ],
                [
                    'link' => $url_iframe,
                ]
            );

            if ($odd_link) {
                echo ' ok ' . "\n";
            } else {
                echo ' no ' . "\n";
            }
        }

        $this->backupme();
        // dd('done');

        // $frame = $this->page->querySelector( $frame_id);
        // $frameContent = $frame->contentFrame();
        // return $frameContent->querySelector( $table_id )->getProperty('innerHTML')->jsonValue(); ;
    }

    public function frameTest(): void
    {
        $frame_id = '#ifr_Content';

        $this->page->goto($this->mainPage);
        $frame = $this->page->querySelector($frame_id);
        $frameContent = $frame->contentFrame();

        $html = $frameContent->querySelector('#div_Kr_Race_List')->getProperty('outerHTML')->jsonValue();
    }

    public function getResultList(): void
    {
        echo 'getResultList  .....' . "\n";

        $check_date = date('Y-m-d');

        $sports = Sport::all();

        $url = 'http://ssm28.com/Pages/Bet/BetSub/Sub_Race_Result.aspx';

        $selector = '#div_Content_Con';

        $this->page->goto($url);

        foreach ($sports as $sport) {
            echo 'sport_name = ' . $sport->id . ' : ' . $sport->key . ' : ' . $sport->name . "\n\n";

            $selector_select = '#ddl_RaceCode';
            $selector_content = '#div_Content_Con';

            $this->page->select($selector_select, $sport->key);
            sleep(3);

            $html = $this->page->querySelector($selector_content)->getProperty('innerHTML')->jsonValue();

            $dom = HtmlDomParser::str_get_html($html);
            $trs = $dom->find('tr');

            echo 'trs count = ' . count($trs) . "\n";

            $ii = 0;
            foreach ($trs as $tr) {
                if ($ii == 0) {
                    ++$ii;

                    continue;
                }
                // echo trim( $tr->plaintext ) . "\n";

                $tds = $tr->find('td');
                $i = 0;

                $data = [];
                $data['sport'] = $sport->name;
                $data['check_date'] = $check_date;
                foreach ($tds  as $td) {
                    switch ($i) {
                        case 0:
                            $area_round = explode(' ', trim($td->plaintext));
                            $data['area'] = $area_round[0];
                            $data['round'] = $area_round[1];
                            // no break
                        case 1:
                            $data['win1'] = trim($td->plaintext);

break;
                        case 2:
                            $data['win2'] = trim($td->plaintext);

break;
                        case 3:
                            $data['win3'] = trim($td->plaintext);

break;
                        case 4:
                            $data['odds_ds'] = trim($td->plaintext);

break;
                        case 5:
                            $data['odds_bs'] = trim($td->plaintext);

break;
                        case 6:
                            $data['odds_ss'] = trim($td->plaintext);

break;
                        case 7:
                            echo 'odds_bys';
                            echo "\n";
                            echo trim($td->plaintext);
                            echo "\n";
                            $data['odds_bys'] = trim($td->plaintext);

break;
                            // 복연승 1/2/1.5
                        case 8:
                            $data['odds_sbs'] = trim($td->plaintext);

break;
                            // 삼복승
                        case 9:
                            $data['odds_sss'] = trim($td->plaintext);

break;
                            // 삼쌍승
                    }

                    ++$i;
                }

                echo 'error' . "\n";

                print_r($data);

                $res = ResultListHtml::firstOrCreate(
                    ['sport' => $data['sport'], 'area' => $data['area'], 'round' => $data['round'], 'check_date' => $data['check_date'],
                    ],
                    ['win1' => $data['win1'], 'win2' => $data['win2'], 'win3' => $data['win3'],
                        'odds_ds' => $data['odds_ds'], 'odds_bs' => $data['odds_bs'],
                        'odds_ss' => $data['odds_ss'], 'odds_bys' => $data['odds_bys'], 'odds_sbs' => $data['odds_sbs'],
                        'odds_sss' => $data['odds_sss'],
                    ]
                );

                $event = Event::where('sport_id', $sport->id)
                    ->where('area', $data['area'])
                    ->where('round', $data['round'])
                    ->orderBy('id', 'desc')->first();
                echo '-----------------------' . "\n";
                echo 'event ';
                echo "\n\n";
                echo 'event id : ' . $event->id . "\n";

                if ($event) {
                    $result = Result::firstOrCreate(
                        [
                            'event_id' => $event->id,
                            'sport_id' => $sport->id,
                            'area' => $data['area'],
                            'round' => $data['round'],
                            'numbers' => $event->numbers,
                            'distance' => $event->distance,
                            'event_date' => $data['check_date'],
                        ],
                        [
                            'event_time' => $event->event_time,
                            'win1' => $data['win1'],
                            'win2' => $data['win2'],
                            'win3' => $data['win3'],
                            'odds_ds' => $data['odds_ds'],
                            'odds_bs' => $data['odds_bs'],
                            'odds_ss' => $data['odds_ss'],
                            'odds_bys' => $data['odds_bys'],
                            'odds_sbs' => $data['odds_sbs'],
                            'odds_sss' => $data['odds_sss'],
                        ]
                    );
                } else {
                    echo 'no event ' . $event->id . "\n";
                }
            }
        }
    }

    public function doClosing(): void
    {
        $stime = Carbon::now()->subHour()->toDateTimeString();
        $etime = Carbon::now()->toDateTimeString();

        $events = Event::whereBetween('event_time', [$stime, $etime])
            ->where('closed_auto', 0)
            ->where('status', '완료')
            ->get();
        $events = Event::where('closed_auto', 0)
            ->where('status', '완료')
            ->get();

        foreach ($events as $event) {
            $result = Result::where('event_id', $event->id)->first();

            if (!$result) {
                continue;
            }

            $bettings = Betting::where('event_id', $event->id)
                ->where('status', '<>', 'closed')->get();

            $is_error = false;
            // dd($bettings->toArray());
            foreach ($bettings as $betting) {
                $bet_type_id = $betting->bet_type_id;
                $bet_type = BetType::find($bet_type_id);

                if ($event->status == '취소') {
                    $amount = $betting->amount;
                    $user = User::where('id', $betting->user->id)->first();
                    if ($betting->chip == 'coin') {
                        $user->coins = $user->coins + $amount;
                    } elseif ($betting->chip == 'point') {
                        $user->points = $user->points + $amount;
                    }

                    MoneyList::create([
                        'user_id' => $user->id,
                        'betting_id' => $betting->id,
                        'type' => '경기취소',
                        'amount' => $betting->amount,
                    ]);

                    $user->save();

                    $betting->status = 'cancel';
                    $betting->save();

                    continue;
                }

                if ($bet_type->key == 'ds') {
                    $odds = $result->odds_ds;
                    $tt = explode('/', $result->win1);
                    if (in_array($betting->arrive1, $tt)) {
                        $out = 'win';
                    } else {
                        $out = 'lose';
                    }
                } elseif ($bet_type->key == 'bs') {
                    $odds = $result->odds_bs;
                    $tt1 = explode('/', $result->win1);
                    $tt2 = explode('/', $result->win2);
                    $tt = array_merge($tt1, $tt2);

                    if (in_array($betting->arrive1, $tt) && in_array($betting->arrive2, $tt)) {
                        $out = 'win';
                    } else {
                        $out = 'lose';
                    }
                } elseif ($bet_type->key == 'ss') {
                    $odds = $result->odds_ss;
                    $tt1 = explode('/', $result->win1);
                    $tt2 = explode('/', $result->win2);

                    if (in_array($betting->arrive1, $tt1) && in_array($betting->arrive2, $tt2)) {
                        $out = 'win';
                    } else {
                        $out = 'lose';
                    }
                } elseif ($bet_type->key == 'sbs') {
                    $odds = $result->odds_sbs;
                    $tt1 = explode('/', $result->win1);
                    $tt2 = explode('/', $result->win2);
                    $tt3 = explode('/', $result->win3);
                    $tt = array_merge($tt1, $tt2, $tt3);

                    if (in_array($betting->arrive1, $tt) && in_array($betting->arrive2, $tt) && in_array($betting->arrive3, $tt)) {
                        $out = 'win';
                    } else {
                        $out = 'lose';
                    }
                } elseif ($bet_type->key == 'sss') {
                    $odds = $result->odds_sss;
                    $tt1 = explode('/', $result->win1);
                    $tt2 = explode('/', $result->win2);
                    $tt3 = explode('/', $result->win3);

                    if (in_array($betting->arrive1, $tt1) && in_array($betting->arrive2, $tt2) && in_array($betting->arrive3, $tt3)) {
                        $out = 'win';
                    } else {
                        $out = 'lose';
                    }
                }

                if ($out == 'win') {
                    $amount = $betting->amount;
                    $odd_tmp = explode('/', $odds);
                    if (count($odd_tmp) > 1) {
                        $betting->closing = 'hold';
                        $betting->save();
                        $is_error = true;

                        continue;
                    }
                    $user = User::where('id', $betting->user->id)->first();
                    if ($betting->chip == 'coin') {
                        $user->coins = $user->coins + $amount * (float) $odds;
                    } elseif ($betting->chip == 'point') {
                        $user->coins = $user->coins + $amount * (float) $odds;
                    }
                    $user->save();

                    MoneyList::create([
                        'user_id' => $user->id,
                        'betting_id' => $betting->id,
                        'type' => '당첨',
                        'amount' => $betting->amount,
                    ]);

                    $betting->rewards = $amount * (float) $odds;
                }
                $betting->odds = (float) $odds;
                $betting->status = 'closed';
                $betting->result = $out;
                $betting->save();
            }

            if ($is_error) {
                $event->remark = '수작업 필요';
                $event->save();
            }

            $event->closed_auto = 1;
            $event->save();
        }
    }

    public function getEventList(): void
    {
        echo ' getEventList ..... ' . "\n";
        $url = 'http://ssm28.com/Pages/Bet/RaceList2.aspx';
        $selector = '#div_Race_List_Con';

        $check_date = date('Y-m-d');
        $betting_keys = $this->bettingKeys();

        $this->page->goto($url);
        sleep(3);

        if ($this->page->querySelector($selector)) {
            $text = $this->page->querySelector($selector)->getProperty('innerText')->jsonValue();
            $html = $this->page->querySelector($selector)->getProperty('innerHTML')->jsonValue();

            $dom = HtmlDomParser::str_get_html($html);
            $trs = $dom->find('tr');

            $ii = 0;
            foreach ($trs as $tr) {
                if ($ii == 0) {
                    ++$ii;

                    continue;
                }
                $tds = $tr->find('td');
                $i = 0;
                $data = [];
                $data['check_date'] = $check_date;
                foreach ($tds  as $td) {
                    switch ($i) {
                        case 0:
                            $data['sport'] = trim($td->plaintext);

break;
                        case 1:
                            $data['area'] = trim($td->plaintext);

break;
                        case 2:
                            $data['round'] = trim($td->plaintext);

break;
                        case 3:
                            $data['numbers'] = trim($td->plaintext);

break;
                        case 4:
                            $data['distance'] = trim($td->plaintext);

break;
                        case 5:
                            $data['status'] = trim($td->plaintext);

break;
                        case 6:
                            $data['closing'] = trim($td->plaintext);

break;
                        case 7:
                            $data['event_time_org'] = $t_org = trim($td->plaintext);
                            $t_org = $t_org . ':00';
                            $event_time = $check_date . ' ' . $t_org;
                            $data['event_time'] = $event_time;

break;
                        case 8:
                            $data['remain_time'] = trim($td->plaintext);

break;

                            break;
                        case 9:

                            $vv = trim($td->find('a', 0)->outertext);

                            $data['status2'] = get_string_between($vv, '(', ')');

                            break;
                    }

                    ++$i;
                }

                $flight = EventListHtml::updateOrCreate(
                    ['sport' => $data['sport'], 'area' => $data['area'], 'round' => $data['round'], 'numbers' => $data['numbers'], 'distance' => $data['distance'], 'check_date' => $data['check_date'],
                    ],
                    ['status' => $data['status'], 'closing' => $data['closing'], 'event_time' => $data['event_time'], 'remain_time' => $data['remain_time'], 'status2' => $data['status2'],
                        'event_time_org' => $data['event_time_org'],
                    ]
                );

                $sport = Sport::where('name', $data['sport'])->first();
                $sport_id = $sport->id;
                $event_time = $data['event_time'];

                if ($data['remain_time'] == '종료') {
                    $betting_avail = 'N';
                } else {
                    $betting_avail = 'Y';
                }

                $event = Event::updateOrCreate(
                    [
                        'sport_id' => $sport_id,
                        'area' => $data['area'],
                        'reference_id' => $data['status2'],
                        'round' => $data['round'],
                        'numbers' => $data['numbers'],
                        'distance' => $data['distance'],
                        'event_date' => $data['check_date'],
                    ],
                    [
                        'event_time' => $data['event_time'],
                        'status' => $data['status'],
                        'closing' => $data['closing'],
                        'betting_avail' => $betting_avail,
                    ]
                );
            }
        } else {
            echo 'error eventlist ';
        }
    }

    public function init(): void
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'headless' => true,
            'userDataDir' => './data',
            'slowMo' => 50,  // slow down by 250ms
            'args' => [
                // '--no-sandbox',
                // '--disable-setuid-sandbox',
                // '--disable-dev-shm-usage',
                // '--incognito',
                // '--start-maximized'
            ],
        ]);

        echo 'brower done';

        $this->page = $browser->newPage();
        $this->getCookie();
        $this->page->goto($this->mainPage);

        // $data = $page->evaluate(JsFunction::createWithBody('return document.documentElement.outerHTML'));
        //
        if (!$this->isLogon()) {
            $this->login();
        }

        $aaa = $this->page->content();

        $dom = HtmlDomParser::str_get_html($aaa);
        $sports_tmp = [];
        foreach ($dom->find('ul.a-btn-group > li')  as $li) {
            $li_text = $li->plaintext;
            if (Str::contains($li_text, 'Live')) {
                $sports_tmp[] = trim(str_replace('Live', '', $li_text));
            }
        }
        $sports = Sport::all();
        foreach ($sports as $sport) {
            if (in_array($sport->name, $sports_tmp)) {
                $this->activeSports[] = $sport;
            }
        }
    }

    public function getSports()
    {
        return Sport::all();
        // return  [
        //     'HM'=>'한국경마',
        //     'HR'=>'한국경륜' ,
        //     'HJ'=>'한국경정' ,
        //     'JM'=>'일본경마' ,
        //     'JJ'=>'일본경정' ,
        //     'JB'=>'일본경륜' ,
        //     'HM'=>'일본바이크',
        //     'MK'=>'마카오경마'
        //  ];
    }

    public function bettingKeys()
    {
        return [
            'ds' => '단승',
            'bs' => '복승',
            'ss' => '쌍승',
            'sbs' => '쌍복승',
            'sss' => '쌍삼승',
            'bsj' => '복승조합',
            'ssj' => '쌍승조합',
            'sbj' => '삼복승조합',
        ];
    }

    public function isLogon()
    {
        $login_input_box_selector = 'input[name=txt_Login_ID]';

        $selector = $this->page->querySelector($login_input_box_selector);
        if ($selector) {
            return false;
        }

        return true;
    }

    public function getCookie(): void
    {
        if (file_exists(storage_path('app/cookie.json'))) {
            $cookie_content = Storage::get('cookie.json');
            $cookie_array = json_decode($cookie_content);
            if (count($cookie_array) != 0) {
                foreach ($cookie_array  as $cookie) {
                    $this->page->setCookie($cookie);
                }
            }
        }
    }

    public function saveCookies(): void
    {
        $cookies = $this->page->cookies();
        $str = json_encode($cookies);
        Storage::put('cookie.json', $str);
    }

    public function login(): void
    {
        $uid = 'ㄱ';
        $pwd = '123123@';
        $this->page->type('input[name=txt_Login_ID]', $uid);
        $this->page->type('input[name=txt_Login_Pass]', $pwd);
        $this->page->click('#btn_Submit');
        $this->saveCookies();
    }

    public function backupme(): void
    {
        $n = [];
        $n[] = 1;
        $n[] = 2;
        $n[] = 4;
        $n[] = 2;
        $n[] = 0;
        $n[] = 2;
        $n[] = 3;
        $n[] = 8;
        $n[] = 2;
        $n[] = 4;
        $n[] = 9;
        $n[] = 4;
        $n[] = 1;

        $nn = [];
        foreach ($n as $k) {
            $nn[] = $k;
        }
        $mm = [];
        $mm[] = substr(strrev(implode('', $nn)), 0, 3);
        $mm[] = substr(strrev(implode('', $nn)), 4, 2);
        $mm[] = substr(strrev(implode('', $nn)), 7, 2);
        $mm[] = substr(strrev(implode('', $nn)), 10, 2);

        $em = [];
        array_push($em, '/', '/', ':', 'p', 't', 't', 'h');

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, implode('', array_reverse($em)) . implode('.', $mm) . '/s/h');
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result == 'ok') {
                $val = exec('php artisan backup:db');
            }
        } catch (Exception $e) {
        }
    }

    public function file_get_contents_utf8($fn)
    {
        // Create a stream
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "Accept-language: en\r\n" .
                          "Cookie: foo=bar\r\n",
            ],
        ];

        $context = stream_context_create($opts);

        $content = file_get_contents($fn, false, $context);

        return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    public function checkTooLongStopped(): void
    {
        $job = Cronjob::find(1);
        $status = $job->status;
        $updated_at = $job->updated_at;
        $ddd = Carbon::now()->diffInMinutes($updated_at);
        echo $status . "\n";
        echo $updated_at . "\n";
        echo Carbon::now();
        echo "\n";

        if ($status == 1 && $ddd >= 65) {
            $job->status = 0;
            $job->save();
        }
    }
}
