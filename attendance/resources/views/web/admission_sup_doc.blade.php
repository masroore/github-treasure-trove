@extends('web.layouts.web_layout')


@section('title', 'Oguses IT Solutions | OSN Support Document')

@section('addcss')
		<link rel="stylesheet" href="{{URL::to('css/bootstrap.min.css')}}">
@endsection

@section('content')
	<!-- banner -->
	<div class="banner-agile-2">
		@include('web.layouts.admsion_nav')
	</div>
	<!-- breadcrumb -->
	@include('web.layouts.breadcrumb')
	<!-- breadcrumb -->
	<!-- //banner -->

<!-- admission form -->
	<div class="form-w3l py-5">
		<div class="container py-xl-5 py-lg-3">
			<h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">Admission
				<span class="font-weight-bold">form</span>
			</h3>
			
			<div class="register-form pt-md-4">
				<form action="{{route('submit-sup-doc')}}" method="post" id="uploaddoc" enctype="multipart/form-data">
					@csrf
					<legend>Suppoting Documnents</legend>
						<div class="styled-input agile-styled-input-top form-group">
							<label>Document Type</label>
							<select class="category2" name="doctype" required>
								<option value=""></option>
								<option value="Certificate">Certificate</option>
								<option value="Results">Results</option>
								<option value="Others">Others</option>
							</select>
						</div>
						<legend>Upload Document</legend>
						<div class="styled-input form-group">
							<input type="file" class="form-control"  name="fileToUpload" required="" style="background: none;">
						</div>
						<input type="submit" value="Upload Document">
				</form>
			</div>
			<div class="register-form pt-md-4">
				@if($supportdoc)
				<div class="table-responsive" style="background-color: rgb(249 246 249 / 30%);">
					<button class="btn btn-default">Total Document Uploaded&nbsp;<span style="font-size:1.0em;"class="badge">{{ count($supportdoc )}}</span></button>
					<div id="showAirtest" style="background-color: rgb(249 246 249 / 30%);">
						<table class="table table-striped"  border="1" cellpadding="10">
							<tr>
								<th>Document Type</th>
								<th>filename</th>
								<th>Uploaded</th>
								<th>View</th>
								<th>Delect</th>
							</tr>
							@foreach($supportdoc as $docs)
								<tr>
									<td>{{$docs->doctype}}</td>
									<td>{{$docs->filename}}</td>
									<td>{{$docs->created_at}}</td>
								<td><a href="{{asset('storage')}}/{{$docs->name}}" target="_blank" class="btn btn-success"><span class="fa fa-eye"></span></a></td>
									<!-- <td>{{asset('storage', $docs->name)}}</td> -->
			<td>
				<a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$docs->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-trash'></i>Delete</a>
<form id="delete_doc_{{$docs->id}}" 
	action="{{ route('doc-delete', ['id'=> $docs->id ]) }}" method="POST" style="display: none;">
				                    
				       @csrf
				               </form>	
								</td>
								</tr>	
							@endforeach
						</table>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	<!-- admission form -->


@endsection