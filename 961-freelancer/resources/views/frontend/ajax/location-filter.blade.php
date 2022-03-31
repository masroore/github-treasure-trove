<div id="mCSB_2" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 150px;" tabindex="0">
	<div id="mCSB_2_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
		@foreach($countries as $country)
		<span class="wt-checkbox">
			<input id="wt-description{{$country->id}}" type="checkbox" name="job_location" value="{{$country->name}}">
			<label for="wt-description{{$country->id}}">  {{$country->name}}</label>
		</span>
		@endforeach
		<div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
			<div class="mCSB_draggerContainer">
				<div id="mCSB_2_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 70px; max-height: 140px; top: 0px;">
					<div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
					<div class="mCSB_draggerRail"></div>
				</div>
			</div>
		</div>
	</div>
</div>
