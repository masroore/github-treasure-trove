<div>
    <div>
        <label class="block title-sm" for="courses">Course</label>
        <select wire:model="course" name="courses" id="courses">
            @forelse ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @empty
                <option value="null" disabled hidden selected>No courses available</option>
            @endforelse
        </select>
    </div>
    <div>
        <h3 class="mt-4 title">Course Students</h3>
        {{-- @dump($tasks) --}}
        <div class="flex flex-col outline-primary">
            <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-0">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 md:px-0">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    </th>
                                    @foreach ($tasks as $task_type => $task_type_tasks)
                                        <th scope="col" colspan="{{ $task_type_tasks->count() }}"
                                            class="px-6 {{ $this->getbg($task_type) }} text-center py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ Str::plural(\App\Models\TaskType::find($task_type)->name) }}
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Name
                                    </th>
                                    @foreach ($tasks as $type_tasks)
                                        @foreach ($type_tasks as $task)
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-center text-gray-500 uppercase">
                                                {{ $loop->iteration }}
                                            </th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $student->last_name }}, {{ $student->first_name }}
                                        </td>
                                        @foreach ($tasks->flatten() as $submission_task)
                                            @php
                                                $submission = $student->submissions->firstWhere('task_id', $submission_task->id);
                                            @endphp
                                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                                {{ $submission ? ($submission->date_graded ? "$submission->score/{$submission->task->max_score}" : 'unchecked') : 'none' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-4 text-center title-sm">No students enrolled in this
                                            course.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('page_title')
    Teacher Gradebook
@endsection

@section('title')
    Gradebook
@endsection
