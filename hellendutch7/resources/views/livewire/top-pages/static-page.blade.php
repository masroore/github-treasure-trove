<div>
    <div class="text-base p-4">
        <div class="prose lg:prose-xl  text-justify ">
            @foreach ($paras as $para)
            <p class="pb-2">{!! $para->para_content!!}</p>
            @endforeach
            <br>
        </div>
    </div>
</div>