@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card-deck">
        <div class="card" style="max-width: 16rem; min-width: 16rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Issues</h5>
                <p class="card-text">QC submit issues when got complaint about LLIs or agencies.</p>
                <a href="{{url('issue')}}" class="btn btn-primary">Search issues</a>
                @can('upload issues')
                <a href="{{url('issue/upload')}}" class="btn btn-secondary">Upload</a>
                @endcan
            </div>
        </div>
        <div class="card" style="max-width: 16rem; min-width: 16rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Violations</h5>
                <p class="card-text">Valid issues will become violations and be punished.</p>
                <a href="{{url('violation')}}" class="btn btn-primary">Search violations</a>
                @can('upload violations')
                <a href="{{url('violation/upload')}}" class="btn btn-secondary">Upload</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection