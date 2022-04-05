@props(['course'])
<div class="p-4 bg-white outline-primary">
    <div>
        <h3 class="title-sm">Course Name: {{ $course->name }}</h3>
        <h3 class="title-sm">Course Code: {{ $course->code }}</h3>
        <h3 class="title-sm">Section Code: {{ $course->section_code }}</h3>
        <h4 class="title-sm">Date Created: {{ $course->readable_date_created }}</h4>
        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
</div>
