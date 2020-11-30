@extends('layouts.app')

@section('content')
    @section('css')
        @livewireStyles
       @endsection
    <h3 class="page-title">{{ trans('tictic/title.create') }}</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('tictic/title.create') }}
        </div>
{{--        @livewire('music.index')--}}
{{--        @livewire('music.index')--}}
        @livewire('music.create')
    </div>


@endsection


@section('javascript')
    @livewireScripts
@endsection
