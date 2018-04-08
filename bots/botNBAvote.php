<?php

include 'token.php'; 
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

// Set the bot TOKEN
$bot_token = getToken('botNBAvote');
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botNBAvote';
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

$gameid=0;


// $q="select * from vb_telegrambot where `message_id`= ".$UpdateID;
// $sql->query ($q);

// if ($sql->get_num_rows () == 0) {
    

$q="select * from vb_play_results where vote=1 ORDER BY Id desc limit 1";
$sql->query ($q);

if ($sql->get_num_rows () > 0) {
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $id=$row ["Id"];
    $a=$row["idteama"];
    $b=$row["idteamb"];
    
$gameid=$id;



// $content = ['chat_id' => $chat_id, 'text' => $gameid];
// $telegram->sendMessage($content);
//$arrayResultIds=getTeamInfoByGameId($sql,$gameid);
$q="SELECT * FROM `vb_teams` where Id=".$a;
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a1=$row["Id"];
    $team1=$row["nameen"];
    $team1fa=$row["namefa"];
    

    $q="SELECT * FROM `vb_teams` where Id=".$b;
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a2=$row["Id"];
    $team2=$row["nameen"];
    $team2fa=$row["namefa"];
    
    $arrayResultIds= [$a1,$a2,$team1,$team2,$team1fa,$team2fa];
}


$a="1
**مهمان**
✅".$arrayResultIds[2]
."
✅".$arrayResultIds[4];
        
$b="2
**میزبان**
✅".$arrayResultIds[3]
."
✅".$arrayResultIds[5];
        
        
                    
// $content = ['chat_id' => $chat_id, 'text' => $a];
// $telegram->sendMessage($content);

// $content = ['chat_id' => $chat_id, 'text' => $b];
// $telegram->sendMessage($content);       
        
        
$iscmd=0;
$start=0;
$davataz=0;
    $command = substr($text,0,6);
    if ($text == '/start'||$command=='/start') {
        if($command=='/start')
        $davataz=substr($text,6,strlen($text)-6);


        $start=1;
    }
        
// $content = ['chat_id' => $chat_id, 'text' => $davataz];
// $telegram->sendMessage($content);

// $content = ['chat_id' => $chat_id, 'text' => $text];
// $telegram->sendMessage($content);

// $content = ['chat_id' => $chat_id, 'text' => $gameid];
// $telegram->sendMessage($content);


if(substr($text,0,2)!='/r')
{
    if($gameid>0)
    {

        
        if(substr($text,0,1)!='1' && substr($text,0,1)!='2' )
        {
        $bazi="بازی بین 
        ".$a.
"
".$b;
        
        $content = ['chat_id' => $chat_id, 'text' => $bazi];
        $telegram->sendMessage($content);        
        
        mainkeyboard($bot_token,$chat_id,"یک گزینه از دکمه های روبات یا عدد 1 برای مهمان و عدد 2 برای میزبان انتخاب کن",$a,$b);
        }
        else
        {
            if(substr($text,0,1)=='1' )
            {
                
            $msg='1';
            // $content = ['chat_id' => $chat_id, 'text' => $msg];
            // $telegram->sendMessage($content); 
            }
            if(substr($text,0,1)=='2' )
            {
            $msg='2';
            // $content = ['chat_id' => $chat_id, 'text' => $msg];
            // $telegram->sendMessage($content); 
            }
            $msg=$text.'

نتیجه پیش بینی شما ثبت شد

دیدن نتایج

/results

دعوت دوستات با لینک خودت که در زیر میبینی

شانس برنده شدن شما با دعوت هر نفر و رای گیری دو برابر میشه
';
            $content = ['chat_id' => $chat_id, 'text' => $msg];
            $telegram->sendMessage($content); 
            
            
            printResults($telegram,$botname,$sql,$chat_id,$a,$b,$gameid,0);  

        }
    }
    else
    {
        $msg='بازی و مسابقه ای جهت پیش بینی تعریف نشده است یا 
مدت زمان پیش بینی به اتمام رسیده است
جهت مشاهده آخرین نتایج پیش بینی برگزار شده
اینجا کلیک کنید
/results
        ';
        $content = ['chat_id' => $chat_id, 'text' => $msg];
        $telegram->sendMessage($content);      
    }
}
if(substr($text,0,1)=='/')
{
    if($text=='/results')
    {
    printResults($telegram,$botname,$sql,$chat_id,$a,$b,$gameid,0);  
    
    }
    if(substr($text,0,8)=='/results')
    {
        $gameidd=substr($text,8,strlen($text));
        if($gameidd>0)
        {
        printResults($telegram,$botname,$sql,$chat_id,$a,$b,$gameidd,1);  
        }
    }
    if(substr($text,0,5)=='/send')
    {
        $cid=substr($text,5,strlen($text));
        $msg="شما در روبات پیش بینی نظر دادید و شرکت کردید میشه به من پیام بدین عرض کوچیکی دارم @berimbasket_ir";
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);   
    $content = ['chat_id' => $cid, 'text' => $msg];
    $telegram->sendMessage($content);   
    
    }
    $iscmd=1;
}
else
{
    $msg='
دستوری اینجنین تعریف نشده
لطفا با پشتیبانی تماس بگیرید
@berimbasket_ir
اگر ریپورت هستید
@berimbasketrobot
        ';
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content);   
    
}
$gozine=substr($text,0,1);
$id=0;


//SELECT * FROM `vb_telegrambot` WHERE chat_type=".$gameid." and chat_id=127562196 and botname='botNBAvote' and timestamp >= NOW() - INTERVAL 2 DAY and from_language_code>0 limit 1 



$query_current_info="SELECT * FROM `vb_telegrambot` WHERE chat_type=".$gameid." and chat_id=".$chat_id." and botname='".$botname."'"
//." and timestamp >= NOW() - INTERVAL 2 DAY"
." and from_language_code>0 ORDER BY id DESC limit 1 ";
$sql->query ($query_current_info);

if ($sql->get_num_rows () > 0) {
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $id=$row ["id"];
}


//


// $content = ['chat_id' => $chat_id, 'text' => $iscmd." ".$start." ".$id];
// $telegram->sendMessage($content); 
        
        
if($iscmd!=1&&$start==0)
{
if($id>0)
{
    $q="UPDATE `vb_telegrambot` SET `from_language_code` = ".$gozine." WHERE `vb_telegrambot`.`id` = ".$id;
    $sql->query ($q);
    
 $msg="بروزشد";
 //$msg="بروزشد".$id." ".$gozine;
 
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content); 
}
else
{
$query_insert_log="INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '$gozine', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '$gameid', '', '$text', '$botname');"; 

 $sql->query ($query_insert_log);
 
 $msg="ثبت شد";
    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content); 
}
}


if($start==0)
{
        $votemsg="لینک دعوت دوستات"
        ;
        $content = ['chat_id' => $chat_id, 'text' => $votemsg];
        $telegram->sendMessage($content);
        
        $votemsg="امشب پیش بینی مهم ترین مسابقه ی فردا در NBA رو داریم"
        ." روبات زیر رو استارت کن "
        ."
@t.me/NBAvotebot?start=".$chat_id
        ;
        
        //$channelId
        $content = ['chat_id' => $chat_id, 'text' => $votemsg];
        $telegram->sendMessage($content);
        
        // $reply='https://t.me/NBAvotebot?start='.$chat_id;
        // $content = ['chat_id' => "@aghbaba2", 'text' => $reply];
        // $telegram->sendMessage($content);  
} 
        




function mainkeyboard($bot_token,$chat_iD,$replY,$a,$b){

        // Create option for the custom keyboard. Array of array string
        $option = [
        [$a]
        , [$b]
        //, [''
        //, '']
        //nameunicode
        ];
        // Get the keyboard
        
        $telegram = new Telegram($bot_token);
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_iD, 'reply_markup' => $keyb, 'text' => $replY];    
        $telegram->sendMessage($content);
}

function printResults($telegram,$botname,$sql,$chat_id,$a,$b,$gameid,$who)
{
    
// $content = ['chat_id' => $chat_id, 'text' => $gameid." ".$who." ".$chat_id];
// $telegram->sendMessage($content); 
        
        
        
    $kol=0;
    $guest=0;
    $home=0;
    $query_current_info="SELECT * FROM `vb_telegrambot` WHERE chat_type=".$gameid." and botname='".$botname."'"
    //." and timestamp >= NOW() - INTERVAL 2 DAY "
    ." and from_language_code>0 ";
    
    $sql->query ($query_current_info);
    
    if ($sql->get_num_rows () > 0) {
    $kol=$sql->get_num_rows ();
    }
    
// $content = ['chat_id' => $chat_id, 'text' => $kol." ".$gameid." ".$who." ".$chat_id];
// $telegram->sendMessage($content);         
    
    $query_current_info="SELECT * FROM `vb_telegrambot` WHERE chat_type=".$gameid." and botname='".$botname."'"
    //." and timestamp >= NOW() - INTERVAL 2 DAY "
    ." and from_language_code>0 and from_language_code=1";
    
    $sql->query ($query_current_info);
    
    if ($sql->get_num_rows () > 0) {
    $guest=$sql->get_num_rows ();


// $content = ['chat_id' => $chat_id, 'text' => $guest." ".$kol." ".$gameid." ".$who." ".$chat_id];
// $telegram->sendMessage($content);      

        $guestWho="";
        if($who==1)
        {
        while($row = mysqli_fetch_assoc ( $sql->get_result () ) )
        {
        $guestWho.="
@".$row ["chat_username"]." /send".$row ["chat_id"];
        }
        }
    
    }
    
    
    $query_current_info="SELECT * FROM `vb_telegrambot` WHERE chat_type=".$gameid." and botname='".$botname."'"
    //." and timestamp >= NOW() - INTERVAL 2 DAY"
    ." and from_language_code>0 and from_language_code=2";
    
    $sql->query ($query_current_info);
    
    if ($sql->get_num_rows () > 0) {
    $home=$sql->get_num_rows ();
            
        $homeWho="";
        if($who==1)
        {
        while($row = mysqli_fetch_assoc ( $sql->get_result () ) )
        {
        $homeWho.="
@".$row ["chat_username"]." /send".$row ["chat_id"];
        }
        }
    
    }
// $content = ['chat_id' => $chat_id, 'text' => substr($a,1,strlen($a)-1)." ".$home." ".$guest." ".$kol." ".$gameid." ".$who." ".$chat_id];
// $telegram->sendMessage($content);  

    $msg='نتایج
تعداد کل رای دهندگان تا این لحظه'
.'
'
.$kol
.'
'
.' تعداد رای تیم مهمان 
'.substr($a,1,strlen($a)-1).'
'
.$guest
.'
'.$guestWho
.'
'
.' تعداد رای تیم میزبان
'.substr($b,1,strlen($b)-1).'
'
.$home
.'
'.$homeWho    ;

    $content = ['chat_id' => $chat_id, 'text' => $msg];
    $telegram->sendMessage($content); 
}


function getTeamInfoByGameId($sql,$gameid)
{
    $q="SELECT * FROM `vb_play_results` where Id=".$gameid;
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a=$row["idteama"];
    $b=$row["idteamb"];
    
    
    $q="SELECT * FROM `vb_teams` where Id=".$a;
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a1=$row["Id"];
    $team1=$row["nameen"];
    $team1fa=$row["namefa"];
    

    $q="SELECT * FROM `vb_teams` where Id=".$b;
    $sql->query ($q);
    $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
    $a2=$row["Id"];
    $team2=$row["nameen"];
    $team2fa=$row["namefa"];
    
    return [$a1,$a2,$team1,$team2,$team1fa,$team2fa];
}



//456068819:AAFYj0QPHAL5BpWwawd8m_SW59sqPcqC8hs
// $a="1
// **مهمان**
// ✅Golden State Warriors 
// ✅گلدن استیت واریرز 
// ";
// $b="2
// **میزبان**

// ✅کلیولند کاولیرز
// ✅Cleveland Cavaliers"
// ;
?>