@extends('app')


@section('content')
	<div class="flash-message">
	    @if(Session::has('success'))
		   <div class="alert alert-info alert-block">
					<button type="button" class="close" data-dismiss="alert">X</button>
				<strong>{{ "Success" }}</strong>
			</div>
	    @endif
	</div>
	<div class="container-fluid">
		<div class="row">
				<h2>User Profile</h2>
				<form name="userProfile" action="{{ url('/user/profile') }}" class="form-horizontal" >
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="_method" value="put" >

					<div class="form-group">
						<input type="hidden" class="form-control" name="userId" value="{{ Auth::user()->id }}">
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">First Name</label>
						<div class="col-sm-4">
							<input type="text" name="firstName" id="firstName" value="<?php echo ($profile->first_name)?$profile->first_name:'';?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Last Name</label>
						<div class="col-sm-4">
							<input type="text" name="lastName" id="lastName" value="<?php echo ($profile->last_name)?$profile->last_name:'';?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Dob</label>
						<div class="col-sm-4">
							<input type="date" name="dob" id="dob" value="<?php echo ($profile->dob)?$profile->dob:'';?>" class="form-control">
						</div>
					</div>
					<div class="checkbox">
						<label class="col-sm-4 control-label">Gender</label>
						<div class="col-sm-4">
							<input type="radio" name="gender" id="gender" value="M" <?php echo ($profile->gender == "M")?"checked":"" ?>>Male
							<input type="radio" name="gender" id="gender" value="F" <?php echo ($profile->gender == "F")?"checked":"" ?>>Female
						</div>
					</div>
					<div class="form-group">
				      <div class="col-sm-offset-6 col-sm-2">
				        <input type="submit" value="Update" class="btn btn-primary align-center">
				      </div>
				    </div>

				</form>
			</div>
		</div>
 @endsection