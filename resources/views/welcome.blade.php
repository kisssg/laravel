@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card-deck">
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Issues</h5>
                <p class="card-text">QC submit issues when got complaint about LLIs or agencies.</p>
                <a href="{{url('issue')}}" class="btn btn-primary">Search</a>
                @can('upload issues')
                <a href="{{url('issue/upload')}}" class="btn btn-secondary">Upload</a>
                @endcan
            </div>
        </div>
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Violations</h5>
                <p class="card-text">Valid issues will become violations and be punished.</p>
                <a href="{{url('violation')}}" class="btn btn-primary">Search</a>
                @can('upload violations')
                <a href="{{url('violation/upload')}}" class="btn btn-secondary">Upload</a>
                @endcan
            </div>
        </div>
        @can('manage violations')
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Violation Handle</h5>
                <p class="card-text">Produce violations based on issues, handle region managers' confirmation</p>
                <a href="{{url('violation/handle')}}" class="btn btn-primary">Go</a>                    
            </div>
        </div>
        @endcan
        @can('manage collectors')
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Collectors</h5>
                <p class="card-text">Create, edit or erase collectors' info here.</p>
                <a href="{{url('collector')}}" class="btn btn-primary">Go</a>                    
            </div>
        </div>
        @endcan
        
    </div>
</div>
@endsection