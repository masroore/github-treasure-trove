<?php

namespace App\Jobs\Cancelresults;

use App\Coureregistration;
use App\Examcancel;
use App\Examresults;
use App\Studentinfo;
use DB;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RevertSessionCancelJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $level;

    public $session;

    public $programme;

    public $coursecode;

    public $semester;

    public $academicyear;

    /**
     * Create a new job instance.
     */
    public function __construct($level, $session, $programme, $coursecode, $semester, $academicyear)
    {
        $this->level = $level;
        $this->session = $session;
        $this->programme = $programme;
        $this->coursecode = $coursecode;
        $this->semester = $semester;
        $this->academicyear = $academicyear;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $students = Studentinfo::where('currentlevel', $this->level)->get();

        foreach ($students as $row) {
            $indexnumber = $row->indexnumber;

            $creg = Coureregistration::where('indexnumber', $indexnumber)
                ->where('level', $this->level)->where('cource_code', $this->coursecode)->where('semester', $this->semester)
                ->where('academic_year', $this->academicyear)->first();

            if ($creg) {
                DB::beginTransaction();

                try {
                    $id = $creg->id;
                    $coursecode = $creg->cource_code;
                    $coursetitle = $creg->cource_title;
                    $user_id = $creg->user_id;

                    $examcanecl = Examcancel::where('course_id', $id)->first();

                    $coursecode = $creg->cource_code;
                    $coursetitle = $creg->cource_title;
                    $user_id = $creg->user_id;

                    $creg->IA_mark = $examcanecl->IA_mark;
                    $creg->exams_mark = $examcanecl->exams_mark;
                    $creg->total_marks = $examcanecl->total_marks;
                    $creg->grade = $examcanecl->grade;
                    $creg->grade_point = $examcanecl->grade_point;
                    $creg->total_gp = $examcanecl->total_gp;
                    $creg->save();

                    $examcanecl->delete();

                    //GET LEVEL
                    $level = $creg->level;
                    $semester = $creg->semester;
                    $userid = $creg->user_id;
                    $Ayear = $creg->academic_year;

                    //level 100 first
                    $leval1f = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 100')
                        ->where('semester', 'First Semester')->first();

                    if ($leval1f) {
                        $totalgpl1f = DB::table('coureregistrations')
                            ->where('level', 'Level 100')->where('semester', 'First Semester')
                            ->sum('total_gp');

                        $credithrl1f = DB::table('coureregistrations')
                            ->where('level', 'Level 100')->where('semester', 'First Semester')
                            ->sum('credithours');

                        $gpal1f = $totalgpl1f / $credithrl1f;

                        //get exams
                        $examsl1f = Examresults::where('user_id', $user_id)
                            ->where('semester', 'First Semester')
                            ->where('year', $leval1f->academic_year)->first();

                        $examsl1f->totalgp = $totalgpl1f;
                        $examsl1f->gpa = $gpal1f;
                        $examsl1f->save();
                    }

                    //level 100 second

                    $leval1s = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 100')
                        ->where('semester', 'Second Semester')->first();

                    if ($leval1s) {
                        $totalgpl1s = DB::table('coureregistrations')
                            ->where('level', 'Level 100')->where('semester', 'Second Semester')
                            ->sum('total_gp');

                        $credithrl1s = DB::table('coureregistrations')
                            ->where('level', 'Level 100')->where('semester', 'Second Semester')
                            ->sum('credithours');

                        $totalgb1 = $totalgpl1f + $totalgpl1s;

                        $totcredit = $credithrl1f + $credithrl1s;

                        $gpal1s = $totalgb1 / $totcredit;

                        //get exams
                        $examsl1s = Examresults::where('user_id', $user_id)
                            ->where('semester', 'Second Semester')
                            ->where('year', $leval1s->academic_year)->first();

                        $examsl1s->totalgp = $totalgpl1s;
                        $examsl1f->gpa = $gpal1s;
                        $examsl1s->save();
                    }

                    //level 200 firat

                    $leval2f = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 200')
                        ->where('semester', 'First Semester')->first();

                    if ($leval2f) {
                        $totalgpl2f = DB::table('coureregistrations')
                            ->where('level', 'Level 200')->where('semester', 'First Semester')
                            ->sum('total_gp');

                        $credithrl2f = DB::table('coureregistrations')
                            ->where('level', 'Level 200')->where('semester', 'First Semester')
                            ->sum('credithours');

                        $totalgbl2f = $totalgb1 + $totalgpl2f;
                        $totcredidl2f = $totcredit + $credithrl2f;
                        $gpal2f = $totalgbl2f / $totcredidl2f;

                        //get exams
                        $examsl2f = Examresults::where('user_id', $user_id)
                            ->where('semester', 'First Semester')
                            ->where('year', $leval2f->academic_year)->first();

                        $examsl2f->totalgp = $totalgpl2f;
                        $examsl1f->gpa = $gpal2f;
                        $examsl2f->save();
                    }

                    //level 200 second

                    $leval2s = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 200')
                        ->where('semester', 'Second Semester')->first();

                    if ($leval2s) {
                        $totalgpl2s = DB::table('coureregistrations')
                            ->where('level', 'Level 200')->where('semester', 'Second Semester')
                            ->sum('total_gp');

                        $credithrl2s = DB::table('coureregistrations')
                            ->where('level', 'Level 200')->where('semester', 'Second Semester')
                            ->sum('credithours');

                        $totalgbl2s = $totalgbl2f + $totalgpl2s;

                        $totcredidl2s = $totcredidl2f + $credithrl2s;

                        $gpal2s = $totalgbl2s / $totcredidl2s;

                        //get exams
                        $examsl2s = Examresults::where('user_id', $user_id)
                            ->where('semester', 'Second Semester')
                            ->where('year', $leval2s->academic_year)->first();

                        $examsl2s->totalgp = $totalgpl2s;
                        $examsl2s->gpa = $gpal2s;
                        $examsl2s->save();
                    }

                    //level 300 first

                    $leval3f = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 300')
                        ->where('semester', 'First Semester')->first();

                    if ($leval3f) {
                        $totalgpl3f = DB::table('coureregistrations')
                            ->where('level', 'Level 300')->where('semester', 'First Semester')
                            ->sum('total_gp');

                        $credithrl3f = DB::table('coureregistrations')
                            ->where('level', 'Level 300')->where('semester', 'First Semester')
                            ->sum('credithours');

                        $totalgbl3f = $totalgbl2s + $totalgpl3f;

                        $totcredidl3f = $totcredidl2s + $credithrl3f;

                        $gpal3f = $totalgbl3f / $totcredidl3f;

                        //get exams
                        $examsl3f = Examresults::where('user_id', $user_id)
                            ->where('semester', 'First Semester')
                            ->where('year', $leval3f->academic_year)->first();

                        $examsl3f->totalgp = $totalgpl3f;
                        $examsl3f->gpa = $gpal3f;
                        $examsl3f->save();
                    }

                    //level 300 second

                    $leval3s = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 300')
                        ->where('semester', 'Second Semester')->first();

                    if ($leval3s) {
                        $totalgpl3s = DB::table('coureregistrations')
                            ->where('level', 'Level 300')->where('semester', 'Second Semester')
                            ->sum('total_gp');

                        $credithrl3s = DB::table('coureregistrations')
                            ->where('level', 'Level 300')->where('semester', 'Second Semester')
                            ->sum('credithours');

                        $totalgbl3s = $totalgbl3f + $totalgpl3s;

                        $totcredidl3s = $totcredidl3f + $credithrl3s;

                        $gpal3s = $totalgbl3s / $totcredidl3s;

                        //get exams
                        $examsl3s = Examresults::where('user_id', $user_id)
                            ->where('semester', 'Second Semester')
                            ->where('year', $leval3s->academic_year)->first();

                        $examsl3s->totalgp = $totalgpl3s;
                        $examsl3s->gpa = $gpal3s;
                        $examsl3s->save();
                    }

                    //level 400 first

                    $leval4f = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 400')
                        ->where('semester', 'First Semester')->first();

                    if ($leval4f) {
                        $totalgpl4f = DB::table('coureregistrations')
                            ->where('level', 'Level 400')->where('semester', 'First Semester')
                            ->sum('total_gp');

                        $credithrl4f = DB::table('coureregistrations')
                            ->where('level', 'Level 400')->where('semester', 'First Semester')
                            ->sum('credithours');

                        $totalgbl4f = $totalgbl3s + $totalgpl4f;

                        $totcredidl4f = $totcredidl3s + $credithrl4f;

                        $gpal4f = $totalgbl4f / $totcredidl4f;

                        //get exams
                        $examsl4f = Examresults::where('user_id', $user_id)
                            ->where('semester', 'First Semester')
                            ->where('year', $leval4f->academic_year)->first();

                        $examsl4f->totalgp = $totalgpl4f;
                        $examsl4f->gpa = $gpal4f;
                        $examsl4f->save();
                    }

                    //level 400 second

                    $leval4s = Coureregistration::where('indexnumber', $indexnumber)
                        ->where('level', 'Level 400')
                        ->where('semester', 'Second Semester')->first();

                    if ($leval4s) {
                        $totalgpl4s = DB::table('coureregistrations')
                            ->where('level', 'Level 400')->where('semester', 'Second Semester')
                            ->sum('total_gp');

                        $credithrl4s = DB::table('coureregistrations')
                            ->where('level', 'Level 400')->where('semester', 'Second Semester')
                            ->sum('credithours');

                        $totalgbl4s = $totalgbl4f + $totalgpl4s;

                        $totcredidl4s = $totcredidl4f + $credithrl4s;

                        $gpal4s = $totalgbl4s / $totcredidl4s;

                        //get exams
                        $examsl4s = Examresults::where('user_id', $user_id)
                            ->where('semester', 'Second Semester')
                            ->where('year', $leval4s->academic_year)->first();

                        $examsl4s->totalgp = $totalgpl4s;
                        $examsl4s->gpa = $gpal4s;
                        $examsl4s->save();
                    }

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                }
            }
        }
    }
}
