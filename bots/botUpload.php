<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'token.php'; 
include 'Telegram.php';

include 'Pushe.php';

    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$botTokenmj = getToken("mj23");

// Set the bot TOKEN
$bot_token = getToken("botUpload");
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botUpload';
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
//  $VoiceFileID = $telegram->VoiceFileID();
$getUpdateType = $telegram->getUpdateType();
// Test CallBack
$query_current_info="SELECT * FROM `vb_user` WHERE telegram='$chat_username'";

//$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botUpload', '', '$text', '$botname');";

$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', '$text', '$botname');"; 

//  $query_insert_log_file="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', '$text', '$botname', '$file_id');";
//$query_insert_log_file="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', '$text', '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');";
//"INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botUpload', '', '$text', '$botname');"


//Test Inline
//todo هر کسی که میاد و چت آی دی داره و ثبت نام نکرده رو ثبت کنیم که بهش پیام بدیم بگیم برنامه رو نصب کرد هر کس برنامه رو نصب کرد بیاد پروفایل کامل کنه



// Check if the text is a command $chat_username
if ( (!is_null($text)||!is_null($getUpdateType)) && !is_null($chat_id) && !is_null($chat_username)) {
    $cmd = substr($text,0,6);
    if ($text == '/start'||$cmd=='/start') {
        
        /*
        if ($telegram->messageFromGroup()) {
            $reply = 'اینجا گروه؟';
        } else {
            $reply = 'خصوصیه؟';
        }
        */
        
        if ($cmd=='/start') {
            $r = substr($text,7,strlen($text));
            if($r>0)
            {
			
             $z=getInfoPlayground($r);
			 
            sendMsg($r.'#عکس زمینی با آیدی در حال بارگذاری است',$botTokenmj);
            $rp='شما برای زمین با آی دی زیر میخواهید عکس بفرستید؟'
			.' '
			.$r
			.' '
			.$z;
            }
            $content = ['chat_id' => $chat_id, 'text' => $rp];
            $telegram->sendMessage($content);
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', '$r', '$botname','$r');");
        }
      
        
		//$sql->query ($query_insert_log);
        		
        		
    }

    elseif ($text == 'راهنما') {
        $reply = ': https://berimbasket.ir/?p=1';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'همه ی امکانات سایت و اپ اینجا در این روبات معرفی شده: https://t.me/berimbasketrobot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'مدیر روابط عمومی برای پاسخگویی: https://t.me/berimbasket_ir';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    }
    elseif ($text=='/cancel')
    {
    
        //$sql->query ();
            
        $content = ['chat_id' => $chat_id, 'text' => 'کنسل شد'];
        $telegram->sendMessage($content);
    }
    elseif($getUpdateType=='photo')
    {
        $sql->query ("SELECT * FROM `vb_telegrambot` WHERE 1 and chat_id='$chat_id' and chat_type='botUpload' order by id DESC LIMIT 1");
        
        //and text = 'سن' 
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        // if count > 1 todo
        
        $t=$row ["text"];        
            $content = ['chat_id' => $chat_id, 'text' => $t];
        $telegram->sendMessage($content);

        if($t >0 )
        {
            //$sql->query ($query_insert_log);
            //$wval=($text);
            //$q="UPDATE `vb_user` SET nameunicode='$wval' WHERE telegram='$chat_username'";
            //$sql->query ($q); 
            //$msg="مقدارش تغییر کرد".$q;
            //$msg="مقدار تغییر کرد";
            //$content = ['chat_id' => $chat_id, 'text' => $msg];
            //$telegram->sendMessage($content);
						
			if($getUpdateType=='photo')
			{
				$chat_ch_id=222909344;  
				
				$msg=$getUpdateType.'';
				$content = ['chat_id' => $chat_ch_id, 'text' => $msg];
				$telegram->sendMessage($content);
				 
				 
				// getVoiceFileDURATION getVoiceFileMIMETYPE getFileSIZE
				$file_id0=$telegram->getFileID2();
				//$file_id=$d['message']['voice']['file_id'];
				$file_id=$file_id0.'';
				$content = ['chat_id' => $chat_ch_id, 'text' => $file_id];
				$telegram->sendMessage($content);
				
				$file_size0=$telegram->getFileSIZE();
				//$file_id=$d['message']['voice']['file_id'];
				$file_size=$file_size0;
				$content = ['chat_id' => $chat_ch_id, 'text' => $file_size];
				$telegram->sendMessage($content);
				
					$message = 'ارسال فایل عکس زمین برای آپلود'
				.' #photo #uploadbot'.' : '.(string)$chat_id
				.' نام '
				.(string)$chat_firstname
				.' فامیل '
				.(string)$chat_lastname
				.' @'.(string)$chat_username
				.' '
				.$instagramLink.'  '.$text.'  ';
				sendMsg($message." #photo#".'https://berimbasket.ir/bball/bots/playgroundphoto/'.$UpdateID.'.png',$botTokenmj);
				//'$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type
				$width=123;
				$height=123;
				$duration=0;
				$mime_type='';
				$file_type='photo';
				$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', $t, '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');");

				$content = ['chat_id' => $chat_ch_id, 'photo' => $file_id , 'caption' => 'http://berimbasket.ir/bball/www/approvephoto.php?file_id='.$file_id.'&chat_id='.$chat_id];
				$telegram->sendPhoto($content);
				
				
				$file=$telegram->getFile($file_id);
				// $content = ['chat_id' => $chat_id, 'text' => $file.''];
				// $telegram->sendMessage($content);
				
				
				//$file = $telegram->getFile($file_id);
			//$telegram->downloadFile($file['result']['file_path'], './playgroundphoto/'.$t.$chat_id.'.png');
			$telegram->downloadFile($file['result']['file_path'], './playgroundphoto/'.$UpdateID.'.png');

				$msg='عکس زمین شما در اپ بریم بسکت اضافه شد'
				.' روی این لینک کلیک کنید '
				.PHP_EOL
				.'https://berimbasket.ir/bball/bots/playgroundphoto/'.$UpdateID.'.png'
				.' ';
				$content = ['chat_id' => $chat_id, 'text' => $msg];
				$telegram->sendMessage($content);

				$msg='صفحه ی زمین رو ببین و برای دوستات بفرست'
				.PHP_EOL
				.'https://berimbasket.ir/bball/www/instagram.php?id='.$t;
				
				$content = ['chat_id' => $chat_id, 'text' => $msg];
				$telegram->sendMessage($content);
				
				
				$msg='برای آپلود یک عکس دیگه اینجا کلیک کن'
				.PHP_EOL
				.'https://t.me/berimbasketuploadbot?start='.$t;
				
				$content = ['chat_id' => $chat_id, 'text' => $msg];
				$telegram->sendMessage($content);
				
				//http://berimbasket.ir/bball/www/instagram.php?id=4
			
 		$pushe_id='pid_b133-20a9-33';
 		//$pushe_id='pid_9f8d-e5ee-32';
 		
 		
//         $ch_id = 222909344;
  	$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botUpload', '', '$t', '$botname');");      
        
// // 			    //$sqll = new DB ();
//     $sql->query ( "SELECT * FROM `vb_user`  WHERE  pushe_id <>'' and"
//     //chat_id >0"
//  ."chat_id LIKE '%"
//     .$chat_id
//     ."%' ORDER BY id desc limit 1" );
    
    
    
//     $integercount=$sql->get_num_rows ();
//         $content = array('chat_id' => $ch_id, 'text' => $integercount);
//         $telegram->sendMessage($content);
        
        
        
//     if ($sql->get_num_rows () > 0) {
//         $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
//         $message=$row ["pushe_id"];
//         $content = array('chat_id' => $ch_id, 'text' => $message);
//         $telegram->sendMessage($content);
    
//     	//$row = mysqli_fetch_assoc ( $sqll->get_result () ); 
//     	$pushe_id= $row ["pushe_id"];
//     }
// 	else{
// 	 $content = array('chat_id' => $ch_id, 'text' => '0 row');
//         $telegram->sendMessage($content);
// 	}
				$msg='عکس زمین شما در اپ بریم بسکت اضافه شد'
				.' روی این لینک کلیک کنید ';
                //$pushe_id = getPusheId($chat_id);
                
                //$msg="جی پی اس دستگاه شما روشن نیست یا تنظیمات در حالت دقیق ست نشده است";
                //if($pushe_id!='')
                Send($pushe_id
                ,$msg
                ,$msg);
				
			}
        }

            
    }


}

else
{
    //msg
    
            $msg="شما باید برای تلگرام خودتون نام کاربری انتخاب کنید   "." اگر تابحال در بریم بسکت ثبت نام نکرده اید از روبات زیر برای ثبت نام استفاده کنید و پس از نصب اپ اندروید و عضویت برای تکمیل آپلود بسکتبالی خود بازگردید";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
    
            $msg="https://t.me/berimbasketbot?start=botupload";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
                    
            $msg="اگر نمیدانید چطور برای تلگرام خودتان آی.دی برگزینید روی لینک زیر کلیک کنید   https://t.me/berimbasket/280";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);            
            
            $message = 'ثبت نام نشده  #unregistered #uploadbot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$text.'  ';
            sendMsg($message." unregistered",$botTokenmj);
            
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'new', '', $t, '$botname','unregistered');");
                		
                		
}


function getInfoPlayground($a){
    
    return 'l';
}

function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}



// function getPusheId($chat_id)
// {
//     $sqll = new DB ();
//     $sqll->query ( "SELECT * FROM `vb_user` where pushe_id <>'' and chat_id =$chat_id ORDER BY id desc limit 1" );
//     if ($sqll->get_num_rows () > 0) {
        
//     $message=$row ["pushe_id"];
//     $ch_id = '-1001136444717';
//     $content = array('chat_id' => $ch_id, 'text' => $message);
//     $telegram->sendMessage($content);

// 	$row = mysqli_fetch_assoc ( $sqll->get_result () ); 
// 	return $row ["pushe_id"];
//     }
//     else
//     return '';
// }


?>