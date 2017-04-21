<?php

if(empty($_GET['u'])) {
	throw new Exception('');
}

$url = $_GET['u'];
$code = $_GET['code'];
$url .= strpos($url, '?') === false ? '?' : '&';
$url .= 'code=' . $code;

header('Location: ' . $url);