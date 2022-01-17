@include('front')
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
    <p>
    Your {{ ucfirst($keyword) }} {{do_spintax('{images|images HD|images 4K|wallpapers}')}} are {{do_spintax('{ready|available|available in this site|ready in this website}')}}. {{ ucfirst($keyword) }} are a topic that is being searched for and liked by netizens {{do_spintax('{today|now}')}}. You can {{do_spintax('{Download|Get|Find and Download}')}} the {{ ucfirst($keyword) }} files here. {{do_spintax('{Download|Get|Find and Download}')}} all {{do_spintax('{free|royalty-free}')}} {{do_spintax('{photos|images|vectors|photos and vectors}')}} in {{ SITE_NAME }}. {{ ucfirst($keyword) }} was {{do_spintax('{covered|explained|described|reported|informed|notified|advised|narrated}')}} {{do_spintax('{completly|robust|holistic}')}} and {{do_spintax('{image item|item by item|detail}')}}.
</p>
   
	
<!--more-->
    
	@yield('head')
	@include('head')

</head>
<body>
<header>

<p>
      
If you're {{do_spintax('{looking|searching}')}} for <strong>{{ $keyword }}</strong> {{do_spintax('{pictures|images}')}} information {{do_spintax('{related|linked|connected with}')}} to the <strong>{{ $keyword }}</strong> {{do_spintax('{keyword|topic|interest}')}}, {{do_spintax('{you have|you have}')}} {{do_spintax('{come to|visit|pay a visit to}')}} the {{do_spintax('{right|ideal}')}}  {{do_spintax('{blog|site}')}}.  Our {{do_spintax('{site|website}')}} {{do_spintax('{always|frequently}')}}  {{do_spintax('{provides you with|gives you}')}}  {{do_spintax('{suggestions|hints}')}}  for {{do_spintax('{refferencing|downloading|seeking|viewing|seeing}')}}  the {{do_spintax('{highest|maximum}')}}  quality video and {{do_spintax('{image|picture}')}}  content, please kindly {{do_spintax('{surf|search|hunt}')}} and {{do_spintax('{find|locate}')}} more {{do_spintax('{informative|enlightening}')}} video {{do_spintax('{content|articles}')}} and {{do_spintax('{images|graphics}')}}  that {{do_spintax('{match|fit}')}} your interests.</p>
        
</header>
<main>
@yield('content')
         
<center>
@include('ads_btn_banner')
</center>
</main>

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
    
</body>

</html>
