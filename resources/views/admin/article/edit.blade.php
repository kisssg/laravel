@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card card-default">
                <div class="card-header">编辑文章</div>
                <div class="card-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>更新失败</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <form action="{{ url('admin/articles/'.$article->id) }}" method="POST">
                    	{{ method_field('PATCH') }}
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$article->id}}"/>
                        <input type="hidden" name="user_id" value="{{$article->user_id}}"/>
                        <input type="text" name="title" class="form-control" required="required" placeholder="请输入标题" value="{{$article->title}}">
                        <br>
                        <textarea name="body" rows="10" class="form-control" required="required" placeholder="请输入内容">{{ $article->body }}</textarea>
                        <br>
                        <button class="btn btn-lg btn-info">提交</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection