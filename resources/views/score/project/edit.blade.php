@extends('layouts.app') 
@section('content')
<div class="container">
    <form action='{{url('project/'.$project->id)}}' method="POST">
        <div class="card">
            {!! csrf_field() !!}
            {{ method_field('PATCH') }}
            <div class="card-header">{{$project->name}}</div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>保存失败</strong> 输入不符合要求<br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
            @endif                    
            <div class='card-body' id="content">
                <table class='table table-borderless'>
                    <tr>
                        <td class="text-right">Name:</td>
                        <td><input name='name' class='form-control' type='text' value='{{$project->name}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Description:</td>
                        <td><textarea name='description' class='form-control' rows="3">{{$project->description}}</textarea></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data to score:</td>
                        <td><input name='data_to_score' class='form-control' type='text' value='{{$project->data_to_score}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns:</td>
                        <td><input name='data_fillable' class='form-control' type='text' value='{{$project->data_fillable}}'/>
                        <span class="text-muted">separate by comma ','</span></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data list columns:</td>
                        <td><input name='data_list_columns' class='form-control' type='text' value='{{$project->data_list_columns}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data list column alias:</td>
                        <td><input name='data_list_column_alias' class='form-control' type='text' value='{{$project->data_list_column_alias}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns on score card:</td>
                        <td><input name='data_to_score_columns' class='form-control' type='text' value='{{$project->data_to_score_columns}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns to order by:</td>
                        <td><input name='order_by_columns' class='form-control' type='text' value='{{$project->order_by_columns}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data field of date:</td>
                        <td><input name='date_field' class='form-control' type='text' value='{{$project->date_field}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data field of contract number:</td>
                        <td><input name='contract_no_field' class='form-control' type='text' value='{{$project->contract_no_field}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">DIY search columns:</td>
                        <td><input name='search_columns' class='form-control' type='text' value='{{$project->search_columns}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Score save to:</td>
                        <td><input name='score_save_to' class='form-control' type='text' value='{{$project->score_save_to}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Score columns:</td>
                        <td><input name='score_fillable' class='form-control' type='text' value='{{$project->score_fillable}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Minutes allow edit in:</td>
                        <td><input name='minutes_allow_edit_in' class='form-control' type='text' value='{{$project->minutes_allow_edit_in}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Uncheck data limitation:</td>
                        <td><input name='uncheck_ceiling' class='form-control' type='text' value='{{$project->uncheck_ceiling}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Batch pick depends on:</td>
                        <td><input name='batchpick_depends_on' class='form-control' type='text' value='{{$project->batchpick_depends_on}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Allow single pick(0/1):</td>
                        <td><input name='allow_single_pick' class='form-control' type='text' value='{{$project->allow_single_pick}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Audit save to:</td>
                        <td><input name='audit_save_to' class='form-control' type='text' value='{{$project->audit_save_to}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Audit columns:</td>
                        <td><input name='audit_fillable' class='form-control' type='text' value='{{$project->audit_fillable}}'/></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type='submit' class='float-right btn btn-primary'>Save</button>
                <button onclick='history.back();' class='float-left btn btn-secondary'>Back</button>
            </div>
    </form>
</div>
</div>
@endsection
