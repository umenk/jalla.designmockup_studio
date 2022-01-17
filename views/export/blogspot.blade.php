@php
	//$backdate = isset($argv[2]) ? strtotime($argv[2]) : strtotime('-1 month');
	$backdate 	= BACK_DATE;
	$schedule 	= SHEDULE_DATE;
	$wp_cat 	= WP_CATEGORY;
@endphp
{!! '<' . '?' . "xml version='1.0' encoding='UTF-8'?>" !!}
<ns0:feed xmlns:ns0="http://www.w3.org/2005/Atom">
<ns0:title type="html">wpan.com</ns0:title>
<ns0:generator>Blogger</ns0:generator>
<ns0:link href="http://localhost/wpan" rel="self" type="application/atom+xml" />
<ns0:link href="http://localhost/wpan" rel="alternate" type="text/html" />
<ns0:updated>2016-06-10T04:33:36Z</ns0:updated>
@foreach($keywords as $id => $keyword)
	@php
	$slug = new_slug($keyword);
	$data = get_data($slug);
	if(empty($data['images'])){ continue; }
	$keyword 		 	= $data['images'][0]['keyword'];
	$data['keyword'] 	= $keyword;
	$timestamp 	= date('Y-m-d\TH:i:s\Z', rand(strtotime($backdate), strtotime($schedule)));
	$arr_tags 	= explode('-',new_slug($keyword, '-', FALSE, FALSE));
	$arr_tags[] = $wp_cat;
	@endphp
	<ns0:entry>
		@foreach(collect($arr_tags)->shuffle()->take(4) as $id => $tag)
		@if(strlen($tag) <= 3) 
		    @continue
		@endif
		<ns0:category scheme="http://www.blogger.com/atom/ns#" term="{{ $tag }}" />
		@endforeach
		<ns0:category scheme="http://schemas.google.com/g/2005#kind" term="http://schemas.google.com/blogger/2008/kind#post" />
		<ns0:id>post-{{ $id }}</ns0:id>
		<ns0:author>
		<ns0:name>admin</ns0:name>
		</ns0:author>
		<ns0:content type="html">@php
		$content = str_replace("\n", ' ', export('export.post', $data));
		@endphp {{ Minify_Html($content) }}
		</ns0:content>
		<ns0:published>{{ $timestamp }}</ns0:published>
		<ns0:title type="html">{{ ucwords($keyword) }}</ns0:title>
		<ns0:link href="http://localhost/wpan/{{ $id }}/" rel="self" type="application/atom+xml" />
		<ns0:link href="http://localhost/wpan/{{ $id }}/" rel="alternate" type="text/html" />
	</ns0:entry>
@endforeach
</ns0:feed>