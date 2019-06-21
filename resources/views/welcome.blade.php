@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card-deck">
            <div class="card" style="width: 18rem; ">
                <img class="card-img-top" src="picture/blank.png" >
                <div class="card-body">
                    <h5 class="card-title">Issues</h5>
                    <p class="card-text">QC submit issues when got complaint about LLIs or agencies.</p>
                    <a href="{{url('issue')}}" class="btn btn-primary">Search issues</a>
                </div>
            </div>
      <div class="card" style="width: 18rem; ">
                <img class="card-img-top" src="picture/blank.png" >
                <div class="card-body">
                    <h5 class="card-title">placeholder</h5>
                    <p class="card-text">Many people think that beautiful things don't last long, I don't think so.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection