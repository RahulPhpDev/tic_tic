@extends('layouts.app')

@section('content')
    <h3 class="page-title">    {{trans('tictic/title.dashboard')}} </h3>
        

    <div class="panel panel-default">
        <div class="panel-heading">
            {{trans('tictic/title.list')}}
        </div>
         {{-- @livewire('admin/User/User') --}}
          {{-- @livewire('admin/music.user') --}}
           @livewire('admin.user.user')
    </div>
@stop

@section('javascript')

@endsection
