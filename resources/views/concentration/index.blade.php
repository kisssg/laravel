@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Concentration on Collector</div>
                <div class="card-body">
                    <div class='row'><div class='col-md-5'><v-select  :options="collectors" :reduce="name_en=>name_en.employee_id" label='name_en' @search="fetchCollectors" v-model="name_en"></v-select>
                        </div>
                        </div>
                        <issues :id="name_en"></issues>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
