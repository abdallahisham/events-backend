@extends('adminlte::page')

@section('title')
	Events dashboard - All events
@stop

@section('content')
	<h3>Events</h3>
	{{-- <a href="{{ route('admin.events.create') }}" class="btn btn-primary"><b>Add event</b></a> --}}
	<hr>
	<table class="table table-bordered table-hover" id="table" dir="rtl">
		<thead>
			<tr>
				<th class="text-center">@lang('general.ID')</th>
				<th class="text-center">@lang('general.Name')</th>
				<th class="text-center">@lang('general.Created by')</th>
				<th class="text-center">@lang('general.Start date') - @lang('general.End date')</th>
				<th class="text-center">@lang('general.Start time') - @lang('general.End time')</th>
				<th class="text-center">@lang('general.Featured')?</th>
				<th class="text-center">@lang('general.Actions')</th>
			</tr>
		</thead>
		<tbody>
			@foreach($events as $event)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $event['name'] }}</td>
				<td>{{ $event['user_name'] }}</td>
				<td>{{ $event['start_date'] }} - {{ $event['end_date'] }}</td>
				<td dir="ltr" class="text-center">{{ $event['start_time'] }} - {{ $event['end_time'] }}</td>
				<td>
					@if($event['is_featured'] == 1)
						<label class="label label-success">@lang('general.Featured')</label>
					@else
						<label class="label label-danger">@lang('general.Not featured')</label>
					@endif
					<a href="{{ route('admin.events.featured.toggle', $event['id']) }}" class="btn btn-default">@lang('general.Toggle feature')</a>
				</td>
				<td>
					<form action="{{ route('admin.events.destroy', $event['id']) }}" method="post" onsubmit="return confirmDelete('{{ $event['name'] }}')">
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