<?php

include 'token.php'; 
include 'Telegram.php';

    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$botTokenmj = getToken("mj23");
// Set the bot TOKEN
$bot_token = getToken('botRegister');
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botRegister';


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
// 



if (!is_null($text) && !is_null($chat_id) && !is_null($chat_username)) 
{
    $cmd = substr($text,0,6);
    if ($text == 'بریم بسکت'||$text == '/start'||$cmd=='/start')
    {
        $reply = 'بریم  '.'دکمه های کیبورد برای ثبت نام و انتخاب نام کاربری و رمز عبور خودت استفاده کن';
        
        if ($cmd=='/start') 
        {
            $r = substr($text,7,strlen($text)-7);
            if($r==$chat_id)
            {
            sendMsg($r.'#خودش #معرفی کرد #خودش را',$botTokenmj);
            $rp='شما توسط خودتون دعوت شدید. خب چرا؟ بفرست برای دوستت عزیزم که هم شما و هم ایشون امتیاز بگیرید';
                
            }
            else
            {
            sendMsg($r.'#دوست #معرفی کرد #دوستش را',$botTokenmj);
            $rp='شما توسط دوستتون دعوت شدید هم شما هم ایشون امتیاز میگیرید';
            }
            $content = ['chat_id' => $chat_id, 'text' => $rp];
            $telegram->sendMessage($content);
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname','$r');");
        }
        
        
                
        // Create option for the custom keyboard. Array of array string
        $option = [
        ['بریم بسکت'
        , 'نام نمایشی در اپ']
        , ['/username']
        , ['ما رو به دوستت معرفی کن و لینک به اشتراک بزار و امتیاز بگیر']
        //, [''
        //, '']
        ];
        // Get the keyboard
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
        $telegram->sendMessage($content);
        
        
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');");
		
		
		
    }
    
    //
    elseif($text == 'ما رو به دوستت معرفی کن و لینک به اشتراک بزار و امتیاز بگیر')
    {
        $reply='https://t.me/berimbasketregisterbot?start='.$chat_id;
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);        
        
        sendMsg('یکی لینک معرفی به دوستش رو از روبات #پروفایل گرفت'.' @'.$chat_username,$botTokenmj);
        
                
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');");
		
    }
    elseif ($text == '/username') {    
        
        //sendMsg('شخصی 
        //username خودش را درخواست داد'.' @'.$chat_username,$botTokenmj);
        
        
		//$sql->query ("SELECT * FROM vb_user where active = 1 order by height desc");
		
		
        $sql->query ("SELECT * FROM `vb_user` WHERE telegram='$chat_username'");
        if ($sql->get_num_rows () > 0)
        {
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ['username'];
        
        
        $rp=': نام کاربری شما'.' @'.$chat_username.' x='.$x;
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
        
        
        $rp='میتونید اگر خواستید رمز تون رو عوض کنید';
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
        
        
        // if yes approved then insert status then exit
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');");
        }
        else
        {
        $rp='شما نام کاربری ثبت شده در سیستم ما ندارید'.': نام کاربری شما'.' @'.$chat_username.' x='.$x;
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
        

        $rp='نام کاربری خود را در یک خط جداگانه و رمز عبور انتخابی خود را جداگانه در خط بعدی وارد کنید تا نام کاربری تان ساخته شود';
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
        
        // if yes approved then insert status then exit
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');");
            
        }
    }
    elseif($text !='\cancel')
    {
        $sql->query ("SELECT * FROM `vb_telegrambot` WHERE 1 and chat_id='$chat_id' and chat_type='botRegister' order by id DESC LIMIT 1");
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;

        $t=$row ["text"];        
            $content = ['chat_id' => $chat_id, 'text' => $t];
        $telegram->sendMessage($content);

        if($t == '/username' )
        {
            $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text', '$botname');");
            
             $sql->query ("INSERT INTO `vb_user` (username, password) VALUES ('".$username."', '".$password."');");
             
             
            $wval=($text);
            $q="UPDATE `vb_user` SET nameunicode='$wval' WHERE telegram='$chat_username'";
            $sql->query ($q); 
            //$msg="مقدارش تغییر کرد".$q;
            $msg="مقدار تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
            sendLog2Channel("username signup #robot #notexist: ".$username);

            $sql->query ("INSERT INTO `vb_log` (mac, username, password , sender , devicetype , msg) VALUES ('$mac', '$username', '$password','setPasswordForThisUsername','android','notexist')");
          
          
        }
        elseif($t == 'نام خانوادگی' )
        {
            $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botProfile', '', '$text', '$botname');");
            $wval=($text);
            $q="UPDATE `vb_user` SET familynamefa='$wval' WHERE telegram='$chat_username'";
            $sql->query ($q); 
            //$msg="مقدارش تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
    
    }
}



function sendMsg($message,$bot_id){ 
    $m='#botRegister '.$message;
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $m);
    $telegram->sendMessage($content);
}




?>