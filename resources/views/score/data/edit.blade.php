@extends('layouts.app') 
@section('content')
<div class="container">
    <form action='{{url('project/data/'.$data->id)}}' method="POST">
        <div class="card">
            <div class="card-header">
                <span class="float-left"><a href='{{url('project/'.$project->id)}}' >{{$project->name}}</a> -> Data ->Edit</span>
                <button type='submit' class='float-right btn btn-primary'>Save</button>
            </div>
            {{ method_field('PUT') }}
            {!! csrf_field() !!}
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>保存失败</strong> 输入不符合要求<br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
            @endif
            <span class="text-center alert-success">{{old('msg')}}</span>
            <div class="card-body">
                <table class='table table-borderless'>
                    @foreach($columns as $column)
                    <tr>
                        <td class="text-right">{{$column}}:</td>
                        <td><input name='{{$column}}' class='form-control' type='text' value='{{$data->$column}}'/></td>
                    </tr>
                    @endforeach
                </table>                    
            </div>
            <div class='card-footer text-center'>
                <input type="hidden" name="project_id" value="{{\Request::get('project_id')}}"/>
                <button type='submit' class='float-right btn btn-primary'>Save</button>
                <span class=" alert-success">{{old('msg')}}</span>
                <a href='{{url('project/'.\Request::get('project_id'))}}' class='float-left btn btn-secondary'>Back</a>
            </div>
        </div>
    </form>
</div>
@endsection
