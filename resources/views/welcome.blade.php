@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card-deck">
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Issues</h5>
                <p class="card-text">QC submit issues when got complaint about LLIs or agencies.</p>   
            </div>
            <div class='card-footer'>
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

            </div>
            <div class='card-footer'>
                <a href="{{url('violation')}}" class="btn btn-primary">Search</a>
                @can('upload violations')
                <a href="{{url('violation/upload')}}" class="btn btn-secondary">Upload</a>
                @endcan
            </div>
        </div>
        @can('view concentration')
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Concentration</h5>
                <p class="card-text">Concentration of collectors</p>   
            </div>
            <div class='card-footer'>
                <a href="{{url('concentration')}}" class="btn btn-primary">Go</a>                    
            </div>
        </div>
        @endcan

        @can('manage collectors')
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">Collectors</h5>
                <p class="card-text">Create, edit or erase collectors' info here.</p>   
            </div>
            <div class='card-footer'>
                <a href="{{url('collector')}}" class="btn btn-primary">Go</a>                    
            </div>
        </div>
        @endcan

        @foreach($projects as $project)
        @can('use project'.$project->id)
        <div class="card" style="max-width: 15rem; min-width: 15rem;">
            <img class="card-img-top" src="picture/blank.png" >
            <div class="card-body">
                <h5 class="card-title">{{$project->name}}</h5>
                <p class="card-text">{{$project->description}}</p>   
            </div>
            <div class='card-footer'>
                <a href="{{url('project/'.$project->id)}}" class="btn btn-primary">Go</a>                    
            </div>
        </div>
        @endcan        
        @endforeach

    </div>
</div>
@endsection