@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Issues</div>

                <div id="content">
                    <form action="{{ url('issue/search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{$search}}" placeholder="Search by name of collector or contract number...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
