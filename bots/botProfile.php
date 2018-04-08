<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'token.php'; 
include 'Telegram.php';
//include 'xmlapi.php';

    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$chat_id_admin=222909344;


$botTokenmj = getToken("mj23");
// Set the bot TOKEN
$bot_token = getToken('botprofile');
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botprofile';
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
$query_current_info="SELECT * FROM `vb_user` WHERE chat_id='$chat_id'";
$query_current_infobyusername="SELECT * FROM `vb_user` WHERE username='$usern'";
$query_chat_username_by_FromChatID="SELECT * FROM `vb_telegrambot` WHERE chat_id='$FromID' and chat_username<>'' limit 1";
$query_chat_username_by_id="SELECT * FROM `vb_telegrambot` WHERE chat_id='$IDD' and chat_username<>'' limit 1";
//$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botProfile', '', '$text', '$botname');";

$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname');"; 

//  $query_insert_log_file="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname', '$file_id');";
//$query_insert_log_file="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');";
//"INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botProfile', '', '$text', '$botname');"


//Test Inline
//todo هر کسی که میاد و چت آی دی داره و ثبت نام نکرده رو ثبت کنیم که بهش پیام بدیم بگیم برنامه رو نصب کرد هر کس برنامه رو نصب کرد بیاد پروفایل کامل کنه
$flagUsernameNull=0;
//مقدارش
$ValueChanged='مقدارش تغییر کرد';
$ValueChanged=' ذخیره شد';
$AreYouChangeYouUsername="شما نام کاربری تون در تلگرام رو تغییر دادید؟";
$newone="جدید";
$lastone="قدیم";
$PleaseSpecifyUseename="لطفا یک نام کاربری تایپ کنید";
// Check if the text is a command $chat_username
if ( (!is_null($text)||!is_null($getUpdateType)) && !is_null($chat_id) 
//&& !is_null($chat_username)
) {

    $sql->query ("SELECT * FROM `vb_user` WHERE chat_id='$chat_id'");
    if ($sql->get_num_rows () == 1)
    {

    
    // $sql->query ("UPDATE `vb_user` SET telegram='$chat_username' WHERE chat_id='$chat_id'");
    if ( $row = mysqli_fetch_assoc ( $sql->get_result () ) )
        $telegram_username=$row['telegram'];
        if($telegram_username!=$chat_username)
            {
            $content = ['chat_id' => $chat_id, 'text' => $AreYouChangeYouUsername." ".$chat_username." : ".$newone."
            ".$telegram_username." : ".$lastone];
            $telegram->sendMessage($content);
            
            }
    }
    if ($sql->get_num_rows () == 0)
    {
        if($chat_username)
        {

        //unique
        $code4digit=rand ( 1000 , 9999 );
        $sql->query ("INSERT INTO `vb_user` (`chat_id`,`username`,`password`,`code`,`timestamp`) VALUES ( '$chat_id' ,'$chat_username' ,'$code4digit' ,'$code4digit',CURRENT_TIMESTAMP);");
        
        $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`,`timestamp`) VALUES ('', '', '', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '', '', '$text',CURRENT_TIMESTAMP);");
        $sql->query ("INSERT INTO `vb_log` (mac, username, password , sender , devicetype , msg , code4digit,chat_id) VALUES ('', '$chat_username', '','robot profile login','android','serial','$code4digit','$chat_id')");
        }
        else
        {
           
   
   
   
             $sql->query ("SELECT * FROM `vb_telegrambot` WHERE 1 and chat_id=".$chat_id." and chat_type='botProfile' order by id DESC LIMIT 1");
            // timestamp >= NOW() - INTERVAL 2 DAY 
            if ($sql->get_num_rows () >0)
            {
            $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
            
            $t=$row ["chat_username"];      
            
            if($t)
            {
              
            $content = ['chat_id' => $chat_id, 'text' => $t];
            $telegram->sendMessage($content);  
            }
            else
            {
            $flagUsernameNull=1;
            $content = ['chat_id' => $chat_id, 'text' => $PleaseSpecifyUseename.$t];
            $telegram->sendMessage($content);
            }
            //if 2 select from log usernam
            
            //if 1 get and insert to log
        $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`,`timestamp`) VALUES ('', '', '', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$text', '', '', '$text',CURRENT_TIMESTAMP);");
            
    
            }
        }
    }
    // $sql->query ("SELECT * FROM `vb_user` WHERE chat_id='$chat_id'");
    // if ($sql->get_num_rows () == 1)
    // {
        
    // $sql->query ("UPDATE `vb_user` SET chat_id='$chat_id' WHERE chat_id='$chat_id'");
    // }    
    
    
if($flagUsernameNull==0)
{
    $cmd = substr($text,0,6);
    if ($text == 'بریم بسکت'||$text == '/start'||$cmd=='/start') {
        $reply = 'بریم آقا '.'دکمه های کیبورد یکی رو برای ویرایش پروفایلت انتخاب کن';
        /*
        if ($telegram->messageFromGroup()) {
            $reply = 'اینجا گروه؟';
        } else {
            $reply = 'خصوصیه؟';
        }
        */
        $flagzamin=false;
        $PusheId="";
        if ($cmd=='/start') {
            $r = substr($text,7,strlen($text));
            if($r==$chat_id)
            {
            sendMsg($r.'#خودش #معرفی کرد #خودش را',$botTokenmj);
            $rp='شما توسط خودتون دعوت شدید. خب چرا؟ بفرست برای دوستت عزیزم که هم شما و هم ایشون امتیاز بگیرید';
                
            }
            if($r<0)
            {
                $flagzamin=true;
                $rp='شما در حال ویرایش زمین بسکتبال ';
                $sqlzamin = new DB ();
                $id=-1*$r;
                $q='select * from `vb_playground` where Id='.$id;
                $sqlzamin -> query($q);
                if ($sqlzamin->get_num_rows () > 0) {
        			//$i = 0;
    			    if ( $row = mysqli_fetch_assoc ( $sqlzamin->get_result () ) )
    			    {
        				 $NameZamin=$row["Name"];
        				 $PgTlgrmGroupAdmin=$row["PgTlgrmGroupAdminId"];
        				 $PusheId=$row["pushe_id"];
        			    
        			}
                    
                }
                $payamzamin=$rp
                .' بنام '
                .$NameZamin
                .' با لینک 
'
                .' http://t.me/berimbasketmapbot?start='.$id
                .PHP_EOL
                .' http://berimbasket.ir/bball/www/editMap.php?id='.$id
                .'
هستید'
                .PHP_EOL
                ."لطفا قبل از هر گونه تغییرات یا گزارش با ادمین اپ یا ثبت کننده تماس بگیرید"
                .PHP_EOL.$PgTlgrmGroupAdmin
                .PHP_EOL." @berimbasket_ir";
                
                
                
                $rp=$payamzamin;
            }
            else
            {
            sendMsg($r.'#دوست #معرفی کرد #دوستش را',$botTokenmj);
            $rp='شما توسط دوستتون دعوت شدید هم شما هم ایشون امتیاز میگیرید';
            }
            $content = ['chat_id' => $chat_id, 'text' => $rp];
            $telegram->sendMessage($content);
            
            if($chat_id==$chat_id_admin)
            {
            $content = ['chat_id' => $chat_id, 'text' => $PusheId];
            $telegram->sendMessage($content);
            }
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname','$r');");
        }
        if($flagzamin==false)
        $reply = 'بریم آقا '.'دکمه های کیبورد یکی رو برای ویرایش پروفایلت انتخاب کن';
        else
        $reply = ' خب ممنون از ویرایش زمین اگر خواستی میتونی پروفایل خودت رو هم کامل تر کنی';
        mainkeyboard($bot_token,$chat_id,$reply);
      
        
		$sql->query ($query_insert_log);
        		
        		
    }

    //
    elseif($text == 'ما رو به دوستت معرفی کن و لینک به اشتراک بزار و امتیاز بگیر')
    {
        $reply='https://t.me/berimbasketprofilebot?start='.$chat_id;
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);        
        
        sendMsg('یکی لینک معرفی به دوستش رو از روبات #پروفایل گرفت'.' @'.$chat_username,$botTokenmj);
        
                
		$sql->query ($query_current_info);
		
    }
    elseif ($text == 'پروفایل شما') {    
        
        sendMsg('شخصی 
        پروفایل خودش را درخواست داد'.' @'.$chat_username,$botTokenmj);
        
        
		//$sql->query ("SELECT * FROM vb_user where active = 1 order by height desc");
		
		
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        
        $rp=getProfile($row,$chat_username);
        
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
    }
   
            
    elseif ($text == 'نام خانوادگی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["familynamefa"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }   
    elseif ($text == 'نام') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["firstnamefa"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'شهر') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["city"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'جنسیت') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["sex"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
          
        //($x==0?'خانم':'مرد')
          
        $reply = $text.' شما در سیستم '
        .'('
        .($x==0?'خانم':'آقا')
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);


        $sql->query ("SELECT buttons FROM `vb_bot_commands` where bot='profile' and command ='sex'");
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $key_str =$row ["buttons"];
        $option []=explode(',',$key_str);
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'انتخاب جنسیت'];
        //$content = ['chat_id' => $chat_id, 'text' => $option];

        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'استان') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["provincefa"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'توابع') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["urbanfa"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'ارسال عکس پروفایل') {
    
        $reply = $text.'  لطفا عکس خود را برای این روبات بفرستید  ';
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'نام مربی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["coach"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'نام تیم سالنی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["teamname"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'نام تیم 3به3') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["teamname3x3"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'پست تخصصی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["post"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'پست غیر تخصصی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["postnonprof"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'نام پدر') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["fathersnamefa"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'سابقه غیر حرفه ای در بسکتبال') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["experience"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'سابقه حرفه ای رسمی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["experienceofficial"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'نام نمایشی در اپ') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["nameunicode"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
    elseif ($text == 'ایمیل') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["email"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'آدرس پستی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["address"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 

    elseif ($text == 'کدپستی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["postalcode"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'کدملی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["nationalcode"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
        
    elseif ($text == 'موبایل تلگرام') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["telegramcellphone"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'موبایل تماس تلفنی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["cellphone"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'تلفن ثابت') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["homephone"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = $text.' شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه متنی را وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
        
        
    elseif ($text == 'سن') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["age"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'سن شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
        
        
    elseif ($text == 'سال تولد') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["birthdayyear"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = "لطفا اعداد #کیبورد #انگلیسی ";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
          
        $reply = 'سال تولد شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
        
        
    elseif ($text == 'ماه تولد') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["birthdaymonth"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
          
        $reply = "لطفا اعداد #کیبورد #انگلیسی ";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $reply = 'ماه تولد شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
        
        
    elseif ($text == 'روز تولد') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["birthdayday"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = "لطفا اعداد #کیبورد #انگلیسی ";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
          
        $reply = 'روز تولد شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
            
        
    elseif ($text == 'شماره لباس در بازی سالنی') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["jerseyNoB"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = "لطفا اعداد #کیبورد #انگلیسی ";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
          
        $reply = 'شماره ی لباس در بازی سالنی شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'شماره لباس در بازی استریت') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["jerseyNo3"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = "لطفا اعداد #کیبورد #انگلیسی ";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
          
        $reply = 'شماره ی لباس در بازی استریت شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید    ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
        
    elseif ($text == 'قد') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["height"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'قد شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
    
    elseif ($text == 'وزن') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["weight"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'وزن شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه عددی وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
    
    elseif ($text == 'TelegramID') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["telegram"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'تلگرام آی دی شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);

    } 
    
    elseif ($text == 'InstagramID') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["instagram"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'اینستاگرام آی دی شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
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
    
        $sql->query ();
            
        $content = ['chat_id' => $chat_id, 'text' => 'کنسل شد'];
        $telegram->sendMessage($content);
    }
    elseif($text !='/cancel')
    {
        $sql->query ("SELECT * FROM `vb_telegrambot` WHERE 1 and chat_id='$chat_id' and chat_type='botProfile' order by id DESC LIMIT 1");
        
        //and text = 'سن' 
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        // if count > 1 todo
        
        $t=$row ["text"];        
            $content = ['chat_id' => $chat_id, 'text' => $t];
        $telegram->sendMessage($content);

        if($t == 'نام نمایشی در اپ' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET nameunicode='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg=$ValueChanged.$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'نام خانوادگی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET familynamefa='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg=$ValueChanged.$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'نام' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET firstnamefa='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'جنسیت' )
        {
            $sql->query ($query_insert_log);
            $wval=0;
            if($text=='آقا')
            $wval=1;
            $q="UPDATE `vb_user` SET sex='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
            
                    mainkeyboard($bot_token,$chat_id,'بریم بسکت');

        //     $option = [['بریم بسکت'
        // , 'نام نمایشی در اپ']
        // , ['پروفایل شما','وزن'
        // , 'قد']
        // , ['نام پدر'
        // ,'نام', 'نام خانوادگی']
        // , ['جنسیت']
        // , ['استان'
        // ,'توابع', 'شهر']
        // , ['نام مربی'
        // , 'سابقه حرفه ای رسمی']
        // , ['شماره لباس در بازی سالنی'
        // , 'شماره لباس در بازی استریت']
        // , ['سابقه غیر حرفه ای در بسکتبال'
        // , 'نام تیم سالنی']
        // , ['نام تیم 3به3'
        // //jerseyNoB
        // , 'پست تخصصی']
        // , ['پست غیر تخصصی'
        // , 'ایمیل']
        // , [ 'سن','روز تولد'
        // ,'ماه تولد', 'سال تولد']
        // , [ 'کدملی'
        // ,'کدپستی', 'آدرس پستی']
        // , [ 'موبایل تلگرام'
        // ,'موبایل تماس تلفنی','تلفن ثابت', 'راهنما']
        // , ['ما رو به دوستت معرفی کن و لینک به اشتراک بزار و امتیاز بگیر']
        // //, [''
        // //, '']
        // //nameunicode
        // //, ['آپارات'
        // //, 'فیلم آموزشی']
        // //, ['روبات ها'
        // //, 'صفحه ی زمین بسکت']
        // //, ['توییتر من و شما'
        // //, 'اینستاگرام']
        // //, ['کانال تلگرام'
        // //, 'فیس بوک']
        // //, ['اضافه کردن زمین بسکتبال'
        // //, 'دانلود اپ اندروید']
        // //, ['عضویت در سایت'
        // //, 'تکمیل پروفایل']
        // //, ['پشتیبانی'
        // //, 'درباره ما']
        // ];
        // // Get the keyboard
        // $keyb = $telegram->buildKeyBoard($option);
        // $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'بریم بسکت'];
        // $telegram->sendMessage($content);
        }        
        elseif($t == 'شهر' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET city='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'استان' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET provincefa='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'توابع' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET urbanfa='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'آپلود عکس پروفایل' )
        {
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'نام مربی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET coach='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'نام تیم سالنی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET teamname='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'نام تیم 3به3' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET teamname3x3='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'نام پدر' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET fathersnamefa='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'پست تخصصی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET post='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'پست غیر تخصصی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET postnonprof='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'سابقه حرفه ای رسمی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET experienceofficial='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'سابقه غیر حرفه ای در بسکتبال' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET experience='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'ایمیل' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET email='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'آدرس پستی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET address='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'کدپستی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET postalcode='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'کدملی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET nationalcode='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'موبایل تلگرام' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET telegramcellphone='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'موبایل تماس تلفنی' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET cellphone='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'تلفن ثابت' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET homephone='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'سن' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET age=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'سال تولد' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET birthdayyear=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'ماه تولد' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET birthdaymonth=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'روز تولد' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET birthdayday=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'شماره لباس در بازی سالنی' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET jerseyNoB=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'شماره لباس در بازی استریت' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET jerseyNo3=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }        
        elseif($t == 'قد' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET height=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'وزن' )
        {
            $sql->query ($query_insert_log);
            $wval=intval($text);
            $q="UPDATE `vb_user` SET weight=$wval WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            

        }
        elseif($t == 'TelegramID' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET telegram='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
		
// $ip = "127.0.0.1";                // should be server IP address or 127.0.0.1 if local server
// $account = "";            // cPanel user account name
// $passwd ="";            // cPanel user password
// $port =2083;                    // cpanel secure authentication port
// $email_domain = 'berimbasket.ir';   // email domain (usually same as cPanel domain)
// $email_quota = 1;                // default amount of space in megabytes  

// $xmlapi = new xmlapi($ip);

// //set port number. cpanel client class allow you to access WHM as well using WHM port.
// $xmlapi->set_port($port);                        

// // authorization with password. Not as secure as hash.
// $xmlapi->password_auth($account, $passwd);   

// // cpanel email addpop function Parameters


// $sql->query ($query_current_info);
// $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
// $username=$row ["username"];
// $code=$row ["code"];


// $email_user=$wval;
// $email_pass=$username.$code;
// $call = array(domain=>$email_domain, email=>$email_user,password=>$email_pass, quota=>$email_quota);

// $dest_email="saber.tabataba.ee@gmail.com";
// // cpanel email fwdopt function Parameters
// $call_f  = array(domain=>$email_domain, email=>$email_user,
// fwdopt=>"fwd", fwdemail=>$dest_email);

// //output to error file  set to 1 to see
// // $xmlapi->set_debug(0);      
// // error_log.

// // making call to cpanel api
// $result = $xmlapi->api2_query($account, "Email", "addpop", 
// $call);

// //create a forward
// $result_forward = $xmlapi->api2_query($account, "Email", "addforward",
// $call_f);  

        }
        elseif($t == 'InstagramID' )
        {
            $sql->query ($query_insert_log);
            $wval=($text);
            $q="UPDATE `vb_user` SET instagram='$wval' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg=$ValueChanged;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            

        }
    
        elseif ($t=0||$t='0'){
            $msg="دستوری وارد نشده است  ";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
        $telegram->sendMessage($content);
        }
        if(!($t=0||$t='0'))
        {
            $message = ' #profilebot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$text.'  ';
            sendMsg($message,$botTokenmj);
        }
            
    }


}
}
else
{
    //msg
    
            // $msg="شما باید برای تلگرام خودتون نام کاربری انتخاب کنید   "." اگر تابحال در بریم بسکت ثبت نام نکرده اید از روبات زیر برای ثبت نام استفاده کنید و پس از نصب اپ اندروید و عضویت برای تکمیل پروفایل بسکتبالی خود بازگردید";
            // $content = ['chat_id' => $chat_id, 'text' => $msg];
            // $telegram->sendMessage($content);
    
            // $msg="https://t.me/berimbasketbot?start=botprofile";
            // $content = ['chat_id' => $chat_id, 'text' => $msg];
            // $telegram->sendMessage($content);
                    
            // $msg="اگر نمیدانید چطور برای تلگرام خودتان آی.دی برگزینید روی لینک زیر کلیک کنید   https://t.me/berimbasket/280";
            // $content = ['chat_id' => $chat_id, 'text' => $msg];
            // $telegram->sendMessage($content);            
            
            // $message = 'ثبت نام نشده  #unregistered #profilebot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$text.'  ';
            // sendMsg($message." unregistered",$botTokenmj);
            
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'new', '', '$text', '$botname','unregistered');");
                		
                		
}


//  if($VoiceFileID){
        

//         try {
//             $msg=$VoiceFileID.'';
//             $content = ['chat_id' => $chat_id, 'text' => $msg];
//             $telegram->sendMessage($content);
//         }
//  }
if($getUpdateType=='voice')
{
    $msg=$getUpdateType.'';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    // getVoiceFileDURATION getVoiceFileMIMETYPE getVoiceFileSIZE
    $getVoice=$telegram->getFileID2();
    //$file_id=$d['message']['voice']['file_id'];
    $msg=$getVoice.'';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    $getVoice=$telegram->getVoiceFileDURATION();
    //$file_id=$d['message']['voice']['file_id'];
    $msg=$getVoice.'';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    $getVoice=$telegram->getVoiceFileMIMETYPE();
    //$file_id=$d['message']['voice']['file_id'];
    $msg=$getVoice.'';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    $getVoice=$telegram->getFileSIZE();
    //$file_id=$d['message']['voice']['file_id'];
    $msg=$getVoice.'';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    
    $message = 'ارسال فایل صوتی برای روبات پروفایل'
    .' #voice #profilebot #'.' : '.(string)$chat_id
    .' نام '
    .(string)$chat_firstname
    .' فامیل '
    .(string)$chat_lastname
    .' @'.(string)$chat_username
    .' '
    .$instagramLink.'  '.$text.'  ';
    sendMsg($message." #voice#",$botTokenmj);
    
    //$sql->query ($query_insert_log_file);
    
}
if($getUpdateType=='photo')
{
    $chat_ch_id=222909344;  
    
    $msg=$getUpdateType.'';
    $content = ['chat_id' => $chat_ch_id, 'text' => $msg];
    $telegram->sendMessage($content);
     
     
    // getVoiceFileDURATION getVoiceFileMIMETYPE getFileSIZE
    $file_id0=$telegram->getFileID();
    //$file_id=$d['message']['voice']['file_id'];
    $file_id=$file_id0.'';
    $content = ['chat_id' => $chat_ch_id, 'text' => $file_id];
    $telegram->sendMessage($content);
    
    $file_size0=$telegram->getFileSIZE();
    //$file_id=$d['message']['voice']['file_id'];
    $file_size=$file_size0.' @'.$chat_username;
    $content = ['chat_id' => $chat_ch_id, 'text' => $file_size];
    $telegram->sendMessage($content);
    
        $message = 'ارسال فایل عکس برای روبات پروفایل'
    .' #photo #profilebot'.' : '.(string)$chat_id
    .' نام '
    .(string)$chat_firstname
    .' فامیل '
    .(string)$chat_lastname
    .' @'.(string)$chat_username
    .' '
    .$instagramLink.'  '.$text.'  ';
    sendMsg($message." #photo#".'https://berimbasket.ir/bball/bots/dl/'.$chat_id.'.png'.' '.$file_size,$botTokenmj);
    //'$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type
    $width=123;
    $height=123;
    $duration=0;
    $mime_type='';
    $file_type='photo';
    $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');");

    $content = ['chat_id' => $chat_ch_id, 'photo' => $file_id , 'caption' => 'http://berimbasket.ir/bball/www/approvephoto.php?file_id='.$file_id.'&chat_id='.$chat_id];
    $telegram->sendPhoto($content);
    
    
    $file=$telegram->getFile($file_id);
    // $content = ['chat_id' => $chat_id, 'text' => $file.''];
    // $telegram->sendMessage($content);
    
    
    //$file = $telegram->getFile($file_id);
$telegram->downloadFile($file['result']['file_path'], './dl/'.$chat_id.'.png');

    $msg='عکس پروفایل شما در اپ بریم بسکت تغییر کرد'
    .' روی این لینک کلیک کنید '
    .'https://berimbasket.ir/bball/bots/dl/'.$chat_id.'.png'
    .' ';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
}


    // $content = ['chat_id' => $chat_id, 'text' => $chat_id];
    // $telegram->sendMessage($content);
    
    
    // $content = ['chat_id' => $chat_id, 'text' => $FromID];
    // $telegram->sendMessage($content);
    
    
 if (($FromID!=null&&$chat_id=='222909344')|| (substr($text,0,3)=='sss'&&$chat_id=='222909344')) {    
        //substr($text,0,3) =='/s='
        //$FromChatID
        if(substr($text,0,3)=='sss'){
        if(substr($text,3,15)!=null){
            
    $content = ['chat_id' => $chat_id, 'text' => substr($text,3,15)];
    $telegram->sendMessage($content);
    
        $IDD=substr($text,3,15);
        $sql->query ($query_chat_username_by_id);
        }
        }
        else
        {
        sendMsg('صابر 
        پروفایل شخص دیگری غیر از خودش را درخواست داد'.' http://t.me/berimbasketprofilebot?sss='.$FromID,$botTokenmj);
        
        
		//$sql->query ("SELECT * FROM vb_user where active = 1 order by height desc");
        $sql->query ($query_chat_username_by_FromChatID);
        }
		$row = mysqli_fetch_assoc ( $sql->get_result () ) ;
		$usern=$row['chat_username'];
        $sql->query ($query_current_infobyusername);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        
        $rp=getProfile($row,$chat_username);
        
        $content = ['chat_id' => $chat_id, 'text' => $rp];
        $telegram->sendMessage($content);
    }
    
function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}


function mainkeyboard($bot_id,$chat_iD,$replY){

        // Create option for the custom keyboard. Array of array string
        $option = [['بریم بسکت'
        , 'نام نمایشی در اپ']
        , ['پروفایل شما','وزن'
        , 'قد']
        , ['نام پدر'
        ,'نام', 'نام خانوادگی']
        , ['جنسیت'
        ,'ارسال عکس پروفایل'
        ]
        , ['استان'
        ,'توابع', 'شهر']
        , ['نام مربی'
        , 'سابقه حرفه ای رسمی']
        , ['شماره لباس در بازی سالنی'
        , 'شماره لباس در بازی استریت']
        , ['سابقه غیر حرفه ای در بسکتبال'
        , 'نام تیم سالنی']
        , ['نام تیم 3به3'
        //jerseyNoB
        , 'پست تخصصی']
        , ['پست غیر تخصصی'
        , 'ایمیل']
        , [ 'سن','روز تولد'
        ,'ماه تولد', 'سال تولد']
        , [ 'کدملی'
        ,'کدپستی', 'آدرس پستی']
        , [ 'موبایل تلگرام'
        ,'موبایل تماس تلفنی','تلفن ثابت', 'راهنما']
        , ['TelegramID'
        , 'InstagramID']
        , ['ما رو به دوستت معرفی کن و لینک به اشتراک بزار و امتیاز بگیر']
        //, [''
        //, '']
        //nameunicode
        //, ['آپارات'
        //, 'فیلم آموزشی']
        //, ['روبات ها'
        //, 'صفحه ی زمین بسکت']
        //, ['توییتر من و شما'
        //, 'اینستاگرام']
        //, ['کانال تلگرام'
        //, 'فیس بوک']
        //, ['اضافه کردن زمین بسکتبال'
        //, 'دانلود اپ اندروید']
        //, ['عضویت در سایت'
        //, 'تکمیل پروفایل']
        //, ['پشتیبانی'
        //, 'درباره ما']
        ];
        // Get the keyboard
        
        $telegram = new Telegram($bot_id);
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_iD, 'reply_markup' => $keyb, 'text' => $replY];    
        $telegram->sendMessage($content);
}



function getProfile($row,$chat_username)
{
    $x=$row ['familynamefa'];
        $rp=': پروفایل شما'
        .PHP_EOL
        .' @'
        .$chat_username
        .PHP_EOL
        .' نام خانوادگی:'
        .$x
        .PHP_EOL;
        
        $x=$row['firstnamefa'];
        $rp.=
        ' نام:'
        .$x
        .PHP_EOL;
         
        $x=$row['fathersnamefa'];
        $rp.=
        ' نام پدر:'
        .$x
        .PHP_EOL;       
                 
        $x=$row['telegram'];
        $rp.=
        'تلگرام:'
        .$x
        .PHP_EOL;       
                 
        $x=$row['chat_id'];
        $rp.=
        'تلگرام نامبر:'
        .$x
        .PHP_EOL;       
                 
        $x=$row['email'];
        $rp.=
        'ایمیل:'
        .$x
        .PHP_EOL;       

         
        $x=$row['height'];
        $rp.=
        '  قد:'
        .$x
        .PHP_EOL;       
        
                 
        $x=$row['weight'];
        $rp.=
        ' وزن:'
        .$x
        .PHP_EOL;       
        
                 
        $x=$row['city'];
        $rp.=
        ' شهر:'
        .$x
        .PHP_EOL;       
         
        $x=$row['urbanfa'];
        $rp.=
        ' حومه:'
        .$x
        .PHP_EOL;    
         
        $x=$row['provincefa'];
        $rp.=
        '  استان:'
        .$x
        .PHP_EOL;       
         
        $x=$row['age'];
        $rp.=
        '  سن:'
        .$x
        .PHP_EOL;             
        $x=$row['birthdayday'].'/'
        .$row['birthdaymonth'].'/'
        .$row['birthdayyear'];
        $rp.=
        '  تولد:'
        .$x
        .PHP_EOL;             
        $x=$row['sex'];
        $rp.=
        'جنسیت:'
        .($x==0?'خانم':'آقا')
        .PHP_EOL;             
        $x=$row['coach'];
        $rp.=
        ' نام مربی:'
        .$x
        .PHP_EOL;    
        $x=$row['teamname'];
        $rp.=
        ' نام تیم:'
        .$x
        .PHP_EOL;    
        $x=$row['jerseyNo3'];
        $rp.=
        ' شماره پیرهن 3 به 3 :'
        .$x
        .PHP_EOL;    
        $x=$row['jerseyNo5'];
        $rp.=
        ' شماره پیرهن دوزمینه :'
        .$x
        .PHP_EOL;    
        $x=$row['teamname3x3'];
        $rp.=
        '  نام تیم سه نفره:'
        .$x
        .PHP_EOL;    
        $x=$row['experience'];
        $rp.=
        '  سابقه بسکتبال خیابانی:'
        .$x
        .PHP_EOL;    
 
        $x=$row['experienceofficial'];
        $rp.=
        '  سابقه سالنی :'
        .$x
        .PHP_EOL;           
 
        $x=$row['post'];
        $rp.=
        ' پست بسکتبال:'
        .$x
        .PHP_EOL;    
        $x=$row['nationalcode'];
        $rp.=
        '  کد ملی:'
        .$x
        .PHP_EOL;    
        $x=$row['address'];
        $rp.=
        '  آدرس:'
        .$x
        .PHP_EOL;    
        $x=$row['postalcode'];
        $rp.=
        '  کد پستی:'
        .$x
        .PHP_EOL;    
        $x=$row['postnonprof'];
        $rp.=
        '  پست غیر تخصصی و غیر حرفه ای:'
        .$x
        .PHP_EOL;    
        $x=$row['telegramphone'];
        $rp.=
        '  موبایل تلگرامی:'
        .$x
        .PHP_EOL;           

        $x=$row['telegramcellphone'];
        $rp.=
        '  موبایل:'
        .$x
        .PHP_EOL;    
        
        $x=$row['homephone'];
        $rp.=
        ' تلفن منزل :'
        .$x
        .PHP_EOL;    
        
        
        $x=$row['cellphone'];
        $rp.=
        ' موبایل دیگر :'
        .$x
        .PHP_EOL;    
        
        $x=$row['telegram'];
        $rp.=
        '  تلگرام شما :'
        .$x
        .PHP_EOL;    
        
        
                 
        $x=$row['instagram'];
        $rp.=
        ' آی دی صفحه ی اینستاگرام شما:'
        .$x
        .PHP_EOL;       
        
        
        
        return $rp;
}