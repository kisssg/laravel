@extends('layouts.app')
@section('content')
<div class='container-fluid'>
    <div class='card'>
        <div class='card-header'></div>
        <div class='card-body'>            
            data:
            <table class='table'>
                <tr v-for="(item, key, index) in {{$score->data($project)}}" class="row">                        
                    <td class="col-3">@{{ key }} </td><td class="col-6">@{{ item }} </td>                    
                </tr>
            </table>            
            score:
            <table class='table'>
                <tr v-for="(item, key, index) in {{$score}}" class="row">                        
                    <td class="col-3">@{{ key }} </td><td class="col-6">@{{ item }} </td>
                </tr>
            </table>
        </div>
        <div class='card-footer'></div>
    </div>
</div>
@endsection