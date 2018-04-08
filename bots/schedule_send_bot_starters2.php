<?php

include ('../../wp-load.php');
include 'Telegram.php';
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

////////////////////////////////JOMLE/////////////////////////////////
$bot_token = getToken('botJomle');
$telegram = new Telegram($bot_token);
$text= "برام یه جمله بفرست درباره #بسکت #بازی_سگا #استریت #خاطره #مسابقات NBA یا AND1 یا بسکتبال بانوان یا مسابقات #توکیو یا پروفایل فیبا3به3 یا توییت یا ";
$content = ['chat_id' => 222909344, 'text' => $text];
$telegram->sendMessage($content);

// $content = ['chat_id' => 111398115, 'text' => $text];
// $telegram->sendMessage($content);

// $content = ['chat_id' => 83674896, 'text' => $text];
// $telegram->sendMessage($content);

// $content = ['chat_id' => 151370482, 'text' => $text];
// $telegram->sendMessage($content);

// $content = ['chat_id' => 127562196, 'text' => $text];
// $telegram->sendMessage($content);
////////////////////////////////////////////////////////////////


// find a valid postid
$post_id=0;
$sql->query ("SELECT * FROM `vb_log` where devicetype='bottwitter'  and password >0  ORDER BY  rand() limit 1" );
if ($sql->get_num_rows () > 0) {
    if( $row = mysqli_fetch_assoc ( $sql->get_result()))
    $post_id= $row["password"];
}

$content = ['chat_id' => 222909344, 'text' => $post_id];
$telegram->sendMessage($content);

// $text= "post_id  :".$post_id;
// $content = ['chat_id' => 222909344, 'text' => $text];
// $telegram->sendMessage($content);

if($post_id>0)
{
    // fetch a commentid,text
    $sql->query ("select * from vb_telegrambot WHERE chat_type like '%bball%' and foaf=0 order by id limit 1");
    if ($sql->get_num_rows () > 0) {
        if( $row = mysqli_fetch_assoc ( $sql->get_result()))
        $comment= $row["text"];
        $commentid= $row["id"];
        $chat_first_name= $row["chat_first_name"];
        $chat_last_name= $row["chat_last_name"];
        $chat_username= $row["chat_username"];
        $sender_chat_id= $row["chat_id"];
    }
    
    
$content = ['chat_id' => 222909344, 'text' => $commentid];
$telegram->sendMessage($content);
// $text= "commentid  :".$commentid;
// $content = ['chat_id' => 222909344, 'text' => $text];
// $telegram->sendMessage($content);

    $text='بسکتبال خیلی ورزش خوبیه و طرح شما هم طرح خوبیه منتها سوال اینه که اپل هم دارید؟';

    if($commentid>0)
    {
    // send to post id
    // send to post id
    //$post_id

	$comid=setComment($post_id
		,$chat_first_name
		,$chat_last_name //'صابر'
		,$comment
		);
    //tik comment as used
        
$text= "$chat_first_name $chat_last_name commentid  :".$comid .' '. $comment .PHP_EOL.'https://berimbasket.ir/?p='.$post_id;
$content = ['chat_id' => 222909344, 'text' => $text];
$telegram->sendMessage($content);



$content = ['chat_id' => $sender_chat_id, 'text' => $text];
$telegram->sendMessage($content);


        $sql->query ("UPDATE `vb_telegrambot` SET foaf='$post_id' WHERE id='$commentid' ");
        
        
    }

    



}

function setComment($post_id,$first,$lastname,$textcomment){

        $comment_post_ID = $post_id;
        $comment_author = __($first, $lastname);
        $comment_author_url = '';
        $comment_content = $textcomment;
        $comment_agent = 'WooCommerce';
        $comment_type = 'order_note';
        $comment_parent = 0;
        $comment_approved = 1;
        $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_agent', 'comment_type', 'comment_parent', 'comment_approved');
        $comment_id = wp_insert_comment($commentdata);

    return $comment_id;
}


?>