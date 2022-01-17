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
    

<div class="navi text-center">
        @if(!empty($sentences))
            <p align="justify">{{ @array_pop($sentences) }} {{ @array_pop($sentences) }} {{ @array_pop($sentences) }} <br>              
            </p>
        @endif
        @foreach(collect(random_related())->shuffle()->take(8) as $r)
            @if($r !== $keyword)
            <a class="badge badge-{{ collect(['primary', 'secondary', 'success', 'info', 'danger', 'warning', 'light', 'dark'])->random() }}" href="{{ image_url($r) }}">{{ ucfirst($r) }}</a>
            @endif
        @endforeach
</div>
    
**{{ ucwords($keyword) }}**. {{ $sentences->shuffle()->take(4)->implode(' ') }}  
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

<div>
<span class="garis">
<b>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M2,6.5 C2,5.11928813 3.11928813,4 4.5,4 L19.5,4 C20.8807119,4 22,5.11928813 22,6.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 Z M3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,6.5 C21,5.67157288 20.3284271,5 19.5,5 L4.5,5 C3.67157288,5 3,5.67157288 3,6.5 Z M16,7 L18,7 C18.5522847,7 19,7.44771525 19,8 L19,10 C19,10.5522847 18.5522847,11 18,11 L16,11 C15.4477153,11 15,10.5522847 15,10 L15,8 C15,7.44771525 15.4477153,7 16,7 Z M16,8 L16,10 L18,10 L18,8 L16,8 Z M2.85355339,15.8535534 C2.65829124,16.0488155 2.34170876,16.0488155 2.14644661,15.8535534 C1.95118446,15.6582912 1.95118446,15.3417088 2.14644661,15.1464466 L7.14644661,10.1464466 C7.34170876,9.95118446 7.65829124,9.95118446 7.85355339,10.1464466 L13.5,15.7928932 L16.1464466,13.1464466 C16.3417088,12.9511845 16.6582912,12.9511845 16.8535534,13.1464466 L21.3535534,17.6464466 C21.5488155,17.8417088 21.5488155,18.1582912 21.3535534,18.3535534 C21.1582912,18.5488155 20.8417088,18.5488155 20.6464466,18.3535534 L16.5,14.2071068 L13.8535534,16.8535534 C13.6582912,17.0488155 13.3417088,17.0488155 13.1464466,16.8535534 L7.5,11.2071068 L2.85355339,15.8535534 Z" />
</svg>
Images information:
</b>
<span>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M8.29289322,15 L3.5,15 C3.22385763,15 3,14.7761424 3,14.5 C3,14.2238576 3.22385763,14 3.5,14 L9.5,14 C9.77614237,14 10,14.2238576 10,14.5 L10,20.5 C10,20.7761424 9.77614237,21 9.5,21 C9.22385763,21 9,20.7761424 9,20.5 L9,15.7071068 L3.85355339,20.8535534 C3.65829124,21.0488155 3.34170876,21.0488155 3.14644661,20.8535534 C2.95118446,20.6582912 2.95118446,20.3417088 3.14644661,20.1464466 L8.29289322,15 Z M15.7071068,9 L20.5,9 C20.7761424,9 21,9.22385763 21,9.5 C21,9.77614237 20.7761424,10 20.5,10 L14.5,10 C14.2238576,10 14,9.77614237 14,9.5 L14,3.5 C14,3.22385763 14.2238576,3 14.5,3 C14.7761424,3 15,3.22385763 15,3.5 L15,8.29289322 L20.1464466,3.14644661 C20.3417088,2.95118446 20.6582912,2.95118446 20.8535534,3.14644661 C21.0488155,3.34170876 21.0488155,3.65829124 20.8535534,3.85355339 L15.7071068,9 Z" />
</svg>
Dimensions: {{ $image[ 'width' ] }} x {{ $image[ 'height' ] }} </span>
<span>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M4.5,5 C3.67157288,5 3,5.67157288 3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,9.5 C21,8.67157288 20.3284271,8 19.5,8 L14,8 C12.8954305,8 12,7.1045695 12,6 C12,5.44771525 11.5522847,5 11,5 L4.5,5 Z M4.5,4 L11,4 C12.1045695,4 13,4.8954305 13,6 C13,6.55228475 13.4477153,7 14,7 L19.5,7 C20.8807119,7 22,8.11928813 22,9.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 C2,5.11928813 3.11928813,4 4.5,4 Z" />
</svg>
File type: {{ $image[ 'filetype' ] }} </span>
</span>
<span class="garis"> 
</div>
<p>
{{ $sentences->shuffle()->take(6)->implode(' ') }}

### {{ $sentences->shuffle()->pop() }}<br>
{{ $sentences->shuffle()->pop() }} {{ $sentences->shuffle()->take(10)->implode(' ') }}
</p>
</article>

<section>
@foreach(collect($images)->shuffle()->take(18) as $image)
@php
$img_thumb = $image['thumb']??$default_thumb;
@endphp

<aside>
<script>
var a2a_config = a2a_config || {};
a2a_config.overlays = a2a_config.overlays || [];
a2a_config.overlays.push({
    services: ['pinterest', 'facebook', 'twitter', 'tumblr', 'instagram'],
    size: '25',
    style: 'vertical',
    position: 'upper-left corner'
});
</script>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<img class="v-image ads-img" alt="{{ $image['title'] }}" src="{{ $image['url'] }}" width="100%" onerror="this.onerror=null;this.src='{{$img_thumb}}';" />
<small>Source: {{ $image['domain'] }}</small>
<div>
<span>
<b>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M2,6.5 C2,5.11928813 3.11928813,4 4.5,4 L19.5,4 C20.8807119,4 22,5.11928813 22,6.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 Z M3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,6.5 C21,5.67157288 20.3284271,5 19.5,5 L4.5,5 C3.67157288,5 3,5.67157288 3,6.5 Z M16,7 L18,7 C18.5522847,7 19,7.44771525 19,8 L19,10 C19,10.5522847 18.5522847,11 18,11 L16,11 C15.4477153,11 15,10.5522847 15,10 L15,8 C15,7.44771525 15.4477153,7 16,7 Z M16,8 L16,10 L18,10 L18,8 L16,8 Z M2.85355339,15.8535534 C2.65829124,16.0488155 2.34170876,16.0488155 2.14644661,15.8535534 C1.95118446,15.6582912 1.95118446,15.3417088 2.14644661,15.1464466 L7.14644661,10.1464466 C7.34170876,9.95118446 7.65829124,9.95118446 7.85355339,10.1464466 L13.5,15.7928932 L16.1464466,13.1464466 C16.3417088,12.9511845 16.6582912,12.9511845 16.8535534,13.1464466 L21.3535534,17.6464466 C21.5488155,17.8417088 21.5488155,18.1582912 21.3535534,18.3535534 C21.1582912,18.5488155 20.8417088,18.5488155 20.6464466,18.3535534 L16.5,14.2071068 L13.8535534,16.8535534 C13.6582912,17.0488155 13.3417088,17.0488155 13.1464466,16.8535534 L7.5,11.2071068 L2.85355339,15.8535534 Z" />
</svg>
Images information:
</b>
<span>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M8.29289322,15 L3.5,15 C3.22385763,15 3,14.7761424 3,14.5 C3,14.2238576 3.22385763,14 3.5,14 L9.5,14 C9.77614237,14 10,14.2238576 10,14.5 L10,20.5 C10,20.7761424 9.77614237,21 9.5,21 C9.22385763,21 9,20.7761424 9,20.5 L9,15.7071068 L3.85355339,20.8535534 C3.65829124,21.0488155 3.34170876,21.0488155 3.14644661,20.8535534 C2.95118446,20.6582912 2.95118446,20.3417088 3.14644661,20.1464466 L8.29289322,15 Z M15.7071068,9 L20.5,9 C20.7761424,9 21,9.22385763 21,9.5 C21,9.77614237 20.7761424,10 20.5,10 L14.5,10 C14.2238576,10 14,9.77614237 14,9.5 L14,3.5 C14,3.22385763 14.2238576,3 14.5,3 C14.7761424,3 15,3.22385763 15,3.5 L15,8.29289322 L20.1464466,3.14644661 C20.3417088,2.95118446 20.6582912,2.95118446 20.8535534,3.14644661 C21.0488155,3.34170876 21.0488155,3.65829124 20.8535534,3.85355339 L15.7071068,9 Z" />
</svg>
Dimensions: {{ $image[ 'width' ] }} x {{ $image[ 'height' ] }} </span>
<span>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
<path fill="currentColor" d="M4.5,5 C3.67157288,5 3,5.67157288 3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,9.5 C21,8.67157288 20.3284271,8 19.5,8 L14,8 C12.8954305,8 12,7.1045695 12,6 C12,5.44771525 11.5522847,5 11,5 L4.5,5 Z M4.5,4 L11,4 C12.1045695,4 13,4.8954305 13,6 C13,6.55228475 13.4477153,7 14,7 L19.5,7 C20.8807119,7 22,8.11928813 22,9.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 C2,5.11928813 3.11928813,4 4.5,4 Z" />
</svg>
File type: {{ $image[ 'filetype' ] }} </span>
</span></div>
<p>
{{ $sentences->shuffle()->pop() }} {{ $sentences->shuffle()->take(4)->implode(' ') }}
</p>
</aside>
@endforeach
</section>
<p>
This site is an open community for users to <a rel="nofollow" href="/contact.html"> share their favorite wallpapers on the internet</a>, all images or pictures in this site are for personal wallpaper use only, it is stricly prohibited to use this wallpaper for commercial purposes, if you are the author and find this image is shared without your permission, please kindly raise a DMCA report <a href="/contact.html">Contact Us</a>.
</p>
<p>If you find this site {{do_spintax('{adventageous|beneficial|helpful|good|convienient|serviceableness|value}')}}, please support us by sharing this posts to your {{do_spintax('{favorite|preference|own}')}} social media accounts like Facebook, Instagram and so on or you can also {{do_spintax('{bookmark|save}')}} this blog page with the title {{ $keyword }} by using Ctrl + D for devices a laptop with a Windows operating system or Command + D for laptops with an Apple operating system. If you use a smartphone, you can also use the drawer menu of the browser you are using. Whether it's a Windows, Mac, iOS or Android operating system, you will still be able to bookmark this website.</p>
</section>
@endsection