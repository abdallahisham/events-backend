@extends('adminlte::page')

@section('title')
	Events dashboard
@stop

@section('content')
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">@lang('general.Events')</span>
              <span class="info-box-number">{{ $eventsCount ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">@lang('general.Featured events')</span>
              <span class="info-box-number">{{ $featuredEventsCount ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">@lang('general.Users')</span>
              <span class="info-box-number">{{ $usersCount ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-cubes"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">@lang('general.Events types')</span>
              <span class="info-box-number">{{ $eventTypesCount ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    </div>
@stop

@push('js')
	<script>
		
	</script>
@endpush