@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Collectors</div>
                <div class='card-body' id="content">
                    <form action="{{ url('collector') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="s" value="{{Request::get('s')}}" placeholder="Search by name of collector...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go
                                </button>
                            </span>
                        </div>
                    </form>
                    @if($collectors->count())
                    <table class='table'>
                        <thead>
                        <th><input onclick='switch_check_all(this);' type='checkbox' />Name EN</th>
                        <th>Name CN</th>
                        <th>Area</th>
                        <th>City</th>
                        <th>Position</th>
                        <th>Employee ID</th>
                        <th>TL</th>
                        <th>SV</th>
                        <th>Manager</th>
                        <th>Type</th>
                        <th>Action</th>
                        </thead>
                        @foreach($collectors as $collector)
                        <tr>
                            <td><input name='checkbox_lli' type='checkbox' value='{{$collector->id}}'/>{{$collector->name_en}}</td>
                            <td>{{$collector->name_cn}}</td>
                            <td>{{$collector->area}}</td>
                            <td>{{$collector->city}}</td>
                            <td>{{$collector->position}}</td>
                            <td>{{$collector->employee_id}}</td>
                            <td>{{$collector->tl}}</td>
                            <td>{{$collector->sv}}</td>
                            <td>{{$collector->manager}}</td>
                            <td>{{$collector->type}}</td>
                            <td><a href='{{url("collector/".$collector->id)}}'>Detail...</a></td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row text-right">
                        {{$collectors->links()}}
                        <div class="text-right">
                            <a class="btn btn-light btn-xs" href="{{url('collector/export?s='.Request::get('s'))}}">导出Excel</a>
                            <a class="btn btn-light btn-xs" href="{{url('collector/upload')}}">Excel上传</a>
                            <a class='btn btn-light btn-xs' href="{{url('collector/create')}}">添加</a>                    
                            <button class="btn btn-light btn-xs" onclick="if (confirm('确认删除选择的外催员吗？')) {
                                        deleteCollector();
                                    }">删除</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function switch_check_all(src) {
        check_boxes = (document.getElementsByName('checkbox_lli'));
        for (i = 0; i < check_boxes.length; i++) {
            check_boxes[i].checked = src.checked;
        }
    }
    function deleteCollector() {
        check_boxes = document.getElementsByName('checkbox_lli');
        checked = [];
        for (i = 0; i < check_boxes.length; i++) {
            if (check_boxes[i].checked) {
                checked.push(check_boxes[i].value);
            }
        }
        console.log(checked);
        args = {
            'ids': checked
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(args);
        $.post('collector/delete', args, function (data) {
            console.log(data);
        }, 'json');
    }
</script>
@endsection
