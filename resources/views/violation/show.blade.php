@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="card" >

                <div class="card-header">
                    <button class="btn-default" onclick="window.history.go(-1);">Back</button>
                    {{ $violation->Issue->issue.' '.$violation->punishment_decided  }}</div>
                <div class="card-body">
                    <table class='table'><tr><td>ID：{{$violation->id}}</td><td><a href="{{url('issue/'.$violation->Issue->id)}}">See issue detail</a></td></tr>
                        <tr><td>Month propose：{{$violation->month_belong}}</td><td>Contract number：{{$violation->contract_no}}</td></tr>                        
                        <tr><td colspan='2'>Channel：{{$violation->channel}}</td></tr>
                        <tr><td>City：{{$violation->city_en}}</td><td>Region：{{$violation->region}}</td></tr>
                        <tr><td>Collector：{{$violation->name_collector}}</td><td>Employee ID：{{$violation->employee_id}}</td></tr>
                        <tr><td>Harassment:{{$violation->harassment_type}}</td>
                            <td>Issue type：{{$violation->Issue->issue_type.'->'.$violation->Issue->issue}}</td></tr>
                        <tr><td colspan='2'>Remark：{{$violation->Issue->remark}}</td></tr>
                        <tr><td colspan='2'>Feedback：{{$violation->Issue->feedback}}</td></tr>
                        <tr><td>Violation date：{{$violation->month_violation.' '.$violation->date_violation}}</td>
                            <td>Detected by：{{$violation->who_detected}}</td>
                        </tr>
                        <tr><td colspan='2'>Punishment proposed：{{$violation->punishment_proposed}}</td></tr>
                        <tr>
                            <td>Date proposed：{{$violation->month_propose_action.' '.$violation->date_propose_action}}</td>
                            <td>Proposed by：{{$violation->who_proposed_disciplinary}}</td>                            
                        </tr>
                        <tr>
                            <td colspan="2">Comments from region manager：{{$violation->region_manager_email}}
                                <span class="badge badge-success">{{$violation->region_manager_approval}}</span>
                                <br>{{$violation->region_manager_comment}}</td>
                        </tr>
                        <tr><td>Punishment determined：{{$violation->punishment_decided}}</td></tr>
                        <tr><td colspan='2'>Comment from determinator：{{$violation->comment}}</td></tr>
                        <tr><td>Date determined：{{$violation->month_decided_action.' '.$violation->date_decided_action}}</td>
                            <td>Punishment determined by：{{$violation->who_decide_disciplinary}}</td>
                        </tr>                       
                        <tr>
                            <td>Date punishment taking action：{{$violation->month_executed_disciplinary.' '.$violation->date_executed_disciplinary}}</td>
                            <td>Who take the action:{{$violation->who_execute_disciplinary}}</td></tr>
                        <tr><td>Date verify if action taken：{{$violation->month_verify_disciplinary.' '.$violation->date_verify_disciplinary}}</td>
                            <td>Verified by：{{$violation->who_verify_disciplinary}}</td></tr>                        	
                        <tr></tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn-default" onclick="window.history.go(-1);">Back</button>
                </div>
            </div>
        </div>
    </div>
    @endsection