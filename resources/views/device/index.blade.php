@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Devices</div>
                <div class='card-body' id="content">
                    <form action="{{ url('device') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{Request::get('s')}}" placeholder="Search by name of collector...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    @if($devices->count())
                    <table class='table'>
                        <thead>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Device</th>
                        <th>status</th>
                        <th>remark</th>
                        <th>updated by</th>
                        <th>updated at</th>
                        </thead>
                        @foreach($devices as $device)
                        <tr>
                            <td>{{$device->name}}</td>
                            <td>{{$device->employee_id}}</td>
                            <td>{{$device->device}}</td>
                            <td>{{$device->status}}</td>
                            <td>{{$device->remark}}</td>
                            <td>{{$device->updated_by}}</td>
                            <td>{{$device->updated_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row text-right">
                        {{$devices->links()}}
                        <div class="text-right">
                            <a class="btn btn-light btn-xs" href="{{url('device/export?s='.Request::get('s'))}}">导出Excel</a>
                            <a class="btn btn-light btn-xs" href="{{url('device/upload')}}">Excel上传</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
