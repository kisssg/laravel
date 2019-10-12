@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Selected issues {{$startDate.'-'.$endDate}}</div>

                <div id="content">
                    <table class='table'>
                        @foreach ($test as $t)
                        <tr>
                            <td>
                                <input name='checkbox_lli' type='checkbox' value='{{$t->id}}'/>{{ $t->object.'-'.$t->result.'-'.$t->issue_type.'-'.$t->date}}
                            </td>
                            <td>{{$t->issue}}</td>
                        </tr> 
                        @endforeach
                    </table>
                    <label for='checkAll'><input id='checkAll' onclick='switch_check_all(this);' type='checkbox' />全选</label>
                </div>
                <div class="card-footer">{{$test->links()}}</div>
            </div>
        </div>
    </div>
</div>
<script>
    function switch_check_all(src) {
        check_boxes = (document.getElementsByName('checkbox_lli'));
        for (i = 0; i < check_boxes.length; i++) {
            check_boxes[i].checked = src.checked;
        }
    }
    </script>
@endsection
