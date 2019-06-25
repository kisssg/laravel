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
                                <button class="btn btn-default" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul>
                        <li class="list-inline">{{$issues->total().' records'}}
                            @if($search)
                            <a class="btn btn-default btn-sm" href="{{url('issue/search?s='.$search.'&e=1')}}">导出excel</a></li>
                            @endif
                        @foreach ($issues as $issue)
                        <li class='list-group' style="margin: 30px;">
                            <div class="title row">
                                <div><span class='badge {{$issue->result=="无效"?'badge-secondary':'badge-primary'}}'>{{$issue->result}}</span></div>
                                <a href="{{ url('issue/detail/'.$issue->id) }}">
                                    <h4>{{ $issue->contract_no.'-'.$issue->issue.'-'.$issue->collector  }}</h4>
                                </a>
                            </div>
                            <div class="body">
                                <p>{{ $issue->remark }}</p>
                            </div>
                        </li> 
                        @endforeach
                    </ul>
                </div>
                <div class='card-footer'>{{$issues->links()}}</div>
            </div>
        </div>
    </div>
</div>
@endsection
