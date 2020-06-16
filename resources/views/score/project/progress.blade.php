@extends('layouts.app')
@section('content')
<div class='container'>
    <div class='card'>
        <div class='card-header'>{{$project->name}} progress</div>
        <div class='card-body'>     
            <chart-container project="{{$project->id}}"></chart-container>
        </div>
        <div class='card-footer text-muted'>Notes: <br>1. keep owner blank to show data of all people during selected date range;
            <br>2. data are ordered by uncheck volume.</div>
    </div>
</div>
@endsection