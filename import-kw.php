<?php
// prevent browser
if(PHP_SAPI !== 'cli'){ die; }

error_reporting(0);

require 'constants.php';
require 'vendor/autoload.php';
require 'assets/simple_html_dom.php';
require 'helpers.php';

use Buchin\GoogleSuggest\GoogleSuggest;
use Buchin\GoogleImageGrabber\GoogleImageGrabber;
use Buchin\Badwords\Badwords;

if(!isset($argv[1])){
	echo "Please specify keyword: php import-kw.php \"keywords.txt\"\n";
	die;
}

if(!file_exists($argv[1])){
	echo 'file not exists, exiting';
	die;
}

$keywords = explode("\n", file_get_contents($argv[1]));
$keywords = array_map('trim', $keywords);
$keywords = array_values(array_filter($keywords));

foreach ($keywords as $key => $kw)
{
	if(Badwords::isDirty($kw)){
		unset($keywords[$key]);
	}
}

$keywords = arr_filter($keywords);

//Check Proxy
//cek_proxy();
//sleep(2);

$lang 		= isset($argv[2]) ? $argv[2] : '';
$country 	= isset($argv[3]) ? $argv[3] : '';
$max 		= isset($argv[4]) ? $argv[4] : PHP_INT_MAX;
$source 	= 'i';

$scrap_mode = CONTENT_MODE;
$g_suggest 	= GOOGLE_SUGGEST;

echo "\n
=================================" . '
Importing: ' . $argv[1] . "
=================================\n\n";

$count = 1;

do {
	try {
		if($count > $max){
			echo "Import finished. Congratulations!\n";
			die;
		}

		$keyword = array_shift($keywords);

		if(Badwords::isDirty($keyword))
		{
			echo "==> [BADWORD] : {$keyword}...\n";
			continue;
		}
		else
		{
			$slug = new_slug($keyword,'-',TRUE);

			echo "==> scraping #{$count}: {$slug}\n";
		}

		$data = [
			'related' => [],
			'images' => [],
			'sentences' => [],
		];

		if($scrap_mode !== 'IMAGE_ONLY')
		{
			$sentences = (array)@get_sentences($keyword);
			$data['sentences'] = $sentences;
		}	

		$related = [];

		if($g_suggest)
		{
			echo "==> Get Suggest : {$keyword}\n";

			$related = suggest_google($keyword);

			if($related){
				$new_keywords = [];

				foreach ($related  as $r) {
					if(!data_exists($r) && $r !== $keyword){
						$new_keywords[] = $r;
					}
				}

				$keywords = array_merge($keywords, $new_keywords);
			}
		}

		$data['related'] = $related;

		$images = [];
		$images = (array)@GoogleImageGrabber::grab($keyword);

		if($images)
		{
			$data['images'] = $images;

			if($scrap_mode == 'IMAGE_ARTICLE')
			{
				if($data['sentences'])
				{
					compile_data($keyword, $data);
				}
			}
			else
			{
				compile_data($keyword, $data);
			}
		}
	} catch (\Exception $e) {
		echo '===>' . $e->getMessage() . "\n";
		sleep(rand(5, 60));
	}

	sleep(1);
	$count++;

} while (!empty($keywords));

function compile_data($kw,$data)
{
	$fn 	= get_filename($kw);
	$data 	= serialize($data);

	file_put_contents($fn, $data);

	/*
	$date 	= date('Y-m-d');
	$time 	= date('Y-m-d H:i:s');
	$path 	= __DIR__."/info/log/import-kw {$date}.txt";
	$log   = "Scrap [{$time}] ==> {$kw}\r\n";
	file_put_contents($path,$log, FILE_APPEND | LOCK_EX);
	*/

	sleep(BREAK_TIME);
	echo "==> Finishing..\r\n";	
}