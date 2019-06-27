@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Violations</div>

                <div id="content">
                    <form action="{{ url('violation/search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{$search}}" placeholder="Search by name of collector or contract number...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul>
                        <li class="list-inline">{{$violations->total().' records'}}

                            @foreach ($violations as $violation)
                        <li class='list-group' style="margin: 30px;">
                            <div class="title row">                                
                                <a href="{{ url('violation/'.$violation->id) }}">
                                    <h4>{{ $violation->contract_no.'-'.$violation->issue.'-'.$violation->punishment_decided  }}</h4>
                                </a>
                            </div>
                            <div class="body">
                                <p>{{ $violation->remark }}</p>
                            </div>
                        </li> 
                        @endforeach
                    </ul>
                </div>
                <div class='card-footer'><div class="row">{{$violations->links()}}
                        @if($search)
                        <div> <a class="btn btn-primary" href="{{url('violation/search?s='.$search.'&e=1')}}">导出excel</a></li>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
