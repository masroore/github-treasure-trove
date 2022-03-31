<div id="mCSB_4" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 150px;" tabindex="0">
	<div id="mCSB_4_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
		@foreach($languages as $language)
		<span class="wt-checkbox">
			<input  id="language-{{$language->id}}" type="checkbox" name="lang_search" value="{{$language->language_name}}">
			<label for="language-{{$language->id}}">{{$language->language_name}}</label>
		</span>
		@endforeach
		<div id="mCSB_4_scrollbar_vertical" class="mCSB_scrollTools mCSB_4_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
			<div class="mCSB_draggerContainer">
				<div id="mCSB_4_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 70px; max-height: 140px; top: 0px;">
					<div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
					<div class="mCSB_draggerRail"></div>
				</div>
			</div>
		</div>
	</div>
</div>
