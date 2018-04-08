<?php

include 'token.php'; 
include 'mytelegram.php';
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$bot_token = getToken('botPlayerName');
$telegram = new Telegram($bot_token);

     //sendLog2Channel("#botJomle #$command");
$Group_Id=-1001281813080;

$botname='botPlayerName';
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
$query_current_info="";



    // $content = ['chat_id' => $chat_id, 'text' => "سلام"];
    // $telegram->sendMessage($content);
    
    
    
if($chat_id!=$Group_Id){

    $chat_ch_id=222909344;  //saber aghbaba2
    $chat_ch_id2=434590301; //not found
    $chat_ch_id3=83674896; // not found
    $chat_ch_id4=151370482; //not found
    $chat_ch_id5=127562196; //not found
    
    
    
    $admin=0;
    if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
    $admin=1;
    
    
    if(substr($text,0,1)=='/')
    {
        if($admin==1)
        {
            if(substr($text,0,4)=='/del')
            {
            $message_id=substr($text,4,strlen($text)-4);
            $sql->query("UPDATE vb_telegrambot SET approved=0 WHERE Id= $message_id");
            
            $content = ['chat_id' => $chat_id, 'text' => 'پاک شد'];
            $telegram->sendMessage($content);
            }
    
        }
        if($text=='/start'||$text=='/stop'||$text=='/else')
        {
            $command=$text;
            $text=substr($text, 1, strlen($text)-1);
            $sql->query ("select distinct(text) from vb_telegrambot WHERE chat_type like '%".$text."%' and botname = 'botPlayerName' order by id desc limit 20");
            if ($sql->get_num_rows () > 0) {
            while ( $row = mysqli_fetch_assoc ( $sql->get_result () ) ) {
            	$text= $row ["text"].PHP_EOL.PHP_EOL;
                $content = ['chat_id' => $chat_id, 'text' => $text];
                $telegram->sendMessage($content);
            }
            }
            
            
            sendLog2Channel("#botPlayerName #$command @".$chat_username);
            sendLog2ChannelNBA($bot_token,$Group_Id,"#botPlayerName #$command @".$chat_username);
        }
    }
    else
    {
    $resultarray   = explode(' ',$text);

    $name=trim($resultarray[0]);
    $family=trim($resultarray[1]);



    $sql->query ("select distinct(text) from vb_telegrambot WHERE text like '%".$text."%' and botname = 'botPlayerName' order by id");
     	if ($sql->get_num_rows () == 0) 
     	{
     	    
     	    
        $sql->query ("INSERT INTO `vb_telegrambot` 
        
        (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) 
        
        VALUES 
        
        (NULL, '1', '$botname', '$UpdateID', '$FromID', '$name', '$family', '$from_username', '$from_language_code', '$pushe_id', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$chat_type', '', '$text', CURRENT_TIMESTAMP, '$foaf', '', '', '', '', '', '', '');");	
        
        
            $q="Select * From `vb_telegrambot` order by id desc limit 1";
            $sql->query ($q);
            $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
            
            $delcmd='/del'
            .$row["id"].'
            /vote'
            .$row["id"]
            ;
        
        $text="https://nba-players.herokuapp.com/players/$family/$name
        ".
        PHP_EOL.
        PHP_EOL.
        "دریافت شد و در بانک قرار گرفت"
        .PHP_EOL
        ." و درطبقه بندی"
        ." "
        ."#عکس"
        ." اضافه شد "
        .PHP_EOL
        ."برام یه عکس دیگه بفرست"
        .PHP_EOL 
        
        ." صد تا عکس برسیم شروع میکنیم ".$delcmd
        ;
        
        
        $content = ['chat_id' => $chat_id, 'text' => $text];
        $telegram->sendMessage($content);
    
         sendLog2Channel("#botPlayerName $chat_type".PHP_EOL.$text);
         sendLog2ChannelNBA($bot_token,$Group_Id,"#botPlayerName #$command @".$chat_username.PHP_EOL.$text);
    }
    else
    {
            $text="تکراری ";
        
        $content = ['chat_id' => $chat_id, 'text' => $text];
        $telegram->sendMessage($content);
    
         sendLog2Channel("#botPlayerName $text");
         sendLog2ChannelNBA($bot_token,$Group_Id,"#botPlayerName #$command @".$chat_username);
    }
    }
    // $content = ['chat_id' => 222909344, 'text' => $text];
    // $content = ['chat_id' => 111398115, 'text' => $text];
    // $content = ['chat_id' => 83674896, 'text' => $text];
    // $content = ['chat_id' => 151370482, 'text' => $text];
    // $content = ['chat_id' => 127562196, 'text' => $text];
}
// else
// {
  
    
// }

    
    function sendLog2ChannelNBA($bot_token,$Group_Id,$message){    
        $telegram = new Telegram($bot_token);
        $chat_id = $Group_Id;
    	$content = array('chat_id' => $chat_id, 'text' => $message);
    	$telegram->sendMessage($content);
    }
    
    
    
?>