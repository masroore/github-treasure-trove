<div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 150px;" tabindex="0">
	<div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
		@foreach($categories as $category)
		<span class="wt-checkbox">
			<input id="wordpress{{$category->id}}" type="checkbox" name="jobCategory" value="{{$category->category_name}}" onchange="category(this)">
			<label for="wordpress{{$category->id}}"> {{$category->category_name}}</label>
		</span>
		@endforeach
		<div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
			<div class="mCSB_draggerContainer">
				<div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 70px; max-height: 140px; top: 0px;">
					<div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
					<div class="mCSB_draggerRail"></div>
				</div>
			</div>
		</div>
	</div>
</div>
