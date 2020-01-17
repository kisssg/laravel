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
                                <a  href="{{ url('project/item/'.$item->id) }}"  class="btn btn-danger btn-xs"
                                    onclick="event.preventDefault();
                                            if (confirm('Remove item?')) {
                                                document.getElementById('delete-form').submit();
                                            }">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">&times;</span>
                                </a></td>

                        <form id="delete-form" action="{{ url('project/item/'.$item->id) }}" method="POST" style="display: none;">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>
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
