<?php

define('HOST', 'localhost');
define('PORT', 3306);
define('DB_NAME', 'banner');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('TABLE_NAME', 'banner.banner');
define('MAX_VARCHAR', 383);

$data = $_SERVER;

if (!isset($data['HTTP_REFERER'])){
    die('<h1>:)</h1>');
}

$ip_address = $data['REMOTE_ADDR'];
$page_url = substr($data['HTTP_REFERER'], 0, MAX_VARCHAR - 1);
$user_agent = substr($data['HTTP_USER_AGENT'], 0, MAX_VARCHAR - 1);

try{
    $pdo = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
} catch(PDOException){
    //do something
    image();
}

$sql = 'INSERT INTO ' . TABLE_NAME
. '(ip_address, user_agent, page_url) '
. 'VALUES(INET_ATON(:ip_address), :user_agent, :page_url)'
. 'ON DUPLICATE KEY UPDATE views_count=views_count+1';

$query = $pdo->prepare($sql);

$query->bindParam(':ip_address', $ip_address);
$query->bindParam(':user_agent', $user_agent);
$query->bindParam(':page_url', $page_url);

try{
    $query->execute();
} catch(PDOException){
    //do something
    image();
}

function image()
{
    header('Content-Type: image/svg+xml');
    echo <<<IMAGE
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" style="fill:#0273a2">
<title>Super Banner</title>
<path d="M990,271.4c0,16.6-5.7,31-17,43.1L428.5,859c-12.1,11.3-26.5,17-43.1,17s-31-5.7-43.1-17L27,543.7c-11.3-12.1-17-26.5-17-43.1c0-16.6,5.7-31,17-43.1l86.2-86.2c12.1-12.1,26.5-18.1,43.1-18.1c16.6,0,31,6,43.1,18.1l186,187.2l415.1-416.3C812.7,130,827,124,843.7,124c16.6,0,31,6,43.1,18.1l86.2,86.2C984.3,240.4,990,254.8,990,271.4z"/>
</svg>
IMAGE;
    exit;
}

image();