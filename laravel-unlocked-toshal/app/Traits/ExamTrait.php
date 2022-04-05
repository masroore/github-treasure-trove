<?php

namespace App\Traits;

use App\Chapter;
use App\Exam;
use App\Question;
use App\Quiz;
use App\Subject;

trait ExamTrait
{
    /*
    Method Name:    examList
    Developer:      Shine Dezign
    Created Date:   2020-12-22 (yyyy-mm-dd)
    Purpose:        To get list of all active exams
    Params:         [password]
    */
    public function examList()
    {
        $exam_list = Exam::where('status', 1)
            ->get(['id', 'name']);

        return $exam_list;
    }
    // End Method examList

    /*
    Method Name:    subjectByExamId
    Developer:      Shine Dezign
    Created Date:   2020-12-22 (yyyy-mm-dd)
    Purpose:        To get list of all active subjects on the basic of exam
    Params:         [exam_id]
    */
    public function subjectByExamId($exam_id)
    {
        $subjects = Subject::where('exam_id', $exam_id)
            ->where('status', 1)
            ->get(['id', 'exam_id', 'name']);

        return $subjects;
    }
    // End Method subjectByExamId

    /*
    Method Name:    chapterByExamIdSubjectId
    Developer:      Shine Dezign
    Created Date:   2020-12-22 (yyyy-mm-dd)
    Purpose:        To get list of all active chapter on the basic of exam and subject
    Params:         [exam_id, subject_id]
    */
    public function chapterByExamIdSubjectId($exam_id, $subject_id)
    {
        $chapters = Chapter::where('exam_id', $exam_id)
            ->where('subject_id', $subject_id)
            ->where('status', 1)
            ->get(['id', 'exam_id', 'subject_id', 'name']);

        return $chapters;
    }
    // End Method chapterByExamIdSubjectId

    /*
    Method Name:    chapterDetailById
    Developer:      Shine Dezign
    Created Date:   2020-12-22 (yyyy-mm-dd)
    Purpose:        To get detail of chapter on the basic of id
    Params:         [exam_id, subject_id]
    */
    public function chapterDetailById($chapter_id)
    {
        $chapters = Chapter::where('id', $chapter_id)
            ->get(['id', 'exam_id', 'subject_id', 'name']);

        return $chapters;
    }
    // End Method chapterDetailById

    /*
    Method Name:    createAutoDailyQuiz
    Developer:      Shine Dezign
    Created Date:   2021-01-18 (yyyy-mm-dd)
    Purpose:        To create Daily Quiz of 25 question
    Params:         []
    */
    public function createAutoDailyQuiz(): void
    {
        $record = Question::where(['status' => 1]);
        $totalRecord = $record->count();
        if ($totalRecord >= 25) {
            $totalRecord = 25;
            $result = $record->get(['id'])->random(25);
        } else {
            $result = $record->inRandomOrder()->get(['id']);
        }

        $data = [];
        foreach ($result as $question) {
            $data[] = $question->id;
        }
        $data = implode(',', $data);
        $createData = [
            'type' => 1,
            'date' => date('Y-m-d'),
            'no_of_questions' => $totalRecord,
            'question_list' => $data,
            'status' => 1,
        ];
        if (Quiz::where(['type' => 1, 'date' => date('Y-m-d')])->count() == 0) {
            Quiz::create($createData);
        }
    }
    // End Method createAutoDailyQuiz

    /*
    Method Name:    createAutoMockQuiz
    Developer:      Shine Dezign
    Created Date:   2021-01-18 (yyyy-mm-dd)
    Purpose:        To create Mock Quiz of 100 question
    Params:         []
    */
    public function createAutoMockQuiz(): void
    {
        foreach ($this->examList() as $exam) {
            $record = Question::where(['status' => 1, 'exam_id' => $exam->id]);
            $totalRecord = $record->count();
            if ($totalRecord >= 100) {
                $totalRecord = 100;
                $result = $record->get(['id'])->random(100);
            } else {
                if ($totalRecord == 0) {
                    continue;
                }
                $result = $record->inRandomOrder()->get(['id']);
            }
            $data = [];
            foreach ($result as $question) {
                $data[] = $question->id;
            }
            $data = implode(',', $data);
            $createData = [
                'type' => 3,
                'exam_id' => $exam->id,
                'date' => date('Y-m-d'),
                'no_of_questions' => $totalRecord,
                'question_list' => $data,
                'status' => 1,
            ];
            if (Quiz::where(['type' => 3, 'date' => date('Y-m-d')])->count() == 0) {
                Quiz::create($createData);
            }
        }
    }
    // End Method createAutoMockQuiz
}
