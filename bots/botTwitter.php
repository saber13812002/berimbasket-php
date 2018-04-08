<?php
include 'token.php';
include ('../../wp-load.php');
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();


$botTokenmj = getToken("mj23");


$botname='botTwitter';
$bot_id = getToken("botTwitter");
$telegram = new Telegram($bot_id);
// Get all the new updates and set the new correct update_id
//$req = $telegram->getUpdates();
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
//	$telegram->serveUpdate($i);
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$chat_username = $telegram->Username();
$chat_firstname = $telegram->FirstName();
$chat_lastname = $telegram->LastName();
$FromChatID = $telegram->FromChatID();
$messageFromGroup = $telegram->messageFromGroup();
$FromID = $telegram->FromID();
$UpdateID = $telegram->UpdateID();
$firstlastname = $chat_firstname.' '.$chat_lastname;
	//$txt=$telegram->data["message"]["text"];
	//
	//$text=substr($text,strpos($text, '/')+1,strlen($text));
	//if(strpos($text, '/')>0)
	//echo strpos($text, '/');    

	//echo json_encode ( $telegram );
	
	//$chat_username = $telegram->Username();
	
    if($text == "/start")
    {
			$reply = " پیام  دریافت شد توییت خود را شروع کنید";
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			$telegram->sendMessage($content);
    }
	else if ($text != "") {
	    if ($telegram->messageFromGroup()) 
			$reply = " پیام در گروه دریافت شد";
		else
			$reply = " پیام در خصوصی دریافت شد";
		    
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			$telegram->sendMessage($content);


$stringtitle = (strlen($text) > 143) ? substr($text,0,140).'...' : $text;

$stringtitle = str_replace([":", PHP_EOL], ' ', $stringtitle);
$stringtitle = str_replace([")", '('], ' ', $stringtitle);
$stringtitle = str_replace(["/", '@'], ' ', $stringtitle);
$stringtitle = str_replace([";", ','], ' ', $stringtitle);
$stringtitle = str_replace(["-", '_'], ' ', $stringtitle);

$textcomment=substr($text,8,strlen($text)-8);
            //echo ' '.$text;

			//$sql->query ("INSERT INTO `vb_log` (`msg` , 'username' , 'sender' , 'devicetype') VALUES ( '$text' , '$chat_username' , 'twitter' , 'bottwitter')");
			$sql->query ("INSERT INTO `vb_log` (`timestamp`, `mac`, `username`, `password`, `sender`, `devicetype`, `msg`, `active`, `id`) VALUES (CURRENT_TIMESTAMP, '', '$chat_username', '', 'twitter', 'bottwitter', '$text','1', NULL)");
    $sql->query ("INSERT INTO `vb_telegrambot` (`timestamp`,`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES (CURRENT_TIMESTAMP,'$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'bottwitter', '', '$text', '$botname');");


	$tag=findTag($text,$sql);
	$tags=beliefmedia_hashtag_string($text);
	
	//<a href='//t.me/NBAESPN'>@nbaespn</a>
	
	$text=turnTheWordIntoALink($text." berimbaskettelegramchannel"," berimbaskettelegramchannel",'https://t.me/berimbasket');
	
	$video_id=getVideoMessageId($sql);
	//$photo_id=getPhotoMessageId($sql);
	
	
// 	if($photo_id!=null)
// 	$text.="[caption id='attachment_349' align='alignnone' width='300']<img class='size-medium wp-image-349' 
// 	src='https://berimbasket.ir/bball/bots/playgroundphoto/".$photo_id.".png' 
// 	alt='عکس های زمین بسکتبال'  
// 	width='300' height='300' /> عکس های زمین بسکتبال[/caption]";
	    
	
	if($video_id==null)
	$text.="[embed]https://berimbasket.ir/bball/bots/dl/videos/576655278.mp4[/embed]";
	else
	$text.="[embed]https://berimbasket.ir/bball/bots/dl/videos/".$video_id.".mp4[/embed]";
	
	
// 	$photo_id=getPhotoMessageId($sql);
	
	
// 	if($photo_id!=null)
// 	$text.="&nbsp;[caption id='attachment_349' align='alignnone' width='300']<img class='size-medium wp-image-349' 
// 	src='https://berimbasket.ir/bball/bots/playgroundphoto/".$photo_id.".png' 
// 	alt='عکس های زمین بسکتبال'  
// 	width='300' height='300' /> عکس های زمین بسکتبال[/caption]&nbsp;";
	    
	
	
	
// 	$photo_id=getPhotoMessageId($sql);
	
	
// 	if($photo_id!=null)
// 	$text.="&nbsp;[caption id='attachment_349' align='alignnone' width='300']<img class='size-medium wp-image-349' 
// 	src='https://berimbasket.ir/bball/bots/playgroundphoto/".$photo_id.".png' 
// 	alt='عکس های زمین بسکتبال'  
// 	width='300' height='300' /> عکس های زمین بسکتبال[/caption]&nbsp;";
	    
	
	

// 	$text.="&nbsp;<a href='http://berimbasket.ir/bball/www/instagram.php?id=4'>دیدن عکس های بیشتر از زمین های استریت بسکتبال در تهران و کرج و ارومیه و اصفهان و مشهد و رشت و شیراز و</a>";
	
			$content = array('chat_id' => $chat_id ,'text' => 'https://berimbasket.ir/bball/bots/dl/videos/'.$video_id.'.mp4');
			$telegram->sendMessage($content);
	
	if(substr($text,0,5) == "/id=0"){

        $comment_post_ID = substr($text,4,4);
        $comment_author = __($firstlastname, $firstlastname);
        $comment_author_url = '';
        $comment_content = $textcomment;
        $comment_agent = 'WooCommerce';
        $comment_type = 'order_note';
        $comment_parent = 0;
        $comment_approved = 1;
        $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_agent', 'comment_type', 'comment_parent', 'comment_approved');
        $comment_id = wp_insert_comment($commentdata);
        //add_comment_meta($comment_id, 'is_customer_note', $is_customer_note);
        			$reply = "https://berimbasket.ir/?p=".substr($text,5,3).'#'.$comment_id;
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			$telegram->sendMessage($content);
			//echo $telegram->data["message"]["text"];
		
    sendMsg('#postCommentbot #twitter : '.substr($text,8,strlen($text)).' #bythisuser : @'.$chat_username,$botTokenmj);
    sendMsg($reply,$botTokenmj);
	}
	else {
	    //$post_id = wp_insert_post( $my_post, $wp_error=true );
            $id = wp_insert_post(array(
            'post_title' => ($stringtitle),
                //'post_type' => 'booking',
                //
                //            'post_type' => 'page',
                'post_type' => 'player',
                'height' => 190,
                
                'post_status' => 'publish'
                , 'post_content'=>$text
                //,'post_name' => $pagename
                ,'tags_input'     => $tag.",".",بسکتبال,"."نتایج,NBA,".$tags,
  
            ));
            //), $wp_error=true);
            
    //         if ( is_wp_error($id) ){
    //           //$er= $id->get_error_message();
    //               $errors = $id->get_error_messages();

    //           foreach ($errors as $error) {
    //     $er.=$error; //this is just an example and generally not a good idea, you should implement means of processing the errors further down the track and using WP's error/message hooks to display them
    // }
    //         }

	    			$reply = "https://berimbasket.ir/?p=".$id;
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			$telegram->sendMessage($content);
			//echo $telegram->data["message"]["text"];
		
    sendMsg('#postblogbot #twitter : '.$string.' #bythisuser : @'.$chat_username.' error:'.$er. " edit link: https://berimbasket.ir/wp-admin/post.php?post=".$id."&action=edit",$botTokenmj);
    sendMsg($reply,$botTokenmj);
	}
	
	$sql->query ("INSERT INTO `vb_log` (`timestamp`, `mac`, `username`, `password`, `sender`, `devicetype`, `msg`, `active`, `id`) VALUES (CURRENT_TIMESTAMP, '', '$chat_username', '$id', 'twitter', 'bottwitter', '$text','1', NULL)");

		 

    }

//}



function turnTheWordIntoALink($string, $word, $link) {
    if(isLink($string)) {
        return $string;   
    } else {
        $string = str_replace($word, "<a href=\"" . $link . "\">" . $word . "</a>", $string);
        return $string;
    }
}

function isLink($string) {
    return preg_match("/(<a href=\".\">)/", $string);
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

function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = -1001136444717;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}

function getVideoMessageId($sql)
{
    
      $sql->query ("SELECT * FROM `vb_telegrambot` where botname = 'botVoice' AND file_id > '' and text='video' order by rand() limit 1");
       $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $message_id =$row ["message_id"];
        return $message_id;
}


function getPhotoMessageId($sql)
{
    
      $sql->query ("SELECT * FROM `vb_telegrambot` where botname = 'botUpload' AND file_id > '' and file_type='photo' order by rand() limit 1");
       $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
        $message_id =$row ["message_id"];
        return $message_id;
}


//sendLoc('@varzeshboard',35.35,51.51);

//$response = array ();
//$response [] = getUpd();
//echo json_encode ( $response[0]['result'].update_id );



//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");


?>