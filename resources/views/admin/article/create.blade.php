@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card card-default">
                <div class="card-header">新增一篇文章</div>
                <div class="card-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>新增失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/articles') }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="text" name="title" class="form-control" required="required" placeholder="请输入标题" value="{{old('title')}}">
                        <br>
                        <textarea name="body" rows="10" class="form-control" required="required" placeholder="请输入内容">{{old('body')}}</textarea>
                        <br>
                        <button class="btn btn-lg btn-info">新增文章</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection