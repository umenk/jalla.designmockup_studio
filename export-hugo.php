<?php
// prevent browser
if(PHP_SAPI !== 'cli'){ die; }
require 'constants.php';
require 'vendor/autoload.php';
require 'helpers.php';

echo "=> generating hugo export\n";



$seo = SEO_PATH;

if($seo)
{
	if (!file_exists("export/deploy/content/"))
	{
	    mkdir("export/deploy/content/{$seo}", 0777, true);
	    sleep(1);
	}
}

$seo = ($seo)?"{$seo}/":"";

foreach (keywords() as $keyword)
{
	$slug = new_slug($keyword);
	$data = get_data($slug);

	if(!$data['images']){continue;}

	$data['path'] 		= $slug;
	$data['keyword'] = str_replace('-', ' ', $slug);

	$res = view('image', $data, false);

	if(MINIFY_HTML)
	{
		$res = Minify_Html($res);
	}
    
	file_put_contents("export/deploy/content/{$seo}{$slug}.md", $res);

	echo "\r\n[\033[32msuccess\033[39m] ==> {$slug}.md\r\n";
}
