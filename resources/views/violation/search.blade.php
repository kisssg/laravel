@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Violations</div>

                <div id="content">
                    <form action="{{ url('violation/search') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-search-modal">+</button>
                            </div>
                            <input type="text" class="form-control" name="s" value="{{\Request::get('s')}}" placeholder="Search by name of collector or contract number...">
                            <span class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search
                                </button>
                            </span>
                        </div>
                    </form>
                    {{$violations->total().' records'}}
                    <table class='table'>
                        <th>Contract No.</th><th>Collector</th><th>Issue</th><th>Punishment Proposed</th><th>RM Email</th><th>RM Approval</th><th>Status</th><th>Action</th>
                        @foreach ($violations as $violation)
                        <tr>
                            <td> 
                                <input name='checkbox_id' type='checkbox' value='{{$violation->id.",".$violation->region_manager_email}}'/>{{ $violation->contract_no}}</td>
                            <td>{{$violation->name_collector}}</td>
                            <td>{{$violation->issue}}</td>
                            <td>{{FLOOR(($violation->bonus_reduction)*100).'%'.'&'.$violation->action_level  }}
                            </td>
                            <td>{{$violation->region_manager_email}}</td>
                            <td>{{$violation->region_manager_approval}}</td>
                            <td>{{ $violation->status }}</td>
                            <td><a href="{{ url('violation/'.$violation->id) }}">detail</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class='card-footer'>{{$violations->links()}}
                    <div class="row">
                        @can('handle violation')
                        <div> 
                            <label for='selectall'><input id='selectall' onclick='switch_check_all(this);' type='checkbox' />全选</label>
                            <button type="button" data-toggle="modal" data-target=".bs-example-modal">生成Violation</button>
                            <button type="button" data-toggle='modal' data-target=".bs-propose-modal">设定建议处罚</button>
                            <button onclick='return setEmails();'>设定收件人</button>
                            <button onclick='return sendFeedbackLinks();'>发送邮件</button>
                            <button disabled>生成最终处罚</button>
                            <a class="btn" href="{{url('violation/search?s='.\Request::get('s').'&e=1')}}">导出excel</a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("violation.modals")
@endsection
