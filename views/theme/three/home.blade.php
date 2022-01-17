@extends($layout)

@section('head')
<title>{{ site_name() }}</title>
@endsection

@section('bg')
@endsection

@section('content')
	@php
		$lazyload 		= LAZY_LOAD;
	@endphp
		@foreach(collect(random_related())->shuffle()->take(20)->chunk(5) as $chunked) 
				@foreach($chunked as $n => $keyword)
					@php
						$is_cover = ($n % 5 == 0)?'posts-image-big':'';						
					@endphp
					<div class="posts-image {{$is_cover}}">
						<div class="posts-image-content">
							<h2><a href="{{ image_url($keyword) }}">
								{{ ucwords($keyword) }}
							</a></h2>
							<a href="{{ image_url($keyword) }}">
								@if($lazyload == TRUE)
									<img src="{{ home_url('assets/img/loading.jpg') }}" data-src="{{ image_url($keyword, true) }}" alt="{{ ucwords($keyword) }}" class="img-fluid lazyload" onerror="this.onerror=null;this.src='{{DEFAULT_THUMBNAIL}}';">
								@else
									<img src="{{ image_url($keyword, true) }}" alt="{{ ucwords($keyword) }}" class="img-fluid" onerror="this.onerror=null;this.src='{{DEFAULT_THUMBNAIL}}';">
								@endif	
							</a> 
						</div>
					</div>
				@endforeach 
		@endforeach 
		
@endsection
