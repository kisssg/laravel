@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card" >

                <div class="card-header">
                    <button class="btn-default" onclick="javascript:history.back()">back</button>
                    {{ $issue->issue  }}</div>
                <div class="card-body">

                    <table class='contracts'><tr><td>ID：{{$issue->id}}</td><td>Source：{{$issue->source}}</td></tr>
                        <tr><td>Date：{{$issue->date}}</td><td>Contract Number：{{$issue->contract_no}}</td></tr>
                        <tr><td>Client name：{{$issue->client_name}}</td><td>Phone：{{$issue->phone}}</td></tr>
                        <tr><td colspan='2'>Object：{{$issue->object}}</td></tr>
                        <tr><td>City：{{$issue->city}}</td><td>Region：{{$issue->region}}</td></tr>
                        <tr><td>Collector：{{$issue->collector}}</td><td>Employee ID：
                                @if($issue->Collector)
                                <a href="{{url('collector/'.$issue->Collector->id)}}">
                                    {{$issue->employeeID}}</a>
                                @else
                                {{$issue->employeeID}}
                                @endif
                            </td></tr>
                        <tr><td>Harassment:{{$issue->harassment_type}}</td>
                            <td>Issue Type：{{$issue->issue_type.'->'.$issue->issue}}</td></tr>
                        <tr><td colspan='2'>Remark：{{$issue->remark}}</td></tr><tr><td colspan='2'>Responsible person：{{$issue->responsible_person}}</td></tr>
                        <tr><td colspan='2'>Feedback：{{$issue->feedback}}</td></tr>
                        <tr><td>Feedback by：{{$issue->feedback_person}}</td><td>Feedback at：{{$issue->feedback_time}}</td></tr>
                        <tr><td>Result：<span class='badge {{$issue->result=="无效"?'badge-secondary':'badge-primary'}}'>{{$issue->result}}</span></td><td>QC name：{{$issue->qc_name}}</td></tr>
                        <tr><td>Created at：{{$issue->add_time}}</span></td><td>Source ID：<span id='cid'>{{$issue->callback_id}}</td></tr>
                        <tr><td>Closed at：{{$issue->close_time}}</td><td>Closed by：{{$issue->close_person}}</td></tr><tr><td colspan='2'>Close reason：{{$issue->close_reason}}</td></tr>
                        <tr><td colspan="2"> 
                                Punishment：<span class="text-muted">Function to be reshaped. Related punishment like bonus reduction, administrative actions taken, will be shown when data reconstructuring completed.</span>
                                <!--@if($issue->violation)
                                <span class="badge badge-danger">{{$issue->violation->punishment_decided}}</span><br/>
                                Punishment proposed：{{$issue->violation->punishment_proposed}}<br/>
                                {{$issue->violation->who_execute_disciplinary.'：'.$issue->violation->comment}}<br/>
                                <a href="{{url('violation/'.$issue->violation->id)}}">Violation detail</a>
                                @else
                                <span class="badge badge-danger">No punishment yet</span>
                                @endif-->
                            </td></tr></table>
                </div>
                <div class="card-footer">
                    <button class="btn-default" onclick="javascript:history.back()">Back</button>
                </div>
            </div>
        </div>
    </div>
    @endsection