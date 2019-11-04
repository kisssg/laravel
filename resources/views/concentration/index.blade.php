@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <search-box wtf='{{\Request::get('s')}}'></search-box>  
        </div>
    </div>
</div>
@endsection
