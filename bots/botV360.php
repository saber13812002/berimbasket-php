<?php

include 'token.php'; 
include 'Telegram.php';
// include 'goo.gl.php' ;


require_once __DIR__ . '/db_connect.php';
$sql = new DB ();
 
$channel='@edu360';

//$file_id='AgADBAADw6oxGyyzuVHTFN16zGGjgRAxJhoABG41p40NIWWfKbABAAEC';

$chat_ch_id=222909344;  //saber aghbaba2
$chat_ch_id2=434590301; //not found
$chat_ch_id3=83674896; // not found
$chat_ch_id4=151370482; //not found
$chat_ch_id5=127562196; //not found

//$channelId=-1001311680377;
$channelId=-1001242973513;
// Set the bot TOKEN
$bot_token = getToken("botV360");
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botV360';


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


// any message in channel not replyed there and msg send to me
if($chat_id==$channelId)
$chat_id=$chat_ch_id;


$admin=0;
if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
$admin=1;


if(substr($text,0,1)=='/')
{
    if($admin==1)
    {
        if(substr($text,0,4)=='/del')
        {
        $message_id=substr($text,4,9);
        $sql->query("UPDATE vb_telegrambot SET approved=0 WHERE id= $message_id");
        
        $content = ['chat_id' => $chat_id, 'text' => 'پاک شد'];
        $telegram->sendMessage($content);
        }
        if(substr($text,0,6)=='/admin')
        {
        $message_id=substr($text,6,20);
        $sql->query("Insert into vb_telegrambot id= $message_id");
        
        $content = ['chat_id' => $chat_id, 'text' => 'ادمین شد'];
        $telegram->sendMessage($content);
        }
        if(substr($text,0,6)=='/start')
        {
            $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین هستید شروع کنید'];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_ch_id, 'text' => 'یک ادمین شروع کرد '
            .PHP_EOL
            .'/noadmin'
            .$chat_id
            ];
            $telegram->sendMessage($content);
        }
    }
    else 
    {
        if(substr($text,0,6)=='/start')
        {
            $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین نیستید درخواست ادمین شدن شما برای ادمین ارسال شد اگر ایشان موافقت کند شما هم میتوانید از روبات استفاده کنید'];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_ch_id, 'text' => 'درخواست ادمین شدن '
            .PHP_EOL
            .'/admin'
            .$chat_id
            ];
            $telegram->sendMessage($content);
        }
    }
}
else
{
$cap_len=strlen($caption);

$adad=substr($caption,0,2);

$flagHour=false;

if (is_numeric($adad)) {
$adad=intval($adad);
$flagHour=true;

$textc=substr($telegram->Caption(),2);
}
else
    $adad=-1;
    
    $getUpdateType=$telegram->getUpdateType();
    
        $ext='.png';
    if($getUpdateType=='voice'){
        $ext='.ogg';$file_type='voice';}
    else if($getUpdateType=='video'){
        $ext='.mp4';$file_type='video';}
    else if($getUpdateType=='photo'){
        $ext='.png';$file_type='photo';}
    else if($getUpdateType=='document'){
        $ext='.gif';$file_type='document';}
        
    $file_id = $telegram->getFileID2();
        
    $sql->query ("INSERT INTO `vb_telegrambot` (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES (NULL, '1', '$botname', '$UpdateID', '', '', '', '', '', '', '$chat_id', '', '', '', '', '', '$textc', CURRENT_TIMESTAMP, $adad , '$file_id', '$file_type', '', '', '', '', '');");
    
    
    if($admin==1)
    {
    
    
    
    //'AwADBAADvgEAAszoGFNxOcuI4bQB1wI'
    // $file=$telegram->getFile($file_id);
    // $filepath=$file["result"]["file_path"];
    //$telegram->downloadFile($filepath, 'dl/videos/'.$UpdateID.$ext);
    //$rp='https://berimbasket.ir/bball/bots/dl/videos/'.$UpdateID.$ext;
    //$content = ['chat_id' => $chat_id, 'text' => $rp];
    //$telegram->sendMessage($content);
        
        
    $width=123;
    $height=123;
    $duration=0;
    $mime_type='';
    //$file_type=$ext;
    
    
    if($file_type=='photo'){
    $content = ['chat_id' => $chat_ch_id, 'photo' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendPhoto($content);
    
    $content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendPhoto($content);
    }
    
    if($file_type=='video'){
    $content = ['chat_id' => $chat_ch_id, 'video' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendVideo($content);
    
    $content = ['chat_id' => $chat_id, 'video' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendVideo($content);
    }
    
    if($file_type=='voice'){
    $content = ['chat_id' => $chat_ch_id, 'voice' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendVoice($content);
    
    $content = ['chat_id' => $chat_id, 'voice' => $file_id , 'caption' => $textc.PHP_EOL.$channel];
    $telegram->sendVoice($content);
    }
    
    $content = ['chat_id' => $chat_ch_id, 'text' => ' راس  ساعت  '.$adad.'   در کانال قرار میگیرد'];
    $telegram->sendMessage($content);
    
    
    if($adad>=0&&$adad<24){
       $sql->query ("select * from vb_telegrambot WHERE botname like '%botV360%' and approved=1 and foaf= $adad order by id desc limit 1");
        if ($sql->get_num_rows () > 0) {
            if( $row = mysqli_fetch_assoc ( $sql->get_result()))
            
            $hour=$row["foaf"];
            $message_id=$row["id"];
            $chat_id=$row["chat_id"];
            $file_id=$row["file_id"];
            $textc=$row["text"];
            $file_type=$row["file_type"];
        }
    }
    
    
    $content = ['chat_id' => $chat_id, 'text' => ' راس  ساعت  '.$adad. '   در کانال قرار میگیرد'
    .PHP_EOL
    .'طول کپشن شما الان '
    .$cap_len
    .' است نباید بیشتر از 190 باشد '
    .' اگر میخواهید پیام را ویرایش کنید این را پاک کنید '
    .'/del'.$message_id
    
    ];
    $telegram->sendMessage($content);
    
    
    }
    else
    {
        if($chat_id<0)
        {
    $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین نیستید '];
    $telegram->sendMessage($content);
            
        }
    $content = ['chat_id' => $chat_ch_id, 'text' => $chat_id.' ایشان ادمین نیستند '];
    $telegram->sendMessage($content);
    }

}

function assert_equals($is, $should) {
  if($is != $should) {
    exit(1);
  } 

}
function assert_url($is) {
  if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $is)) {
    exit(1);
  } 

}


?>