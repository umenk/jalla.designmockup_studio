@php
	//$backdate = isset($argv[2]) ? strtotime($argv[2]) : strtotime('-1 month');
	$backdate 	= BACK_DATE;
	$schedule 	= SHEDULE_DATE;
@endphp
---
title: "{{rand(10,50)}}{{ collect(['+', '++'])->random() }} {{ ucfirst($keyword) }} {{ collect(['ideas', 'ideas in 2021 ', 'information', 'info'])->random() }}"
date: {{ date('Y-m-d') }}
@php
$timestamp = date('Y-m-d\TH:i:s\Z', rand(strtotime($backdate), strtotime($schedule)));
@endphp
publishDate: {{ $timestamp }}
image: "{{ $image['url'] }}"
author: "{{ collect(['Ines', 'Ireland', 'Wayne'])->random() }}" # use capitalize
description: "Your {{ ucfirst($keyword) }} images are {{do_spintax('{ready|available|available in this site|ready in this website}')}}. {{ ucfirst($keyword) }} are a topic that is being searched for and liked by netizens {{do_spintax('{today|now}')}}. You can {{do_spintax('{Download|Get|Find and Download}')}} the {{ ucfirst($keyword) }} files here. {{do_spintax('{Download|Get|Find and Download}')}} all {{do_spintax('{free|royalty-free}')}} {{do_spintax('{photos|images|vectors|photos and vectors}')}} in {{ SITE_NAME }}."
categories: ["{{ collect(['Wallpapers', 'Background'])->random() }}"]
tags: ["{{ collect(['iphone', 'phone'])->random() }}"]
keywords: "{{ ucfirst($keyword) }}"
draft: false

---
