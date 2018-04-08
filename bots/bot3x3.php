<?php
include 'token.php'; 
include 'Telegram.php';
//include 'Bot2Channel.php';
    
require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$botname='bot3x3';
$bot_id = getToken("bot3x3");
$telegram = new Telegram($bot_id);
// Get all the new updates and set the new correct update_id
//$req = $telegram->getUpdates();
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
	// You NEED to call serveUpdate before accessing the values of message in Telegram Class
	//$telegram->serveUpdate($i);
	//$botname='botdrtamir';

	$text = $telegram->Text();
	$location = $telegram->Location();
	$chat_id = $telegram->ChatID();
	$chat_firstname = $telegram->FirstName();
	$chat_lastname = $telegram->LastName();
	//
	//user = update.message.from_user;
	//echo json_encode ( $telegram );
	$chat_username = $telegram->Username();
	
    $help = "ثبت نام اولیه شما انجام شد . در صورت تمایل با شماره 09223097420 آقای طباطبایی تماس تلفنی یا تلگرامی برقرار کنید در غیر این صورت کمی صبر کنید تا همکاران ما سریعا با شما تماس بگیرند شما باید یکی از سرویس ها را انتخاب کنید و منتظر تماس  همکاران ما باشید برای سهولت پیدا کردن آدرس شما  یا منزل تان لطفا اگر میتوانید از طریق دکمه ی ارسال نقطه جی پی اس یا نقشه در تلگرام لوکیشن خود را برای ما ارسال کنید در غیر این صورت یکی از انواع سرویس را انتخاب فرمائید باتشکر. لطفا هیچ مراجعه کننده ای را بدون کد رهگیری به زمین بسکتبال خود راه ندهید. تیم مدیریت بریم بسکت ";       
    
	if ($text == "/start") 
	{
	    if ($telegram->messageFromGroup()) 
	    {
			$reply = "گروه است اینجا و فقط در خصوصی روبات فعال است در خصوصی پیام بده";
	    } 
    	else 
    	{
		$reply=$help;
        // Create option for the custom keyboard. Array of array string
        $option = array( array("ثبت نام",
        "سفارشات")
        , array("جوایز"
        , "امتیازات")
        , array("ثبت زمین"
        , "تکمیل پروفایل")
        , array("نصب اپ بریم بسکت"
        , "کار با روبات ها")
        , array("بخش ماموریت ها"
        , "مشکل نوتیفیکیشن")
        , array("تیم کشی"
        , "تغییرات تیم")
        , array("مسابقات"
        , "برنامه مسابقات")
        , array("تایید ماموریت ها"
        , "ساختن صفحه زمین و تیم")
        , array("انجام تمرینات"
        , "ضبط تمرینات")
        , array("جذب تیم و مربی"
        , "سایر")
        );
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', 'drtamir', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
        }
    }
	
	if ($location != null) {
	    $lat=$location['latitude'];
	    $long=$location['longitude'];
	    //echo $location['latitude'];
	    $reply = "آدرس منزل شما دریافت شد : ";

		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		//$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', '', '', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', '', '', '$text');");
        //$sql->query ("INSERT INTO `vb_log` (mac, username, password , sender , devicetype , msg , code4digit) VALUES ('', '$chat_username', '','robot serial login','android','serial','$code4digit')");
        $tekrari=0;
        
        if($sql->query ("select * from vb_playground where PlaygroundLatitude = $lat and PlaygroundLongitude = $long")===TRUE)
        {
            //$row = $result->fetch_assoc();
            if ($result->num_rows > 0) 
             $tekrari=1;
            
        }
        echo $tekrari;
        if($tekrari=='0')
        {
        if($sql->query ("INSERT INTO `dr_map` (`Id`, `Name`, `PlaygroundType`, `PlaygroundLatitude`, `PlaygroundLongitude`, `desc`, `PgTlgrmGroupAdminId`, `PgTlgrmGroupJoinLink`, `PgTlgrmChannelId`, `PgInstagramId`, `ProvinceId`) VALUES (NULL, 'توسط  $chat_firstname $chat_lastname از طریق بات', 'bballstreet', $lat, $long, 'اضافه شده توسط $chat_firstname $chat_lastname', '$chat_username', '', '', '', 'IR-07')")===TRUE)
        {
            $id = $sql->insert_id;
            $reply = "آدرس منزل / شرکت شما ذخیره شد که البته شما مشتری سابق ما بودید : ";

        }
        else
            $reply = "آدرس منزل / شرکت شما ذخیره شد : ";

        //echo mysql_insert_id();
        //if ($conn->query($sql) === TRUE) {
        
        //$id=$sql->query ("SELECT LAST_INSERT_ID()");
        //echo $id;
        
        $content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
        $reply = "http://imenservice.com/bball/www/map.php?lat=".$lat."&long=".$long."&zoom=14&mlat=".$lat."&mlong=".$long."&ProvinceId=&id=".$id;
        }
        else
    	    $reply = "آدرس منزل یا شرکت  شما قبلا ثبت شده است همکاران ما به زودی با شما تماس خواهند گرفت : ";



		
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		//@varzeshboard
		$content = array('chat_id' => -1001136444717, 'text' => $reply);
		$telegram->sendMessage($content);
		
		$message = 'درخواست خدمات  #mapbot '.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';
		//echo $message;
        //sendLog2Channel("#mapbot .php ",$message);
        sendMsg($message,$bot_id);
        sendLoc($chat_id,$lat,$long,$bot_id);
		//@varzeshboard
		sendLoc(-1001136444717,$lat,$long,$bot_id);
	}else{

        //sendLog2Channel("#mapbotelse .php ",$message);
        sendMsg($message,$bot_id);
        sendLoc($chat_id,$lat,$long,$bot_id);
	}
	
	
	if ($text == "لینک سایت") {
		if ($telegram->messageFromGroup()) {
			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
		} 
		else {
		$reply="http://imenservice.com/bball/www/default.php";    
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', 'drtamir', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
        }
	}
	
	else if ($text == "راهنما") {
		if ($telegram->messageFromGroup()) {
			$reply = "گروه است اینجا و در خصوصی روبات فعال است در خصوصی پیام بده";
		} 
		else {
		$reply=$help;    
        // Create option for the custom keyboard. Array of array string
        $option = array( array("کامپیوتر",
        "یخچال")
        , array("لپ تاپ"
        , "تلویزیون")
        , array("تبلت"
        , "جاروبرقی")
        , array("موبایل"
        , "پکیج")
        , array("شبکه"
        , "تلفن")
        , array("نرم افزار"
        , "ماشین لباسشویی")
        , array("سخت افزار"
        , "ماشین ظرفشویی")
        , array("دوربین مداربسته"
        , "اتو")
        , array("ماکروفر", "دوربین عکاسی")
        , array("آموزش تلفنی", "سایر")
        );      
        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
		//$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', 'drtamir', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'bot3x3', '', '$text', '$botname');");
        }
	}
	else {
	    		$code4digit=rand ( 1000 , 9999 );

	    $reply="سفارش سرویس و خدمات شما ثبت شد منتظر تماس و چت سرویس کار ما باشید که ایشان یک شماره تماس از شما خواهد گرفت و تماس تلفنی در صورت لزوم در ادامه بسته به نیاز شما انجام خواهد شد. لطفا هیچ کس را بدون"
	    
	    ."کد رهگیری به داخل شرکت یا منزل خود راه ندهید".
	   ' کد رهگیری شما : '.$code4digit
	    ;
	    
	    
	    
	    
	    
	    
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);
		$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`) VALUES ('', 'drtamir', '', '', '', '', '$chat_id', '', '', '', '', '', '$text');");
		
		$message = 'مشتری جدیدی با کد رهگیری '.$code4digit
		.'\n نوع خدمت ' .(string)$text.' '.'#درخواست خدمات  #mapbot '.' : '.(string)$chat_id.' '.(string)$chat_firstname.' '.(string)$chat_lastname.' @'.(string)$chat_username.' ';

        sendMsg($message,$bot_id);
	}
//}






//$bot_id = "UCA";
//sendMsg('hello all',);
//sendLoc('@varzeshboard',35.35,51.51,$bot_id);

//$response = array ();
//$response [] = getUpd($bot_id);
//echo json_encode ( $response[0]['result'].update_id );



//$sql->query ("INSERT INTO `vb_log` (update_id, username, password , sender , devicetype , msg) VALUES ($response[0].update_id, '$username', '$password','setPasswordForThisUsername','android','notexist')");


function sendMsg($message,$bot_id){ 
    $telegram = new Telegram($bot_id);
    $chat_id = -1001137971754;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}

function sendLoc($chat_id,$latitude,$longitude,$bot_id){ 
    $telegram = new Telegram($bot_id);
    //$chat_id = '127562196';
    $content = array('chat_id' => $chat_id, 'latitude' => $latitude , 'longitude' => $longitude);
    $telegram->sendLocation($content);
}

function getUpd($bot_id){
    $telegram = new Telegram($bot_id);
    //$chat_id = '127562196';
    //$content = array('chat_id' => $chat_id, 'latitude' => $latitude , 'longitude' => $longitude);
    return $telegram->getUpdates();
}

?>