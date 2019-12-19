@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            {{$project->name}}
        </div>
        <div id="content" class="card-body" >
            <table class='table-condensed table-bordered'>
                <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                </thead>
                @foreach($data as $d)
                <tr>
                    <td>{{$d->NAME_COLLECTOR}}</td>
                    <td>{{$d->owner}}</td>
                    <td>
                <data-pick-button id='{{$d->id}}' user='{{$d->owner}}' project='{{$project->id}}' @set-data='setData' @set-score='setScore'></data-pick-button>
                </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class='card-footer'>{{$data->links()}}</div>
    </div>
</div>
@include('score.project.modals')
@endsection
