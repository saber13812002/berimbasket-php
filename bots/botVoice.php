<?php


include 'token.php'; 
include 'Telegram.php';
// include 'goo.gl.php' ;


require_once __DIR__ . '/db_connect.php';
$sql = new DB ();


$chat_ch_id=222909344;  
$chat_ch_id2=111398115;
$chat_ch_id3=83674896;
$chat_ch_id4=151370482;
$chat_ch_id5=127562196;

// Set the bot TOKEN
$bot_token = getToken("botVoice");
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botVoice';


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
$getUpdateType=$telegram->getUpdateType();

// $message = $this->getMessage();
// if ($photo = $message->getPhoto()) {
//     // Get the original size.
//     $photo = end($photo);

//     $file = Request::getFile([
//         'file_id' => $photo->getFileId(),
//     ]);
//     if ($file->isOk() && Request::downloadFile($file->getResult())) {
//         // File downloaded successfully, get the local path.
//         $photo_location = $this->telegram->getDownloadPath() . '/' . $file->getResult()->getFilePath();

//         // Do something with the file...
//         $exif_data = exif_read_data($photo_location);
        
        
        
//         $rp=$photo_location;
//         $content = ['chat_id' => $chat_id, 'text' => $text];
//         $telegram->sendMessage($content);
//         //....
//     } else {
//         // Failed to download.
//     }
// }

if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
{
//approve
if(substr($text,0,1)=='/')
{
    if(substr($text,0,9)=='/rejected')
    {
        $id=substr($text,9,strlen($text)-9);
        if($id>0)
        {
            $sql->query("UPDATE vb_telegrambot SET approved=0 WHERE id= $id");
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
        }
    }
    if(substr($text,0,5)=='/rate')
    {
        $id=substr($text,6,strlen($text)-6);
        $rate=substr($text,5,1);
        if($id>0)
        {
            $sql->query("UPDATE vb_telegrambot SET rate=$rate , from_id=$chat_id WHERE id= $id");
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $rate];
            $telegram->sendMessage($content);
        }
    }
    if(substr($text,0,9)=='/caption,')
    {
        $resultarray   = explode(',',$text);
        if($resultarray[2])
        {
        $id=$resultarray[1];
        $caption=$resultarray[2];
        if($id>0)
        {
            $sql->query("UPDATE vb_telegrambot SET caption='$caption'  WHERE id= $id");
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $caption];
            $telegram->sendMessage($content);
        }
        }
        else
        {
            $content = ['chat_id' => $chat_id, 'text' => "کپشن نداشت"];
            $telegram->sendMessage($content);
        }
        
    }
    if(substr($text,0,8)=='/keyword')
    {
        $resultarray   = explode(PHP_EOL,$text);
        if($resultarray[2])
        {
        $id=$resultarray[1];
        
        for ($i=2; $i<count($resultarray); $i++) 
        { 
            $keyword.=$resultarray[$i].',';
        }

        //$resultarray=array_shift(($resultarray));
        //$keyword=implode(',',$resultarray);
        if($id>0)
        {
            $sql->query("UPDATE vb_telegrambot SET keyword='$keyword'  WHERE id= $id");
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $id];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $keyword];
            $telegram->sendMessage($content);
        }
        }
        else
        {
            $content = ['chat_id' => $chat_id, 'text' => "کپشن نداشت"];
            $telegram->sendMessage($content);
        }
        
    }
//UPDATE `InstagramBot` SET `Active` = '0' WHERE `InstagramBot`.`id` = 1334;
    if(substr($text,0,10)=='/instaVote')
    {
        $id=substr($text,11,strlen($text)-11);
            $content = ['chat_id' => $chat_id, 'text' => "#a_".$id];
            $telegram->sendMessage($content);
        $rate=substr($text,10,1);
            // $content = ['chat_id' => $chat_id, 'text' => $rate];
            // $telegram->sendMessage($content);
        if($id>0)
        {
            $sql->query("UPDATE `InstagramBot` SET `vote` = '$rate' WHERE `InstagramBot`.`id` =".$id);
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $rate];
            $telegram->sendMessage($content);
        }
    }
    if(substr($text,0,10)=='/uploadId,')
    {
        $resultarray   = explode(',',$text);
        if($resultarray[2])
        {
        $id=$resultarray[1];
        $uploadid=$resultarray[2];
        if($id>0)
        {
            $sql->query("UPDATE `InstagramBot` SET `uploadid` = '$uploadid' WHERE `InstagramBot`.`id` = ".$id);
            $content = ['chat_id' => $chat_id, 'text' => "انجام شد"];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_id, 'text' => $uploadid];
            $telegram->sendMessage($content);
        }
        }
        else
        {
            $content = ['chat_id' => $chat_id, 'text' => "آپلود آی دی نداشت"];
            $telegram->sendMessage($content);
        }
        
    }
    
}
else if($text==null||$text=='')
{
    //'AwADBAADvgEAAszoGFNxOcuI4bQB1wI'
$file_id = $telegram->getFileID2();
$file=$telegram->getFile($file_id);

$filepath=$file["result"]["file_path"];


//   $mp3fileid = $file["result"]["file_id"];

// $mime = $image->mime();

//     if ($mime == 'image/jpeg') {
//         $extension = '.jpg';
//     } elseif ($mime == 'image/png') {
//         $extension = '.png';
//     } elseif ($mime == 'image/gif') {
//         $extension = '.gif';
//     } else {
//         $extension = 'ogg';
//     }
    
    // //E# if else statement
    // //Resize images
    // $image->resize(\Config::get('media::media.mainWidth'), \Config::get('media::media.mainHeight'));
    // $thumbnail->resize(\Config::get('media::media.thumbnailWidth'), \Config::get('media::media.thumbnailHeight'));

    // //Build media name
    // $media_name = \Str::random(\Config::get('media::media.mediaNameLength')) . $extension;

    // //Save images
    // $image->save($upload_path . '/' . $media_name);
    // $thumbnail->save($upload_path . '/thumbnails/' . $media_name);
        $folder="";
        $ext='.png';
    if($getUpdateType=='voice')
    {
        $ext='.ogg';
        $file_type='voice';
        $folder="voices";
    }
    else if($getUpdateType=='video')
    {
        $ext='.mp4';
        $file_type='video';
        $folder="videos";
    }
    else if($getUpdateType=='photo')
    {
        $ext='.png';
        $file_type='photo';
        $folder="photos";
    }
    else if($getUpdateType=='document'){
        $ext='.gif';
        $file_type='document';
        $folder="documents";
    }
//if(substr($filepath,-3)=='ogg')
    $telegram->downloadFile($filepath, 'dl/'.$folder.'/'.$UpdateID.$ext);
//else
  //  $telegram->downloadFile($filepath, "a.png");
    
    
// if($file)
// {

    $rp='https://berimbasket.ir/bball/bots/dl/'.$folder.'/'.$UpdateID.$ext;
    $content = ['chat_id' => $chat_id, 'text' => $rp];
    $telegram->sendMessage($content);
    
    
//     $m=$mp3fileid;
//     $content = ['chat_id' => $chat_id, 'file_id' => $m];
//     $telegram->sendMessage($content);
// }
// else
// {
//     $rp='فایل دریافت نشد';
//     $content = ['chat_id' => $chat_id, 'text' => $rp];
//     $telegram->sendMessage($content);
// }

$width=123;
$height=123;
$duration=0;
$mime_type='';
$file_type=$ext;
//$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `chat_id`, `botname`, `file_id`) VALUES ($UpdateID, $chat_id, $botname,$file_id)");



$sql->query ("INSERT INTO `vb_telegrambot` (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES (NULL, '1', '$botname', '$UpdateID', '', '', '', '', '', '', '$chat_id', '', '', '', '', '', '$getUpdateType', CURRENT_TIMESTAMP, '', '$file_id', '$file_type', '', '', '', '', '');");

$sql->query("SELECT * FROM `vb_telegrambot`  where botname='botvoice' and file_id='$file_id'");

if ($sql->get_num_rows () > 0) 
{
	if ( $row = mysqli_fetch_assoc ( $sql->get_result())) 
	{
		$id = $row ["id"];
	}
    
            $content = ['chat_id' => $chat_id, 'text' => "#a_".$id];
            $telegram->sendMessage($content);
}

// $content = ['chat_id' => $chat_ch_id, 'video' => $file_id , 'caption' => 'http://berimbasket.ir/bball/www/approvephoto.php?file_id='.$file_id.'&chat_id='.$chat_id.'&update_id='.$UpdateID];
// $telegram->sendVideo($content);


   
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
				
// $urltiny='url:'.	assert_url($googl->shorten('http://www.google.ch'));
// $content = ['chat_id' => $chat_ch_id, 'text' => $urltiny];
// $telegram->sendVideo($content);	

}
}



// function googl()
// {

// //AIzaSyByoeQuwYfzLqo4IwOMMFKMXrK-SGJiths


// $googl = new Googl('AIzaSyByoeQuwYfzLqo4IwOMMFKMXrK-SGJiths');

// // Shorten URL
// $googl->shorten('http://www.google.com/');

// // Look up long URL
// $googl->expand('http://goo.gl/fbsS');

// unset($googl);

// }




function assert_equals($is, $should) {
  if($is != $should) {
    exit(1);
  } 
//   else {
//     println('Passed!');
//   }
}
function assert_url($is) {
  if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $is)) {
    exit(1);
  } 
//   else {
//     println('Passed!');
//   }
}
// function println($text) {
//   echo $text . "\n";
// }

// $googl = new Googl('YOUR_API_KEY');
// println('#1 - Assert that shortening http://www.google.ch results in an URL');
// assert_url($googl->shorten('http://www.google.ch'));
// println('#2 - Assert that expanding http://goo.gl/KSggQ resolves to http://www.google.com/');
// assert_equals($googl->expand('http://goo.gl/KSggQ'), 'http://www.google.com/');
// println('#3 - Assert that shortening https://www.facebook.com results in an URL');
// assert_url($googl->shorten('https://www.facebook.com'));
// println('#4 - Assert that expanding http://goo.gl/wCWWd resolves to http://www.php.net/');
// assert_equals($googl->expand('http://goo.gl/wCWWd'), 'http://www.php.net/');
// # If this point is reached, all tests have passed
// println('All tests have successfully passed!');


?>