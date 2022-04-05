@section('page_title')
    Manage Course Students > {{ $course->name }}
@endsection

@section('title')
    Managing Students
@endsection

<div class="flex h-full flex-col">
    <x-course-description :course="$course">
        <div>
            <h4 class="title-sm">No. of students: {{ $students->count() }}</h4>
        </div>
    </x-course-description>
    <div class="my-4 p-4 outline-primary">
        <div class="flex-1 flex flex-col space-y-2 md:flex-row md:space-y-0 md:items-stretch md:space-x-2">
            <input wire:model.defer="email" type="text" placeholder="Student email address..." class="@error('email'){{'error-outline'}}@enderror text-sm w-full">
            <button wire:click="enrol" class="button-primary flex-shrink-0 text-sm">Enrol Student</button>
        </div>
        <x-error field="email" class="error-xs"/>
    </div>
    <div class="flex outline-primary flex-col">
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
                                Email
                            </th>
                            <th scope="col" class="px-6 text-center py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $student->last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->first_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->email }}
                                    </td>
                                    <td class="px-6 flex justify-center space-x-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="unenroll({{ $student }})" class="text-indigo-600 hover:text-indigo-900 focus:outline-none underline">Unenroll</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="title-sm text-center p-4">No students enrolled in this course.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
