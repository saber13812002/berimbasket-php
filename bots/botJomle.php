<?php

include 'token.php'; 
include 'mytelegram.php';
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$bot_token =  getToken("botJomle");
$telegram = new Telegram($bot_token);


$chat_ch_id=222909344;  
$chat_ch_id2=111398115;
$chat_ch_id3=83674896;
$chat_ch_id4=151370482;
$chat_ch_id5=127562196;


$botname='botJomle';
// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$chat_username = $telegram->Username();
$chat_firstname = $telegram->FirstName();
$chat_lastname = $telegram->LastName();
$FromChatID = $telegram->FromChatID();
$messageFromGroup = $telegram->messageFromGroup();
$FromID = $telegram->FromID();
$UpdateID = $telegram->UpdateID();
$caption =$telegram->Caption();
// 
$query_current_info="";


 $search='بسکتبال';
 $offset=strpos($text,$search);
 if ($offset !==false)
   $chat_type="bball";
 else if (strpos($text,"بسكتبال")!==false || strpos($text,"لیگ")!==false || strpos($text,"NBA")!==false||strpos($text,"باخت")!==false||strpos($text,"بازی")!==false||strpos($text,"بسکت")!==false||strpos($text,"برد")!==false)
   $chat_type="bball";
 else
   $chat_type="else";
 

if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
   $chat_type="bball";
 
 if($text=='/bball'||$text=='/start'||$text=='/stop'||$text=='/else')
 {
     $command=$text;
     $text=substr($text, 1, -1);
     $sql->query ("select distinct(text) from vb_telegrambot WHERE chat_type like '%".$text."%' order by id desc limit 20
");
 	if ($sql->get_num_rows () > 0) {
		while ( $row = mysqli_fetch_assoc ( $sql->get_result () ) ) {
			$text.= $row ["text"].PHP_EOL;
		}
 	}
 	
 	    
    $content = ['chat_id' => $chat_id, 'text' => $text];
    $telegram->sendMessage($content);
    
    
     sendLog2Channel("#botJomle #$command");
 }
 else
 {
     
    // $content = ['chat_id' => $chat_id, 'text' => $caption];
    // $telegram->sendMessage($content);
    
     if($caption)
        $text=$caption;
     
     
    // $content = ['chat_id' => $chat_id, 'text' => $text];
    // $telegram->sendMessage($content);
    
$sql->query ("select distinct(text) from vb_telegrambot WHERE text like '%".$text."%' order by id
");
 	if ($sql->get_num_rows () == 0) 
 	{
 	    
 	    
    $sql->query ("INSERT INTO `vb_telegrambot` 
    
    (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) 
    
    VALUES 
    
    (NULL, '0', '$botname', '$UpdateID', '$FromID', '$from_first_name', '$from_last_name', '$from_username', '$from_language_code', '$pushe_id', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$chat_type', '', '$text', CURRENT_TIMESTAMP, '$foaf', '', '', '', '', '', '', '');");	
    
    
    
    $text1="دریافت شد و در صف قرار گرفت"
    .PHP_EOL
    ." و درطبقه بندی"
    ." "
    ."#"
    .$chat_type
    ." اضافه شد "
    .PHP_EOL
    ."برام یه جمله دیگه بفرست";
    
    $content = ['chat_id' => $chat_id, 'text' => $text1.PHP_EOL.$text];
    $telegram->sendMessage($content);

     sendLog2Channel("#botJomle $chat_type "."@$chat_username"." @jomlebesazbot
     
     $text
     ");
}
else
{
        $text="تکراری ";
    
    $content = ['chat_id' => $chat_id, 'text' => $text];
    $telegram->sendMessage($content);

     sendLog2Channel("#botJomle $text"."@$chat_username"." @jomlebesazbot
     
     $text");
}
}
// $content = ['chat_id' => 222909344, 'text' => $text];
// $content = ['chat_id' => 111398115, 'text' => $text];
// $content = ['chat_id' => 83674896, 'text' => $text];
// $content = ['chat_id' => 151370482, 'text' => $text];
// $content = ['chat_id' => 127562196, 'text' => $text];


?>