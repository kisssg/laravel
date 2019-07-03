@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            Issues batch upload
        </div>
        <div class="card-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>操作失败</strong> <br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>      
            @endif            
            @can('upload issues')
            <form action="{{ url('issue/import') }}" method="POST" name="importform" 
                  onSubmit="btn = document.getElementById('submitBtn');btn.disabled = true;btn.innerText = '上传中...'"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="file" class="form-control">
                <br>
                <button type="submit" class="btn btn-success" id="submitBtn"  >上传</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection