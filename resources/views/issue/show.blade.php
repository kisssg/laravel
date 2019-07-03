@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card" >

                <div class="card-header">
                    <button class="btn-default" onclick="javascript:history.back()">返回</button>
                    {{ $issue->issue  }}</div>
                <div class="card-body">
                    <table class='contracts'><tr><td>ID：{{$issue->id}}</td><td>来源：{{$issue->source}}</td></tr>
                        <tr><td>日期：{{$issue->date}}</td><td>合同号：{{$issue->contract_no}}</td></tr>
                        <tr><td>客户姓名：{{$issue->client_name}}</td><td>电话：{{$issue->phone}}</td></tr>
                        <tr><td colspan='2'>投诉对象：{{$issue->object}}</td></tr>
                        <tr><td>城市：{{$issue->city}}</td><td>区域：{{$issue->region}}</td></tr>
                        <tr><td>催收员：{{$issue->collector}}</td><td>工号：{{$issue->employeeID}}</td></tr>
                        <tr><td>困扰类型:{{$issue->harassment_type}}</td>
                            <td>异常类别：{{$issue->issue_type.'->'.$issue->issue}}</td></tr>
                        <tr><td colspan='2'>备注：{{$issue->remark}}</td></tr><tr><td colspan='2'>负责人/部门：{{$issue->responsible_person}}</td></tr>
                        <tr><td colspan='2'>反馈：{{$issue->feedback}}</td></tr>
                        <tr><td>反馈登记人：{{$issue->feedback_person}}</td><td>反馈时间：{{$issue->feedback_time}}</td></tr>
                        <tr><td>处理结果：<span class='badge {{$issue->result=="无效"?'badge-secondary':'badge-primary'}}'>{{$issue->result}}</span></td><td>QC姓名：{{$issue->qc_name}}</td></tr>
                        <tr><td>添加时间：{{$issue->add_time}}</span></td><td>回访ID：<span id='cid'>{{$issue->callback_id}}</td></tr>
                        <tr><td>关闭时间：{{$issue->close_time}}</td><td>关闭操作者：{{$issue->close_person}}</td></tr><tr><td colspan='2'>关闭原因：{{$issue->close_reason}}</td></tr>
                        <tr><td colspan="2"> 
                                执行的处罚：
                                @if($issue->hasManyViolations->count())
                                @foreach($issue->hasManyViolations as $violation)
                                <span class="badge badge-danger">{{$violation->punishment_decided}}</span><br/>
                                建议的处罚：{{$violation->punishment_proposed}}<br/>
                                {{$violation->who_execute_disciplinary.'：'.$violation->comment}}<br/>
                                <a href="{{url('violation/'.$violation->id)}}">Violation详情</a>
                                @endforeach
                                @else
                                <span class="badge badge-danger">No punishment yet</span>
                                @endif
                            </td></tr></table>
                </div>
                <div class="card-footer">
                    <button class="btn-default" onclick="javascript:history.back()">返回</button>
                </div>
            </div>
        </div>
    </div>
    @endsection