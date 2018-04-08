<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'token.php'; 
include 'Telegram.php';

    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();


$botTokenmj = getToken("mj23");
// Set the bot TOKEN botReserve
$bot_token = getToken("botReserve");
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botReserve';
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
// 
$query_current_info="SELECT * FROM `vb_user` WHERE telegram='$chat_username'";


$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');"; 

if ( (!is_null($text)||!is_null($getUpdateType)) && !is_null($chat_id) && !is_null($chat_username)) {
    
    $sql->query ("SELECT * FROM `vb_user` WHERE telegram='$chat_username'");
    if ($sql->get_num_rows () == 1)
    {
        
    $sql->query ("UPDATE `vb_user` SET chat_id='$chat_id' WHERE telegram='$chat_username'");
    }    
    
    
    
    
    $cmd = substr($text,0,6);
    if ($text == 'بریم بسکت'||$text == '/start'||$cmd=='/start') {
        $reply = 'بریم آقا '.'دکمه های کیبورد یکی رو برای ویرایش پروفایلت انتخاب کن';

        $flagzamin=false;
        if ($cmd=='/start') {
            $r = substr($text,7,strlen($text));
            if($r==$chat_id)
            {
            sendMsg($r.'#خودش #معرفی کرد #خودش را',$botTokenmj);
            $rp='شما توسط خودتون دعوت شدید. خب چرا؟ بفرست برای دوستت عزیزم که هم شما و هم ایشون امتیاز بگیرید';
                
            }
            if($r>0)
            {
                $flagzamin=true;
                $rp='شما در حال رزرو زمین بسکتبال';
                $sqlzamin = new DB ();
                $id=$r;
                $q='select * from `vb_playground` where Id='.$id;
                $sqlzamin -> query($q);
                if ($sqlzamin->get_num_rows () > 0) {
        			//$i = 0;
    			    if ( $row = mysqli_fetch_assoc ( $sqlzamin->get_result () ) )
    			    {
        				 $NameZamin=$row["Name"];
        			    
        			}
                    
                }
                $payamzamin=$rp
                .' بنام '
                .$NameZamin
                .' با لینک '
                .' http://berimbasket.ir/bball/www/editMap.php?id='.$id
                .' هستید'
                .' درخواست رزرو با موفقیت ارسال شد منتظر نتیجه باشید';
                $rp=$payamzamin;
                
                sendMsg(
		        " #reservezamin #reserve"
		        .' '
		        .$rp
		        .' '
		        .' @'
		        .$chat_username,$botTokenmj);
		        
            }
            // else
            // {
            // sendMsg($r.'#دوست #معرفی کرد #دوستش را',$botTokenmj);
            // $rp='شما توسط دوستتون دعوت شدید هم شما هم ایشون امتیاز میگیرید';
            // }
            $content = ['chat_id' => $chat_id, 'text' => $rp];
            $telegram->sendMessage($content);
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', $botname, '', '$text', '$botname','$r');");
    		

        }

		$sql->query ($query_insert_log);
        		
        		
    }
}



function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}


?>