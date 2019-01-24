@extends('adminlte::page')

@section('title')
	Events dashboard - Change password
@stop

@section('content')
	<form action="{{ route('admin.change-password.post') }}" method="post">
		@csrf
		<div class="input-group">
			<label for="old-password">@lang('general.Old password')</label>
			<input type="password" name="old_password" class="form-control" id="old-password">
		</div>

		<div class="input-group">
			<label for="new-password">@lang('general.New password')</label>
			<input type="password" name="new_password" class="form-control" id="new-password">
		</div>

		<div class="input-group">
			<label for="new-password-confirmation">@lang('general.Confirm new password')</label>
			<input type="password" name="new_password_confirmation" class="form-control" id="new-password-confirmation">
		</div>

		<br>

		<button type="submit" class="btn btn-primary">@lang('general.Change password')</button>
	</form>
@stop