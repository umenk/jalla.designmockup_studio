@extends($layout)

@php
	$info 		= $images[$mid];
	$title 		= $info['title'];
	$title_seo	= str_limit($title, $limit = 60, $end = '');
	$cover_img 	= $info['url'];

	$path 		= $info['slug'];

	$type 		= $info['filetype'];
	$type 		= (!empty($type))?$type:'jpg';
	$width 		= $info['width'];
	$height 	= $info['height'];
	$domain 	= $info['domain'];
	$img_thumb 	= $info['thumb']??DEFAULT_THUMBNAIL;
@endphp

@section('head')
<title>Details of {{ $title_seo }}</title>
@endsection

@section('header')
	<h1 class="h4">{{ ucwords($title_seo) }}</h1>
@endsection

@section('content')
	<div class="row">
		<div class="col-12 mb-4">						
			<div class="card">				
				<img class="card-img-top dwn-cover" src="{{ $cover_img }}" onerror="this.onerror=null;this.src='{{$img_thumb}}';" alt="{{ $title }}">
				<div class="card-body">					
					<table class="table table-striped table-responsive-sm">
					  <tbody>
					  	<tr>
					      <td>Title</td>
					      <th>: {{$title_seo}}</th>
					    </tr>
					    <tr>
					      <td>Type</td>
					      <th>:	{{$type}}</th>
					    </tr>
					    <tr>
					      <td>Dimension</td>
					      <th>:	{{$width}} x {{$height}}</th>
					    </tr>
					    <tr>
					      <td>Source</td>
					      <th>:	{{$domain}}</th>
					    </tr>
					  </tbody>
					</table>
					<div class="d-block my-2" align="center">
						<a class="btn btn-lg btn-primary" href='{{home_url("dwn-{$mid}/{$path}.html")}}' ><i class="fa fa-check mr-1"></i>Save Image NOW</a>
					</div>
					<p class="p-2" align="justify">
							Details of {{ ucwords($title) }}. You can download and save this image for free.
					</p>
				</div> 
			</div>
		</div>
	</div>
@endsection
