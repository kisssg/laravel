@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Payments</div>
                <div class='card-body' id="content">
                    <form action="{{ url('payment') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{Request::get('s')}}" placeholder="Search by name of collector...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    @if($payments->count())
                    <table class='table'>
                        <thead>
                        <th>year</th>
                        <th>month</th>
                        <th>Employee ID</th>
                        <th>Name CN</th>
                        <th>payment</th>
                        <th>assign_amt</th>
                        </thead>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{$payment->year}}</td>
                            <td>{{$payment->month}}</td>
                            <td>{{$payment->employee_id}}</td>
                            <td>{{$payment->NAME_COLLECTOR}}</td>
                            <td>{{$payment->PAYMENT}}</td>
                            <td>{{$payment->ASSIGN_AMT}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row text-right">
                        {{$payments->links()}}
                        <div class="text-right">
                            <a class="btn btn-light btn-xs" href="{{url('payment/export?s='.Request::get('s'))}}">导出Excel</a>
                            <a class="btn btn-light btn-xs" href="{{url('payment/upload')}}">Excel上传</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
