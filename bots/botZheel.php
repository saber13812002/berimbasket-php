<?php

include 'token.php'; 
include ('../../wp-load.php');
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

// Set the bot TOKEN
$bot_token = '185734706:AAGxHo6ViL5WCrBelUYhF39pq5LSlhRgPjQ';
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botZheel';
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
$getUpdateType = $telegram->getUpdateType();
// 
$query_current_info="SELECT * FROM `vb_user_zheel` WHERE chat_id='$chat_id'";

$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');";


// Check if the text is a command $chat_username
if (!is_null($text) && !is_null($chat_id) && !is_null($chat_username) && ($chat_id!= -2147483648)) 
{
    
    $sql->query ($query_current_info);
    if ($sql->get_num_rows () == 0)
    {
    $sql->query ("INSERT INTO `vb_user_zheel` (`chat_id`) VALUES ( '$chat_id');");
    }
    
    
   // $command='';
if($text!='تمام سوالات را پاسخ دادم - ارسال اطلاعات به مدیر')
{
    
    $cmd = substr($text,0,6);
    if ($text == '/start'||$cmd=='/start') {
        $reply = 'برای شروع به سوالات زیر به صورت کامل پاسخ داده و در آخر روی دکمه ی ارسال به مدیر کلیک کنید';

        
        if ($cmd=='/start') {
  
            sendMsg($r.'کسی روبات را استارت کرد',$bot_token);
            $rp='برای شروع روی سوالات زیر کلیک کنید ';

            $content = ['chat_id' => $chat_id, 'text' => $rp];
            $telegram->sendMessage($content);
            
    		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `foaf`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname','0');");
        }
        $reply = 'برای شروع به سوالات زیر به صورت کامل پاسخ داده و در آخر روی دکمه ی ارسال به مدیر کلیک کنید';
        mainkeyboard($bot_token,$chat_id,$reply);
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'h1') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["h1"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'عنوان شما در سیستم '
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
    elseif ($text == 'p1') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["p1"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'پاراگراف شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'h2') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["h2"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'عنوان با فونت 2 هدر شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'p2') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["p2"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'پاراگراف شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'h3') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["h3"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'عنوان با فونت 2 هدر شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'p3') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["p3"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'پاراگراف شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }
    elseif ($text == 'snippet') {
        
        // get user profile
        $sql->query ($query_current_info);
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["snippet"];
        // if($x==1)
        // $x='آقا';
        // else
        // $x='خانم';
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


        $sql->query ("SELECT buttons FROM `vb_bot_commands` where bot='blog' and command ='tabs'");
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $key_str =$row ["buttons"];
        $option []=explode(',',$key_str);
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'انتخاب snippet'];
        //$content = ['chat_id' => $chat_id, 'text' => $option];

        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    }       
    elseif ($text == 'picture') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["keyword"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'https://berimbasket.ir/wp-content/uploads/images/'.$x."_".$chat_id.'.png
'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را عکسی کنید   ".' مثل ارسال عکس به همین روبات یا مقدار توضیحی دلخواهتان';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
    elseif ($text == 'keyword') {
        
        // get user profile
        $sql->query ($query_current_info);
        
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $x=$row ["keyword"];
        // message his info to him if want to cancel and select another command
        if($x==null||$x=="")
          $x=0;
          
        $reply = 'کلمه ی کلیدی  شما در سیستم '
        .'('
        .$x
        .')'
        ." ثبت شده است برای  انصراف از تغییر /cancel و برای ادامه مقداری را وارد کنید   ";
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);

        // if yes approved then insert status then exit
		$sql->query ($query_insert_log);
    } 
    elseif ($text == 'راهنما') {
        $reply = ': https://yourwebsite/?p=1';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'همه ی امکانات سایت و اپ اینجا در این روبات معرفی شده: https://t.me/babakfani';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'مدیر روابط عمومی برای پاسخگویی: https://t.me/babakfani';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    }
    elseif ($text=='/cancel')
    {
        $sql->query ();
        $content = ['chat_id' => $chat_id, 'text' => 'کنسل شد'];
        $telegram->sendMessage($content);
        //keybo
        mainkeyboard($bot_token,$chat_id,'بریم بعدی');
    }
    elseif($text !='/cancel')
    {
        $sql->query ("SELECT * FROM `vb_telegrambot` WHERE 1 and chat_id='$chat_id' and chat_type='$botname' order by id DESC LIMIT 1");
        

        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        // if count > 1 todo
        
        $t=$row ["text"];        
        $content = ['chat_id' => $chat_id, 'text' => $t];
        $telegram->sendMessage($content);


        
        if($t == 'h1' )
        {
            $sql->query ($query_insert_log);
            
            $wval=$text;
            $q="UPDATE `vb_user_zheel` SET h1='".addslashes($text)."' WHERE chat_id='$chat_id'";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'p1' )
        {
            $sql->query ($query_insert_log);
            
            $wval=$text;
            sendMsg($text.' '.$t.' '.$wval,$bot_token.' '.$chat_id);
            $q="UPDATE `vb_user_zheel` SET `p1`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'picture' )
        {
            $sql->query ($query_insert_log);
            $q="UPDATE `vb_user_zheel` SET `picture`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }

        elseif($t == 'keyword' )
        {
            $sql->query ($query_insert_log);
            $q="UPDATE `vb_user_zheel` SET `keyword`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'h2' )
        {
            $sql->query ($query_insert_log);
            $q="UPDATE `vb_user_zheel` SET `h2`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'p2' )
        {
            $sql->query ($query_insert_log);
            
            $wval=$text;
            sendMsg($text.' '.$t.' '.$wval,$bot_token.' '.$chat_id);
            $q="UPDATE `vb_user_zheel` SET `p2`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'h3' )
        {
            $sql->query ($query_insert_log);
            $q="UPDATE `vb_user_zheel` SET `h3`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'p3' )
        {
            $sql->query ($query_insert_log);
            
            $wval=$text;
            sendMsg($text.' '.$t.' '.$wval,$bot_token.' '.$chat_id);
            $q="UPDATE `vb_user_zheel` SET `p3`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
        }
        elseif($t == 'snippet' )
        {
            $sql->query ($query_insert_log);
            
            //$wval=$text;
            //sendMsg($text.' '.$t.' '.$wval,$bot_token.' '.$chat_id);
            $q="UPDATE `vb_user_zheel` SET `snippet`='".addslashes($text)."' WHERE chat_id=$chat_id";
            $sql->query ($q); 
            //$msg="مقدار تغییر کرد".$q;
            $msg="مقدارش تغییر کرد";
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
            
            mainkeyboard($bot_token,$chat_id,'بریم بعدی');
        }
        // elseif ($t=0||$t='0'){
        //     $msg="دستوری وارد نشده است  ";
        //     $content = ['chat_id' => $chat_id, 'text' => $msg];
        // $telegram->sendMessage($content);
        // }
        // if(!($t=0||$t='0'))
        // {
        //     $message = ' #profilebot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$text.'  ';
        //     sendMsg($message,"");
        // }
    }

}
else
{
    //$command='/sendtoadmin';

    
    
    //72814039
    $sql->query ($query_current_info);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $h1=$row ["h1"];
    $p1=$row ["p1"];
    $width=$row ["width"];
    $height=$row ["height"];
    $chat_idd=$row ["chat_id"];
    $keyword=$row ["keyword"];
    $picture=$row ["picture"];
    $h2=$row ["h2"];
    $p2=$row ["p2"];
    $h3=$row ["h3"];
    $p3=$row ["p3"];
    
    $picture='https://berimbasket.ir/wp-content/uploads/images/'.$keyword."_".$chat_idd.'.png';
    // $x5=$row ["trips"];
    // $x6=$row ["visa"];
    // $x7=$row ["civil"];
    // $x8=$row ["account"];
    // $x10=$row ["address"];
    if($h1!=''&&$p1!=''&&$width!=''&&$height!=''&&$chat_idd!=''&&$keyword!=''&&$h2!=''&&$h3!=''&&$picture!=''&&$p2!=''&&$p3!='')
    {
        $message = '<h1>'
        .$h1
        .'</h1> 
'
        . '<p>'
        .$p1
        
        .'  <a href="http://berimbasket.ir/%D8%AA%DB%8C%D9%85-%D8%A8%D8%B3%DA%A9%D8%AA%D8%A8%D8%A7%D9%84/">
<strong>'
        .$keyword
        .'</strong>
</a> '        
        .'</p>         
'
        
        .'[caption id="attachment_395" align="alignnone" width="'.$width.'"]<a href="http://berimbasket.ir/%D8%AA%DB%8C%D9%85-%D8%A8%D8%B3%DA%A9%D8%AA%D8%A8%D8%A7%D9%84/"><img class="wp-image-395 size-full" src="'.$picture.'" alt="'.$keyword.'" width="'.$width.'" height="'.$height.'" /></a>'.$keyword.' [/caption]
'
        .$keyword
        .'<h2> 
'
        .$h2
        .' </h2> '
                . '<p>'
        .$p2
        .'</p>         
'
        .'<h3> 
'
        .$h3
        .' </h3> '
        . '<p>'
        .$p3
        .'</p>         
'

//         .$x4
//         .' سفرها '
//         .$x5
//         .' ویزا '
//         .$x6
//         .' ملک '
//         .$x7
//         .' حساب '
//         .$x8
//         .' حساب '
//         .$x10.'
// @zheelbot '
;
//todo
// $tag=findTag($text,$sql);
// $tags=beliefmedia_hashtag_string($message);
            
    $id = wp_insert_post(array(
            'post_title' => ($h1),
                //'post_type' => 'booking',
                //
                //            'post_type' => 'page',
                'post_type' => 'post',
                
                'post_status' => 'publish'
                , 'post_content'=>$message
                //,'post_name' => $pagename
                ,'tags_input'     => 
                //$tag.
                ",".",بسکتبال,"."تیم_بسکتبال,".$keyword
                //.$tags
                ,
  
            ));
            
            
            $content = ['chat_id' => 72814039, 'text' => $message];
            $telegram->sendMessage($content);
            
        
            $content = ['chat_id' => 222909344, 'text' => $message];
            $telegram->sendMessage($content);
            
            
            
            $msg="https://berimbasket.ir/?p=".$id;
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
            
    }
}
}

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
    $file_size=$file_size0.' @'.$chat_username;
    $content = ['chat_id' => $chat_ch_id, 'text' => $file_size];
    $telegram->sendMessage($content);
    
        $message = 'ارسال فایل عکس برای روبات پروفایل'
    .' #photo #zheelbot'.' : '.(string)$chat_id
    .' نام '
    .(string)$chat_firstname
    .' فامیل '
    .(string)$chat_lastname
    .' @'.(string)$chat_username
    .' '
    .$instagramLink.'  '.$text.'  ';
    //'$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type
    
    $sql->query ($query_current_info);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $x=$row ["keyword"];
    // message his info to him if want to cancel and select another command
    if($x==null||$x=="")
      $x=0;
          
    $x = str_replace(' ', '_', $x);
      
      
    sendMsg($message." #photo#".'https://berimbasket.ir/wp-content/uploads/images/'.$x."_".$chat_id.'.png'.' '.$file_size);
    
    $width=$telegram->getPhotoWidth2() ;
    $height=$telegram->getPhotoHeight2() ;
    $duration=0;
    $mime_type='';
    $file_type='photo';
    $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botZheel', '', '$text', '$botname', '$file_id', '$file_type', '$file_size', '$width', '$height', '$duration', '$mime_type');");

    $content = ['chat_id' => $chat_ch_id, 'photo' => $file_id , 'caption' => 'http://berimbasket.ir/bball/www/approvephoto.php?file_id='.$file_id.'&chat_id='.$chat_id];
    $telegram->sendPhoto($content);
    
    
    $file=$telegram->getFile($file_id);
    // $content = ['chat_id' => $chat_id, 'text' => $file.''];
    // $telegram->sendMessage($content);
    
    
    //$file = $telegram->getFile($file_id);
$telegram->downloadFile($file['result']['file_path'], '../../wp-content/uploads/images/'.$x."_".$chat_id.'.png');

    $msg='عکس مقاله ی شما تغییر کرد'
    .' روی این لینک کلیک کنید '
    .'https://berimbasket.ir/wp-content/uploads/images/'.$x."_".$chat_id.'.png'
    .' '
    .$width.' '.$height;
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
    
    $sql->query ($query_insert_log);
    $q="UPDATE `vb_user_zheel` SET `address`='".addslashes($chat_id)."' WHERE chat_id=$chat_id";
    $sql->query ($q); 
            
    $q="UPDATE `vb_user_zheel` SET `width`=$width WHERE chat_id=$chat_id";
    $sql->query ($q); 
    $msg="width"."مقدارش تغییر کرد";
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);
            
    $q="UPDATE `vb_user_zheel` SET `height`=$height WHERE chat_id=$chat_id";
    $sql->query ($q); 
    $msg="height"."مقدارش تغییر کرد";
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);            
}

function sendMsg($message,$bot_id){ 
    
    $telegram = new Telegram($bot_id);
    $chat_id = 222909344; // '-1121691989';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
    
    // $telegram = new Telegram($bot_id);
    // $chat_id = 222909344; // '-1121691989';
    // $content = array('chat_id' => $chat_id, 'text' => $message);
    // $telegram->sendMessage($content);
}


function mainkeyboard($bot_id,$chat_iD,$replY){

        // Create option for the custom keyboard. Array of array string
        $option = [['راهنما']
        , ['p1','h1']
        , ['keyword'
        ,'picture']
        , ['snippet' 
        ]
        
        , ['p2','h2']
        
        , ['p3','h3']
        , ['تمام سوالات را پاسخ دادم - ارسال اطلاعات به مدیر']
        //, [''
        //, '']
        //nameunicode
        ];
        
        $telegram = new Telegram($bot_id);
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_iD, 'reply_markup' => $keyb, 'text' => $replY];    
        $telegram->sendMessage($content);
}



function findTag($text,$sql)
{
    $sql->query ("SELECT buttons FROM `vb_bot_commands` where bot='twitter' and command ='post'");
        $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $key_str =$row ["buttons"];
        $option []=explode(',',$key_str);
        
    foreach ($option[0] as $match) {
    $keywords .= $match . ',';
  }
  
    return ",بسکتبال,".$keywords;
}


function beliefmedia_hashtag_string($string) {
 
 /* Match hashtags */
 preg_match_all('/#(\w+)/', $string, $matches);
 
  /* Add all matches to array */
  foreach ($matches[1] as $match) {
    $keywords .= $match . ',';
  }
 
 return rtrim(trim($keywords), ',');
}

// CREATE TABLE `vb_user_zheel` (
//   `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//   `username` varchar(255) NOT NULL ,
//   `telegram` varchar(35) DEFAULT NULL,
//   `active` tinyint(1) NOT NULL DEFAULT '1',
//   `age` varchar(11) NOT NULL,h1
//   `job` varchar(11) NOT NULL,p1
//   `picture` varchar(11) NOT NULL,
//   `childs` varchar(11) NOT NULL, //h2
//   `trips` varchar(400) NOT NULL,
//   `visa` varchar(400) NOT NULL,
//   `civil` varchar(400) NOT NULL,
//   `account` varchar(400) NOT NULL,
//   `sex` tinyint(1) NOT NULL,
//   `experience` varchar(11) NOT NULL,
//   `address` varchar(100) NOT NULL
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8;




?>