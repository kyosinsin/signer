<?php
date_default_timezone_set('Asia/Tokyo');
//$filename = date('YmdHi') . '.jpg';
$filename = date('YmdHis') . '.jpg';
$result = file_put_contents( 'C:/xampp/htdocs/signer/pic/'.$filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI'])
	. '/pic/' . $filename;
print "$url\n";
?>
