@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href='{{url("project")}}'>{{$project->name}}</a> -> Items 
                    <span class="alert-success">{{old('msg')}}</span>
                    <a class="btn btn-primary float-right" href="{{url('project/item/create?project='.$project->id)}}">New</a>
                </div>
                <div id="content" class="card-deck" style="margin:15px auto;">
                    <table class="table table-responsive-lg">
                        <thead>
                        <th>Item</th><th>Order</th><th>Field</th><th>Type</th><th>Options/scores</th><th>Action</th>
                        </thead>
                        @foreach($project->items as $item)
                        <tr>
                            <td title='{{$item->sub_title}}'>{{$item->title}}</td>                           
                            <td>{{$item->order}}</td>   
                            <td>{{$item->score_field}}</td>
                            <td>{{$item->option_type}}</td>   
                            <td>{{$item->options}}<br/>
                                {{$item->scores}}</td>   
                            <td><a  href="{{url('project/item/'.$item->id."/edit")}}" class="btn btn-info btn-xs">Edit</a>
                                <form id="{{'delete-form'.$item->id}}" action="{{ url('project/item/'.$item->id) }}" method="POST" style="display: inline;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form></td>

                        </tr>
                        @endforeach                    
                    </table>
                </div>
                <div class='card-footer'></div>
            </div>
        </div>
    </div>
</div>
@endsection
