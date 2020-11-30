@extends('layouts.app')

@section('content')
    <h3 class="page-title">    {{trans('tictic/title.dashboard')}} </h3>
        

    <div class="panel panel-default">
        <div class="panel-heading">
            {{trans('tictic/title.list')}}
        </div>
           @livewire('admin.video.video')
    </div>
@stop

@section('javascript')

@endsection
