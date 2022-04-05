<div class="flex flex-col h-full" x-data x-init="
    new JitsiMeetExternalAPI('meet.jit.si',{
        roomName: '{{ $this->room }}',
        parentNode: $refs.meeting_container
    })
">
    <div id="meet" class="flex-1" x-ref="meeting_container"></div>
</div>
