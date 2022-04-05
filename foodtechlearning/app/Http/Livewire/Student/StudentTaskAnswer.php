<?php

namespace App\Http\Livewire\Student;

use App\Models\Submission;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentTaskAnswer extends Component
{
    use WithFileUploads;

    public Task $task;

    public $answers = [];

    public function render()
    {
        return view('livewire.student.student-task-answer', [
            'course' => $this->task->course,
            'questions' => $this->task->questions,
            'attachments' => $this->task->getMedia(),
        ]);
    }

    public function mount(): void
    {
        $course = auth()->user()?->classes()->whereHas('tasks', function ($query): void {
            $query->where('id', $this->task->id);
        })->first();
        if (!$course) {
            abort(403);
        }
        foreach ($this->task->questions as $qk => $question) {
            $this->answers[$qk]['identifier'] = $question['identifier'];
            $this->answers[$qk]['answers'] = [];
            $this->answers[$qk]['attachments'] = [];
        }
    }

    public function submit_answers(): void
    {
        $answers = $this->answers;
        foreach ($answers as $ak => $answer) {
            unset($answers[$ak]['attachments']);
        }
        $submission = Submission::create([
            'user_id' => auth()->id(),
            'task_id' => $this->task->id,
            'answers' => $answers,
            'date_submitted' => now(),
        ]);
        foreach ($this->answers as $ansk => $ans) {
            foreach ($ans['attachments'] as $attachment) {
                $submission->addMedia($attachment->getRealPath(), )->usingName($attachment->getClientOriginalName())->usingFileName($attachment->getClientOriginalName())->withCustomProperties(['identifier' => $ans['identifier']])->toMediaCollection();
            }
        }
        session()->flash('flash_message', 'Submission submitted successfully.');
        $this->redirect(route('student.course.tasks', ['course' => $this->task->course]));
    }
}
