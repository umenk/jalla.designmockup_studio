@extends($layout)

@php
    $show_download  = (IS_CLI)?'':SHOW_DOWNLOAD;        
    $max_image      = MAX_IMAGE_RESULT;
    $lazyload       = LAZY_LOAD;
    $default_thumb  = DEFAULT_THUMBNAIL;

    $related        = collect(random_related());
    $sentences      = collect($sentences);
    $images         = collect($images);
    $ads_link       = ADS_LINK;
@endphp

@section('title')
{{ ucwords($keyword) }}
@endsection

@section('head')
@include('json_id')
@endsection

@section('content')
<article>
    <p><strong>{{ ucwords($keyword) }}</strong>. {{ $sentences->shuffle()->take(2)->implode(' ') }}</p>
    @php
        $image = collect($images)->shuffle()->shift();
        $img_thumb = $image['thumb']??$default_thumb;
    @endphp
    @if($image)
    <figure>
        <img class="v-cover ads-img" src="{{ $image['url'] }}" alt="{{ $image['title'] }}" style="width: 100%; padding: 5px; background-color: grey;"  onerror="this.onerror=null;this.src='{{$img_thumb}}';">
        <figcaption>{{ $image['title'] }} from {{ $image['domain'] }}</figcaption>
    </figure>
    @endif
    <p>
        {{ $sentences->shuffle()->take(3)->implode(' ') }}
    </p>
    <h3>{{ $sentences->shuffle()->pop() }}</h3>
    <p>{{ $sentences->shuffle()->pop() }} {{ $sentences->shuffle()->take(3)->implode(' ') }}</p>
</article>

<section>
@foreach(collect($images)->shuffle()->take(9) as $image)
@php
    $img_thumb = $image['thumb']??$default_thumb;
@endphp

    <aside>
        <img class="v-image ads-img" alt="{{ $image['title'] }}" src="{{ $image['url'] }}" width="100%" onerror="this.onerror=null;this.src='{{$img_thumb}}';" />
        <small>Source: {{ $image['domain'] }}</small>
            @if(strpos($ads_link, '//') !== false)
            <center>
                <button class="btn btn-sm btn-success ads-img">Check Details</button>
            </center>
            @endif
        <p>{{ $sentences->shuffle()->pop() }}</p>
    </aside>
@endforeach
</section>
<section>
    <article>
        <p>
        @foreach($related->shuffle()->take(2) as $key => $r)
            @if($r !== $keyword)            
            @if($key == 0)
                <a href="{{ image_url($r) }}"><i>&larr; {{ $r }}</i></a>
            @endif
            @if($key == 1)
                <a href="{{ image_url($r) }}"><i>{{ $r }} &rarr;</i></a>
            @endif
            @endif
        @endforeach
        </p>
    </article>
</section>
@endsection