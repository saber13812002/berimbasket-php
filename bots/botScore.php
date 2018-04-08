<?php
include 'token.php'; 
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$botTokenmj = getToken("mj23");

$bot_id = getToken("botScore");
$telegram = new Telegram($bot_id);

//$telegram->serveUpdate($i);
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$chat_firstname = $telegram->FirstName();
$chat_lastname = $telegram->LastName();
$FromChatID = $telegram->FromChatID();
$messageFromGroup = $telegram->messageFromGroup();
$FromID = $telegram->FromID();
$UpdateID = $telegram->UpdateID();
//$txt=$telegram->data["message"]["text"];

$chat_username = $telegram->Username();
$ch_id=(string)$chat_id;



$instagramLink=substr($text,strpos($text, 'https://'),strlen($text));

//echo json_encode ( $telegram );

$chat_username = $telegram->Username();

$help = PHP_EOL." /start".PHP_EOL."  آی دی ادمین"
.PHP_EOL."@berimbasket_ir پیام دهید ";

$help = $help.". به کمک روبات نقشه زمین بسکتبال خود را برای ما بفرستید @berimbasketmapbot  https://t.me/berimbasket/302";


$count=0;$score=0;
$totalScore=0;
$countreserve=0;
$scorereserve=0;
$countfp=0;
$scorefp=0;
$countaxp=0;
$scoreaxp=0;
$countaxz=0;
$scoreaxz=0;

$countInvite=0;
$scoreInvite=0;
    
$countz=0;
$scorez=0;


$content = array('chat_id' => $chat_id ,'text' => $help);

$telegram->sendMessage($content);

$sql->query ("INSERT INTO `InstagramBot` (`text`, `tags`,`FromID`,`ChatID`,`FromChatID`,`messageFromGroup`,`UpdateID`) VALUES ( 'instagram', '', '$ch_id', '$chat_username' ,'$FromChatID','$messageFromGroup','$UpdateID')" );


$sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and  `FromID`  = '$ch_id' and `Active`=1  and tags<>'/start'  and tags<>'' and tags<>'' and tags like '%instagram.com%'" );

if ($sql->get_num_rows() > 0)
{

    $count=$sql->get_num_rows ();
    $score=$count*50;
}

$reply = "ممنون از مشارکت شما"
.PHP_EOL.PHP_EOL.
"تعداد ویدئوهای آپلود شده ی شما تاکنون "
.$count." عدد و"
.PHP_EOL." امتیاز ویدئوی شما "
.$score
.PHP_EOL.PHP_EOL;


$sql->query ("SELECT * FROM `vb_playground` where PgTlgrmGroupAdminId='".$chat_username ."'");
if ($sql->get_num_rows() > 0)
{

    $countz=$sql->get_num_rows ();
    $scorez=$countz*100;
}

$reply .= "تعداد زمین های ثبت شده ی شما با روبات تاکنون "
.$countz." عدد و"
.PHP_EOL." امتیاز زمین شما "
.$scorez
.PHP_EOL.PHP_EOL;




$sql->query ("SELECT * FROM `vb_telegrambot` WHERE `chat_type`='botUpload' and `chat_id`='".$chat_id."' and `file_type`='photo'");
if ($sql->get_num_rows() > 0)
{

    $countaxz=$sql->get_num_rows ();
    $scoreaxz=$countaxz*100;
}

$reply .= "تعداد عکس زمین های آپلود شده ی شما با روبات تاکنون "
.$countaxz." عدد و"
.PHP_EOL." امتیاز عکس زمین شما "
.$scoreaxz
.PHP_EOL.PHP_EOL;




$sql->query ("SELECT * FROM `vb_telegrambot` WHERE `chat_type`='botProfile' and `chat_id`='".$chat_id."' and `file_type`='photo'");
if ($sql->get_num_rows() > 0)
{

    $countaxp=$sql->get_num_rows ();
    $scoreaxp=$countaxp*100;
}

$reply .= "تعداد عکس پروفایل آپلود شده ی شما با روبات تاکنون "
.$countaxp." عدد و"
.PHP_EOL." امتیاز عکس زمین شما "
.$scoreaxp
.PHP_EOL.PHP_EOL;




$sql->query ("SELECT * FROM `vb_telegrambot` WHERE `chat_type`='botProfile' and `chat_id`='".$chat_id."' and `file_type`<>'photo'");
if ($sql->get_num_rows() > 0)
{

    $countfp=$sql->get_num_rows ();
    $scorefp=$countfp*50;
}

if($countfp>15){
$countfp=15;
    $scorefp=750;
}
    
$reply .= "تعداد فیلد پروفایل کامل شده ی شما با روبات تاکنون "
.$countfp." عدد و"
.PHP_EOL." امتیاز پروفایل شما "
.$scorefp
.PHP_EOL.PHP_EOL;





$sql->query ("SELECT * FROM `vb_telegrambot` WHERE (`chat_type`='botrserve' or `chat_type`='botreport') and `chat_id`='".$chat_id."' and `file_type`<>'photo'");
if ($sql->get_num_rows() > 0)
{

    $countreserve=$sql->get_num_rows ();
    $scorereserve=$countreserve*50;
}

$reply .= "تعداد بازیکن یا زمین ریپورت شده توسط شما با روبات تاکنون "
.$countaxp." عدد و"
.PHP_EOL." امتیاز شما "
.$scoreaxp
.PHP_EOL.PHP_EOL;



$sql->query ("SELECT distinct foaf  FROM `vb_telegrambot` where foaf > 100000 and chat_id <> foaf and chat_id = ".$chat_id);
if ($sql->get_num_rows() > 0)
{

    $countInvite=$sql->get_num_rows ();
    $scoreInvite=$countInvite*1000;
}

$reply .= "تعداد بازیکن دعوت شده توسط شما با روبات تاکنون "
.$countInvite." عدد و"
.PHP_EOL." امتیاز شما "
.$scoreInvite
.PHP_EOL.PHP_EOL;






$totalScore=$scorez+$score+$scoreaxz+$scoreaxp+$scorefp+$scorereserve+$scoreInvite;

$reply .=" امتیاز کل شما "
.$totalScore.PHP_EOL.PHP_EOL
.'';




$content = array('chat_id' => $chat_id ,'text' => $reply.' ');

$telegram->sendMessage($content);



$message = ' #scorebot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$count.'  ';

sendMsg($message,$botTokenmj);




function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = -1001136444717;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);

}




//sendLoc('@varzeshboard',35.35,51.51);

//$response = array ();
//$response [] = getUpd();
//echo json_encode ( $response[0]['result'].update_id );



//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");

