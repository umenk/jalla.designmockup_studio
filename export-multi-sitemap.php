<?php
// prevent browser
if(PHP_SAPI !== 'cli'){ die; }
require 'constants.php';
require 'vendor/autoload.php';
require 'helpers.php';

//WAJIB CONFIG
$seo_path   = '';//Kosongi jika url artikel langsung dr root domain
$base       = "http://domain-target.com";

if(isset($argv[2]))
{
    $seo_path = ($argv[2] !== 'no') ? $argv[2]."/":"";
}

$base_url   = isset($argv[1]) ? $argv[1]."/{$seo_path}" : "{$base}/{$seo_path}";

$date 		= date('c',time());

$keywords 	= keywords();
$list 		= array_chunk($keywords,200);
$sub_count  = count($list);

echo "\r\n ==> [\033[32mgenerating Sitemap\033[39m] <== \r\n\r\n";

if (!file_exists("export/export_sitemap"))
{
    mkdir("export/export_sitemap", 0755, true);
    sleep(1);
}

if (!file_exists("export/export_sitemap/sitemap"))
{
    mkdir("export/export_sitemap/sitemap", 0755, true);
    sleep(1);
}

$no = 0;

foreach ($list as $key => $sublist)
{
	$no++;

	$sitemap   = sitemap_wraper($sublist);

	$sn        = "submap_{$no}.xml";

	file_put_contents("export/export_sitemap/sitemap/{$sn}", $sitemap);

	echo "[\033[32msuccess\033[39m] ==> {$sn}\r\n";
}

echo "[\033[32mGENERATE\033[39m] ==> sitemap_index.xml\r\n";

$sitemap_index  = sitemap_index_wraper($sub_count);

file_put_contents("export/export_sitemap/sitemap_index.xml", $sitemap_index);

function sitemap_wraper($arr_kw)
{    
    global $base_url;
    global $date;

    $dt ='';
    $dt .='<?xml version="1.0" encoding="utf-8"?>';
    $dt .='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
    
    foreach ($arr_kw as $kw)
    {
        $path 		= rawurlencode(new_slug($kw));	
        $item_url   = "{$base_url}{$path}.html";
        $dt         .="<url><loc>{$item_url}</loc><lastmod>{$date}</lastmod></url>".PHP_EOL;
    }

    $dt .='</urlset>';
    return $dt;
}

function sitemap_index_wraper($count)
{    
    global $base_url;

    $dt ='';
    $dt .='<?xml version="1.0" encoding="utf-8"?>';
    $dt .='<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

    for ($i=1; $i <= $count ; $i++)
    { 
        $submap_url   = "{$base_url}sitemap/submap_{$i}.xml";
        $dt         .=" <sitemap><loc>{$submap_url}</loc></sitemap>".PHP_EOL;
    }

    $dt .='</sitemapindex>';
    return $dt;
}

echo "\r\n=> Sitemap Ready..\r\n\r\n";