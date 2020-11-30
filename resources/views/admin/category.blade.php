@extends('layouts.app')

@section('content')
    <h3 class="page-title"> Category </h3>


    <div class="panel panel-default">
        <div class="panel-heading">
           Category
        </div>
           @livewire('admin.category.category-controller')
    </div>
@stop

@section('javascript')

@endsection

