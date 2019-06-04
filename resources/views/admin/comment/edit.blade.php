@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset-1">
			<div class="card card-default">
				<div class="card-header">编辑评论 ->{{$comment->article->title}}</div>
				<div class="card-body">

					@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>更新失败</strong> 输入不符合要求<br> <br> {!! implode('<br>',
						$errors->all()) !!}
					</div>
					@endif

					<form action="{{ url('admin/comments/'.$comment->id) }}"
						method="POST">
						{{ method_field('PATCH') }} {!! csrf_field() !!} <input
							type="hidden" name="id" value="{{$comment->id}}" /> <input
							type="hidden" name="user_id" value="{{$comment->user_id}}" />
						<div class='form-group'>
							<div class='label'>昵称</div>
							<input type="text" name="nickname" class="form-control"
								required="required" placeholder="昵称"
								value="{{$comment->nickname}}">

						</div>
						<div class='form-group'>
							<div class='label'>邮箱</div>
							<input type="text" name="email" class="form-control"
								placeholder="邮箱" value="{{$comment->email}}">

						</div>
						<div class='form-group'>
							<div class='label'>主页</div>
							<input type="text" name="website" class="form-control"
								placeholder="主页" value="{{$comment->website}}">

						</div>
						<div class='form-group'>
							<div class='label'>评论</div>
							<textarea name="content" rows="10" class="form-control"
								required="required" placeholder="请输入评论">{{ $comment->content }}</textarea>

						</div>
						<br> <br>
						<button class="btn btn-lg btn-info">提交</button>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
