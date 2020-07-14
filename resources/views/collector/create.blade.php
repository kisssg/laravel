@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form action='{{url('collector')}}' method="POST">
                    {!! csrf_field() !!}
                    <div class="card-header"><a href='/collector'>Collector</a> -> create</div>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>保存失败</strong> 输入不符合要求<br><br>
                        {!! implode('<br>', $errors->all()) !!}
                    </div>
                    @endif                    
                    <div class='card-body' id="content">
                        <table class='table'>
                            @foreach($collector as $key=>$value)
                            <tr>
                                <td>{{$key}}</td>
                                <td><input name='{{$key}}' class='form-control' type='text' value='{{old($key)}}'/></td>
                            </tr>           
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        <input type='submit' value="Save" class='btn btn-light'/>
                        <input type='button' value="Back" onclick='history.back();' class='btn btn-light'/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
