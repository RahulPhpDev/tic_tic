@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('tictic/title.create') }}</h3>
<p>
    <a href="{{ route('admin.music.create') }}" class="btn btn-success">@lang('tictic.add_new')</a>

</p>
<div class="panel panel-default">
    <div class="panel-heading">
        {{ trans('tictic/title.create') }}
    </div>
</div>
        @livewire('music.index')
    <div
@endsection

