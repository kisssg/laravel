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
                        <li class="list-inline">{{$issues->total().' records'}}

                            @foreach ($issues as $issue)
                        <li class='list-group' style="margin: 30px;">
                            <div class="title row">
                                <div><span class='badge {{$issue->result=="无效"?'badge-secondary':'badge-primary'}}'>{{$issue->result}}</span></div>
                                <a href="{{ url('issue/'.$issue->id) }}">
                                    <h4>{{ $issue->date.' '.$issue->issue  }}</h4>
                                </a>
                            </div>
                            <div class="body">
                                <p>{{ $issue->remark }}</p>
                            </div>
                        </li> 
                        @endforeach
                    </ul>
                </div>
                <div class='card-footer'><div class="row">{{$issues->links()}}
                        @if($search)
                        <div> <a class="btn btn-primary" href="{{url('issue/search?s='.$search.'&e=1')}}">导出excel</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
