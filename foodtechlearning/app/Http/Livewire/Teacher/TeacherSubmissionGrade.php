<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Submission;
use Livewire\Component;

class TeacherSubmissionGrade extends Component
{
    public Submission $submission;

    public $assessment = [];

    public $questions;

    public function render()
    {
        return view('livewire.teacher.teacher-submission-grade', [
            'task' => $this->submission->task,
            'attachments' => $this->submission->getMedia(),
        ]);
    }

    public function mount(): void
    {
        foreach ($this->submission->answers as $ak => $answer) {
            $this->assessment[$ak]['identifier'] = $answer['identifier'];
            $this->assessment[$ak]['score'] = 0;
            $this->assessment[$ak]['partial'] = 1;
            $this->assessment[$ak]['rating'] = 'ungraded';
        }
        $this->questions = $this->submission->task->questions;
    }

    public function grade_as_correct($qk): void
    {
        $this->assessment[$qk]['score'] = $this->questions[$qk]['points'];
        $this->assessment[$qk]['rating'] = 'correct';
        $this->alert('success', 'Marked as correct!');
    }

    public function grade_as_incorrect($qk): void
    {
        $this->assessment[$qk]['score'] = 0;
        $this->assessment[$qk]['rating'] = 'incorrect';
        $this->alert('success', 'Marked as incorrect!');
    }

    public function grade_partially($qk): void
    {
        $this->validate([
            "assessment.$qk.partial" => 'integer|required|numeric|min:1|max:' . $this->questions[$qk]['points'],
        ], [], [
            "assessment.$qk.partial" => 'partial points',
        ]);
        $this->assessment[$qk]['score'] = $this->assessment[$qk]['partial'];
        $this->assessment[$qk]['rating'] = 'partial';
        $this->alert('success', 'Marked with partial points!');
    }

    public function get_class_color($qk)
    {
        return [
            'ungraded' => 'bg-white',
            'partial' => 'bg-yellow-200',
            'correct' => 'bg-green-100',
            'incorrect' => 'bg-red-200',
        ][$this->assessment[$qk]['rating']];
    }

    public function finish_grading()
    {
        $assessment = collect($this->assessment);
        if ($assessment->filter(fn ($item) => $item['rating'] === 'ungraded')->count()) {
            return $this->alert('error', 'You have unchecked items.', ['toast' => false, 'position' => 'center']);
        }
        $this->submission->update([
            'assessment' => $this->assessment,
            'date_graded' => now(),
        ]);
        session()->flash('flash_message', 'Submission checked!');
        $this->redirect(route('teacher.tasks.manage', ['task' => $this->submission->task]));
    }
}
