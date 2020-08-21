@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Training results</div>
                <div class='card-body' id="content">
                    <form action="{{ url('training') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{Request::get('s')}}" placeholder="Search by name of collector...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    @if($trainings->count())
                    <table class='table'>
                        <thead>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Training type</th><th>Training date</th><th>Business</th><th>Much</th><th>VRD</th>
                        <th>Phone collection</th><th>Oral score</th><th>COC score</th><th>General score</th>
                        <th>updated at</th>
                        </thead>
                        @foreach($trainings as $training)
                        <tr>
                            <td>{{$training->name_cn}}</td>
                            <td>{{$training->employee_id}}</td>
                            <td>{{$training->training_type}}</td>
                            <td>{{$training->training_date}}</td>
                            <td>{{$training->business_score}}</td>
                            <td>{{$training->much_score}}</td>
                            <td>{{$training->vrd_score}}</td>
                            <td>{{$training->phone_score}}</td>
                            <td>{{$training->oral_score}}</td>
                            <td>{{$training->coc_score}}</td>
                            <td>{{$training->general_score}}</td>
                            <td>{{$training->updated_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row text-right">
                        {{$trainings->links()}}
                        <div class="text-right">
                            <a class="btn btn-light btn-xs" href="{{url('training/export?s='.Request::get('s'))}}">导出Excel</a>
                            <a class="btn btn-light btn-xs" href="{{url('training/upload')}}">Excel上传</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
