@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Selected issues</div>

                <div id="content">
                    <ul>
                        @foreach ($test as $t)
                        <li style="margin: 50px 0;">
                            <div class="title">
                                <h4>{{ $t->object.'-'.$t->result.'-'.$t->issue_type.'-'.$t->date}}</h4>
                            </div>
                            <div class="body">{{$t->issue}}</div>
                        </li> 
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">{{$test->links()}}</div>
            </div>
        </div>
    </div>
</div>
@endsection
