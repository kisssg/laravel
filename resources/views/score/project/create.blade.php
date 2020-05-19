@extends('layouts.app') 
@section('content')
<div class="container">
    <form action='{{url('project')}}' method="POST">
        <div class="card">
            {!! csrf_field() !!}
            <div class="card-header">New project</div>
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
                        <td><input name='name' class='form-control' type='text' value='{{old('name')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Description:</td>
                        <td><textarea name='description' class='form-control' rows="3">{{old('description')}}</textarea></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data to score:</td>
                        <td><input name='data_to_score' class='form-control' type='text' value='{{old('data_to_score')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns:</td>
                        <td><input name='data_fillable' class='form-control' type='text' value='{{old('data_fillable')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data list columns:</td>
                        <td><input name='data_list_columns' class='form-control' type='text' value='{{old('data_list_columns')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data list column alias(titles showing):</td>
                        <td><input name='data_list_column_alias' class='form-control' type='text' value='{{old('data_list_column_alias')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns on score card:</td>
                        <td><input name='data_to_score_columns' class='form-control' type='text' value='{{old('data_to_score_columns')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data columns to order by:</td>
                        <td><input name='order_by_columns' class='form-control' type='text' value='{{old('order_by_columns')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data field of date:</td>
                        <td><input name='date_field' class='form-control' type='text' value='{{old('date_field')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Data field of contract number:</td>
                        <td><input name='contract_no_field' class='form-control' type='text' value='{{old('contract_no_field')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">DIY search columns:</td>
                        <td><input name='search_columns' class='form-control' type='text' value='{{old('search_columns')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Score save to:</td>
                        <td><input name='score_save_to' class='form-control' type='text' value='{{old('score_save_to')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Score columns:</td>
                        <td><input name='score_fillable' class='form-control' type='text' value='{{old('score_fillable')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Audit save to:</td>
                        <td><input name='audit_save_to' class='form-control' type='text' value='{{old('audit_save_to')}}'/></td>
                    </tr>
                    <tr>
                        <td class="text-right">Audit columns:</td>
                        <td><input name='audit_fillable' class='form-control' type='text' value='{{old('audit_fillable')}}'/></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer"><button type='submit' class='float-right btn btn-primary'>Save</button>
                <button onclick='history.back();' class='float-left btn btn-secondary'>Back</button>
            </div>
    </form>
</div>
</div>
@endsection
