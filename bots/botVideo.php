<?php
include 'token.php'; 
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();


$botTokenmj = getToken("mj23");

$bot_id = getToken("botVideo");
$telegram = new Telegram($bot_id);
// Get all the new updates and set the new correct update_id
//$req = $telegram->getUpdates();
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
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
	//
	if(strpos($text, 'instagram.com')>=0)
	{
	$instagramLink=substr($text,strpos($text, 'https://'),strlen($text));

	//echo json_encode ( $telegram );
	
	$chat_username = $telegram->Username();
	
	$help = " سلام شما برای عضویت در شبکه اجتماعی بسکتبالیست ها نیاز به رمز دارید از طریق دکمه ی کد فعالسازی اقدام کنید یا روبات را /start کنید تا یک دقیقه اگر رمز برای شما ارسال نشد به آی دی ادمین @berimbasket_ir پیام دهید ";
	
    $help = $help.". به کمک روبات نقشه زمین بسکتبال خود را برای ما بفرستید @berimbasketmapbot";
    $count=0;$score=0;$totalScore=0;
	if ($text != "" && strlen(trim($instagramLink)) > 0) {
	    
        $tekrari=0;
        
        $sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and  `FromID`  = '$ch_id' and `Active`=1 and tags like '%instagram.com%'" );
        
        if ($sql->get_num_rows() > 0)
        {

            $count=$sql->get_num_rows ();
            $score=$count*50;
        }
 
        $sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and  `tags`  = '$instagramLink' and `Active`=1 and tags like '%instagram.com%'" );
        
        if ($sql->get_num_rows() > 0)
        {
             $tekrari=1;
  
        }
 
               
	    
	    if ($telegram->messageFromGroup()) {

			

			
			//,'FromChatID' ,'messageFromGroup','FromID','UpdateID'
			//,'$FromChatID' ,'$messageFromGroup','$FromID','$UpdateID'
			if($tekrari==1)
			$sql->query ("INSERT INTO `InstagramBot` (`text`, `tags`,`FromID`,`ChatID`,`FromChatID`,`messageFromGroup`,`UpdateID`,`Active`) VALUES ( 'instagram', '$instagramLink', '$ch_id', '$chat_username' ,'$FromChatID','$messageFromGroup','$UpdateID',0)" );
			else
			$sql->query ("INSERT INTO `InstagramBot` (`text`, `tags`,`FromID`,`ChatID`,`FromChatID`,`messageFromGroup`,`UpdateID`) VALUES ( 'instagram', '$instagramLink', '$ch_id', '$chat_username' ,'$FromChatID','$messageFromGroup','$UpdateID')" );
			//echo $telegram->data["message"]["text"];
			
            $sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and  `FromID`  = '$ch_id' and `Active`=1 and tags like '%instagram.com%'" );
        
            if ($sql->get_num_rows() > 0)
            {
    
                $count=$sql->get_num_rows ();
                $score=$count*50;
            }			
	        if($tekrari==1)
                $reply="تکراری";
            else
  			    
			$reply = " پیام در گروه دریافت شد"
.PHP_EOL.PHP_EOL."تعداد ویدئوهای آپلود شده ی شما تاکنون "
			.$count
			.PHP_EOL.PHP_EOL." امتیاز ویدئوی شما "
			.$score
			." امتیاز کل شما "
			.PHP_EOL.PHP_EOL
			." برای دریافت لیست ریز امتیازات خود از روبات زیر استفاده کنید"
			.PHP_EOL.PHP_EOL." @berimbasketscorebot";
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			
			$telegram->sendMessage($content);
			
		}
		else{
		    

			

			//,'FromChatID' ,'messageFromGroup','FromID','UpdateID'
			//,'$FromChatID' ,'$messageFromGroup','$FromID','$UpdateID'
			if($tekrari==1)
			$sql->query ("INSERT INTO `InstagramBot` (`text`, `tags`,`FromID`,`ChatID`,`FromChatID`,`messageFromGroup`,`UpdateID`,`Active`) VALUES ( 'instagram', '$instagramLink', '$ch_id', '$chat_username' ,'$FromChatID','$messageFromGroup','$UpdateID',0)" );
			else
			$sql->query ("INSERT INTO `InstagramBot` (`text`, `tags`,`FromID`,`ChatID`,`FromChatID`,`messageFromGroup`,`UpdateID`) VALUES ( 'instagram', '$instagramLink', '$ch_id', '$chat_username' ,'$FromChatID','$messageFromGroup','$UpdateID')" );
		  
		  
            $sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and  `FromID`  = '$ch_id' and `Active`=1 and tags like '%instagram.com%'" );
        
            if ($sql->get_num_rows() > 0)
            {
    
                $count=$sql->get_num_rows ();
                $score=$count*50;
            }
            if($tekrari==1)
                $reply="تکراری";
            else
  			    $reply = " پیام در خصوصی دریافت شد"
.PHP_EOL.PHP_EOL."تعداد ویدئوهای آپلود شده ی شما تاکنون "
			.$count
			.PHP_EOL.PHP_EOL." امتیاز ویدئوی شما "
			.$score
			." امتیاز کل شما "
			.PHP_EOL.PHP_EOL
			." برای دریافت لیست ریز امتیازات خود از روبات زیر استفاده کنید"
			.PHP_EOL.PHP_EOL." @berimbasketscorebot";
			$content = array('chat_id' => $chat_id ,'text' => $reply);
			
			$telegram->sendMessage($content);
			
			
		}
        
		if($tekrari==1)
	    $message = ' #videobot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$count.' این ویدئو قبلا #ثبت شده بود ';
		else		
	    $message = ' #videobot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$count.'  ';
		
		sendMsg($message,$botTokenmj);
		//&& $chat_id==222909344
		if(substr($text,0,2)=='//')
        sendMsg($instagramLink,$bot_id);
    }

//}
}
else
	{
		$content = array('chat_id' => $chat_id ,'text' => 'لینک اینستا نیست');
		$telegram->sendMessage($content);
		
	    $message = 'لینک اینستا نیست #videobot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' '.$instagramLink.'  '.$text.'  ';
		
		sendMsg($message,"");
	}
	



function sendMsg($message,$bot_id){
	$telegram = new Telegram($bot_id);
	$chat_id =-1001116243352;
	//$chat_id=222909344;
	$content = array('chat_id' => $chat_id, 'text' => $message);
	$telegram->sendMessage($content);
	$chat_id=222909344;
	$content = array('chat_id' => $chat_id, 'text' => $message);
	$telegram->sendMessage($content);
    
}




//sendLoc('@varzeshboard',35.35,51.51);

//$response = array ();
//$response [] = getUpd();
//echo json_encode ( $response[0]['result'].update_id );



//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");

