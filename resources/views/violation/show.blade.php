@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card" >

                <div class="card-header">
                    <button class="btn-default" onclick="history.back()">返回</button>
                    {{ $violation->issue.' '.$violation->punishment_decided  }}</div>
                <div class="card-body">
                    <table class='contracts'><tr><td>ID：{{$violation->id}}</td><td><a href="{{url('issue/'.$violation->Issue->id)}}">查看Issue</a></td></tr>
                        <tr><td>提出月份：{{$violation->month_belong}}</td><td>合同号：{{$violation->contract_no}}</td></tr>                        
                        <tr><td colspan='2'>Channel：{{$violation->channel}}</td></tr>
                        <tr><td>City：{{$violation->city_en}}</td><td>Region：{{$violation->region}}</td></tr>
                        <tr><td>催收员：{{$violation->name_lli}}</td><td>工号：{{$violation->employee_id}}</td></tr>
                        <tr><td>困扰类型:{{$violation->harassment_type}}</td>
                            <td>异常类别：{{$violation->issue_type.'->'.$violation->issue}}</td></tr>
                        <tr><td colspan='2'>备注：{{$violation->remark}}</td></tr>
                        <tr><td>违规日期：{{$violation->month_violation.' '.$violation->date_violation}}</td>
                            <td>发现违规的人：{{$violation->who_detected}}</td>
                        </tr>
                        <tr><td colspan='2'>建议的处罚：{{$violation->punishment_proposed}}</td></tr>
                        <tr>
                            <td>提交建议处罚的日期：{{$violation->month_propose_action.' '.$violation->date_propose_action}}</td>
                            <td>提交建议处罚的人：{{$violation->who_proposed_disciplinary}}</td>                            
                        </tr>
                        <tr><td>确定要执行的处罚：{{$violation->punishment_decided}}</td></tr>
                        <tr><td colspan='2'>确定执行什么处罚的人批注：{{$violation->comment}}</td></tr>
                        <tr><td>确定处罚的日期：{{$violation->month_decided_action.' '.$violation->date_decided_action}}</td>
                            <td>确定执行什么处罚的人：{{$violation->who_decide_disciplinary}}</td>
                        </tr>                       
                        <tr>
                            <td>执行处罚的日期：{{$violation->month_executed_disciplinary.' '.$violation->date_executed_disciplinary}}</td>
                            <td>执行处罚的人:{{$violation->who_execute_disciplinary}}</td></tr>
                        <tr><td>确认是否处罚的日期：{{$violation->month_verify_disciplinary.' '.$violation->date_verify_disciplinary}}</td>
                            <td>确认是否执行处罚的人：{{$violation->who_verify_disciplinary}}</td></tr>                        	
                        <tr></tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn-default" onclick="history.back()">返回</button>
                </div>
            </div>
        </div>
    </div>
    @endsection