<?php

include 'token.php'; 
include ('../../wp-load.php');
include 'Telegram.php';
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();
$bot_token = getToken('botZheel');
$telegram = new Telegram($bot_token);


$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$last = isset($_GET['last']) ? intval($_GET['last']) : 1; 

if($limit>100)
    $limit=100;


$query="SELECT DISTINCT(chat_username) FROM `vb_telegrambot` where  botname LIKE 'bot%' and  timestamp >= NOW() - INTERVAL ".$last." HOUR  order by id DESC limit ".$limit;
//".$last."
$sql->query ($query);
$product='';
if ($sql->get_num_rows () > 0) {
			$i = 0;
			while ( $row = mysqli_fetch_assoc ( $sql->get_result () ) ) 
			{
				
				$product .= '@'.$row ["chat_username"]." | ";
			//	$product .= '#'.$row ["chat_id"]." | ";
			//	$product .= '#'.$row ["botname"].PHP_EOL;
			}
    
}


    $chat_id = 222909344; // '-1121691989';
        $content = ['chat_id' => $chat_id, 'text' => $product];
        $telegram->sendMessage($content);
        
        
        
// $product="https://berimbasket.ir/bball/bots/schedule_send_bot_starters.php?limit=1000&last=100000"   ;     
//         $content = ['chat_id' => $chat_id, 'text' => $product];
//         $telegram->sendMessage($content);        
        
        
        
        //timestamp >= NOW() - INTERVAL ".$last." HOUR 
        
  $query="SELECT * FROM `vb_telegrambot` where  botname LIKE 'botVoice%' and rate <1 order by RAND() limit 1";
//".$last."
$sql->query ($query);
//
if ($sql->get_num_rows () > 0) {
			$i = 0;
			if ( $row = mysqli_fetch_assoc ( $sql->get_result () ) ) 
			{
				
				$file_id = $row ["file_id"];
				$id = $row ["id"];

			}
    
}      

$bot_token = getToken('botVoice');
// Instances the class
$telegram = new Telegram($bot_token);
$content = ['chat_id' => $chat_id, 'video' => $file_id , 'caption' => '@berimbasketrobot'];
$telegram->sendVideo($content);
$content = ['chat_id' => $chat_id, 'text' => "#a_".$id];
$telegram->sendMessage($content);
$content = ['chat_id' => $chat_id, 'text' => "/rejected".$id.PHP_EOL."/rate1".$id.PHP_EOL."/rate2".$id.PHP_EOL."/rate3".$id.PHP_EOL."/rate4".$id.PHP_EOL."/rate5".$id];
$telegram->sendMessage($content);
$content = ['chat_id' => $chat_id, 'text' => "/caption,".$id.","];
$telegram->sendMessage($content);
$content = ['chat_id' => $chat_id, 'text' => "/keyword".PHP_EOL.$id.PHP_EOL];
$telegram->sendMessage($content);



$sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and `Active`=1 and tags like '%instagram.com%' order by RAND() LIMIT 1" );

if ($sql->get_num_rows () > 0) {
	
	while ( $row = mysqli_fetch_assoc ( $sql->get_result())) {
		$id = $row ["id"];
		$reply = $row ["tags"];
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $content = ['chat_id' => $chat_id, 'text' => "#a_".$id];
        $telegram->sendMessage($content);
        $content = ['chat_id' => $chat_id, 'text' => "/instaVote1".$id.PHP_EOL."/instaVote2".$id.PHP_EOL."/instaVote3".$id.PHP_EOL."/instaVote4".$id.PHP_EOL."/instaVote5".$id];
        $telegram->sendMessage($content);
        $content = ['chat_id' => $chat_id, 'text' => "/uploadId,".$id.","];
        $telegram->sendMessage($content);
	}

}


?>