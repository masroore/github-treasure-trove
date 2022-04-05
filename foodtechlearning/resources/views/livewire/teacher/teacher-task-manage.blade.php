@section('page_title')
    Manage Task > {{ $task->name }}
@endsection

@section('title')
    Managing Task {{ $task->name }}
@endsection

<div>
    <div class="p-4 bg-white outline-primary">
        <div>
            <h3 class="title-sm">Task Name: {{ $task->name }}</h3>
            <h3 class="title-sm">Section Code: {{ $task->course->section_code }}</h3>
            <h4 class="title-sm">Deadline: {{ $task->readable_deadline }}</h4>
            <button onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="delete_task" class="button-danger">DELETE</button>
        </div>
    </div>
    <div class="flex outline-primary flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-0">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 md:px-0">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                First Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Score
                            </th>
                            <th scope="col" class="px-6 text-center py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($submissions as $submission)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $submission->user->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $submission->user->first_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $submission->score }}/{{$task->max_score}}
                                </td>
                                <td class="px-6 flex justify-center space-x-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('teacher.submission.grade', ['submission' => $submission]) }}" class="text-indigo-600 hover:text-indigo-900 focus:outline-none underline">Grade</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="title-sm text-center p-4">No submissions yet for this task.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
