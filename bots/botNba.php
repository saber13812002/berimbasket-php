<?php
include 'token.php'; 
include ('../../wp-load.php');

include 'Telegram.php';

    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

 
$channel='@berimbasket';
$channelId=-2147483648;

$botTokenmj = getToken("mj23");
// Set the bot TOKEN
$bot_token = get('botNba');
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botNba';
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
$caption =$telegram->Caption();
//  $VoiceFileID = $telegram->VoiceFileID();
$getUpdateType = $telegram->getUpdateType();
// Test CallBack


$chat_ch_id=222909344;  //saber aghbaba2
$chat_ch_id2=434590301; //not found
$chat_ch_id3=83674896; // not found
$chat_ch_id4=151370482; //not found
$chat_ch_id5=127562196; //not found



$admin=0;
if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
$admin=1;


//$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`  ) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$botname', '', '$text', '$botname' );"; 

if(substr($text,0,1)=='/')
{
    if($admin==1)
    {
        if(substr($text,0,4)=='/del')
        {
        $message_id=substr($text,4,9);
        $sql->query("UPDATE vb_play_results SET approved=0 WHERE Id= $message_id");
        
        $content = ['chat_id' => $chat_id, 'text' => 'پاک شد'];
        $telegram->sendMessage($content);
        }
        if(substr($text,0,12)=='/sendchannel')
        {
        $message_id=substr($text,12,strlen($text)-12);
        
        $votemsg="امشب پیش بینی مهم ترین مسابقه ی فردا در NBA رو داریم"
        ." روبات زیر رو استارت کن "
        ."
        @t.me/NBAvotebot?start=".$chat_id
        ;
        
        
        //$channelId
        $content = ['chat_id' => $chat_id, 'text' => $votemsg];
        $telegram->sendMessage($content);
        
        $reply='https://t.me/NBAvotebot?start='.$chat_id;
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);  
        
        }
        if(substr($text,0,5)=='/vote')
        {
        $message_id=substr($text,5,strlen($text)-5);
        $sql->query("UPDATE vb_play_results SET vote=1 WHERE Id= $message_id");
        //UPDATE `vb_play_results` SET `vote` = '1' WHERE `vb_play_results`.`Id` = 1;

        $content = ['chat_id' => $chat_id, 'text' => 'نظرسنجی شروع شد'];
        $telegram->sendMessage($content);
        
            $msg1='            
            /del'
            .$message_id.'
            /vote'
            .$message_id.'
            /cvote'
            .$message_id.'
            /send'
            .$message_id.'
            /sendchannel'
            .$message_id;
            $content = ['chat_id' => $chat_id, 'text' => $msg1];
            $telegram->sendMessage($content);
        }
        if(substr($text,0,6)=='/cvote')
        {
        $message_id=substr($text,6,strlen($text)-6);
        $sql->query("UPDATE vb_play_results SET vote=0 WHERE Id= $message_id");
        //UPDATE `vb_play_results` SET `vote` = '1' WHERE `vb_play_results`.`Id` = 1;

        $content = ['chat_id' => $chat_id, 'text' => 'نظرسنجی قطع شد'];
        $telegram->sendMessage($content);
        
            $msg1='            
            /del'
            .$message_id.'
            /vote'
            .$message_id.'
            /cvote'
            .$message_id.'
            /send'
            .$message_id.'
            /sendchannel'
            .$message_id;
            $content = ['chat_id' => $chat_id, 'text' => $msg1];
            $telegram->sendMessage($content);
        }
        if(substr($text,0,6)=='/admin')
        {
        $message_id=substr($text,6,20);
        $sql->query("Insert into vb_telegrambot id= $message_id");
        
        $content = ['chat_id' => $chat_id, 'text' => 'ادمین شد'];
        $telegram->sendMessage($content);
        }
        if(substr($text,0,6)=='/start')
        {
            $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین هستید شروع کنید'];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_ch_id, 'text' => 'یک ادمین شروع کرد '
            .PHP_EOL
            .'/noadmin'
            .$chat_id
            ];
            $telegram->sendMessage($content);
        }
    }
    else 
    {
        if(substr($text,0,6)=='/start')
        {
            $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین نیستید درخواست ادمین شدن شما برای ادمین ارسال شد اگر ایشان موافقت کند شما هم میتوانید از روبات استفاده کنید'];
            $telegram->sendMessage($content);
            $content = ['chat_id' => $chat_ch_id, 'text' => 'درخواست ادمین شدن '
            .PHP_EOL
            .'/admin'
            .$chat_id
            ];
            $telegram->sendMessage($content);
        }
    }
}
else
{
// log works 20180103
$query_insert_log="INSERT INTO `vb_telegrambot` (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES (NULL, '1', '$botname', '$UpdateID', '$FromID', '$FromChatID', '$FromChatID', '', '', '', '$chat_id', '', '', '', '', '', '$text', CURRENT_TIMESTAMP, '', '', '', '', '', '', '', '');";

//, `quarter`
//, '$quarter'
$sql->query ($query_insert_log);
		
if ( (!is_null($text)||!is_null($getUpdateType)) && !is_null($chat_id) && !is_null($chat_username)) {


$resultarray   = explode(',',$text);

if(sizeof($resultarray) >3 ){
    
    if(sizeof(strtolower($resultarray[0])) > 3)
    $arrayResultIds=getTeamIdByLastName($sql,strtolower($resultarray[0]),strtolower($resultarray[1]));
    else
    $arrayResultIds=getTeamIdBy3Char($sql,strtolower($resultarray[0]),strtolower($resultarray[1]));
    

    
    
    if($arrayResultIds[0]>0 && $arrayResultIds[1]>0)
    {
        // $content = ['chat_id' => $chat_id, 'text' => $arrayResultIds[0].' '.$arrayResultIds[1]];
        // $telegram->sendMessage($content);
                
        
        $q="select * from  `vb_play_results` where `idteama`=".$arrayResultIds[0]." and `idteamb`=".$arrayResultIds[1]." and `scorea`=".$resultarray[2]." and  `scoreb` = ".$resultarray[3]."  and timestamp >= NOW() - INTERVAL 2 DAY and approved=1 limit 1";
        $sql->query ($q);
        if ($sql->get_num_rows () == 0)
        {
            
            $q="INSERT INTO `vb_play_results` (`Id`, `idteama`, `idteamb`, `scorea`, `scoreb`) VALUES (NULL, '".$arrayResultIds[0]."', '".$arrayResultIds[1]."', '".$resultarray[2]."', '".$resultarray[3]."');"; //$resultarray
            $sql->query ($q);
            
            
            $winner='✅';
            $loser='❌';
            $t1=$winner;
            $t2=$winner;
            
            $q="Select * From `vb_play_results` order by Id desc limit 1";
            $sql->query ($q);
            $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
            
            if($resultarray[2]>$resultarray[3])
            {$t1=$winner;$t2=$loser;}
            else if($resultarray[2]<$resultarray[3])
            {$t2=$winner;$t1=$loser;}
            
            
            $msg=""
            .$t1
            .$arrayResultIds[4]
            ." - "
            .$t2
            .$arrayResultIds[5]
            .PHP_EOL
            .$t1
            .$arrayResultIds[2]
            ." - "
            .$t2
            .$arrayResultIds[3]
            .PHP_EOL
            .$resultarray[2]
            ." - "
            .$resultarray[3]
            
            .PHP_EOL
            .$resultarray[4]
;
            
            //".$arrayResultIds[1]."
            
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content);
            
            
            $msg1='/del'
            .$row["Id"].'
            /vote'
            .$row["Id"]
            ;
            
            $content = ['chat_id' => $chat_id, 'text' => $msg1];
            $telegram->sendMessage($content);
            
            
            sendMsg("#Nba #boxscore "
            .PHP_EOL
            .$msg.' '.$msg1
            .' @'
.$chat_username
         .PHP_EOL,$botTokenmj
);
        }
        else
        {
            $content = ['chat_id' => $chat_id, 'text' => 'این نتیجه قبلا ثبت شده است'];
            $telegram->sendMessage($content);
            sendMsg('این نتیجه قبلا ثبت شده است',$botTokenmj);
            
            // update 
            if(sizeof($resultarray) >5 )
            {
            $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
            $iidd=$row['Id'];
            
          
            
            $winner='✅';
            $loser='❌';
            $t1=$winner;
            $t2=$winner;
            
            
            
            $q="UPDATE `vb_play_results` SET `scorea` = ".$resultarray[4]." , `scoreb` =  ".$resultarray[5]." WHERE `vb_play_results`.`Id` =".$iidd;

            if($resultarray[4]>$resultarray[5])
            {$t1=$winner;$t2=$loser;}
            else if($resultarray[4]<$resultarray[5])
            {$t2=$winner;$t1=$loser;}
            
//, `quarter` = '".$resultarray[6]."'

            $sql->query ($q);
            
            $m1="#updateresult ".$iidd;
            
            $content = ['chat_id' => $chat_id, 'text' => $m1];
            $telegram->sendMessage($content);
            //sendMsg( $m1,$botTokenmj);  
            
            $m2=
            $t1
            .$arrayResultIds[4]
            ." - "
            .$t2
            .$arrayResultIds[5]
            .PHP_EOL
            .$t1
            .$arrayResultIds[2]
            ." - "
            .$t2
            .$arrayResultIds[3]
            .PHP_EOL
            .$resultarray[4]
            ." - "
            .$resultarray[5]
            ;
            //.'http://berimbasket.ir/bball/www/score.php?id='
            

            $content = ['chat_id' => $chat_id, 'text' => $m2];
            $telegram->sendMessage($content);
            //sendMsg( $m2,$botTokenmj);  
            
            $m3='/del'
            .$row["Id"].'
            /vote'
            .$row["Id"]
            ;
            
            $content = ['chat_id' => $chat_id, 'text' => $m3];
            $telegram->sendMessage($content);
            sendMsg( $m1.' '
            .PHP_EOL.$m2.' '
            .PHP_EOL.$m3,$botTokenmj);  
            
            $stringtitle=
            'نتایج مسابقات NBA تیم های'
            ." "
            .$arrayResultIds[4]
            ." - "
            .$arrayResultIds[5]
            .' '
            .$arrayResultIds[2]
            ." - "
            .$arrayResultIds[3]
            .' '
            .$resultarray[4]
            ." - "
            .$resultarray[5];
            $stringbody=$stringtitle;
            
//               $iiiid = wp_insert_post(array(
//             'post_title' => $stringtitle,
//                 //'post_type' => 'booking',
//                 //
//                 //            'post_type' => 'page',
//                 'post_type' => 'post',
                
//                 'post_status' => 'publish',
//         'post_author'    => '1'
//                 , 'post_content'=>$stringbody
//                 //,'post_name' => $pagename
//                 ,'tags_input'     => "نتایج,NBA",
//             ));
            
// 			$reply = "https://berimbasket.ir/?p=".$iiiid;
// 			$content = array('chat_id' => $chat_id ,'text' => $reply);
// 			$telegram->sendMessage($content);
			
            }
            
        }
    }
    else
    {
        if( $arrayResultIds[1]>0)
            $msg= 'نام تیم اول درست نیست';
            
        $content = ['chat_id' => $chat_id, 'text' => $msg];
        $telegram->sendMessage($content);
        
        if( $arrayResultIds[0]>0)
            $msg= 'نام تیم دوم درست نیست';
        
        $content = ['chat_id' => $chat_id, 'text' => $msg];
        $telegram->sendMessage($content);
        
        sendMsg($msg,$botTokenmj);
    }
}
else
{
    $content = ['chat_id' => $chat_id, 'text' => 'ساختار ارسال دستور صحیح نیست'];
    $telegram->sendMessage($content);
    
    sendMsg( 'ساختار ارسال دستور صحیح نیست',$botTokenmj);
}




    }
    else
    {
        if($chat_id<0)
        {
    $content = ['chat_id' => $chat_id, 'text' => ' شما ادمین نیستید '];
    $telegram->sendMessage($content);
            
        }
    $content = ['chat_id' => $chat_ch_id, 'text' => $chat_id.' ایشان ادمین نیستند '];
    $telegram->sendMessage($content);
    }

}


function getTeamIdBy3Char($sql,$a,$b)
{
    $q="SELECT * FROM `vb_teams` where espn=LOWER('$a')";
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a1=$row["Id"];
    $team1=$row["nameen"];
    $team1fa=$row["namefa"];
    

    $q="SELECT * FROM `vb_teams` where espn=LOWER('$b')";
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a2=$row["Id"];
    $team2=$row["nameen"];
    $team2fa=$row["namefa"];
    
    return [$a1,$a2,$team1,$team2,$team1fa,$team2fa];
}

function getTeamIdByLastName($sql,$a,$b)
{
    $q="SELECT * FROM `vb_teams` where name_abbr=LOWER('$a')";
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a1=$row["Id"];
    $team1=$row["name_abbr"];
    $team1fa=$row["namefa"];
    

    $q="SELECT * FROM `vb_teams` where name_abbr=LOWER('$b')";
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a2=$row["Id"];
    $team2=$row["name_abbr"];
    $team2fa=$row["namefa"];
    
    return [$a1,$a2,$team1,$team2,$team1fa,$team2fa];
}

    
function sendMsg($message,$bot_id){
    $telegram = new Telegram($bot_id);
    $chat_id = '-1001136444717';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}


?>