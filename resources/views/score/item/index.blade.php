@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href='{{url("project")}}'>{{$project->name}}</a> -> Items
                    <a class="btn btn-primary float-right" href="{{url('project/item/create?project='.$project->id)}}">New</a>
                </div>
                <div id="content" class="card-deck" style="margin:15px auto;">
                    @foreach($project->items as $item)
                    <div class="card" style="max-width: 15rem; min-width: 15rem; position:relative;">
                        <div class="card-header">{{$item->title}}</div>
                        <div class="card-body">{{$item->sub_title}}
                            <table class="table table-borderless">
                            <tr>
                                <td>Order:</td>
                                <td>{{$item->order}}</td>
                            </tr>
                            <tr>
                                <td>Field:</td>
                                <td>{{$item->score_field}}</td>
                            </tr>
                            <tr>
                                <td>Type:</td>
                                <td>{{$item->option_type}}</td>
                            </tr>
                            <tr>
                                <td>Options:</td>
                                <td>{{$item->options}}</td>
                            </tr>
                            </table>
                        </div>
                        <div class="card-footer text-center">
                            <a class=" btn btn-primary float-left" href="{{url('project/item/'.$item->id."/edit")}}">Edit</a>
                            <button class="float-right btn btn-secondary" aria-label="Remove"><span class="glyphicon glyphicon-trash" aria-hidden="true">&times;</span></button></div>
                    </div>
                    @endforeach
                </div>
                <div class='card-footer'></div>
            </div>
        </div>
    </div>
</div>
@endsection
