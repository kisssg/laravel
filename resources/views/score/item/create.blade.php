@extends('layouts.app') 
@section('content')
<div class="container">
    <form action='{{url('project/item')}}' method="POST">
        <div class="card">
            <div class="card-header">
                {{$project->name}} -> Items ->New                    
            </div>
            {!! csrf_field() !!}
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>保存失败</strong> 输入不符合要求<br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
            @endif
            <div class="card-body">
                <table class='table table-borderless'>
                    <tr>
                        <td class="text-right">Title:</td>
                        <td><input name='title' class='form-control' type='text' value='{{old('title')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Sub Title:</td>
                        <td><input   name='sub_title' class='form-control' type="text" value="{{old('sub_title')}}"/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Score Field:</td>
                        <td><input name='score_field' class='form-control' type='text' value='{{old('score_field')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Order:</td>
                        <td><input name='order' class='form-control' type='text' value='{{old('order')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Option Type:</td>
                        <td><input name='option_type' class='form-control' type='text' value='{{old('option_type')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Options:</td>
                        <td><input name='options' class='form-control' type='text' value='{{old('options')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Scores:</td>
                        <td><input name='scores' class='form-control' type='text' value='{{old('scores')}}'/></td>
                    </tr>
                </table>                    
            </div>
            <div class='card-footer text-center'>
                <input type="hidden" name="project_id" value="{{\Request::get('project')}}"/>
                <button type='submit' class='float-right btn btn-primary'>Save</button>
                <span class=" alert-success">{{old('msg')}}</span>
                <a href='{{url('project/item/?project='.\Request::get('project'))}}' class='float-left btn btn-secondary'>Back</a>
            </div>
        </div>
    </form>
</div>
@endsection
