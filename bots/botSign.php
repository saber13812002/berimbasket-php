<?php
include 'token.php'; 
include 'Telegram.php';
include('../Pushe.php');

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();


$botTokenmj = getToken("mj23");

$botname='botsign';

$bot_id = getToken("botSign");
$telegram = new Telegram($bot_id);



// Get all the new updates and set the new correct update_id
//$req = $telegram->getUpdates();
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
// You NEED to call serveUpdate before accessing the values of message in Telegram Class
//	$telegram->serveUpdate($i);

	$text = $telegram->Text();
	$chat_id = $telegram->ChatID();
	$chat_firstname = $telegram->FirstName();
	$chat_lastname = $telegram->LastName();
    $getUpdateType=$telegram->getUpdateType();	

	//user = update.message.from_user;
	//echo json_encode ( $telegram );
	
	$chat_username = $telegram->Username();
	$help = "لطفا با دقت مطالعه کنید
👇👇👇
سلام شما برای عضویت در بریم بسکت نیاز به رمز چهار رقمی دارید از طریق دکمه ی 
👇👇👇
کد فعالسازی
	اقدام کنید";
    //$help = $help.". به کمک روبات نقشه زمین بسکتبال خود را برای ما بفرستید @berimbasketmapbot";
    
//if(substr($text,0,1)=='/')
//if(substr($text,0,6)=='/start')
//{
// $content = array('chat_id' => $chat_id, 'text' => $text);
// $telegram->sendMessage($content);
    

        $option = array( array("کد فعالسازی", "راهنما") );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
    
    
	if ($text == "/start" || substr($text,0,6) == "/start") {
	    if ($telegram->messageFromGroup()) {
			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
		}
		else {
		    
    $pushe_id=substr($text,7,strlen($text)-7);
    
    
//     $content = array('chat_id' => $chat_id, 'text' => $pushe_id);
//     $telegram->sendMessage($content);		    
		    
// $content = array('chat_id' => $chat_id, 'text' => substr($text,0,6));
//     $telegram->sendMessage($content);
    
    
		$reply=$help;    
        // Create option for the custom keyboard. Array of array string
        $option = array( array("کد فعالسازی", "راهنما") );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
		
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`,  `timestamp`,  `pushe_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname',CURRENT_TIMESTAMP,'$pushe_id');");
		
			$message = ' #codebot #start '.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';
			sendMsg($message,$botTokenmj);
        }
	    }

// else if(substr($text,0,9)=='/pusheid=')
// {

//             $pushe_id=substr($text,9,strlen($text)-9);

//     $reply=$help;    
//         // Create option for the custom keyboard. Array of array string
//         $option = array( array("کد فعالسازی", "راهنما") );
//         // Get the keyboard
// 		$keyb = $telegram->buildKeyBoard($option);
// 		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
// 		$telegram->sendMessage($content);
// 		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, ) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname' );");
		
// 			$message = ' #codebot #start '.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';

    
// }
  if($getUpdateType=='reply'){
      
// 	    $content = array('chat_id' => $chat_id, 'text' => "contact");
// 		$telegram->sendMessage($content);
		
		$phone_number=$telegram->getCellPhone();
// 		first_name
// 		last_name
// 		chat_id

		$phone_number = '0'.substr($phone_number, -10);
		
//     	$content = array('chat_id' => $chat_id, 'text' => '0'.$phone_number);
// 		$telegram->sendMessage($content);	
		send4digit($sql,$telegram,$chat_username,$chat_id,$phone_number);

		
	}
if($getUpdateType=='contact'){
$phone_number=$telegram->getCellPhone();
$phone_number = '0'.substr($phone_number, -10);
send4digit($sql,$telegram,$chat_username,$chat_id,$phone_number);
}
if($getUpdateType=='photo')
{
    $file_id0=$telegram->getFileID2();
    $file_id=$file_id0.'';
    $file_size0=$telegram->getFileSIZE();
    $width=$telegram->getPhotoWidth2() ;
    $height=$telegram->getPhotoHeight2() ;
    $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botZheel', '', '$text', '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');");
}
	if ($text == "کد فعالسازی") {
	   $option = array( array($telegram->buildKeyboardButton(
	       "شماره موبایل تلگرام ام برای برنامه ارسال شود",true,false)), array($telegram->buildKeyboardButton("خیر عضو نمیشوم",false,false)) );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $chat_firstname." - ".", برای تایید نهایی اکانت شما و فعالسازی لازم است شماره تماس خود را به اشتراک بگذارید .");
$telegram->sendMessage($content); 
	    

		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`,  `timestamp`,  `pushe_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname',CURRENT_TIMESTAMP,'$pushe_id');");
		
		//$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`,  `timestamp`,  `pushe_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname',CURRENT_TIMESTAMP,'$pushe_id');");
				
		

        
        $sql->query ("SELECT distinct pushe_id FROM `vb_telegrambot`  where chat_id=".$chat_id." and pushe_id<>'' ORDER BY `id` DESC limit 1");
 
    //   $content = array('chat_id' => $chat_id, 'text' => $chat_id." ".$sql->get_num_rows ());
    // $telegram->sendMessage($content);		

        if ($sql->get_num_rows () > 0)
        {
            //$TitleLoginAndroid=getMessage("TitleLoginAndroid");
             $TitleLoginAndroid="دریافت کد ورود به حساب بریم بسکت شما از یک دستگاه جدید";
// دستگاه: Web
// مکان: Iran (IP = 46.209..66)

// اگر این ورود توسط شما نبوده، به صفحه تنظیمات (Settings) وارد شوید، به قسمت حریم خصوصی و امنیت (Privacy and Security) بروید، گزینه ارتباطات فعال (Active Sessions) را بزنید تا همه دستگاه‌های فعال شده در حساب بریم بسکت خود را مشاهده کنید و ارتباط دستگاه مورد نظر را قطع نمایید.

// اگر فکر می‌کنید کسى بدون اجازه وارد حساب شما شده، برای بالابردن امنیت می‌توانید تأیید دومرحله‌ای (Two-Step Verification) را در قسمت حریم خصوصی و امنیت (Privacy and Security) فعال نمایید.

// با احترام،
// تیم مدیریت بریم بسکت";
            
        	while($row = mysqli_fetch_assoc ( $sql->get_result () ))
        	{
         	$pushe_id=$row['pushe_id'];
         	
    //   $content = array('chat_id' => $chat_id, 'text' => $pushe_id);
    // $telegram->sendMessage($content);	 
    
	    	if($pushe_id)
				sendPushe($pushe_id
				,$TitleLoginAndroid
				,$TitleLoginAndroid);
        	}
        }
	

    				
    				
    				
	}
    if ($text == "راهنما") {
		if ($telegram->messageFromGroup()) {
			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
		} 
		else {
		$reply=$help;    
        // Create option for the custom keyboard. Array of array string
        $option = array( array("کد فعالسازی", "راهنما") );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
        }
        
            $msg="لطفا از دکمه ی کیبورد برای ارسال شماره ی تلگرام خود استفاده کنید";
$content = array('chat_id' => $chat_id, 'text' => $msg);
$telegram->sendMessage($content);

$file_id='AgADBAADo6sxG2piYFBMXiAdT_SAyutViRoABHtoZmQNCk_0DYwCAAEC';
    $content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => '
قدم اول
همانند تصویر بالا عمل کنید'];
    $telegram->sendPhoto($content);
    
$file_id='AgADBAADpKsxG2piYFBb9qsxLYr0TW0-IBoABGQ8OPqaF4iiexsFAAEC';
    $content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => '
قدم دوم
همانند تصویر بالا عمل کنید'];
    $telegram->sendPhoto($content);
$file_id='AgADBAADqKsxG2piYFC_YUrLPkNo1ItNJhoABNT_aG8ZQq5HO00EAAEC';
    $content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => '
قدم سوم
همانند تصویر بالا عمل کنید'];
    $telegram->sendPhoto($content);
    
	}
				$message = ' #codebot #start '.$text.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';
			sendMsg($message,"");
//}


//INSERT INTO `vb_telegrambot` (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES (NULL, '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', CURRENT_TIMESTAMP, '', '', '', '', '', '', '', '');




//$response = array ();
//$response [] = getUpd();
//echo json_encode ( $response[0]['result'].update_id );

//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");

function sendMsg($message){
    $telegram = new Telegram($bot_id);
    $chat_id = -1001136444717;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}





function send4digit($sql,$telegram,$chat_username,$chat_id,$phone_number)
{
    
    
    
$soaldarimanonlinambepors="
سوال داری
من آنلاینم
بپرس
👇👇👇👇👇👇👇👇👇👇👇👇
<a href='t.me/aghbaba2'>اینجا کلیک کن</a>";



		$code4digit=rand ( 1000 , 9999 );



$file_id="AgADBAADzKsxG2piYFBKpbkRwk47yNi7JxoABCIxRi059v7Nrk0EAAEC";

    $content = ['chat_id' => $chat_id, 'photo' => $file_id , 'caption' => '
صفحه عضویت
همانند تصویر بالا عمل کنید
سپس از صفحه ورود وارد شوید'];
    $telegram->sendPhoto($content);
    
    
// 	    if($chat_username==null)
// 	    {
// 		    $reply = "کد فعالسازی برای شما ساخته نشد : "
// 		    ." :  لطفا از".
// 		    "بخش تنظیمات تلگرام برای خود یک آی.دی انتخاب کنید
// 👇👇👇👇راهنمای تصویری ویدئویی انتخاب آی دی تلگرام
// t.me/berimbasket/280";
		    
//     		$content = array('chat_id' => $chat_id, 'text' => $reply);
//     		$telegram->sendMessage($content);
//     	}
// 		else
	    {
		    $reply = " نام کاربری شما در برنامه ی بریم بسکت: "
		    .PHP_EOL
		    .$phone_number
		    .PHP_EOL
		    ." کد فعالسازی شما: "
		    .PHP_EOL
		    ."<pre>".$code4digit."</pre>";

		$content = array('chat_id' => $chat_id, 'text' => $reply , 'parse_mode'=> 'html');
		$telegram->sendMessage($content);
		
		$content = array('chat_id' => $chat_id, 'text' => $soaldarimanonlinambepors , 'parse_mode'=> 'html');
		$telegram->sendMessage($content);

        $sql->query ("INSERT INTO `vb_log` (mac, username, password , sender , devicetype , msg , code4digit,chat_id,chat_username) VALUES ('', '$phone_number', '','robot serial login','android','serial','$code4digit','$chat_id','$chat_username')");
        
        
	    }
}


?>