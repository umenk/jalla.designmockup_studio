@extends($layout)

@section('head')
<title>{{ ucwords($keyword) }}</title>
@include('json_id')
@endsection

@section('header')
	<h1>{{ ucwords($keyword) }}</h1>

	@php
		shuffle($sentences);
	@endphp

	<div class="navi text-center">
		@if(!empty($sentences))
			<p align="justify">{{ @array_pop($sentences) }} {{ @array_pop($sentences) }} {{ @array_pop($sentences) }} <br>				
			</p>
		@endif
		@foreach(collect(random_related())->shuffle()->take(8) as $r)
			@if($r !== $keyword)
			<a class="badge badge-{{ collect(['primary', 'secondary', 'success', 'info', 'danger', 'warning', 'light', 'dark'])->random() }}" href="{{ image_url($r) }}">{{ $r }}</a>
			@endif
		@endforeach
	</div>
	@include('ads_in_article')
@endsection

@section('content')

	@php
		$show_download 	= (IS_CLI)?'':SHOW_DOWNLOAD;		
		$max_image 		= MAX_IMAGE_RESULT;
		$lazyload 		= LAZY_LOAD;
	@endphp
	
	<div class="row">
	@foreach($images as $key => $image) 
	@php
		$img_thumb = $image['thumb']??DEFAULT_THUMBNAIL;
	@endphp
	@if($key === $max_image)
		@break
	@endif	
		<div class="col-md-4 mb-4">
			<div class="card h-100">
				<a href="{{ cdn_image($image['url']) }}" data-lightbox="roadtrip" data-title="{{ $image['title'] }}">
					@if($lazyload == TRUE)
						<img class="card-img v-image lazyload" src="{{ home_url('assets/img/loading.jpg') }}" data-src="{{ cdn_image($image['url']) }}" onerror="this.onerror=null;this.src='{{$img_thumb}}';" alt="{{ $image['title'] }}">
					@else
						<img class="card-img v-image" src="{{ cdn_image($image['url']) }}" onerror="this.onerror=null;this.src='{{$img_thumb}}';" alt="{{ $image['title'] }}">
					@endif					
				</a>
				<div class="card-body text-center">      
					@if($show_download)	
					<div class="d-block mb-2">
						<a class="btn btn-sm btn-success" href='{{home_url("pre-{$key}/{$path}.html")}}' >Save Image<i class="fas fa-cloud-download-alt ml-1"></i></a>
					</div>
					@endif
					<h3 class="h6">{{ $image['title'] }}</h3>
				</div>
			</div>
		</div>
			 
		@if($loop->iteration == 6)
			<div class="col-12 mb-4">
				<div class="card">
					@if($lazyload == TRUE)
					<img class="card-img-top v-cover lazyload" src="{{ home_url('assets/img/loading.jpg') }}" data-src="{{ collect($images)->random()['url'] }}" onerror="this.onerror=null;this.src='{{$img_thumb}}';" alt="{{ $image['title'] }}">
					@else
					<img class="card-img-top v-cover" src="{{ collect($images)->random()['url'] }}" onerror="this.onerror=null;this.src='{{$img_thumb}}';" alt="{{ $image['title'] }}">
					@endif
					<div class="card-body">
						<h3 class="h5"><b>{{ @array_pop($sentences) }}</b></h3>
						@foreach(collect($sentences)->shuffle()->take(18)->chunk(3) as $chunked_sentences)
							<p class="p-2" align="justify">
								@if($loop->first)
									<strong>{{ ucfirst($keyword) }}</strong>. 
								@endif

								@foreach($chunked_sentences as $chunked_sentence)
									{{ $chunked_sentence }} 
								@endforeach
							</p>
						@endforeach
					</div> 
				</div>
			</div>
		@endif 

	@endforeach
	</div>
	@php
	$SOURCE_URL = SOURCE_URL;
	$SOURCE_NAME = SOURCE_NAME;
	@endphp
	@if($SOURCE_NAME)
		<div class="clearfix"></div> 
		<div class="d-block mt-4 p-3">
			Source : <a href="{{$SOURCE_URL}}" rel="nofollow noopener">{{$SOURCE_NAME}}</a>
		</div>
	@endif
@endsection
