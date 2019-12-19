@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Score Projects
                    <a class="btn btn-primary float-right" href="{{url('project/create')}}">New</a>
                </div>
                <div id="content" class="card-deck" style="margin:15px auto;">
                    @foreach($projects as $project)
                    <div class="card" style="max-width: 15rem; min-width: 15rem; position:relative;">
                        <div class="card-header">{{$project->name}}</div>
                        <div class="card-body">{{$project->description}}</div>
                        <div class="card-footer text-center">
                            <a class="btn btn-success float-left" href="{{url('project/item?project='.$project->id)}}">Items</a>
                            <a class=" btn btn-primary" href="{{url('project/'.$project->id."/edit")}}">Edit</a>
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
