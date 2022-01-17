@extends($layout)

@php
	$info 		= $images[$mid];
	$title 		= $info['title'];
	$title_seo	= str_limit($title, $limit = 60, $end = '');
	$cover_img 	= $info['url'];
	$type 		= $info['filetype'];
	$type 		= (!empty($type))?$type:'jpg';
	$ads_link 	= ADS_LINK;
@endphp

@section('head')
<title>Download {{ $title_seo }}</title>
@endsection

@section('content')
	<div class="row">
		<div class="col-12 mb-4">			
			<div class="card">
				<img class="card-img-top dwn-cover" src="{{ $cover_img }}" onerror="this.onerror=null;this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh_l3eQ5xwiPy07kGEXjmjgmBKBRB7H2mRxCGhv1tFWg5c_mWT';" alt="{{ $title }}">
				<div class="card-body">
					<h1 class="h4">Download {{ ucwords($title_seo) }}</h1>
					<div class="d-block my-2" align="center">
						<h3 class="h5">Download List :</h3>
						<div class='px-2 mt-4' align='center'>
							@if(strpos($ads_link, '//') !== false)
						    <label>Server 1 [image/{{$type}}] ({{rand(200,500)}} Downloads):</label>
						    <br/>
						    <a class="btn btn-lg btn-success mb-3" href='{{ADS_LINK}}' >Download Image<i class="fas fa-cloud-download-alt ml-1"></i></a>
						    <br/>
						    @endif
						    <label>Server 2 [image/{{$type}}] ({{rand(200,500)}} Downloads):</label>
						    <br/>
						    <button id='image-download' class="btn btn-lg btn-success mb-3" data-url="{{hotlink_url($keyword,$mid,$type)}}" data-title="{{ $title_seo }}.{{ $type }}">Download Image<i class="fas fa-cloud-download-alt ml-1"></i></button>
						</div>						
					</div>
					<p class="p-2" align="justify">
						You are downloading {{ ucwords($title) }}. Click one of them to download image.
					</p>
				</div> 
			</div>
		</div>
	</div>
@endsection
