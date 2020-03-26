@extends('layouts.app')

@section('content')
   <div class="container">
    @include('inc.messages')
            <form method='POST' action="{{route('permissions.update', $permission->id)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
               <label for="code">Permission Name</label>
               <input type="text" name="name" value="{{$permission->name}}" class='form-control' placeholder='Permission Name'>
            </div>
            <div class="form-group">
               <label for="name">Guard Name</label>
               <input type="text" name="guard_name" value="{{$permission->guard_name}}" class='form-control' placeholder='Guard Name'>
            </div>
               <input type="submit" value="Submit" class="btn btn-primary">
         </form>
   </div>
@endsection
