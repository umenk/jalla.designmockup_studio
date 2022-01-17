<?php
use duncan3dc\Laravel\BladeInstance;
use Buchin\Bing\Web;
use Buchin\SearchTerm\SearchTerm;
use Buchin\TermapiClient\TermApi;

function is_cli()
{
	return php_sapi_name() == "cli";
}

function view($template, $data = [], $echo = true)
{
	$theme 			= THEME_NAME;
	$data['layout'] = "theme.{$theme}.layout";

	if($template !== 'pages.page')
	{
		$template 	= "theme.{$theme}.{$template}";	
	}

	if(!is_cli()){
		//termapi();
	}
	
	$blade = new BladeInstance(__DIR__ . '/views', __DIR__ . '/cache');
	$blade->addPath(__DIR__ . '/ads');
	$blade->addPath(__DIR__ . '/views/additional');

	if(!$echo){	
		return $blade->render($template, $data);
	}

	$res = $blade->render($template, $data);
	
	if(MINIFY_HTML)
	{
		$res = Minify_Html($res);
	}

	echo $res;
}

function export($template, $data = [], $echo = true)
{	
	$blade = new BladeInstance(__DIR__ . '/views', __DIR__ . '/cache');
	$blade->addPath(__DIR__ . '/ads');
	$blade->addPath(__DIR__ . '/views/additional');
	$res = $blade->render($template, $data);
	
	return $res;
}

function sitemap($template, $data = [], $echo = true)
{
	header("Content-Type: text/xml");

	$blade = new BladeInstance(__DIR__ . '/views', __DIR__ . '/cache');

	$res = $blade->render($template, $data);

	echo $res;
}


function rss($template, $data = [])
{
	header("Content-Type: text/xml;charset=iso-8859-1");

	$blade = new BladeInstance(__DIR__ . '/views', __DIR__ . '/cache');

	$res = $blade->render($template, $data);

	echo $res;
}

function image_view($keyword, $index=0,$ext='')
{
	$ext = strtolower($ext);

	$allow = ['jpg','png','bmp','gif'];
	
	if(!in_array($ext, $allow))
	{
		die;
	}

	http_response_code(200);
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: image/'.$ext);
	header('Cache-Control: max-age=31536000');
	header('Pragma: cache');

	$img_url = hotlink_image($keyword, $index);

	$image   = @file_get_contents($img_url);

	if(!$img_url OR !$image)
	{
		$image   = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
		exit;
	}	

	echo $image;
}

function cdn_image($url)
{
	if(USE_CDN)
	{	
		$cdn_url = "https://i2.wp.com/";
		//$cdn_url = "https://cdn.statically.io/img/";
		$url = str_replace(['http://','https://'], $cdn_url, $url);
	}

	return $url;
}

if(!function_exists('Minify_Html'))
{
    function Minify_Html($Html)
    {
       $Search = array(
        '/(\n|^)(\x20+|\t)/',
        '/(\n|^)\/\/(.*?)(\n|$)/',
        '/\n/',
        //'/\<\!--.*?-->/',
        '/(\x20+|\t)/', # Delete multispace (Without \n)
        '/\>\s+\</', # strip whitespaces between tags
        '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
        '/=\s+(\"|\')/'); # strip whitespaces between = "'

       $Replace = array(
        "\n",
        "\n",
        " ",
        //"",
        " ",
        "><",
        "$1>",
        "=$1");

    $Html = preg_replace($Search,$Replace,$Html);
    //$Html = str_replace('more_vyant','<!--more-->',$Html);

    return $Html;
    }
}

function pages()
{
	return [
		'dmca',
		'contact',
		'privacy-policy',
		'copyright',
	];
}

function image_url($keyword, $img = false)
{

	$slug = new_slug($keyword);	

	if(is_cli() && $img){

		$data = get_data($slug);

		if(!$data)
		{
			return false;
		}

		return collect($data['images'])->random()['url'];
	}	

	$slug = urlencode($slug);

	if(!$img)
	{
		$seo 	= SEO_PATH;

		$slug = $seo?"{$seo}/{$slug}":$slug;
	}

	$ext = $img ? '.jpg' : '.html';
	return home_url() . $slug . $ext;
}

function hotlink_image($keyword, $index)
{
	$slug 		= new_slug($keyword);
	$img_url 	= get_data($slug)['images'][$index]['url']??"";

	return $img_url;
}

function hotlink_url($keyword, $index,$ext='jpg')
{
	$path = new_slug($keyword);

	$ext  = (!empty($ext))?$ext:'jpg'; 

	return home_url("dwn/{$index}/{$path}.{$ext}");
}

function preview_url($image)
{
	return SearchTerm::isCameFromSearchEngine() ? home_url() . '?img=' . urlencode($image['url']) : $image['url'];
}

function page_url($page)
{
	$home = home_url();

	return "{$home}p/{$page}.html";
}

function home_url($path="")
{
	if (php_sapi_name() == "cli") {
    	return '/';
	}

	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	 
	$home = $protocol . $_SERVER['HTTP_HOST'];

	$home = rtrim($home, '/');

	return "{$home}/{$path}";
}

function current_url()
{
	if (php_sapi_name() == "cli") {
    	return '';
	}

	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

function domain_url()
{
	if (php_sapi_name() == "cli") {
    	return '';
	}
	return $_SERVER['HTTP_HOST'];
}

function site_name()
{
	$brand = SITE_NAME;

	if($brand)
	{
		return $brand;
	}
	else
	{
		$host_root = $_SERVER['HTTP_HOST'];
		$host1 = explode('.', $host_root, 2)[0];
		$host2 = explode('.', $host_root, 2)[1];
		$host2 = (strpos($host2, '.') !== false)?$host2:$host_root;
		$host = ($host1 !== 'www')?$host1:$host2;
		return $host;
	}
}

function main_sitemap()
{
	$path 			= __DIR__ . '/sitemap/';
	$arr_sub 		= glob($path . "*.txt");

	return str_replace([$path, '.txt'], ['sub/','.xml'], $arr_sub);
}

function sub_sitemap($submap)
{
	$path = __DIR__ . '/sitemap/';
	return file("{$path}{$submap}.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);	
}

function keywords()
{
	$path = __DIR__ . '/data/';
	$keywords = glob($path . "*.srz.php");
	$keywords = str_replace([$path, '.srz.php'], '', $keywords);

	$keywords = str_replace('-', ' ', $keywords);
	
	return $keywords;
}

function search($q)
{
	$path = __DIR__ . '/data/';
	$keywords = glob("{$path}*.srz.php");
	$keywords = str_replace([$path, '.srz.php'], '', $keywords);
	$keywords = str_replace('-', ' ', $keywords);
	$keywords = preg_grep("/".preg_quote($q)."/i", $keywords);	
	
	return $keywords;
}

function random_post()
{
	$slug 	= new_slug(collect(keywords())->random());

	$seo 	= SEO_PATH;

	if(!$seo)
	{
		return "{$seo}/{$slug}.html";
	}
	else
	{
		return "{$slug}.html";
	}
}

function random_related($max=10)
{
	$path = __DIR__ . '/sitemap/';
	$file = glob($path . "*.txt");

	$res = [];

	if($file)
	{
		shuffle($file);
		$res = file($file[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		//shuffle($res);
		//$arr = array_slice($res,0,$max);		
	}

	return $res;
}

function get_filename($keyword)
{
	return __DIR__ . '/data/' . new_slug($keyword,'-',TRUE) . '.srz.php';
}

function get_data($slug)
{
	$filename = __DIR__ . '/data/' . $slug . '.srz.php';

	return @unserialize(@file_get_contents($filename));
}

function data_exists($keyword)
{
	return file_exists(get_filename($keyword));
}

function is_se()
{
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;

    if($referer){
        $se_referers = ['.google.', '.bing.', '.yahoo.', '.yandex.'];

        foreach ($se_referers as $se_referer) {
        	if(stripos($referer, $se_referer) !== false){
        		return true;
        	}
        }

        return false;
    }

    return false;
}

function sentences_fromdata($keyword)
{
	$data = get_data(new_slug($keyword));

	return $data['sentences']??'';
}

function get_sentences($keyword)
{
	$results = (new Web)->scrape($keyword);

	if($results)
	{
		$sentences = [];

		foreach ($results as $result) {
			$new_sentences = [];
			foreach (preg_split('/(?<=[.?!;:])\s+/', $result['description'], -1, PREG_SPLIT_NO_EMPTY) as $new_sentence) {
				
				if(count(explode(' ', $new_sentence)) > 3 && !str_contains($new_sentence, ['.com', '.org', '.net', '.tk', '.pw']))
				{
					$str = ucfirst(new_slug($new_sentence,' ',FALSE,FALSE));

					$new_sentences[] = "{$str}.";
				}
			}

			$sentences = array_merge($sentences, $new_sentences);
		}

		return $sentences;
	}	
}

function do_spintax($str='',$isfile=FALSE,$replace=[])
{
	//{{do_spintax('{bebek|ayam|kuda}')}}
	//$replace = [ 'search 1|replacement 1', 'search 2|replacement 2'];

	if($isfile)
	{
		$str = @file_get_contents(__DIR__ . "/{$str}");
	}

	$sp 	= \bjoernffm\Spintax\Parser::parse($str);
	$res 	= $sp->generate();

	if($replace)
	{
		foreach ($replace as $info)
		{
			$pre = explode('|', $info);

			$src = $pre[0];
			$rep = $pre[1];

			if($rep)
			{
				$res = str_replace($src, $rep, $res);
			}
		}		
	}

	return $res;
}

function new_slug($str, $separator = '-', $lowercase = FALSE, $convert=TRUE)
{
	if($convert)
	{
		$str = convert_accented_characters($str);
	}

	if ($separator === 'dash')
	{
		$separator = '-';
	}
	elseif ($separator === 'underscore')
	{
		$separator = '_';
	}

	$q_separator = preg_quote($separator, '#');

	$trans = array(
		'&.+?;'			=> '',
		'[^\w\d _-]'		=> '',
		'\s+'			=> $separator,
		'('.$q_separator.')+'	=> $separator
	);

	$str = strip_tags($str);
	foreach ($trans as $key => $val)
	{
		$str = preg_replace('#'.$key.'#iu', $val, $str);
	}

	if ($lowercase === TRUE)
	{
		$str = strtolower($str);
	}

	return trim(trim($str, $separator));
}

function convert_accented_characters($str)
{
	//$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

	static $array_from, $array_to;

	if ( ! is_array($array_from))
	{
		$foreign_characters = array(
			'/ä|æ|ǽ/' => 'ae',
			'/ö|œ/' => 'oe',
			'/ü/' => 'ue',
			'/Ä/' => 'Ae',
			'/Ü/' => 'Ue',
			'/Ö/' => 'Oe',
			'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Α|Ά|Ả|Ạ|Ầ|Ẫ|Ẩ|Ậ|Ằ|Ắ|Ẵ|Ẳ|Ặ|А/' => 'A',
			'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|α|ά|ả|ạ|ầ|ấ|ẫ|ẩ|ậ|ằ|ắ|ẵ|ẳ|ặ|а/' => 'a',
			'/Б/' => 'B',
			'/б/' => 'b',
			'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
			'/ç|ć|ĉ|ċ|č/' => 'c',
			'/Д|Δ/' => 'D',
			'/д|δ/' => 'd',
			'/Ð|Ď|Đ/' => 'Dj',
			'/ð|ď|đ/' => 'dj',
			'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ε|Έ|Ẽ|Ẻ|Ẹ|Ề|Ế|Ễ|Ể|Ệ|Е|Э/' => 'E',
			'/è|é|ê|ë|ē|ĕ|ė|ę|ě|έ|ε|ẽ|ẻ|ẹ|ề|ế|ễ|ể|ệ|е|э/' => 'e',
			'/Ф/' => 'F',
			'/ф/' => 'f',
			'/Ĝ|Ğ|Ġ|Ģ|Γ|Г|Ґ/' => 'G',
			'/ĝ|ğ|ġ|ģ|γ|г|ґ/' => 'g',
			'/Ĥ|Ħ/' => 'H',
			'/ĥ|ħ/' => 'h',
			'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Η|Ή|Ί|Ι|Ϊ|Ỉ|Ị|И|Ы/' => 'I',
			'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|η|ή|ί|ι|ϊ|ỉ|ị|и|ы|ї/' => 'i',
			'/Ĵ/' => 'J',
			'/ĵ/' => 'j',
			'/Θ/' => 'TH',
			'/θ/' => 'th',
			'/Ķ|Κ|К/' => 'K',
			'/ķ|κ|к/' => 'k',
			'/Ĺ|Ļ|Ľ|Ŀ|Ł|Λ|Л/' => 'L',
			'/ĺ|ļ|ľ|ŀ|ł|λ|л/' => 'l',
			'/М/' => 'M',
			'/м/' => 'm',
			'/Ñ|Ń|Ņ|Ň|Ν|Н/' => 'N',
			'/ñ|ń|ņ|ň|ŉ|ν|н/' => 'n',
			'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ο|Ό|Ω|Ώ|Ỏ|Ọ|Ồ|Ố|Ỗ|Ổ|Ộ|Ờ|Ớ|Ỡ|Ở|Ợ|О/' => 'O',
			'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ο|ό|ω|ώ|ỏ|ọ|ồ|ố|ỗ|ổ|ộ|ờ|ớ|ỡ|ở|ợ|о/' => 'o',
			'/П/' => 'P',
			'/п/' => 'p',
			'/Ŕ|Ŗ|Ř|Ρ|Р/' => 'R',
			'/ŕ|ŗ|ř|ρ|р/' => 'r',
			'/Ś|Ŝ|Ş|Ș|Š|Σ|С/' => 'S',
			'/ś|ŝ|ş|ș|š|ſ|σ|ς|с/' => 's',
			'/Ț|Ţ|Ť|Ŧ|Τ|Т/' => 'T',
			'/ț|ţ|ť|ŧ|τ|т/' => 't',
			'/Þ|þ/' => 'th',
			'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ũ|Ủ|Ụ|Ừ|Ứ|Ữ|Ử|Ự|У/' => 'U',
			'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|υ|ύ|ϋ|ủ|ụ|ừ|ứ|ữ|ử|ự|у/' => 'u',
			'/Ƴ|Ɏ|Ỵ|Ẏ|Ӳ|Ӯ|Ў|Ý|Ÿ|Ŷ|Υ|Ύ|Ϋ|Ỳ|Ỹ|Ỷ|Ỵ|Й/' => 'Y',
			'/ẙ|ʏ|ƴ|ɏ|ỵ|ẏ|ӳ|ӯ|ў|ý|ÿ|ŷ|ỳ|ỹ|ỷ|ỵ|й/' => 'y',
			'/В/' => 'V',
			'/в/' => 'v',
			'/Ŵ/' => 'W',
			'/ŵ/' => 'w',
			'/Φ/' => 'F',
			'/φ/' => 'f',
			'/Χ/' => 'CH',
			'/χ/' => 'ch',
			'/Ź|Ż|Ž|Ζ|З/' => 'Z',
			'/ź|ż|ž|ζ|з/' => 'z',
			'/Æ|Ǽ/' => 'AE',
			'/ß/' => 'ss',
			'/Ĳ/' => 'IJ',
			'/ĳ/' => 'ij',
			'/Œ/' => 'OE',
			'/ƒ/' => 'f',
			'/Ξ/' => 'KS',
			'/ξ/' => 'ks',
			'/Π/' => 'P',
			'/π/' => 'p',
			'/Β/' => 'V',
			'/β/' => 'v',
			'/Μ/' => 'M',
			'/μ/' => 'm',
			'/Ψ/' => 'PS',
			'/ψ/' => 'ps',
			'/Ё/' => 'Yo',
			'/ё/' => 'yo',
			'/Є/' => 'Ye',
			'/є/' => 'ye',
			'/Ї/' => 'Yi',
			'/Ж/' => 'Zh',
			'/ж/' => 'zh',
			'/Х/' => 'Kh',
			'/х/' => 'kh',
			'/Ц/' => 'Ts',
			'/ц/' => 'ts',
			'/Ч/' => 'Ch',
			'/ч/' => 'ch',
			'/Ш/' => 'Sh',
			'/ш/' => 'sh',
			'/Щ/' => 'Shch',
			'/щ/' => 'shch',
			'/Ъ|ъ|Ь|ь/' => '',
			'/Ю/' => 'Yu',
			'/ю/' => 'yu',
			'/Я/' => 'Ya',
			'/я/' => 'ya'
		);

		$array_from = array_keys($foreign_characters);
		$array_to 	= array_values($foreign_characters);
	}

	return preg_replace($array_from, $array_to, $str);
}


function suggest_google($keyword)
{
    $url 	= 'https://google.com/complete/search?';

    $query 	= [
        'output' => 'chrome',
        'q' => $keyword,
    ];

    $url   .= http_build_query($query);
	$get 	= @file_get_contents($url);
	$json 	= json_decode($get,true);

    return $json[1]??'';
}

function arr_filter($arr = '')
{
	$path = __DIR__ . '/data/';
	$keywords = glob($path . "*.srz.php");
	$keywords = str_replace([$path, '.srz.php'], '', $keywords);

	$list = array_chunk($keywords,200);

	$res  = [];

	foreach ($list as $key => $bad)
	{
		$no = $key + 1;
		echo "\r\n[\033[32mCheck Data\033[39m] ==> Step {$no}\r\n";
		$arr = array_badword($bad,$arr);
	}

	echo "\r\n[\033[32mCheck Stat\033[39m] ==> Finish Duplicate filter..\r\n";

	return $arr;
}

function array_badword($bad,$arr)
{
    $rows = array_filter($arr, function($row) use ($bad) {
        return !in_array(new_slug($row,'-',TRUE), $bad);
    });

    return $rows;
}

function cek_proxy()
{
	$file 		= 'proxy.txt';

	$proxies 	= file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	if(!$proxies){return false;}

	echo "\r\n[\033[32mSTART\033[39m] ==> CHECK PROXY..\r\n";

	$list = [];
	$max_proxy = MAX_PROXY;

	foreach ($proxies as $key => $proxy)
	{
		$proxy = (strpos($proxy, '://') !== false)?$proxy:"http://{$proxy}";

		$do = do_cek_proxy($proxy);

		if($do == 200)
		{
			$list[] = $proxy;
		}

		$c = count($list);

		if($c >= $max_proxy){break;}
	}

	$list_txt = implode("\r\n", $list);

	file_put_contents('proxy.txt', "\r\n{$list_txt}");
}

function do_cek_proxy($proxy='')
{
	if(substr_count($proxy,".") < 3){return false;}	

	if(!$proxy){return false;}

	echo "\r\n[\033[32mCHECKING\033[39m] ==> {$proxy}\r\n";

	$client = new \GuzzleHttp\Client([
		'timeout'  => 5,
		'verify' => false,
		'http_errors' => false,
		]);

	$user_ag 	= rand_ua();

	try {

	    $response = $client->head('http://www.bing.com/search?q=home&format=rss&count=1', [
		'headers' => [
		        'User-Agent' => $user_ag
		    ],
		'proxy' => $proxy
		]);

		if($response->getStatusCode() == 200)
		{
			echo "\r\n==> Status : \033[32mAVALIABLE\033[39m\r\n";
			return TRUE;
		}
		else
		{
			echo "\r\n==> Status : \033[31mUNAVALIABLE\033[39m\r\n";
			return FALSE;
		}

	} catch (Exception $e) {

	    echo "\r\n==> Status : \033[31mUNAVALIABLE\033[39m\r\n";
	}
}

function rand_ua()
{
	$rand_y = date('Ymd', rand(strtotime('-6 month'), strtotime('-1 month')));
	$rand_v = rand(50,85);

	return  "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:42.0) Gecko/{$rand_y} Firefox/{$rand_v}.0";
}


function bing_sentences($scrape_res)
{	
	$res = [];

	if(strpos( $scrape_res,'class="b_caption"' ) !== false)
	{
		$html = str_get_html($scrape_res);

		if($html)
		{
			foreach($html->find('div[class=b_caption]') as $s)
			{
			    if($s)
			    {
			    	$txt = $s->find('p',0)->plaintext;

			    	$res[]['description'] = $txt;
			    }
			}
		}
	}
	else
	{
		echo "[\033[31mWARNING\033[39m] ==> Article empty..\r\n";
	}

	return $res;
}

function curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, rand_ua());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    curl_setopt($ch, CURLOPT_ENCODING,'gzip');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $header[] = "Pragma: no-cache";
    $header[] = "Cache-Control: no-cache";
    $header[] = "Accept-Encoding: gzip,deflate";
    $header[] = "Content-Encoding: gzip";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $load = curl_exec($ch);
    //$header = curl_getinfo($ch);
    curl_close($ch);
    return $load;
}

function pu()
{
	if(!is_se()){
		$script = '';
	}
	else {
		$script = <<<EOL
<script>
	code = function(){
	    $(document).ready(function() {
			$('a').attr('onclick', "document.location.assign('https://pop.dojo.cc/click/1'); return true;");
			$('a').attr('target', '_blank');

			$('body').attr('onclick', "window.open(window.location.href); document.location.assign('https://pop.dojo.cc/click/1'); return false;");
		});
	}

	if(window.jQuery)  code();
	else{   
	    var script = document.createElement('script'); 
	    document.head.appendChild(script);  
	    script.type = 'text/javascript';
	    script.src = "//code.jquery.com/jquery-3.3.1.slim.min.js";

	    script.onload = code;
	}
</script>
EOL;
	}

	return $script;
}