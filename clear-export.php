<?php
// prevent browser
if(PHP_SAPI !== 'cli'){ die; }
require 'constants.php';

$seo = SEO_PATH;

if($seo)
{
	if (file_exists("export/html/{$seo}"))
	{
		foreach (glob("export/html/{$seo}/*.html") as $file) {
			unlink($file);
		}
	}
}

foreach (glob('export/*.xml') as $file) {
	unlink($file);
}

foreach (glob('export/html/*.html') as $file) {
	unlink($file);
}



echo "Data cleared\n";