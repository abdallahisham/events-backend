@extends('adminlte::page')

@section('title')
	Events dashboard - All users
@stop

@section('content')
	<h3>Users</h3>
	{{-- <a href="{{ route('admin.events.create') }}" class="btn btn-primary"><b>Add event</b></a> --}}
	<hr>
	<table class="table table-bordered table-hover" id="table" dir="rtl">
		<thead>
			<tr>
				<th class="text-center">@lang('general.ID')</th>
				<th class="text-center">@lang('general.Name')</th>
				<th class="text-center">@lang('general.Email')</th>
				<th class="text-center">@lang('general.Mobile number')</th>
				<th class="text-center">@lang('general.Actions')</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->mobile_number }}</td>
				<td>
					<form action="{{ route('admin.users.destroy', $user) }}" method="post" onsubmit="return confirmDelete('{{ $user->name }}')">
						@csrf
						@method('delete')
						<button type="submit" class="btn btn-danger">@lang('general.Delete')</button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@stop

@push('js')
	<script>
		$('#table').DataTable({});
		function confirmDelete(name)
		{
			return confirm(`@lang('general.Are you sure want to delete') '${name}'?`);
		}
	</script>
@endpush