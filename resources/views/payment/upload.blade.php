@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">            
            <a href='/payment'>Payments</a> -> batch upload
        </div>
        <div class="card-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>操作失败</strong> <br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>      
            @endif            
            <form action="{{ url('payment/import') }}" method="POST" name="importform" 
                  onSubmit="btn = document.getElementById('submitBtn');btn.disabled = true;btn.innerText = '上传中...'"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="file" class="form-control">
                <br>
                <button type="submit" class="btn btn-success" id="submitBtn"  >上传</button>
                <a href="{{url('payment/export?s=下载模板')}}">模板</a>
                <span class="text-muted">
                </span>
            </form>
        </div>
    </div>
</div>
@endsection