<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'token.php'; 
include 'Telegram.php';

require_once __DIR__ . '/db_connect.php';
$sql = new DB ();

$botTokenmj = getToken("mj23");
// Set the bot TOKEN
$bot_token = getToken("botSample");
// Instances the class
$telegram = new Telegram($bot_token);

/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/
$botname='botSample';

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


	$sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `text`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '$chat_firstname', '$chat_lastname', '$chat_username', 'botProfile', '', '$text', '$botname');");
		
		
		
// Test CallBack
$callback_query = $telegram->Callback_Query();
if ($callback_query !== null && $callback_query != '') {
    $reply = 'تعهد شما برای ما پر ارزش است '
    .($telegram->Callback_Data()=='1'?'بله':'خیر');
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'text' => $reply];
    $telegram->sendMessage($content);

    $content = ['callback_query_id' => $telegram->Callback_ID(), 'text' => $reply, 'show_alert' => true];
    $telegram->answerCallbackQuery($content);
}

//Test Inline
$data = $telegram->getData();
if ($data['inline_query'] !== null && $data['inline_query'] != '') {
    $query = $data['inline_query']['query'];
    // GIF Examples
    if (strpos('بله', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif', 'thumb_url'=>'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }

    if (strpos('dance', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif', 'thumb_url'=>'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }
}

// Check if the text is a command
if (!is_null($text) && !is_null($chat_id)) {
    $sql->query ("INSERT INTO `vb_telegrambot` (`message_id`, `from_id`, `from_first_name`, `from_last_name`, `from_username`, `from_language_code`, `chat_id`, `chat_first_name`, `chat_last_name`, `chat_username`, `chat_type`, `date`, `botname`) VALUES ('$UpdateID', '$FromID', '$FromChatID', '', '', '', '$chat_id', '', '', '$chat_username', 'botIntro', '', '$text', '$botname');");
    sendMsg('#introbot : '.$text.' #bythisuser : @'.$chat_username);
    if ($text == 'بریم بسکت'||$text == '/start') {
        $reply = 'بریم آقا '.'دکمه های کیبورد یکی رو انتخاب کن';
        /*
        if ($telegram->messageFromGroup()) {
            $reply = 'اینجا گروه؟';
        } else {
            $reply = 'خصوصیه؟';
        }
        */
        
        //sendLog($UpdateID, $FromID, $FromChatID,$chat_id,$chat_username, $text, 'botIntro');
        
        
        // Create option for the custom keyboard. Array of array string
        $option = [['بریم بسکت'
        , 'سایت']
        , ['عکس'
        , 'آدرس یه زمین بسکتبال']
        , ['تعهد برای ماموریت بعدی'
        , 'راهنما']
        , ['آپارات'
        , 'فیلم آموزشی']
        , ['روبات ها'
        , 'صفحه ی زمین بسکت']
        , ['توییتر من و شما'
        , 'اینستاگرام']
        , ['کانال تلگرام'
        , 'فیس بوک']
        , ['اضافه کردن زمین بسکتبال'
        , 'دانلود اپ اندروید']
        , ['عضویت در سایت'
        , 'تکمیل پروفایل']
        , ['پشتیبانی و مدیریت'
        , 'درباره ما']
        ];
        // Get the keyboard
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
        $telegram->sendMessage($content);
    } 
    
    //
    
    elseif ($text == 'سایت') {
        $reply = 'یک کلیک کن  : https://berimbasket.ir';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'یک کلیک کن  : https://berimbasket.ir/bball/www/mains.php';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'یک کلیک کن  : https://berimbasket.ir/bball/www/instagram.php?id=1';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'یک کلیک کن  : https://berimbasket.ir/bball/www/playground';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } 
    
    elseif ($text == 'پشتیبانی و مدیریت') {
        $reply = 'یک کلیک کن چت کنیم و نظرات و پیشنهادات و انتقادات رو حتما بهم بگو متشکرم پیشاپیش از نقد هاتون  : https://t.me/berimbasket_ir';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } 
    
    elseif ($text == 'درباره ما') {
        $reply = 'یک کلیک کن  : https://berimbasket.ir/about';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } 
    elseif ($text == 'عضویت در سایت') {
        $reply = 'یک کلیک کن  : https://berimbasket.ir/bball/www/register.php';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } 
    elseif ($text == 'تکمیل پروفایل') {
        $reply = 'یک کلیک کن  : https://berimbasket.ir/bball/www/profile.php';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'روبات ثبت نام و تکمیل پروفایل رو حتما ببین  : https://t.me/berimbasketprofilebot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'دانلود اپ اندروید') {
        $reply = 'یک کلیک کن  : https://t.me/berimbasket/579';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'اضافه کردن زمین بسکتبال') {
        $reply = 'روبات مخصوص اضافه کردن زمین بسکتبال که البته در نسخه ی وبی هم میتونید راهنماش توی کانال هست';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'یک کلیک کن  : https://t.me/berimbasketmapbot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = '  از این صفحه ی سایت هم میتونید روی نقشه در مرورگر زمین بسکتبال اضافه کنید';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'کل زمین های تهران  : http://berimbasket.ir/bball/www/map.php?lat=35.723284&long=51.441968&zoom=11&mlat=35.723284&mlong=51.441968&id=1&ProvinceId=IR-07';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'آپارات') {
        $reply = 'به ما سر بزنید : https://www.aparat.com/berimbasket';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'کانال تلگرام') {
        $reply = 'Check me on : https://t.me/berimbasket';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'توییتر من و شما') {
        $reply = 'Check me on : https://t.co/berimbasket';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'با اکانت توییترت ما رو فالو کن و پست ها رو ریتوویت کن تا هر کس دیگه عضو سیستم ما شد ما لینک شما رو هم بدیم که بعدی ها دنبال کنند. ما میتونیم یک شبکه ی بزرگ به هم پیوسته و متحد از بسکتبالیست ها بشیم';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'توییتر بریم بسکت  : https://t.co/basketberim';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'و اما روباتی که میتونی باهاش با اکانت بریم بسکت توییت کنی';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'هر شب یه جمله بسکتی به صورت پینگلیش بنویس و بفرست و امتیاز بگیر';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'https://t.me/berimbaskettwitterbot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'فیس بوک') {
        $reply = 'فیس بوک : https://facebook.com/berimbasket';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'اینستاگرام') {
        $reply = 'ما رو فالو کن  : https://instagram.com/berimbasket';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'عکس') {
        // Load a local file to upload. If is already on Telegram's Servers just pass the resource id
        $img = curl_file_create('../www/instagram_files/19533721_1958037971149834_2993193851390263296_a.jpg', 'image/png');
        $content = ['chat_id' => $chat_id, 'photo' => $img];
        $telegram->sendPhoto($content);
        //Download the file just sended
        $file_id = $message['photo'][0]['file_id'];
        $file = $telegram->getFile($file_id);
        $telegram->downloadFile($file['result']['file_path'], './test_download.png');
        
        $reply = 'کافیه عکس خودت رو برای روبات پروفایل بفرستی'
        .' @berimbasketprofilebot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $reply = 'یا اگر عکس زمین بسکتبال داری '
        .' @berimbasketUploadbot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $reply = 'کل زمین های تهران  : http://berimbasket.ir/bball/www/map.php?lat=35.723284&long=51.441968&zoom=11&mlat=35.723284&mlong=51.441968&id=1&ProvinceId=IR-07';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        
        //https://t.me/berimbasket/532
        $reply = ' https://t.me/berimbasket/532 ';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content); 
        
    }
    elseif ($text == 'آدرس یه زمین بسکتبال') {
        $reply = 'یه زمین بسکتبال توی تهرانه کلیک کن ببین';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        // Send the Catania's coordinate
        $content = ['chat_id' => $chat_id, 'latitude' => '35.7232', 'longitude' => '51.44196'];
        $telegram->sendLocation($content);
        
        //http://berimbasket.ir/bball/www/map.php?lat=35.723284&long=51.441968&zoom=14&mlat=35.723284&mlong=51.441968&id=1&ProvinceId=IR-07
        $reply = 'کلیک کن یه زمین بسکتبال ببین   :  https://goo.gl/X3WYUE';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $reply = 'لیست کل زمین های بسکتبال تهران';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $reply = ' http://berimbasket.ir/bball/www/mains.php?ProvinceId=IR-07 ';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
    } elseif ($text == 'تعهد برای ماموریت بعدی') {
        // Shows the Inline Keyboard and Trigger a callback on a button press
        $option = [
                [
                $telegram->buildInlineKeyBoardButton('بله', $url = '', $callback_data = '1'),
                $telegram->buildInlineKeyBoardButton('خیر', $url = '', $callback_data = '2'),
                ],
            ];

        $keyb = $telegram->buildInlineKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'شما تعهد میدهید که ما برای شما بیست و چهار ساعت آینده ماموریتی را پیشنهاد کنیم و شما با دقت و حوصله متن ماموریت را بخوانید و انجامش دهید؟'];
        $telegram->sendMessage($content);
    } elseif ($text == 'راهنما') {
        $reply = ': https://berimbasket.ir/?p=1';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'روبات ها') {
        $reply = ' 
فرستادن نقطه ی زمین بسکتبال با نقشه
@berimbasketmapbot :  
            
تکمیل پروفایل
@berimbasketprofilebot :  
            
فرستادن ویدئوی اینستاگرام
@berimbasketinstagrambot : 
            
فرستادن خبر به سایت ما
@berimbaskettwitterbot : 
            
فرستادن نتایج مسابقات
@berimbasketNBAbot : ';
        
        //https://t.me/berimfootballbot : https://t.me/berimvolleyballbot : https://t.me/berimkoohbot : https://t.me/berimbasketplayerbot : https://t.me/berimbasketsearchbot : https://t.me/berimbasketnewsbot ';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'صفحه ی زمین بسکت') {
        $reply = 'یه صفحه درست کردیم تقریبا شبیه اینستاگرام اما در سایت خودمون که هر بسکتبالیست عکساش توی صفحه ی خودش دیده میشه  و هر زمین بسکتبال هم صفحه ای اینچنینی در سایت ما دارد ببینید    https://goo.gl/giVxBr';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'هم توی گوشی باز میشه هم توی مرورگر لپ تاپ و کامپیوترت و باعث میشه فالویر های بسکتبالیست ها بیشتر بشه';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == 'فیلم آموزشی') {
        $reply = 'صد ها فیلم آموزشی در موضوعات #شوت و #دریبل و #پاس و #ریباند منتظر توست';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        $reply = 'کافیه این روبات رو استارت کنی و براش لینک ویدئو بفرستی تا روبات هم برات لینک ویدئوی عالی بفرسته امتحان کن: https://t.me/berimbasketinstagrambot';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
        
        $sql->query ("SELECT * FROM `InstagramBot`  WHERE 1 and `Active`=1 order by RAND() LIMIT 1" );
        
		if ($sql->get_num_rows () > 0) {
			
			while ( $row = mysqli_fetch_assoc ( $sql->get_result())) {
				$reply = $row ["tags"];
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $telegram->sendMessage($content);
			}

		}
         
    }
}


function sendMsg($message,$bot_id){ 
    $telegram = new Telegram($bot_id);
    $chat_id = -1001136444717;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}

function sendLoc($chat_id,$latitude,$longitude,$bot_id){ 
    $telegram = new Telegram($bot_id);
    //$chat_id = '127562196';
    $content = array('chat_id' => $chat_id, 'latitude' => $latitude , 'longitude' => $longitude);
    $telegram->sendLocation($content);
}

function sendLog($UpdateID, $FromID, $FromChatID,$chat_id,$chat_username, $text, $botname){ 
}

?>