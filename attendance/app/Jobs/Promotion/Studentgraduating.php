<?php

namespace App\Jobs\Promotion;

use App\Academicyear;
use App\Defer;
use App\Dismssal;
use App\Examresults;
use App\GraduatingList;
use App\Rasticate;
use App\Regacademicyear;
use App\Studentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Studentgraduating implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //$GRAD = "x->ABSENT,Z->DISQUALIFIED,IC->INCOMPLETE,ADT->AUDITING";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $forms = ['Level 400', 'Level 300', 'Level 200', 'Level 100'];

        $cademicyear = Academicyear::where('status', 1)->first();
        $academic = $cademicyear->acdemicyear;
        $semester = $cademicyear->semester;

        $count = \count($forms);

        foreach ($forms as $value) {

         // $student = Studentinfo::
            //    with(["rasticate" => function($q){
            //      $q->where('status','1');
            //    }])
            //    ->with(["defer" => function($q){
            //      $q->where('status','1');
            //    }])
            //    ->with(["dismssal" => function($q){
            //      $q->where('status','1');
            //    }])
            //    ->where('currentlevel', $value)->get();

            $student = Studentinfo::where('currentlevel', $value)->get();

            if (!$student->isEmpty()) {
                foreach ($student as $row) {
                    $indexnumber = $row->indexnumber;
                    $id = $row->id;
                    $userid = $row->user_id;
                    $duration = $row->duration;
                    $progrm = $row->programme;
                    $pcode = $row->progcode;
                    $session = $row->session;
                    $type = $row->type;
                    $fullname = $row->fullname;
                    $level = $row->currentlevel;
                    $indexnumber = $row->indexnumber;

                    $ras = Rasticate::where('user_id', $userid)->where('status', '1')->get();

                    $defer = Defer::where('user_id', $userid)->where('status', '1')->get();

                    $dis = Dismssal::where('user_id', $userid)->where('status', '1')->get();

                    if ('Level 400' == $value) {
                        if (!$ras->isEmpty()) {
                            continue;
                        }

                        if (!$defer->isEmpty()) {
                            continue;
                        }

                        if (!$dis->isEmpty()) {
                            continue;
                        }

                        $creg = Regacademicyear::where('user_id', $userid)->get();

                        if (!$creg->isEmpty()) {
                            $gpa = Examresults::where('user_id', $userid)
                                ->where('semester', $semester)
                                ->where('year', $academic)->first();

                            if ('Degree Programme' == $type) {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 1.99) {
                                    $class = 'Pass';
                                } elseif (round($gpa->gpa, 2) > 1.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Third Class';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 2.99) {
                                    $class = 'Second Class Lower';
                                } elseif (round($gpa->gpa, 2) > 2.99 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Second Class Upper';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'First Class';
                                }
                            } else {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Pass ';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Credit';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'Distinction';
                                }
                            }

                            $cntcreg = \count($creg);

                            if ('4' == $duration) {
                                if ('8' != $cntcreg) {
                                    continue;
                                }
                            }

                            if ('3' == $duration) {
                                if ('6' != $cntcreg) {
                                    continue;
                                }
                            }

                            if ('2' == $duration) {
                                if ('4' != $cntcreg) {
                                    continue;
                                }
                            }

                            foreach ($creg as $grade) {
                                $array = ['D', 'F', '', '-', 'IC', 'ADT', 'X', 'Z'];
                                $grade = $grade->grade;

                                if (\in_array($grade, $array)) {
                                    continue 2;
                                }
                            }

                            $data = ['completstatus' => 'Graduating'];
                            Studentinfo::findorfail($id)->update($data);

                            $new = [
                                'user_id' => $userid,
                                'programme' => $progrm,
                                'session' => $session,
                                'type' => $type,
                                'academicyear' => $academic,
                                'fullname' => $fullname,
                                'gpa' => round($gpa->gpa, 2),
                                'graduatingclas' => $class,
                                'year' => date('Y'),
                                'level' => $level,
                                'indexnumber' => $indexnumber,
                            ];

                            $checkgradua = GraduatingList::where('indexnumber', $indexnumber)->first();

                            if ($checkgradua) {
                                $checkgradua->gpa = round($gpa->gpa, 2);
                                $checkgradua->graduatingclas = $class;
                                $checkgradua->save();
                            } else {
                                $new = new GraduatingList($new);
                                $new->save();
                            }
                        }
                    }
                    //End of level 400

                    if ('Level 300' == $value) {
                        if (!$ras->isEmpty()) {
                            continue;
                        }

                        if (!$defer->isEmpty()) {
                            continue;
                        }

                        if (!$dis->isEmpty()) {
                            continue;
                        }

                        $creg = Regacademicyear::where('user_id', $userid)->get();

                        $data = ['currentlevel' => 'Level 400'];

                        if (!$creg->isEmpty()) {
                            $gpa = Examresults::where('user_id', $userid)
                                ->where('semester', $semester)
                                ->where('year', $academic)->first();

                            if ('Degree Programme' == $type) {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 1.99) {
                                    $class = 'Pass';
                                } elseif (round($gpa->gpa, 2) > 1.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Third Class';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 2.99) {
                                    $class = 'Second Class Lower';
                                } elseif (round($gpa->gpa, 2) > 2.99 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Second Class Upper';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'First Class';
                                }
                            } else {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Pass ';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Credit';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'Distinction';
                                }
                            }

                            $cntcreg = \count($creg);

                            if ('3' == $duration) {
                                if ('6' != $cntcreg) {
                                    continue;
                                }

                                foreach ($creg as $grade) {
                                    $array = ['D', 'F', '', '-', 'IC', 'ADT', 'X', 'Z'];
                                    $grade = $grade->grade;

                                    if (\in_array($grade, $array)) {
                                        continue 2;
                                    }
                                }

                                $data = ['completstatus' => 'Graduating'];
                                Studentinfo::findorfail($id)->update($data);

                                $new = [
                                    'user_id' => $userid,
                                    'programme' => $progrm,
                                    'session' => $session,
                                    'type' => $type,
                                    'academicyear' => $academic,
                                    'fullname' => $fullname,
                                    'gpa' => round($gpa->gpa, 2),
                                    'graduatingclas' => $class,
                                    'year' => date('Y'),
                                    'level' => $level,
                                    'indexnumber' => $indexnumber,
                                ];

                                $checkgradua = GraduatingList::where('indexnumber', $indexnumber)->first();

                                if ($checkgradua) {
                                    $checkgradua->gpa = round($gpa->gpa, 2);
                                    $checkgradua->graduatingclas = $class;
                                    $checkgradua->save();
                                } else {
                                    $new = new GraduatingList($new);
                                    $new->save();
                                }
                            }
                        }
                    }
                    //End of level 300

                    if ('Level 200' == $value) {
                        if (!$ras->isEmpty()) {
                            continue;
                        }

                        if (!$defer->isEmpty()) {
                            continue;
                        }

                        if (!$dis->isEmpty()) {
                            continue;
                        }

                        $creg = Regacademicyear::where('user_id', $userid)->get();

                        $data = ['currentlevel' => 'Level 300'];

                        if (!$creg->isEmpty()) {
                            $gpa = Examresults::where('user_id', $userid)
                                ->where('semester', $semester)
                                ->where('year', $academic)->first();

                            if ('Degree Programme' == $type) {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 1.99) {
                                    $class = 'Pass';
                                } elseif (round($gpa->gpa, 2) > 1.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Third Class';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 2.99) {
                                    $class = 'Second Class Lower';
                                } elseif (round($gpa->gpa, 2) > 2.99 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Second Class Upper';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'First Class';
                                }
                            } else {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Pass ';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Credit';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'Distinction';
                                }
                            }

                            $cntcreg = \count($creg);

                            if ('2' == $duration) {
                                if ('4' != $cntcreg) {
                                    continue;
                                }

                                foreach ($creg as $grade) {
                                    $array = ['D', 'F', '', '-', 'IC', 'ADT', 'X', 'Z'];
                                    $grade = $grade->grade;

                                    if (\in_array($grade, $array)) {
                                        continue 2;
                                    }
                                }

                                $data = ['completstatus' => 'Graduating'];
                                Studentinfo::findorfail($id)->update($data);

                                $new = [
                                    'user_id' => $userid,
                                    'programme' => $progrm,
                                    'session' => $session,
                                    'type' => $type,
                                    'academicyear' => $academic,
                                    'fullname' => $fullname,
                                    'gpa' => round($gpa->gpa, 2),
                                    'graduatingclas' => $class,
                                    'year' => date('Y'),
                                    'level' => $level,
                                    'indexnumber' => $indexnumber,
                                ];

                                $checkgradua = GraduatingList::where('indexnumber', $indexnumber)->first();

                                if ($checkgradua) {
                                    $checkgradua->gpa = round($gpa->gpa, 2);
                                    $checkgradua->graduatingclas = $class;
                                    $checkgradua->save();
                                } else {
                                    $new = new GraduatingList($new);
                                    $new->save();
                                }
                            }
                        }
                    }
                    //End of level 200

                    if ('Level 100' == $value) {
                        if (!$ras->isEmpty()) {
                            continue;
                        }

                        if (!$defer->isEmpty()) {
                            continue;
                        }

                        if (!$dis->isEmpty()) {
                            continue;
                        }

                        $creg = Regacademicyear::where('user_id', $userid)->get();

                        $data = ['currentlevel' => 'Level 200'];

                        if (!$creg->isEmpty()) {
                            $gpa = Examresults::where('user_id', $userid)
                                ->where('semester', $semester)
                                ->where('year', $academic)->first();

                            if ('Degree Programme' == $type) {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 1.99) {
                                    $class = 'Pass';
                                } elseif (round($gpa->gpa, 2) > 1.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Third Class';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 2.99) {
                                    $class = 'Second Class Lower';
                                } elseif (round($gpa->gpa, 2) > 2.99 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Second Class Upper';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'First Class';
                                }
                            } else {
                                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                                    $class = 'Failed';
                                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 2.49) {
                                    $class = 'Pass ';
                                } elseif (round($gpa->gpa, 2) > 2.49 && round($gpa->gpa, 2) <= 3.59) {
                                    $class = 'Credit';
                                } elseif (round($gpa->gpa, 2) > 3.59 && round($gpa->gpa, 2) <= 4.00) {
                                    $class = 'Distinction';
                                }
                            }

                            $cntcreg = \count($creg);

                            if ('1' == $duration) {
                                if ('2' != $cntcreg) {
                                    continue;
                                }

                                foreach ($creg as $grade) {
                                    $array = ['D', 'F', '', '-', 'IC', 'ADT', 'X', 'Z'];
                                    //$array = ['D','F','-','IC','ADT','X','Z'];
                                    $grade = $grade->grade;

                                    if (\in_array($grade, $array)) {
                                        continue 2;
                                    }
                                }

                                $data = ['completstatus' => 'Graduating'];
                                Studentinfo::findorfail($id)->update($data);

                                $new = [
                                    'user_id' => $userid,
                                    'programme' => $progrm,
                                    'session' => $session,
                                    'type' => $type,
                                    'academicyear' => $academic,
                                    'fullname' => $fullname,
                                    'gpa' => round($gpa->gpa, 2),
                                    'graduatingclas' => $class,
                                    'year' => date('Y'),
                                    'level' => $level,
                                    'indexnumber' => $indexnumber,
                                ];

                                $checkgradua = GraduatingList::where('indexnumber', $indexnumber)->first();

                                if ($checkgradua) {
                                    $checkgradua->gpa = round($gpa->gpa, 2);
                                    $checkgradua->graduatingclas = $class;
                                    $checkgradua->save();
                                } else {
                                    $new = new GraduatingList($new);
                                    $new->save();
                                }
                            }
                        }
                    }
                    //End of level 100
                }

                //end student loop here
            }
        }
    }
}
