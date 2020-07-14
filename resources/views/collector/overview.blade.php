@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href='/collector'>Collector</a> -> overview
                </div>
                <div class='card-body' id="content">
                    <table class="table">
                        <tr>
                            <td>Issues:</td>
                            <td>
                    <a href="/issue/search?s={{$collector->name_en}}">{{$collector->issuesCount}}</a></td>
                        </tr>
                        <tr>
                            <td>Violations:</td>
                            <td>
                    <a href="{{url('/violation/search?s='.$collector->name_en)}}">{{$collector->violationsCount}}</a></td>
                        </tr>
                        <tr>
                            <td>Camera Scores:</td>
                            <td>
                    <a href="{{url('/violation/search?s='.$collector->name_en)}}">{{$collector->fcCameraScoresCount}}</a></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-right">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
