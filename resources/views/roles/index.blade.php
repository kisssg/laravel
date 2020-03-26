@extends('layouts.app')
@section('content')
<div class="container">
    @include('inc.messages')
    @can('create_roles')
    <div style="float:right;padding-right:20px;"><a href="{{ route('roles.create') }}" title="Add New Role">New+</a><br /><br /></div>
    @endcan
    <div class="card-body">
        @if (count($roles))
        <table id="roles" class="table table-hover table-responsive-sm table-sm compact">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Guard Name</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>{{ $role->created_at->toFormattedDateString() }}</td>
                    <td>{{ $role->updated_at->toFormattedDateString() }}</td>
                    <td>
                        {{-- <a href="{{ route('roles.show', ['role' => $role->id]) }}" title="View Role Details"><i class="fa fa-info-circle fa-2x"></i></a>&nbsp;&nbsp; --}}
                        @can('edit_roles')
                        <a href="{{ route('roles.edit', ['role' => $role->id]) }}" title="Edit Role Details">Edit</a>&nbsp;&nbsp;
                        @endcan
                        <a href="{{ route('roles.destroy', ['role' => $role->id]) }}" title="Remove Role">Remove</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Guard Name</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        @else
        <center>No Records Found...</center>
        @endif
    </div>
</div>
@endsection
