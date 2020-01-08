@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            {{$project->name}} data list
        </div>
        <div id="content" class="card-body" >
            <score-data-search project_id="{{$project->id}}" query_string="{{\Request::get('s')}}"></score-data-search>
            <table class='table-condensed table-bordered'>
                <thead>
                    @foreach(explode(",",$project->data_list_columns) as $title)
                <th>{{$title}}</th>                    
                @endforeach
                <th>Action</th>
                </thead>
                @foreach($data as $d)
                <tr>
                    @foreach(explode(",",$project->data_list_columns) as $title)
                    <td>{{$d->$title}}</td>                    
                    @endforeach
                    <td>
                <data-pick-button id='{{$d->id}}' user='{{$d->owner}}' project='{{$project->id}}' @set-data='setData' @set-score='setScore' ref="pickScoreBtn{{$d->id}}"></data-pick-button>
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
