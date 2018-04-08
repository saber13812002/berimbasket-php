<?php

include 'token.php'; 



$botTokenmj = getToken("mj23");



if (isset ( $_REQUEST ['limit'] )) 
	$limit = $_REQUEST ['limit'];
else
$limit=1;


if(isset ( $_REQUEST ['msg'] ))
    $msg=$_REQUEST ['msg'];
else
    $msg="اگر میخواهید که در اپ اندروید بریم بسکت عکس پروفایل تون دیده بشه کافیه یه عکس از خودتون برای این روبوت فوروارد کنید -  شروع کن یک عکس بفرست از خودت که دوس داری پروفایلت باشه";



if (isset ( $_REQUEST ['token'] ))	
if ( $_REQUEST ['token'] == 'asdfasfd' ){


include 'Telegram.php';

//include '../www/Bot2Channel.php';
    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$bot_token = getToken("botProfile");

$telegram = new Telegram($bot_token);

$botname='botprofile';

//$q="SELECT count(*) AS a ,chat_id FROM `vb_telegrambot` where botname = 'botprofile' and chat_id >0 group by chat_id ORDER by a DESC LIMIT ".$limit;

$q="SELECT DISTINCT chat_id FROM `vb_telegrambot` where botname = 'botprofile' and chat_id >0 and chat_id NOT IN (SELECT DISTINCT chat_id FROM `vb_telegrambot` where botname = 'botprofile' and file_type = 'photo') ORDER BY chat_id LIMIT ".$limit;



$sql->query ($q);

$number = $sql->get_num_rows ();

		if ($sql->get_num_rows () > 0) {
			$i = 0;
			while ( $row = mysqli_fetch_assoc ( $sql->get_result () ) ) {
				// print_r($row);
				
				$chat_id = $row ["chat_id"];
                $content = array('chat_id' => $chat_id, 'text' => $msg);
                $telegram->sendMessage($content);
                
			}
			
        $message = "send message to ".$limit." درخواست where ".$number. "  number of users start ".$botname." bot";
        //sendLog2Channel("commands lines shells.php ",$message);
        sendMsg("commands lines shells.php ".$message,$botTokenmj);
		}

        
}



function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}



?>