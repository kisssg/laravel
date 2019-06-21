@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
            
                
                <h5 class="card-header">后台管理</h5>

                <div class="card-body">

                    <a href="{{ url('admin/articles') }}" class="btn btn-lg btn-success col-xs-12">管理文章</a>
                    <a href="{{ url('admin/comments') }}" class="btn btn-lg btn-success col-xs-12">管理评论</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection