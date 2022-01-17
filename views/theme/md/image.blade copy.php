@extends($layout)

@php
    $show_download  = (IS_CLI)?'':SHOW_DOWNLOAD;        
    $max_image      = MAX_IMAGE_RESULT;
    $lazyload       = LAZY_LOAD;
    $default_thumb  = DEFAULT_THUMBNAIL;

    $related        = collect(random_related());
    $sentences      = collect($sentences);
    $images         = collect($images);
@endphp

@section('title')
{{ ucwords($keyword) }}
@endsection

@section('head')

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
        <p>{{ $sentences->shuffle()->pop() }}</p>
    </aside>
@endforeach
</section>
<p align="justify">
If you find this site {{do_spintax('{adventageous|beneficial|helpful|good|convienient|serviceableness|value}')}}, please support us by sharing this posts to your {{do_spintax('{favorite|preference|own}')}} social media accounts like Facebook, Instagram and so on or you can also {{do_spintax('{bookmark|save}')}} this blog page with the title {{ $keyword }} by using Ctrl + D for devices a laptop with a Windows operating system or Command + D for laptops with an Apple operating system. If you use a smartphone, you can also use the drawer menu of the browser you are using. Whether it's a Windows, Mac, iOS or Android operating system, you will still be able to bookmark this website.    
</p>


</section>
@endsection