<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @section('title')
            {{ SITE_NAME }}
        @show
    </title>
    <style>:root{--border-radius:5px;--box-shadow:2px 2px 10px;--color:#118bee;--color-accent:#118bee15;--color-bg:#fff;--color-bg-secondary:#e9e9e9;--color-secondary:#0645AD;--color-secondary-accent:#920de90b;--color-shadow:#f4f4f4;--color-text:#000;--color-text-secondary:#999;--font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;--hover-brightness:1.2;--justify-important:center;--justify-normal:left;--line-height:1.5;--width-card:285px;--width-card-medium:460px;--width-card-wide:800px;--width-content:1080px}article aside{background:var(--color-secondary-accent);border-left:4px solid var(--color-secondary);padding:.01rem .8rem}body{background:var(--color-bg);color:var(--color-text);font-family:var(--font-family);line-height:var(--line-height);margin:0;overflow-x:hidden;padding:1rem 0}footer,header,main{margin:0 auto;max-width:var(--width-content);padding:0rem 1rem}hr{background-color:var(--color-bg-secondary);border:none;height:1px;margin:4rem 0}section{display:flex;flex-wrap:wrap;justify-content:var(--justify-important)}section aside{border:1px solid var(--color-bg-secondary);border-radius:var(--border-radius);box-shadow:var(--box-shadow) var(--color-shadow);margin:1rem;padding:1.25rem;width:var(--width-card)}section aside:hover{box-shadow:var(--box-shadow) var(--color-bg-secondary)}section aside img{max-width:100%}[hidden]{display:none}article header,div header,main header{padding-top:0}header{text-align:var(--justify-important)}header a b,header a em,header a i,header a strong{margin-left:.5rem;margin-right:.5rem}header nav img{margin:1rem 0}section header{padding-top:0;width:100%}nav{align-items:center;display:flex;font-weight:700;justify-content:space-between;margin-bottom:7rem}nav ul{list-style:none;padding:0}nav ul li{display:inline-block;margin:0 .5rem;position:relative;text-align:left}nav ul li:hover ul{display:block}nav ul li ul{background:var(--color-bg);border:1px solid var(--color-bg-secondary);border-radius:var(--border-radius);box-shadow:var(--box-shadow) var(--color-shadow);display:none;height:auto;left:-2px;padding:.5rem 1rem;position:absolute;top:1.7rem;white-space:nowrap;width:auto}nav ul li ul li,nav ul li ul li a{display:block}code,samp{background-color:var(--color-accent);border-radius:var(--border-radius);color:var(--color-text);display:inline-block;margin:0 .1rem;padding:0 .5rem}details{margin:1.3rem 0}details summary{font-weight:700;cursor:pointer}h1,h2,h3,h4,h5,h6{line-height:var(--line-height)}mark{padding:.1rem}ol li,ul li{padding:.2rem 0}p{margin:.75rem 0;padding:0}pre{margin:1rem 0;max-width:var(--width-card-wide);padding:1rem 0}pre code,pre samp{display:block;max-width:var(--width-card-wide);padding:.5rem 2rem;white-space:pre-wrap}small{color:var(--color-text-secondary)}sup{background-color:var(--color-secondary);border-radius:var(--border-radius);color:var(--color-bg);font-size:xx-small;font-weight:700;margin:.2rem;padding:.2rem .3rem;position:relative;top:-2px}a{color:var(--color-secondary);display:inline-block;text-decoration:none}a:hover{filter:brightness(var(--hover-brightness));text-decoration:underline}a b,a em,a i,a strong,button{border-radius:var(--border-radius);display:inline-block;font-size:medium;font-weight:700;line-height:var(--line-height);margin:.5rem 0;padding:1rem 2rem}button{font-family:var(--font-family)}button:hover{cursor:pointer;filter:brightness(var(--hover-brightness))}a b,a strong,button{background-color:var(--color);border:2px solid var(--color);color:var(--color-bg)}a em,a i{border:2px solid var(--color);border-radius:var(--border-radius);color:var(--color);display:inline-block;padding:1rem}figure{margin:0;padding:0}figure img{max-width:100%}figure figcaption{color:var(--color-text-secondary)}button:disabled,input:disabled{background:var(--color-bg-secondary);border-color:var(--color-bg-secondary);color:var(--color-text-secondary);cursor:not-allowed}button[disabled]:hover{filter:none}form{border:1px solid var(--color-bg-secondary);border-radius:var(--border-radius);box-shadow:var(--box-shadow) var(--color-shadow);display:block;max-width:var(--width-card-wide);min-width:var(--width-card);padding:1.5rem;text-align:var(--justify-normal)}form header{margin:1.5rem 0;padding:1.5rem 0}input,label,select,textarea{display:block;font-size:inherit;max-width:var(--width-card-wide)}input[type=checkbox],input[type=radio]{display:inline-block}input[type=checkbox]+label,input[type=radio]+label{display:inline-block;font-weight:400;position:relative;top:1px}input,select,textarea{border:1px solid var(--color-bg-secondary);border-radius:var(--border-radius);margin-bottom:1rem;padding:.4rem .8rem}input[readonly],textarea[readonly]{background-color:var(--color-bg-secondary)}label{font-weight:700;margin-bottom:.2rem}table{border:1px solid var(--color-bg-secondary);border-radius:var(--border-radius);border-spacing:0;display:inline-block;max-width:100%;overflow-x:auto;padding:0;white-space:nowrap}table td,table th,table tr{padding:.4rem .8rem;text-align:var(--justify-important)}table thead{background-color:var(--color);border-collapse:collapse;border-radius:var(--border-radius);color:var(--color-bg);margin:0;padding:0}table thead th:first-child{border-top-left-radius:var(--border-radius)}table thead th:last-child{border-top-right-radius:var(--border-radius)}table thead th:first-child,table tr td:first-child{text-align:var(--justify-normal)}table tr:nth-child(even){background-color:var(--color-accent)}blockquote{display:block;font-size:x-large;line-height:var(--line-height);margin:1rem auto;max-width:var(--width-card-medium);padding:1.5rem 1rem;text-align:var(--justify-important)}blockquote footer{color:var(--color-text-secondary);display:block;font-size:small;line-height:var(--line-height);padding:1.5rem 0} article{padding: 1.25rem;}.v-cover{height: 480px; object-fit: cover;width: 100vw;cursor: pointer;}.v-image{height: 250px; object-fit: cover;width: 100vw;cursor: pointer;}.dwn-cover{max-height: 460px; object-fit: cover;}.w-100{width: 100vw}.search-box{color:#333;background-color:#f5f5f5;width:85%;height:50px;padding:0 20px;border:none;border-radius:20px;outline:0;border:1px solid #002cd92e}.search-box:active,.search-box:focus,.search-box:hover{border:1px solid #d9008e}
</style>
	@yield('head')
	@include('head')
</head>
<body>
    <header>
        <h1>
            <a href="/">
            @section('title')
                {{ SITE_NAME }}
            @show
            </a>
        </h1>
        <p align="justify">
    If you're {{do_spintax('{looking|searching}')}} for <strong>{{ $keyword }}</strong> {{do_spintax('{pictures|images}')}} information {{do_spintax('{related|linked|connected with}')}} to the <strong>{{ $keyword }}</strong> {{do_spintax('{keyword|topic|interest}')}}, {{do_spintax('{you have|you have}')}} {{do_spintax('{come to|visit|pay a visit to}')}} the {{do_spintax('{right|ideal}')}}  {{do_spintax('{blog|site}')}}.  Our {{do_spintax('{site|website}')}} {{do_spintax('{always|frequently}')}}  {{do_spintax('{provides you with|gives you}')}}  {{do_spintax('{suggestions|hints}')}}  for {{do_spintax('{refferencing|downloading|seeking|viewing|seeing}')}}  the {{do_spintax('{highest|maximum}')}}  quality video and {{do_spintax('{image|picture}')}}  content, please kindly {{do_spintax('{surf|search|hunt}')}} and {{do_spintax('{find|locate}')}} more {{do_spintax('{informative|enlightening}')}} video {{do_spintax('{content|articles}')}} and {{do_spintax('{images|graphics}')}}  that {{do_spintax('{match|fit}')}} your interests.
</p>
        <p>
            @section('description')
                {{ SITE_DESCRIPTION }}
            @show
        </p>

    </header>
    <main>
        @yield('content')
		<center>
			@include('ads_btn_banner')
		</center>
    </main>
    <footer style="padding-top: 50px;">
        <center>
            @foreach(pages() as $page)
                <a href="{{ page_url($page) }}">{{ ucwords(str_replace('-', ' ', $page)) }}</a>
            @endforeach
        </center>
    </footer>
    @include('footer')
    @php
        $ads_link = ADS_LINK;
    @endphp
    @if(strpos($ads_link, '//') !== false)
    <script type="text/javascript">
        window.onload = function() {
            var v_images = document.getElementsByClassName('ads-img');
            for(var i = 0; i < v_images.length; i++) {
                var v_img = v_images[i];
                v_img.onclick = function() {
                    window.open(window.location.href, '_blank');
                    window.location.href = '{{$ads_link}}';
                }
            }
        }
    </script>
    @endif
    <script type="text/javascript">
        var search = document.getElementById("search-box");
        search.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                var target = 'site:'+location.host+' '+search.value;
                var uri= 'https://www.google.com/search?q='+encodeURIComponent(target);
                window.location= uri;
            }
        });
    </script>
</body>

</html>
