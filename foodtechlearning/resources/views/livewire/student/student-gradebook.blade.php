@section('page_title')
    Student Gradebook
@endsection

@section('title')
    Gradebook
@endsection

<div>
    <div>
        <label class="block title-sm" for="courses">Course</label>
        <select wire:model="class" name="courses" id="courses">
            @forelse ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @empty
                <option value="null" disabled hidden selected>No classes available</option>
            @endforelse
        </select>

        <div class="mt-8">
            @forelse ($tasks as $task_type => $type_tasks)
                <h3 class="uppercase title">{{ Str::plural(\App\Models\TaskType::find($task_type)->name) }}</h3>

                <div class="flex flex-col outline-primary">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-0">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 md:px-0">
                            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Task Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                                Score
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                                Date Submitted
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                                Date Checked
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($type_tasks as $task)
                                            @php
                                                $submission = $submissions->firstWhere('task_id', $task->id);
                                            @endphp
                                            @if ($submission)
                                                <tr class="bg-white">
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $task->name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                                        {{ $submission->score }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                                        {{ $submission->readable_date_submitted }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                                        {{ $submission->readable_date_graded }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="bg-white">
                                                    <td colspan="2"
                                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $task->name }}
                                                    </td>
                                                    <td colspan="2"
                                                        class="px-6 py-4 text-sm font-medium text-center text-gray-900 whitespace-nowrap">
                                                        No submission
                                                    </td>
                                                </tr>
                                            @endif

                                        @empty
                                            <tr>
                                                <td colspan="4" class="p-4 text-center title-sm">No tasks created for
                                                    this course.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h3 class="p-4 text-2xl text-center title">No tasks created for this course.</h3>
            @endforelse
        </div>
    </div>
</div>
