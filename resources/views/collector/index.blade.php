@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Collectors</div>
                <div class='card-body' id="content">
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
<!--                            <td>{{$collector->onboard_date}}</td>
                            <td>{{$collector->email}}</td>
                            <td>{{$collector->province}}</td>-->
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
                <div class="card-footer text-right">
                    {{$collectors->links()}}                    
                    <button class="btn btn-light" onclick="deleteCollector()">删除</button>
                    <button class="btn btn-light" onclick="">标记离职</button>
                    <a class='btn btn-light' href="{{url('collector/create')}}">创建</a>
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
        $.post('collector/delete', args, function (data) {
            console.log(data);
        }, 'json');
    }
</script>
@endsection
