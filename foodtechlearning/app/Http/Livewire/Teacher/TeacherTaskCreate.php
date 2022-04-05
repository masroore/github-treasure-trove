<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\Task;
use App\Models\TaskType;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeacherTaskCreate extends Component
{
    use WithFileUploads;

    public Course $course;

    public $questions = [];

    public $task_type_id = 1;

    public $name = '';

    public $instructions = '';

    public $deadline;

    public function render()
    {
        return view('livewire.teacher.teacher-task-create', [
            'task_types' => TaskType::get(),
            'question_types' => [
                'identification',
                'multiple choice',
                'true or false',
                'enumeration',
                'essay',
                'problem solving',
            ],
        ]);
    }

    public function mount(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403);
        }
        $this->add_question();
    }

    public function create_task(): void
    {
        $this->validate([
            'name' => 'required',
            'instructions' => 'required',
            'questions.*.body' => 'required',
            'questions.*.points' => 'required|integer|min:1',
        ], [
            'questions.*.body.required' => 'The question\'s body is required.',
            'questions.*.points.min' => 'The question\'s points must be at least 1 point.',
            'questions.*.points.integer' => 'The question\'s points must be a whole number.',
        ]);

        DB::transaction(function (): void {
            $question_with_attachments = collect($this->questions)->filter(fn ($q) => count($q['attachments']));
            $questions = $this->questions;
            foreach ($questions as $qk => $q) {
                unset($questions[$qk]['choice'],$questions[$qk]['answer'],$questions[$qk]['attachments']);
            }
            $task = Task::create([
                'name' => $this->name,
                'task_type_id' => $this->task_type_id,
                'instructions' => $this->instructions,
                'course_id' => $this->course->id,
                'questions' => $questions,
                'deadline' => $this->deadline,
            ]);
            foreach ($question_with_attachments as $question) {
                foreach ($question['attachments'] as $attachment) {
                    $task->addMedia($attachment->getRealPath(), )->usingName($attachment->getClientOriginalName())->usingFileName($attachment->getClientOriginalName())->withCustomProperties(['identifier' => $question['identifier']])->toMediaCollection();
                }
            }
        });
        session()->flash('flash_message', 'Task created successfully.');
        $this->redirect(route('teacher.course.manage', ['course' => $this->course]));
    }

    public function add_question(): void
    {
        $this->questions[] = [
            'identifier' => now()->getPreciseTimestamp(),
            'type' => 'identification',
            'points' => 1,
            'file_required' => false,
            'body' => '',
            'choices' => [],
            'links' => [],
            'answers' => [],
            'answer' => '',
            'choice' => '',
            'attachments' => [],
        ];
        $this->alert('success', 'Question added!');
    }

    public function remove_question($qk): void
    {
        unset($this->questions[$qk]);
        $this->alert('success', 'Question removed!');
    }

    public function add_choice($qk): void
    {
        $this->validate([
            "questions.$qk.choice" => 'required',
        ]);
        $choices = collect($this->questions[$qk]['choices']);
        $choice = $this->questions[$qk]['choice'];
        if ($choices->contains($choice)) {
            return;
        }
        $this->questions[$qk]['choices'][] = $this->questions[$qk]['choice'];
        $this->questions[$qk]['choice'] = '';
        $this->alert('success', 'Choice added!');
    }

    public function add_answer($qk): void
    {
        $this->validate([
            "questions.$qk.answer" => 'required',
        ]);
        $answers = collect($this->questions[$qk]['answers']);
        $answer = $this->questions[$qk]['answer'];
        if ($answers->contains($answer)) {
            return;
        }
        $this->questions[$qk]['answers'][] = $this->questions[$qk]['answer'];
        $this->questions[$qk]['answer'] = '';
        $this->alert('success', 'Answer added!');
    }

    public function remove_choice($qk, $ck): void
    {
        $answers = collect($this->questions[$qk]['answers']);
        $this->questions[$qk]['answers'] = $answers->filter(fn ($a) => $a !== $this->questions[$qk]['choices'][$ck]);
        unset($this->questions[$qk]['choices'][$ck]);
        $this->alert('success', 'Choice removed!');
    }

    public function remove_answer($qk, $ak): void
    {
        unset($this->questions[$qk]['answers'][$ak]);
        $this->alert('success', 'Answer removed!');
    }

    public function updating($name, $value): void
    {
        if (preg_match('/questions.\d+.type/', $name)) {
            $key = explode('.', $name);
            $this->questions[$key[1]]['choices'] = [];
            $this->questions[$key[1]]['answers'] = [];
            if ($value === 'true or false') {
                $this->questions[$key[1]]['choices'][] = 'true';
                $this->questions[$key[1]]['choices'][] = 'false';
            }
        }
    }
}
