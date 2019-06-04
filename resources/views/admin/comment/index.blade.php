@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">评论管理</div>
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif


                    @foreach ($comments as $comment)
                        <hr>
                        <div class="comment">
                            <h4>{{ $comment->nickname }} 评论 {{$comment->article->title}}</h4>
                            <div class="content">
                                <p>
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ url('admin/comments/'.$comment->id.'/edit') }}" class="btn btn-success">编辑</a>
                        <form action="{{ url('admin/comments/'.$comment->id) }}" method="POST" style="display: inline;">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                    @endforeach

                </div>
                <div class='card-footer'>{{$comments->links()}}</div>
            </div>
        </div>
    </div>
</div>
@endsection