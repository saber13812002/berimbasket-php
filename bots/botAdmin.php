<?php
include 'token.php'; 
include 'Telegram.php';
include '_Profile.php';
// include 'goo.gl.php' ;
include '../Pushe.php';

include __DIR__ . '/db_connect.php';
$sql = new DB ();

// move to token.php like config php
// $chat_ch_id=23452345234;  
// $chat_ch_id2=23452345234; //not found
// $chat_ch_id3=23452345234; // not found
// $chat_ch_id4=23452345234; //not found
// $chat_ch_id5=23452345234; //not found

// Set the bot TOKEN
$bot_token = getToken('botAdmin');
// Instances the class
$telegram = new Telegram($bot_token);

$botname='botAdmin';



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


// log work 20180103
$sql->query ("INSERT INTO `vb_telegrambot` (`id`, `approved`, `botname`, `message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `pushe_id`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `timestamp`, `foaf`, `file_id`, `file_type`, `file_size`, `width`, `height`, `duration`, `mime_type`) VALUES (NULL, '1', '$botname', '$UpdateID', '', '', '', '', '', '', '$chat_id', '', '', '', '', '', '$text', CURRENT_TIMESTAMP, '', '$file_id', '$file_type', '', '', '', '', '');");


$admin=0;
if($chat_id==$chat_ch_id ||$chat_id==$chat_ch_id2 || $chat_id==$chat_ch_id3 ||$chat_id==$chat_ch_id4||$chat_id==$chat_ch_id5 )
$admin=1;

    if($admin==1)
    {
        $msg="لطفا با ادمین بریم بسکت تماس بگیرید";
        if(substr($text,0,3)=='pid')
        {
            
            sendPushestadium($text,"title","text",151);
            
            
// $msgZamineShomaSabtShod="زمین شما ثبت شد کلیک جهت مشاهده";
//         	sendPusheNewPG($text,$msgZamineShomaSabtShod,"https://berimbasket.ir/bball/www/instagram.php?id=3259");
            //sendPushe($text
            // ,$msg
            // ,$msg);
        }
        
        if(substr($text,0,3)=='Cid')
        {
            $cid=substr($text,3,strlen($text)-3);
            $bot_token =  getToken("botSign");
            // Instances the class
            $telegram = new Telegram($bot_token);
            
            $content = ['chat_id' => $cid, 'text' => $msg.PHP_EOL."@berimbasket_ir"];
            $telegram->sendMessage($content);
        }
    }
    
    
if(substr($text,0,1)=='/')
{
    if($admin==1)
    {
        if(substr($text,0,6)=='/pass.')
        {
        $pass=substr($text,6,strlen($text)-6);
        $reply='';
        $username='';
        //$reply=getUsernameByPassword($text,$sql);
        
            if(strlen($pass)>=2 && strlen($pass)<=20)
            {    
                
        
        
                $q="SELECT * FROM `vb_user` WHERE password='$pass'";
                $sql->query ($q);
                //$number = $sql->get_num_rows ();
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    $username=$row ["username"].PHP_EOL;
                    // if($x==null||$x=="")
                    //   $x=0;
                    if($username)
                        $reply.=$username;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
            }
        }
        //http://www.espn.com/nba/scoreboard/_/date/20180324
        if(substr($text,0,6)=='/espn.')
        {
            $date=substr($text,6,strlen($text)-6);
            $url='http://www.espn.com/nba/scoreboard/_/date/'.$date;
            if(strlen($date)>=2 && strlen($date)<=20)
            {
                //$resultarray   = explode('.',$date);

                $array = file($url);
                $linejson='';
                
                foreach($array as $line)
                {
                
                    //echo $line;
                    // do other stuff here
                    if(strpos($line, 'window.espn.scoreboardData 	= ') !== false)
                    {
                    $end="}}}]}";
                    $linejson=$line;
                    
                    $jsonindexstart=strpos($line, 'window.espn.scoreboardData 	= ');
                        if($jsonindexstart>1)
                        {
                            $jsonindexend=strpos($line, $end);
                            $jsonlen=strlen($line);
                            $str=substr($line,$jsonindexstart+30,-291);
                            $strf=substr($str,0,100);
                            $stre=substr($str,-100);
                            
                            $linejson=json_decode($str);
                            
                        $content = ['chat_id' => $chat_id, 'text' => $strf.PHP_EOL.$stre];
                        $telegram->sendMessage($content); 
                        }
                    
                    $str='';
                    foreach ($linejson->leagues as $l) {
                       $str=($l->name);
                    }
                    
                    $content = ['chat_id' => $chat_id, 'text' =>$str];
                    $telegram->sendMessage($content);
                    
                    
                    
                    $str='';
                  foreach ($linejson->events as $e) {
                      //$str=($e->competitions[0]->competitors->score);
                      //$str=($e->date);
                      foreach ($e->competitions as $cmpt) {
                          //$str.=($cmpt->date);
                          $scoreb=0;
                          $teamb='';
                          foreach ($cmpt->competitors as $compet) {
                            
                            if($scoreb==0){
                                $scoreb=($compet->score);
                                $teamb=($compet->team->abbreviation=='UTAH'?'UTA':$compet->team->abbreviation);
                            }
                            else
                                $str=($compet->team->abbreviation=='UTAH'?'UTA':$compet->team->abbreviation).','.$teamb.','.($compet->score).','.$scoreb;
                          }
                          
                    $content = ['chat_id' => $chat_id, 'text' =>$str];
                    $telegram->sendMessage($content);
                    $str='';
                      }
                      //$str.=($e[0]->competitions[0]->competitors->venue->abbrevation);
                    }
                    
                    
                    
                    }
                }
                

            }
        }
        if(substr($text,0,13)=='/send2allespn')
        {
            sendByPusheLinkNBA();
        }
        if(substr($text,0,4)=='/all')
        {
         //$limit=substr($text,4,strlen($text)-4);

            //if(strlen($from_id)>=1 && strlen($from_id)<=20)
            {
                $q="SELECT  DISTINCT(chat_id) FROM `vb_telegrambot` where  botname LIKE 'bot%'  order by id DESC limit 10";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    $c_id=$row ["chat_id"].PHP_EOL;
                    //$id=$row ["id"];

                    if($c_id){
                        $reply='/getprofile'.$c_id;
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                        
                    }
                    }
                    // $content = ['chat_id' => $chat_id, 'text' => $reply];
                    // $telegram->sendMessage($content);
                }
            }
        
        }
        
        if(substr($text,0,13)=='/robotStarter')
        {
         //$limit=substr($text,4,strlen($text)-4);

            //if(strlen($from_id)>=1 && strlen($from_id)<=20)
            
                $q="SELECT DISTINCT(chat_username) FROM `vb_telegrambot` where  botname LIKE 'bot%' order by id DESC LIMIT 100";
                $sql->query ($q);
                $sql1 = new DB ();

                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                        $reply.= '@'.$row ["chat_username"];
                        $ch_user=$row ["chat_username"];
                        $q1="SELECT chat_id FROM `vb_telegrambot` where  chat_username = '$ch_user' order by id DESC LIMIT 1";
                        $sql1->query ($q1);
                        if ($sql1->get_num_rows () >0)
                        {
                        if($row1 = mysqli_fetch_assoc ( $sql1->get_result () ))
                        {
                            $reply.=" /presented".$row1["chat_id"];
                        }
                        $reply.=PHP_EOL;
                        }
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                    // $content = ['chat_id' => $chat_id, 'text' => $reply];
                    // $telegram->sendMessage($content);
                }
            
        
        }
        if(substr($text,0,10)=='/presented')
        {
        $uid=substr($text,10,strlen($text)-10);

            if(strlen($uid)>=2 && strlen($uid)<=20)
            {
                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="UPDATE `vb_user` SET `presented` = '1' WHERE `vb_user`.`chat_id` ='$uid'";
                $sql->query ($q);
                
                $reply.='/nopresented'.$uid;
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,4)=='/del')
        {
        $from_id=substr($text,4,strlen($text)-4);

            if(strlen($from_id)>=2 && strlen($from_id)<=20)
            {
                $q="SELECT * FROM `vb_user` WHERE chat_id='$from_id'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    $username=$row ["username"].PHP_EOL;
                    $id=$row ["id"];

                    if($username)
                        $reply.='/dell'.$id.' : '.$username;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
            }
        
        }
        if(substr($text,0,5)=='/dell')
        {
        $uid=substr($text,5,strlen($text)-5);

            if(strlen($uid)>=2 && strlen($uid)<=20)
            {
                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` ='$uid'";
                $sql->query ($q);
                
                $reply.='/active'.$uid;
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,7)=='/active')
        {
        $uid=substr($text,7,strlen($text)-7);

            if(strlen($uid)>=2 && strlen($uid)<=20)
            {
                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="UPDATE `vb_user` SET `active` = '1' WHERE `vb_user`.`id` ='$uid'";
                $sql->query ($q);
                
                $reply.='/dell'.$uid;
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,9)=='/setbyun,')
        {
        $cmdstr=substr($text,9,strlen($text)-9);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="UPDATE `vb_user` SET `".$resultarray[1]."` = '".$resultarray[2]."' WHERE `vb_user`.`username` ='".$resultarray[0]."'";
                $sql->query ($q);
                
                $reply.='/done'.$resultarray[0];
                
                $content = ['chat_id' => $chat_id, 'text' => $q];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,9)=='/setbyid,')
        {
        $cmdstr=substr($text,9,strlen($text)-9);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="UPDATE `vb_user` SET `".$resultarray[1]."` = '".$resultarray[2]."' WHERE `vb_user`.`id` ='".$resultarray[0]."'";
                $sql->query ($q);
                
                $reply.='/done'.$resultarray[0];
                
                $content = ['chat_id' => $chat_id, 'text' => $q];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,5)=='/add,')
        {
        $cmdstr=substr($text,5,strlen($text)-5);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                //UPDATE `vb_user` SET `active` = '0' WHERE `vb_user`.`id` = 4;

                $q="INSERT INTO `vb_user` ( `timestamp`,`username`,`password`,`telegram`,`chat_id` ) VALUES ( CURRENT_TIMESTAMP, '".$resultarray[1]."' , '".$resultarray[2]."' , '".$resultarray[1]."' , ".$resultarray[0].")";
                $sql->query ($q);
                
                $reply.='/getprofile'.$resultarray[0].'
                /del'.$resultarray[0];
                
                $content = ['chat_id' => $chat_id, 'text' => $q];
                $telegram->sendMessage($content);
            
            }
        
        }
        if(substr($text,0,12)=='/getattbyid,')
        {
        $cmdstr=substr($text,12,strlen($text)-12);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `vb_user` WHERE id='".$resultarray[0]."'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    $telegram->sendMessage($content);
                    
                    $field=$resultarray[1];    
                    $att=$row [$field].PHP_EOL;
                    $id=$row ["id"];

                    //if($username)
                        $reply='/del'.$id.' : '.$att;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }
        if(substr($text,0,11)=='/getprofile')
        {
        $cmdstr=substr($text,11,strlen($text)-11);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                //$resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `vb_user` WHERE chat_id='".$cmdstr."'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    $telegram->sendMessage($content);
                    }
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                
                $reply='/add,'.$chat_id.',un';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }
        //getPG
        if(substr($text,0,6)=='/getPG')
        {
        $from_id=substr($text,6,strlen($text)-6);
        $reply='';


                        
            $q1="SELECT * FROM `vb_user` where  chat_id=".$from_id." ORDER BY `id` DESC";
            $sql->query ($q1);
            if ($sql->get_num_rows () >0)
            {
                if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                {
                $PgTlgrmGroupAdminId=$row["telegram"];
                }
            }
$content = ['chat_id' => $chat_id, 'text' => $PgTlgrmGroupAdminId];
$telegram->sendMessage($content);  


$q2="SELECT * FROM `vb_playground` where `PlaygroundType` <> 'userloc' and Active=1 and (PgTlgrmGroupAdminId='".$PgTlgrmGroupAdminId."') ";


//and `PgTlgrmGroupAdminId` = ".$PgTlgrmGroupAdminId;
            
            $sql->query ($q2);
            $count=0;
            if ($sql->get_num_rows () >0)
            {
                // while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                // {
                //     $PgTlgrmGroupAdmin=$row["PgTlgrmGroupAdminId"];
                //     if(strtolower($PgTlgrmGroupAdminId)==strtolower($PgTlgrmGroupAdmin))
                //             $count++;
                // }
            $count=$sql->get_num_rows ();
            $content = ['chat_id' => $chat_id, 'text' => $count];
            $telegram->sendMessage($content); 
            }
            
            $url="http://berimbasket.ir/bball/www/map3.php?username=".$PgTlgrmGroupAdminId."&id=";

            $content = ['chat_id' => $chat_id, 'text' => $url];
            $telegram->sendMessage($content);             
            
        }
        if(substr($text,0,12)=='/sendprofile')
        {
        $cmdstr=substr($text,12,strlen($text)-12);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                //$resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `vb_user` WHERE chat_id='".$cmdstr."'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                //if(1==1)
                {
                    if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    
                    {

                    $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    $telegram->sendMessage($content);
                    
                    $bot_token =  getToken("botSign");
                    // Instances the class
                    $telegram = new Telegram($bot_token);

                    $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    $telegram->sendMessage($content);
                    }
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply.$cmdstr];
                $telegram->sendMessage($content);
                }
            }
        }
        if(substr($text,0,13)=='/sendmsgtmpl,')
        {
        $cmdstr=substr($text,13,strlen($text)-13);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `vb_telegrambot` WHERE message_id=248656231";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                //if(1==1)
                {
                    if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    
                    {
                    $msg=$row['text'];
                    $search='Telegramid';
                    
                    $sql2 = new DB ();
                    $q2="SELECT * FROM `vb_user` WHERE chat_id='".$resultarray[0]."'";
                    $sql2->query ($q2);
                    
                    if ($sql2->get_num_rows () >0)
                    {
                        if($row2 = mysqli_fetch_assoc ( $sql2->get_result () ))
                        {
                        
                        $field='chat_username';    
                        $att=$row [$field].PHP_EOL;
                        }
                        
                    }
                    $chat_usernameYaroo=$att;
                    if($chat_usernameYaroo)
                    $msg=strtr ($msg, array ($search => $chat_usernameYaroo));


                    $content = ['chat_id' => $chat_id, 'text' => $msg];
                    $telegram->sendMessage($content);
                    
                    $bot_token =  getToken("botSign");
                    // Instances the class
                    $telegram = new Telegram($bot_token);

                    $content = ['chat_id' => $resultarray[0], 'text' => $msg];
                    $telegram->sendMessage($content);
                    }
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply.$cmdstr];
                $telegram->sendMessage($content);
                }
            }
        }
        if(substr($text,0,12)=='/getattbyun,')
        {
        $cmdstr=substr($text,12,strlen($text)-12);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `vb_user` WHERE username='".$resultarray[0]."'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    if($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    $telegram->sendMessage($content);
                    
                    $field=$resultarray[1];    
                    $att=$row [$field].PHP_EOL;
                    $id=$row ["id"];

                    //if($username)
                        $reply='/del'.$id.' : '.$att;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }
        
        if(substr($text,0,8)=='/select,')
        {
        $cmdstr=substr($text,8,strlen($text)-8);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                $q="SELECT * FROM `".$resultarray[1]."` WHERE ".$resultarray[2]." LIKE '%".$resultarray[3]."%' order by id desc limit 10";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    // $content = ['chat_id' => $chat_id, 'text' => getProfile($row)];
                    // $telegram->sendMessage($content);
                    
                    $field=$resultarray[0];    
                    $att=$row [$field].PHP_EOL;
                    $id=$row ["id"];
                    $c_id=$row ["chat_id"];

                    //if($username)
                        $reply='/del'.$c_id.' : '.$att.'/getprofile'.$c_id.''.PHP_EOL.'/sendprofile'.$c_id.''.PHP_EOL.'/sendmsgtmpl'.$c_id;
                        
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                    }
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }//SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'tbl_name'
        
        if(substr($text,0,12)=='/getcolumns,')
        {
        $cmdstr=substr($text,12,strlen($text)-12);

            if(strlen($cmdstr)>=2 && strlen($cmdstr)<=40)
            {
                $resultarray   = explode(',',$cmdstr);

                $q="SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$resultarray[0]."'  AND table_schema = 'jyvfiltw_bbdb'";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    $field="COLUMN_NAME";    
                    $att.=$row [$field].PHP_EOL;
                    //$id=$row ["id"];

                    //if($username)
                        $reply='/del'.' : '.$att;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }
        if(substr($text,0,10)=='/gettables')
        {
        //$cmdstr=substr($text,10,strlen($text)-10);

            if(1==1)
            {
                //$resultarray   = explode(',',$cmdstr);

                $q="SHOW TABLES FROM jyvfiltw_bbdb";
                $sql->query ($q);
                
                if ($sql->get_num_rows () >0)
                {
                    while($row = mysqli_fetch_assoc ( $sql->get_result () ))
                    {
                    
                    $field="Tables_in_jyvfiltw_bbdb";    
                    $att.=$row [$field].PHP_EOL;
                    //$id=$row ["id"];

                    //if($username)
                        $reply='/del'.' : '.$att;
                    }
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                }
                else
                {
                $reply.='آِ دی نداریم';
                
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
                }
            }
        }
        if(substr($text,0,5)=='/help')
        {
            
            $reply.='#help
pid
Cid
/pass.
/all
/del
/dell
/active
/setbyun,
/setbyid,
/add,
/getattbyid,
/getprofileallrobotStarter
/getPG
/sendprofile
/sendmsgtmpl,
/getattbyun,
/select
/getcoloumns
/gettables
/robotStarter
/help';
            
            $content = ['chat_id' => $chat_id, 'text' => $reply];
            $telegram->sendMessage($content);
        }
    }
}
else
{
    if($admin==1&&$FromID>0)
    {
        $commands='/del'.$FromID.''.PHP_EOL.'/getprofile'.$FromID.''.PHP_EOL.'/sendprofile'.$FromID.''.PHP_EOL.'/sendmsgtmpl'.$FromID.''.PHP_EOL.'/getLoc'.$FromID.''.PHP_EOL.'/getPG'.$FromID;
        $content = ['chat_id' => $chat_id, 'text' => $commands];
        $telegram->sendMessage($content);
    }
} 
        
// function getUsernameByPassword($text,$sql)
// {
//     $query_current_info="Select * From vb_user where password=".$text;
//     $sql->query ($query_current_info);
//     $number = $sql->get_num_rows ();
    
//     if ($number > 0)
//     {
//         $row = mysqli_fetch_assoc ( $sql->get_result () ) ;
//         $username=$row ["username"];
//         // if($x==null||$x=="")
//         //   $x=0;
        
//     }
//     return $username.' - '.$number;
// }



?>