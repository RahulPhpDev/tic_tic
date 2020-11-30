@extends('layouts.app')

@section('content')
    <h3 class="page-title">  {{trans('tictic/title.filter')}} </h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            {{trans('tictic/title.list')}}
        </div>
           @livewire('admin.filter.filter-controller')
    </div>
@stop

@section('javascript')

@endsection

