<?php
include 'token.php'; 
include 'Telegram.php';
include 'mytelegram.php';
//include 'Bot2Channel.php';
    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();
$sql1 = new DB ();

$chat_id_admin="222909344";
//,$botTokenmj
$botTokenmj = getToken("mj23");

$botname='botMap';
$bot_id  = getToken("botMap");
$telegram = new Telegram($bot_id);
// Get all the new updates and set the new correct update_id
//$req = $telegram->getUpdates();
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
	//$telegram->serveUpdate($i);
	$text = $telegram->Text();
	$location = $telegram->Location();
	$chat_id = $telegram->ChatID();
	$chat_firstname = $telegram->FirstName();
	$chat_lastname = $telegram->LastName();
	//
	//user = update.message.from_user;
	//echo json_encode ( $telegram );
	$chat_username = $telegram->Username();
	
    $help = ". به کمک روبات نقشه زمین بسکتبال خود را برای ما بفرستید  @berimbasketmapbot "."به کمک دکمه ی ارسال لوکیشن تلگرام نقطه ی دقیق زمین بسکتبال را انتخاب و برای ما ارسال کنید روبات آنرا به نقشه ی ایران اضافه میکند و لینک نتیجه را برای شما ارسال میکند " ;       
    
    if(substr($text,0,4) == "/del" && $chat_id_admin==$chat_id)
    {
        $playground_id=substr($text,4,strlen($text)-4);
        $sql->query("UPDATE vb_playground SET Active=0 WHERE Id= $playground_id");
        
        $content = ['chat_id' => $chat_id, 'text' => 'پاک شد'];
        $telegram->sendMessage($content);
    }
    
if(substr($text,0,1)=='/')
{
    
	if ($text == "/start") {
	    if ($telegram->messageFromGroup()) {
			$reply = "گروه است اینجا و فقط در خصوصی روبات فعال است در خصوصی پیام بده";
		} 
		else {
		$reply=$help;
        // Create option for the custom keyboard. Array of array string
        $option = array( array("لینک سایت", "راهنما") );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
// 		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname');");
        }
    }
    
    if(substr($text,0,3)=='/my')
    {
        
        $from=0;
       //sendM(strlen($text),$chat_id,$bot_id);

        if(strlen($text)>3)
        $fr=intval(substr($text,3,strlen($text)-3));
       sendM($from,$chat_id,$bot_id);
$from=$fr*10;

        
        $query_current_info="SELECT * FROM `vb_playground` WHERE PlaygroundType<>'userloc' and PgTlgrmGroupAdminId='$chat_username' and Active=1 limit $from,10";
    
        $sql->query ($query_current_info);
    
        if ($sql->get_num_rows () > 0) {
            while($row = mysqli_fetch_assoc ( $sql->get_result () ) )
            {
                $lat=$row["PlaygroundLatitude"];
                $long=$row["PlaygroundLongitude"];
                sendLoc($chat_id,$lat,$long,$bot_id);
                sendM("name:".$row["Name"],$chat_id,$bot_id);
                sendM("/setname".$row["Id"],$chat_id,$bot_id);
                sendM("/dell".$row["Id"],$chat_id,$bot_id);
                //if chat_id = 0 update
            }
            sendM("تعداد "
            .$sql->get_num_rows ()
            ." زمین بسکتبال ",$chat_id,$bot_id);
            if($sql->get_num_rows ()>9)
            sendM("صفحه  بعدی "
            ." /my".($from+1),$chat_id,$bot_id);

        }
        else{
           sendM(" زمینی برای ارسال نداریم ",$chat_id,$bot_id);
           sendM("/my".(($fr-1)>1?($fr-1):""),$chat_id,$bot_id);
        }
        
    }
    if(substr($text,0,5)=='/dell')
    {
    $uid=substr($text,5,strlen($text)-5);

        if(strlen($uid)>=1 && strlen($uid)<=20)
        {
            //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;
            //todo first select and message to user this is not yours
            $q="UPDATE `vb_playground` SET `Active` = 0 WHERE `Id` ='$uid' and PgTlgrmGroupAdminId='$chat_username' ";
            $sql->query ($q);
            
            $reply.='/active'.$uid;
            
            $content = ['chat_id' => $chat_id, 'text' => $reply];
            $telegram->sendMessage($content);
        
        }
    
    }
}
	
	if ($location != null) 
	{
	    $lat=$location['latitude'];
	    $long=$location['longitude'];
	    //echo $location['latitude'];
	    $reply = "زمین بسکتبال شما دریافت شد : ";

		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		//$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', '', '', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '', '', '$text');");
        //$sql->query ("INSERT INTO `vb_log` (mac, username, password , sender , devicetype , msg , code4digit) VALUES ('', '$chat_username', '','robot serial login','android','serial','$code4digit')");
        $tekrari=0;
        
        // if($sql->query ("select * from vb_playground where PlaygroundLatitude = $lat and PlaygroundLongitude = $long")===TRUE)
        // {
        //     //$row = $result->fetch_assoc();
        //     if ($result->num_rows > 0) 
        //      $tekrari=1;
            
        // }
        //echo $tekrari;
        if($tekrari=='0')
        {
        if($sql->query ("INSERT INTO `vb_playground` (`Id`, `Name`, `PlaygroundType`, `PlaygroundLatitude`, `PlaygroundLongitude`, `desc`, `PgTlgrmGroupAdminId`, `PgTlgrmGroupJoinLink`, `PgTlgrmChannelId`, `PgInstagramId`, `ProvinceId`, `chat_id`) VALUES (NULL, 'توسط  $chat_firstname $chat_lastname از طریق بات', 'bballstreet', $lat, $long, 'اضافه شده توسط $chat_firstname $chat_lastname', '$chat_username', '', '', '', 'IR-07', '$chat_id')")===TRUE)
        {
            $id = $sql->insert_id;
            $reply = "زمین بسکتبال شما ذخیره نشد تکراری بود : ";

        }
        else
            $reply = "زمین بسکتبال شما ذخیره شد : ";

$row_id=0;
        $sql->query ("SELECT * FROM `vb_playground` ORDER BY `Id` DESC limit 1");
        if ($sql->get_num_rows () > 0)
        {
            while($row = mysqli_fetch_assoc ( $sql->get_result () ))
        	{
         	$row_id=$row['Id'];
        	}
        }

		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `playground_id`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname', '$row_id');");
		
        //echo mysql_insert_id();
        //if ($conn->query($sql) === TRUE) {
        
        //$id=$sql->query ("SELECT LAST_INSERT_ID()");
        //echo $id;
        
        $content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
        $reply = "http://berimbasket.ir/bball/www/map.php?lat=".$lat."&long=".$long."&zoom=14&mlat=".$lat."&mlong=".$long."&ProvinceId=&id=".$row_id;
        }
        else
    	    $reply = "زمین بسکتبال شما تکراری است : ";
    	    
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		//@varzeshboard
		//$content = array('chat_id' => "-1001136444717", 'text' => $reply);
		sendMsg($reply,$botToken);
		
		$message = ' #mapbot'.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';
		//echo $message;
        sendMsg($message,$botToken);
        sendMSG2Admin($chat_id_admin,$message.PHP_EOL."/del".$row_id,$botToken);
        sendLoc($chat_id,$lat,$long,$bot_id);
		//@varzeshboard
		sendLoc("-1001136444717",$lat,$long,$botToken);
		sendLoc2Admin($chat_id_admin,$lat,$long,$botToken);
	}
	else
	{
        if(substr($text,0,6)=='/start')
        {
            $adad=substr($text,7,strlen($text)-7);
        	if ( $adad > 0 ) 
        	{
        	    if ($telegram->messageFromGroup()) {
        			$reply = "گروه است اینجا و فقط در خصوصی روبات فعال است در خصوصی پیام بده";
        		}
        		else 
        		{
        		    $reply =$text;
        		    $option = array( array("لینک سایت", "راهنما") );
                // Get the keyboard
        		$keyb = $telegram->buildKeyBoard($option);
        		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
        		$telegram->sendMessage($content);
        		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `command`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text','$botname','1');");
                }
                $reply="http://t.me/berimbasketmapbot?start=".$adad;
        		$content = array('chat_id' => $chat_id, 'text' => $reply);
        		$telegram->sendMessage($content);
        		$msg="یکی از دکمه های کیبورد را انتخاب کنید یا به نقشه از طریق لینک زیر مراجعه کنید".PHP_EOL;
        		$msg.="https://berimbasket.ir/bball/www/";
                mainkeyboard($bot_id,$chat_id,$msg,$sql);
            }
        }
        else
        {
            //sendLoc($chat_id,$lat,$long,"");
            $q="SELECT * FROM `vb_telegrambot` where command=1 and chat_id=$chat_id ORDER BY `id` DESC limit 1";
             $sql->query ($q);
            if ($sql->get_num_rows () > 0)
            {
                if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                	{
                 	$cmd=$row['text'];
// $content = array('chat_id' => $chat_id, 'text' => $cmd.PHP_EOL.'1');
// $telegram->sendMessage($content);
                 	
                 	if($cmd=="/cancel")
                 	{
                       mainkeyboard($bot_id,$chat_id,"با انتخاب یکی از دکمه های کیبورد روبات ما شروع کنید",$sql);
                 	}
                 	else if(substr($cmd,0,6)=="/start")
                 	{
                 	    $adad=substr($cmd,7,strlen($cmd)-7);
                    	if ( $adad > 0 ) 
                    	{
                    	    //پیدا کردن قبلی
                    	    $proplast='';
                            $q="SELECT * FROM `vb_telegrambot` where command=0 and chat_id=$chat_id ORDER BY `id` DESC limit 1";
                            $sql->query ($q);
                            if ($sql->get_num_rows () > 0)
                            {
                                if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                            	{
                             	$proplast=$row['text'];
                            	}
                            }
// $content = array('chat_id' => $chat_id, 'text' => $proplast.PHP_EOL.'2');
// $telegram->sendMessage($content);
    
// $content = array('chat_id' => $chat_id, 'text' => $adad.PHP_EOL.'3');
// $telegram->sendMessage($content);
                		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `command`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text','$botname','0');");
                        $q="SELECT * FROM `vb_telegrambot` where command=0 and chat_id=$chat_id ORDER BY `id` DESC limit 1";
                         $sql->query ($q);
                            if ($sql->get_num_rows () > 0)
                            {
                                if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                            	{
                             	$prop=$row['text'];
                            	}
// $content = array('chat_id' => $chat_id, 'text' => $prop.PHP_EOL.'4');
// $telegram->sendMessage($content);
                                $sql1->query ("SELECT * FROM `vb_bot_commands` where bot='map' and command ='$prop'");
// $content = array('chat_id' => $chat_id, 'text' => $sql1->get_num_rows ().'4.5');
// $telegram->sendMessage($content);
                                if ($sql1->get_num_rows () > 0)
                                {
                                    if($row1 = mysqli_fetch_assoc ( $sql1->get_result () ) )
                                    {
                                        $key_str =$row1 ["buttons"];
                                        $fieldName =$row1 ["fieldName"];
                                        
                                        
// $content = array('chat_id' => $chat_id, 'text' => $key_str.PHP_EOL.'5');
// $telegram->sendMessage($content);
                                        if($key_str)
                                        {
                                        $option []=explode(',',$key_str);
                                        $keyb = $telegram->buildKeyBoard($option);
                                        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'انتخاب کنید'];
                                        $telegram->sendMessage($content);
                                            // //update
                                            // $reply="دستور چیست؟" ;
                                            // $cmd1="فعال";
                                            // $cmd2= "غیرفعال";
                                            // $option = array( array($cmd1
                                            // ,$cmd2) );
                                            $q="SELECT * FROM `vb_playground` where Id=".$adad;
                                            $sql->query ($q);
                                            if ($sql->get_num_rows () > 0)
                                            {
                                                if($row = mysqli_fetch_assoc ( $sql->get_result () ) )
                                                {      
                                                $r="مقدار کنونی فیلد
    "
                                                .$row[$fieldName]
                                                ."
    میباشد";
                                                $content = ['chat_id' => $chat_id, 'text' => $r];
                                                $telegram->sendMessage($content);
                                                }
                                            }
                                            // // Get the keyboard
                                            // $keyb = $telegram->buildKeyBoard($option);
                                            // $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
                                            // $telegram->sendMessage($content);
                                        }
                                        $query =$row1 ["query"];
                                        $reply =$row1 ["reply"];
// $content = array('chat_id' => $chat_id, 'text' => $query.PHP_EOL.'6');
// $telegram->sendMessage($content);
                                        if($query)
                                        {   //$Id=$adad;
                                        $sql->query ($query.$adad);
                                        $content = ['chat_id' => $chat_id, 'text' => $reply];
                                        $telegram->sendMessage($content);
                                        mainkeyboard($bot_id,$chat_id,"دستور",$sql);
                                        }
                                    }
                                }
                                else
                                {
// $content = array('chat_id' => $chat_id, 'text' => '8');
// $telegram->sendMessage($content);
                                    $sql1->query ("SELECT * FROM `vb_bot_commands` where bot='map' and command ='$proplast'");
                                    if ($sql1->get_num_rows () > 0)
                                    {
                                        if($row1 = mysqli_fetch_assoc ( $sql1->get_result () ) )
                                        {
                                            $fieldName =$row1 ["fieldName"];
                                        $reply =$row1 ["reply"];
// $content = array('chat_id' => $chat_id, 'text' => $fieldName.'9');
// $telegram->sendMessage($content);
                	                        $query=	"UPDATE `vb_playground` SET `$fieldName` = '".$prop."' WHERE `vb_playground`.`Id` =";
// $content = array('chat_id' => $chat_id, 'text' => $fieldName.'10');
// $telegram->sendMessage($content);
                                            if($fieldName)
                                            {
                                                //$Id=$adad;
                                            $sql->query ($query.$adad);
// $content = array('chat_id' => $chat_id, 'text' => $query.'11');
// $telegram->sendMessage($content);                              
                                        $content = ['chat_id' => $chat_id, 'text' => $reply];
                                        $telegram->sendMessage($content);
                                            mainkeyboard($bot_id,$chat_id,"دستور",$sql);
                                            }
                                        }
                                    }
                                }
                            }
                        
                    	}
                 	}
            	}
            }
        }
	}
	
	
// 	if ($text == "لینک سایت") {
// 		if ($telegram->messageFromGroup()) {
// 			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
// 		} 
// 		else {
// 		$reply="http://berimbasket.ir/bball/www/default.php";    
// 		$content = array('chat_id' => $chat_id, 'text' => $reply);
// 		$telegram->sendMessage($content);
// 		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text','$botname');");
//         }
// 	}
	
// 	if ($text == "راهنما") {
// 		if ($telegram->messageFromGroup()) {
// 			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
// 		} 
// 		else {
// 		$reply=$help;    
//         // Create option for the custom keyboard. Array of array string
//         $option = array( array("لینک سایت", "راهنما") );

//         // Get the keyboard
// 		$keyb = $telegram->buildKeyBoard($option);
// 		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
// 		$telegram->sendMessage($content);
// 		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text','$botname');");
//         }
// 	}
	
// 	if ($text == "/cancel") {
// 		if ($telegram->messageFromGroup()) {
// 			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
// 		} 
// 		else {
// 		$reply=$help;    
//         // Create option for the custom keyboard. Array of array string
//         $option = array( array("لینک سایت", "راهنما") );

//         // Get the keyboard
// 		$keyb = $telegram->buildKeyBoard($option);
// 		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
// 		$telegram->sendMessage($content);
// 		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`, `command`) VALUES ('', '', '', '', '', '', '$chat_id', '', '', '$chat_username', '$botname', '', '$text','$botname','1');");
//         }
// 	}









//}






//$bot_id = "UCA";
//sendLoc('@varzeshboard',35.35,51.51,$bot_id);

//$response = array ();
//$response [] = getUpd($bot_id);
//echo json_encode ( $response[0]['result'].update_id );



//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");





function mainkeyboard($bot_id,$chat_iD,$replY,$sql){

        // Create option for the custom keyboard. Array of array string

        $sql->query ("SELECT * FROM `vb_bot_commands` where bot='map' and buttons <> ''");
        if ($sql->get_num_rows () > 0)
        {
            $i=0;
            while($row = mysqli_fetch_assoc ( $sql->get_result () ) )
            {
                //$option[];
                $key_str .=$row ["command"].',';
                if($i%2==1)
                {
                $a=explode(',',$key_str);
                $option[] = $a;
                $key_str='';
                }
                $i++;   
            }
            // if($key_str)
            //     {
            //     $option []=explode(',',$key_str);
            //     }
            $telegram = new Telegram($bot_id);
            $keyb = $telegram->buildKeyBoard($option);
            $content = ['chat_id' => $chat_iD, 'reply_markup' => $keyb, 'text' => $replY];    
            $telegram->sendMessage($content);
        }
}

?>