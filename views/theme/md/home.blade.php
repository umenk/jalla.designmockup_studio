@extends($layout)

@section('content')
<section>
@foreach(collect(random_related())->shuffle()->take(16)->chunk(4) as $chunked) 
@foreach($chunked as $n => $keyword)
			@php
				$aside_cover 	= ($n % 4 == 0)?'w-100':'';						
				$is_cover 		= ($n % 4 == 0)?'v-cover':'v-image';						
			@endphp
<aside class="{{$aside_cover}}">
<a href="{{ image_url($keyword) }}"><img class="{{$is_cover}}" alt="{{ ucwords($keyword) }}" src="{{ image_url($keyword, true) }}" width="100%" onerror="this.onerror=null;this.src='{{DEFAULT_THUMBNAIL}}';"/></a>
###<a href="{{ image_url($keyword) }}">{{ ucwords($keyword) }}</a>
</aside>
@endforeach 
@endforeach 	
</section>	
@endsection