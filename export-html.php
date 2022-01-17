<?php
// prevent browser
if(PHP_SAPI !== 'cli'){ die; }
require 'constants.php';
require 'vendor/autoload.php';
require 'helpers.php';

echo "=> generating html export\n";

file_put_contents('export/html/index.html', view('home', [],false));

$seo = SEO_PATH;

if($seo)
{
	if (!file_exists("export/html/{$seo}"))
	{
	    mkdir("export/html/{$seo}", 0777, true);
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
    
	file_put_contents("export/html/{$seo}{$slug}.html", $res);

	echo "\r\n[\033[32msuccess\033[39m] ==> {$slug}.html\r\n";
}

if (!file_exists('export/html/p'))
{
    mkdir('export/html/p', 0777, true);
    sleep(1);
}

foreach (pages() as $page_name)
{
	$res = view('pages.page', ['page' => $page_name],false);

	if(MINIFY_HTML)
	{
		$res = Minify_Html($res);
	}

	file_put_contents("export/html/p/{$page_name}.html", $res);

	echo "\r\n[\033[32msuccess\033[39m] ==> {$page_name}.html\r\n";
}
