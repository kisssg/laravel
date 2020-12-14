@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href='/collector'>Collector</a>
                </div>
                <div class='card-body' id="content">
                    <table class='table'>
                        @foreach($collector as $key=>$value)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>           
                        @endforeach
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a class='btn btn-light' href='{{url("collector/".$collector['id']."/edit")}}'>{{__('Edit')}}</a>
                    <a class='btn btn-light' href='{{url('collector')}}'>{{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
