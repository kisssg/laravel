@extends('layouts.app') 
@section('content')
<div class="card">
    <div class="card-header text-center">
        <div class="float-left">{{$project->name}} data list {{$data->total()}}</div>
        <span class=" alert-success">{{old('msg')}}</span>
        <div class="float-right"><a class="btn btn-sm btn-primary" href="{{url("project/data/create?project_id=".$project->id)}}">+</a></div>
    </div>
    <div id="content" class="card-body" >            
        <score-data-search project_id="{{$project->id}}" query_string="{{\Request::get('s')}}"></score-data-search>
        <table class='table table-striped  table-hover table-responsive-md'>
            <thead>
                @foreach(explode(",",$project->data_list_column_alias) as $title)
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
                    <span class="inline">
                        <data-pick-button id='{{$d->id}}' user='{{$d->owner}}' project='{{$project->id}}' @set-data='setData' @set-score='setScore' ref="pickScoreBtn{{$d->id}}"></data-pick-button>
                        <audit-button id='{{$d->id}}' user='{{$d->owner}}' project='{{$project->id}}' @set-data='setData' @set-score='setScore' @set-audit='setAudit' ref="auditBtn{{$d->id}}">Audit</audit-button>
                        <div class="dropdown">
                            <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ...
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url("project/data/".$d->id."/edit?project_id=".$project->id)}}">Edit</a>
                                <form action="{{ url('project/data/'.$d->id.'?project_id='.$project->id) }}" method="POST" onsubmit="return confirm('Really want to remove this data?');">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="submit" class="dropdown-item"  value="Delete"/>
                                </form>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class='card-footer'>{{$data->links()}}</div>
</div>
@include('score.project.modals')
@endsection
