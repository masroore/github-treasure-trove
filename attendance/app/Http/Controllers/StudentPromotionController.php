<?php

namespace App\Http\Controllers;

use App\Academicyear;
use App\Examresults;
use App\GraduatingList;
use App\Jobs\Graduatingtograduated;
use App\Jobs\level100to200;
use App\Jobs\level200to300;
use App\Jobs\level300to400;
use App\Jobs\level400tograduating;
use App\Jobs\Promotion\Studentgraduating;
use App\Jobs\Promotion\Studentpromotion;
use App\Programme;
use App\Studentinfo;
use FPDF as pdfs;
use Illuminate\Http\Request;
use Response;

class StudentPromotionController extends Controller
{
    private $fpdf;

    public function promotestudent()
    {

   // $studentinfo = Studentinfo::
        //  with(["rasticate" => function($q){
        //    $q->where('status','1');
        //  }])
        //  ->with(["defer" => function($q){
        //    $q->where('status','1');
        //  }])
        //  ->with(["dismssal" => function($q){
        //    $q->where('status','1');
        //  }])
        //  ->where('currentlevel', 'Level 400')->get();

        //  foreach ($studentinfo as $row) {
        //    if (count($row->dismssal) > 0) {
        //      dd('working');
        //    }
        //  }

        //  dd($studentinfo);
        //$this->dispatch(new Studentpromotion());
        return view('Student_promotion.promote_student');
    }

    public function gradtatingtograduated()
    {
        // Graduatingtograduated::dispatch($podcast)
        Graduatingtograduated::dispatch();

        return Redirect()->back()->with('message', 'Process Submitted Successfully!');
        // $this->dispatch(new Graduatingtograduated())->onQueue('gradtatingtograduated');
    }

    public function l400tograduating()
    {
        $this->dispatch(new level400tograduating());

        return Redirect()->back()->with('message', 'Process Submitted Successfully!');
    }

    public function l300to400()
    {
        level300to400::dispatch()->onQueue('levelthreetofour');

        return Redirect()->back()->with('message', 'Process Submitted Successfully!');
        // $this->dispatch(new level300to400())->onQueue('levelthreetofour');
    }

    public function l200to300()
    {
        $this->dispatch(new Studentgraduating());
        //level200to300::dispatch()->onQueue('l200to300');
        toastr()->success('Student Graduating Added To Queue Successfully!');

        return Redirect()->back();
        // $this->dispatch(new level200to300())->onQueue('l200to300');
    }

    public function l100to200()
    {
        $this->dispatch(new Studentpromotion());
        //Studentpromotion::dispatch()->onQueue('l100to200');
        toastr()->success('Promition Added To Queue Successfully!');

        return Redirect()->back();
        // $this->dispatch(new level100to200())->onQueue('l100to200');
    }

    public function graduating_list()
    {
        $prog = Programme::all();

        return view('Student_promotion.graduating_list', ['prog' => $prog]);
    }

    public function graduating_list_script(Request $request)
    {
        $cademicyear = Academicyear::where('status', 1)->first();
        $academic = $cademicyear->acdemicyear;
        $semester = $cademicyear->semester;

        $level = $request->post('level');
        $progrm = explode(',', $request->post('programme'));
        $code = $progrm[1];
        $type = $progrm[2];
        $session = $request->post('session');

        $studentinfo = Studentinfo::where('currentlevel', $level)
            ->where('progcode', $code)
            ->where('completstatus', 'Graduating')
            ->where('session', $session)->get();

        foreach ($studentinfo as $student) {
            $userid = $student->user_id;

            $gpa = Examresults::where('user_id', $userid)
                ->where('semester', $semester)
                ->where('year', $academic)->first();

            $grade = round($gpa->gpa, 2);
            $GRAD = 'x->ABSENT,Z->DISQUALIFIED,IC->INCOMPLETE,ADT->AUDITING';

            if ('Degree Programme' == $type) {
                if (round($gpa->gpa, 2) > 0 && round($gpa->gpa, 2) <= 0.99) {
                    $class = 'Failed';
                } elseif (round($gpa->gpa, 2) > 0.99 && round($gpa->gpa, 2) <= 1.99) {
                    $class = 'Pass ';
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

            //check if user has already been added

            $checkgradua = GraduatingList::where('indexnumber', $student->indexnumber)
                ->first();

            if ($checkgradua) {
                $checkgradua->gpa = round($gpa->gpa, 2);
                $checkgradua->graduatingclas = $class;
                $checkgradua->save();
            } else {
                //insert
                $data = [
           'user_id' => $userid,
           'programme' => $progrm[0],
           'session' => $session,
           'type' => $type,
           'academicyear' => $academic,
           'fullname' => $student->fullname,
           'gpa' => round($gpa->gpa, 2),
           'graduatingclas' => $class,
           'year' => date('Y'),
           'level' => $level,
           'indexnumber' => $student->indexnumber,
         ];

                $new = new GraduatingList($data);
                $new->save();
            }
        }

        return Response::json([
   'success' => 'true',
   'level' => $level,
   'prog' => $code,
   'session' => $session,
   'academicyear' => $academic,
   'type' => $type,
], 200);
    }

    public function fetch_graduatng_list($level, $prog, $session, $academicyear, $type)
    {
        $checkgradua = GraduatingList::where('level', $level)
            ->where('programme', $prog)->where('session', $session)->where('academicyear', $academicyear)
            ->get();

        $this->fpdf = new pdfs();
        $this->fpdf->AliasNbPages();

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->AddPage('L');
        $this->fpdf->Cell(276, 5, 'GRADUATING LIST', 0, 1, 'C');

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(276, 5, 'ACADEMIC YEAR - ' . strtoupper($academicyear), 0, 1, 'C');

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(276, 5, 'PROGRAMME - ' . strtoupper($prog), 0, 1, 'C');

        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(276, 5, 'SESSION - ' . strtoupper($session), 0, 1, 'C');

        $this->fpdf->SetFont('Arial');
        $this->fpdf->Cell(260, 5, 'Date: ' . date('m/d/Y'), 0, 1, 'R');

        $this->fpdf->Ln(5);

        //dd($type);

        if ('Degree Programme' == $type) {
            $this->fpdf->SetFont('Arial', '', 12);
            $this->fpdf->SetFillColor(122, 228, 232);
            $this->fpdf->Cell(267, 10, 'First Class', 1, 1, 'L', true);

            $fcu = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $fcu) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('First Class' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $fcu++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Second Class Upper', 1, 1, 'L', true);

            $scu = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $scu) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Second Class Upper' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $scu++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Second Class Lower', 1, 1, 'L', true);

            $scl = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $scl) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Second Class Lower' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $scl++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Third Class', 1, 1, 'L', true);

            $tc = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $tc) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Third Class' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $tc++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Pass', 1, 1, 'L', true);

            $pas = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $pas) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Pass' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $pas++;
            }
        } else {
            //diploma students graduating
            //

            //dd($checkgradua);

            $this->fpdf->SetFont('Arial', '', 12);
            $this->fpdf->SetFillColor(122, 228, 232);
            $this->fpdf->Cell(267, 10, 'Distinction', 1, 1, 'L', true);

            $fcu = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $fcu) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Distinction' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $fcu++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Credit', 1, 1, 'L', true);

            $scu = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $scu) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Credit' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $scu++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Pass', 1, 1, 'L', true);

            $scl = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $scl) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Pass' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $scl++;
            }

            $this->fpdf->Ln(5);

            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(267, 10, 'Failed', 1, 1, 'L', true);

            $tc = 0;
            foreach ($checkgradua as $row) {
                if ('0' == $tc) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, 'Fullname', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'Index Number', 'LRB', 0, 'L');
                    $this->fpdf->Cell(89, 10, 'GPA', 'LRB', 1, 'L');
                }

                if ('Failed' == trim($row->graduatingclas)) {
                    $this->fpdf->SetFont('Arial', '', 12);
                    $this->fpdf->Cell(89, 10, $row->fullname, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->indexnumber, 'LR', 0, 'L');
                    $this->fpdf->Cell(89, 10, $row->gpa, 'LR', 1, 'L');
                }

                $tc++;
            }
        }

        return response($this->fpdf->Output())
            ->header('Content-Type', 'application/pdf');

        return view('Student_promotion.view_graduating', ['graduation' => $checkgradua, 'academicyear' => $academicyear, 'prog' => $prog, 'session' => $session, 'type' => $type]);
    }
}
