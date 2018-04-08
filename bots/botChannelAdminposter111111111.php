<?php

include 'token.php'; 
include 'Telegram.php';
// include 'goo.gl.php' ;

    require_once('emoji.php');



$chat_ch_id=222909344;  

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$channel='@berimbasket';

$bot_token =  getToken("botVoice")
// Instances the class
$telegram = new Telegram($bot_token);

date_default_timezone_set("Asia/Tehran");
$time= date_default_timezone_get();
$currentHour = date('H');
$message_id=0;
    $sql->query ("select * from vb_telegrambot WHERE botname like '%botVoice%' and published=0 and rate>4 order by id limit 1");
    if ($sql->get_num_rows () > 0) {
        if( $row = mysqli_fetch_assoc ( $sql->get_result()))
        
        $hour=$row["foaf"];
        $message_id=$row["id"];
        $chat_id=$row["chat_id"];
        $file_id=$row["file_id"];
        $text=$row["text"];
        $file_type=$row["file_type"];
        $keyword=$row["keyword"];
        $caption=$row["caption"];
    }

$content = ['chat_id' => $chat_ch_id, 'text' => $hour.PHP_EOL.
        $currentHour .PHP_EOL.
        $chat_id.PHP_EOL.
        $file_id.PHP_EOL.
        $text.PHP_EOL.
        $file_type.PHP_EOL.
        $time];
$telegram->sendMessage($content);

if($chat_id!=null)
{
if($file_type=='photo'){
$content = ['chat_id' => $chat_ch_id, 'photo' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendPhoto($content);

$content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendPhoto($content);


$content = ['chat_id' => $channel, 'photo' => $file_id , 'caption' => $text.PHP_EOL.' @edu360'];
$telegram->sendPhoto($content);

}

if($file_type=='.mp4'){
$content = ['chat_id' => $chat_ch_id, 'video' => $file_id , 'caption' => $caption.PHP_EOL.$channel];
$telegram->sendVideo($content);

$content = ['chat_id' => $chat_id, 'video' => $file_id , 'caption' => $caption.PHP_EOL.$channel];
$telegram->sendVideo($content);

//$ch=Emoji::Decode('\\u1F446');
$ch="\u{1F446}";
$ch='👆👆👆';
$content = ['chat_id' => $channel, 'video' => $file_id , 'caption' => $caption.PHP_EOL.$channel.PHP_EOL.$ch];//.utf8_chr( '\u1000' )
$telegram->sendVideo($content);
}

if($file_type=='voice'){
$content = ['chat_id' => $chat_ch_id, 'voice' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendVoice($content);

$content = ['chat_id' => $chat_id, 'voice' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendVoice($content);

$content = ['chat_id' => $channel, 'voice' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendVoice($content);
}

if($file_type=='document'){
$content = ['chat_id' => $chat_ch_id, 'document' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendDocument($content);

$content = ['chat_id' => $chat_id, 'document' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendDocument($content);

$content = ['chat_id' => $channel, 'document' => $file_id , 'caption' => $text.PHP_EOL.$channel];
$telegram->sendDocument($content);
}



$content = ['chat_id' => $chat_ch_id, 'text' => 'راس ساعت مقرر در کانال قرار گرفت '];
$telegram->sendMessage($content);

$content = ['chat_id' => $chat_id, 'text' => 'راس ساعت مقرر در کانال قرار گرفت '];
$telegram->sendMessage($content);

$sql->query("UPDATE vb_telegrambot SET published=1 WHERE id= $message_id");



}
else{
$content = ['chat_id' => $chat_ch_id, 'text' => ' برای این ساعت چیزی نداریم '];
$telegram->sendMessage($content);
}
// $content = ['chat_id' => $chat_id, 'text' => 'راس ساعت مقرر در کانال قرار گرفت'];
// $telegram->sendMessage($content);





?>