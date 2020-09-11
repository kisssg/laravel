@extends('layouts.app')
	@section('content')
	<div class="container">
    @include('inc.messages')
	@can('create_users')
	 <div style="float:right;padding-right:20px;"><a href="{{ route('users.create') }}" title="Add New User">New</a><br /><br /></div>
	@endcan
		<div class="card-body">
			@if (count($users))
		<table id="users" class="table table-hover table-responsive-sm table-sm compact">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->created_at }}</td>
					<td>
					@can('view_users')
				{{-- <a href="{{ route('users.show', ['user' => $user->id]) }}" title="View User Details"><i class="fa fa-info-circle fa-2x"></i></a>&nbsp;&nbsp; --}}
					@endcan
					@can('edit_users')
					<a href="{{ route('users.edit', ['user' => $user->id]) }}" title="Edit User Details">Edit</a>
					@endcan
					@can('delete_users')
					<form method="post" action="{{ route('users.destroy', ['user' => $user->id]) }}" style="display:inline;">@csrf @method('DELETE') <a onclick="if(confirm('Really delete this user?')) { this.parentNode.submit(); }" title="Delete this User">Remove</a></form>
					@endcan
				</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Created</th>
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
