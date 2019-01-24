@extends('adminlte::page')

@section('title')
	Events dashboard - All events
@stop

@section('content')
	<h3>Featured Events</h3>
	<hr>
	<table class="table table-bordered table-hover" id="table" dir="rtl">
		<thead>
			<tr>
				<th class="text-center">@lang('general.ID')</th>
				<th class="text-center">@lang('general.Name')</th>
				<th class="text-center">@lang('general.Created by')</th>
				<th class="text-center">@lang('general.Start date') - @lang('general.End date')</th>
				<th class="text-center">@lang('general.Start time') - @lang('general.End time')</th>
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
			</tr>
			@endforeach
		</tbody>
	</table>
@stop

@push('js')
	<script>
		$('#table').DataTable({});
	</script>
@endpush