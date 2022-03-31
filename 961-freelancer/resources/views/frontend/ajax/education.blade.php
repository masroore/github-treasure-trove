<li id="educatn{{$educ->id}}">
	<div class="wt-accordioninnertitle">
		<span id="accordioneducation{{$educ->id}}" data-bs-toggle="collapse" data-bs-target="#innertitleeduc{{$educ->id}}"><span id="degree{{$educ->id}}">{{$educ->degree}}</span> <span id="start_edu{{$educ->id}}"><em>({{$educ->start_date}}</em></span> - <span id="end_edu{{$educ->id}}"><em> {{$educ->end_date}})</em></span></span>
		<div class="wt-rightarea">
			<a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" id="accordioneducation{{$educ->id}}" data-bs-toggle="collapse" data-bs-target="#innertitleeduc{{$educ->id}}" aria-expanded="true"><i class="fal fa-pencil"></i></a>
			<a href="javascript:void(0);" class="wt-deleteinfo" onclick="deleteEducation({{$educ->id}})"><i class="fal fa-trash-alt"></i></a>
		</div>
	</div>
	<div class="wt-collapseexp collapse" id="innertitleeduc{{$educ->id}}" aria-labelledby="accordioneducation{{$educ->id}}" data-parent="#accordion">
		<div class="wt-formtheme wt-userform">
			<fieldset>
				<input type="hidden" name="educaId" value="{{$educ->id}}">
				<div class="form-group form-group-half">
					<input type="text" name="institute" id="institute{{$educ->id}}" class="form-control" placeholder="School/College/University" value="{{$educ->institute}}">
				</div>
				<div class="form-group form-group-half">
					<input type="date" name="start_date" id="start_date_edu{{$educ->id}}" class="form-control" placeholder="From Date" value="{{$educ->start_date}}">
				</div>
				<div class="form-group form-group-half">
					<input type="date" name="end_date" id="end_date_edu{{$educ->id}}" class="form-control" placeholder="To Date " value="{{$educ->end_date}}">
				</div>
				<div class="form-group form-group-half">
					<input type="text" name="degree" id="degree_edu{{$educ->id}}" class="form-control" placeholder="Your Degree Title" value="{{$educ->degree}}">
				</div>
				<div class="form-group">
					<input type="text" name="area_of_study" id="area_of_study{{$educ->id}}" class="form-control" placeholder="Ex: Computer Science" value="{{$educ->area_of_study}}">
				</div>
				<div class="form-group">
					<textarea name="description" id="degree_desc{{$educ->id}}" class="form-control" placeholder="Your Degree Description">{{$educ->description}}</textarea>
				</div>
				<div class="form-group mt-3 text-end">
					<button onclick="editEducation({{$educ->id}})" class="wt-btn">Edit Education</button>
				</div>
			</fieldset>
		</div>
	</div>
</li>