<?php    	

    include 'telegram.php';
    
    function sendLog2Channel($message){    
        $bot_id = "369147560:AAEVq707XPH_nH3pTl1kMNLKPhkyQWsmUCA";
        $telegram = new Telegram($bot_id);
        
        $chat_id = -1001136444717;
    	$content = array('chat_id' => $chat_id, 'text' => $message);
    	$telegram->sendMessage($content);
    }


    function sendM($message,$chat_id,$bot_id){
        $telegram = new Telegram($bot_id);
        $content = array('chat_id' => $chat_id, 'text' => $message);
        $telegram->sendMessage($content);
    }
    
    function sendMsg($message,$bot_id){
        $telegram = new Telegram($bot_id);
        $chat_id = '-1001136444717';
        $content = array('chat_id' => $chat_id, 'text' => $message);
        $telegram->sendMessage($content);
    }
    
    function sendLoc($chat_id,$latitude,$longitude,$bot_id){ 
    
        $telegram = new Telegram($bot_id);
        //$chat_id = '127562196';
        $content = array('chat_id' => $chat_id, 'latitude' => $latitude , 'longitude' => $longitude);
        $telegram->sendLocation($content);
    }
    
    function sendLoc2Admin($chat_id_admin,$latitude,$longitude,$bot_id){ 
 
        $telegram = new Telegram($bot_id);
        $content = array('chat_id' => $chat_id_admin, 'latitude' => $latitude , 'longitude' => $longitude);
        $telegram->sendLocation($content);
    }
    function sendMSG2Admin($chat_id_admin,$text,$bot_id){ 
    
        $telegram = new Telegram($bot_id);
        $content = array('chat_id' => $chat_id_admin, 'text' => $text );
        $telegram->sendMessage($content);
    }
    
    function getUpd($bot_id){
        $telegram = new Telegram($bot_id);
        //$chat_id = '127562196';
        //$content = array('chat_id' => $chat_id, 'latitude' => $latitude , 'longitude' => $longitude);
        return $telegram->getUpdates();
    }

?>		