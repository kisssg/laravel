@extends('layouts.app') @section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Articles</div>

				<div id="content">
					<ul>
						@foreach ($articles as $article)
						<li style="margin: 50px 0;">
							<div class="title">
								<a href="{{ url('article/'.$article->id) }}">
									<h4>{{ $article->title }} -
								{{$article->user->name}}</h4>
								</a>
							</div>
							<div class="body">
								<p>{{ $article->body }}</p>
							</div>
						</li> 
						@endforeach
					</ul>
				</div>
				<div class='card-footer'>{{$articles->links()}}</div>
			</div>
		</div>
	</div>
</div>
@endsection
