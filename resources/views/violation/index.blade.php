@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Violations</div>

                <div id="content">
                    <form action="{{ url('violation/search') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-search-modal">+</button>
                            </div>
                            <input type="text" class="form-control" name="s" value="{{$search}}" placeholder="Search by name of collector or contract number...">
                            <span class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul>
                        
                    </ul>
                </div>
                <div class="card-footer">
                    @can("handle violation")
                    <button type="button" data-toggle="modal" data-target=".bs-example-modal">生成Violation</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@include("violation.modals")
@endsection
