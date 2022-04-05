<?php

namespace App\Http\Livewire;

use App\Models\CalendarEvent;
use Carbon\Carbon;
use Livewire\Component;

class EventCreator extends Component
{
    public $event_name = '';

    public $event_description = '';

    public $event_target = 'personal';

    public $event_start_day;

    public $event_start_time;

    public $event_end_day;

    public $event_end_time;

    public $creatorOpen = false;

    protected $listeners = ['openEventCreator'];

    public function openEventCreator(): void
    {
        $this->creatorOpen = true;
    }

    public function render()
    {
        return view('livewire.event-creator');
    }

    public function addEvent(): void
    {
        $this->validate([
            'event_name' => 'required',
            'event_start_day' => 'required',
        ]);
        if ($this->event_start_time) {
            $start = $this->event_start_day . ' ' . $this->event_start_time;
        } else {
            $start = $this->event_start_day;
        }
        if ($this->event_end_day) {
            if ($this->event_end_time) {
                $end = $this->event_end_day . ' ' . $this->event_end_time;
                $allDay = false;
            } else {
                $allDay = true;
                $end = Carbon::parse($this->event_end_day)->addDay()->format('Y-m-d');
            }
        } else {
            $end = null;
            $allDay = true;
        }
        $code = auth()->user()->id . Carbon::now()->timestamp;
        CalendarEvent::create([
            'user_id' => auth()->user()->id,
            'code' => $code,
            'title' => $this->event_name,
            'description' => $this->event_description,
            'level' => $this->event_target,
            'start' => $start,
            'url' => '/event/' . $code,
            'end' => $end,
            'allDay' => $allDay,
        ]);
        $this->event_name = '';
        $this->event_description = '';
        $this->event_target = 'personal';
        $this->event_start_day = null;
        $this->event_start_time = null;
        $this->event_end_day = null;
        $this->event_end_time = null;
        $this->creatorOpen = false;
        $this->alert('success', 'Event successfully created.', ['toast' => false, 'position' => 'center']);
        $this->dispatchBrowserEvent('events-changed');
    }
}
