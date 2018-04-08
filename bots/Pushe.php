<?php
include 'token.php'; 
// Your ID and token
//$blogID = '8070105920543249955';


    
//require_once __DIR__ . '/db_connect.php';






function send($pusheid,$title,$content){
$authToken = getToken('pushe');


         
// The data to send to the API
$postData = array(
    
    'applications'=> ["ir.berimbasket.app"],
    //'filter' => array('imei' => ["1234567890123456", "NO-IMEI_b133-20a9-33"]),
    'filter' => array('imei' => ["1234567890123456", $pusheid]),
    
    //"device_id"=> ["2064b4d0c9e941e9"],
    'notification' => array(
        //" ارسال نوتیفیکیشن با وب سرویس بریم بسکت"
     "title"=> $title ,
     "content"=> $title,
     'action'=>array(
         "action_data"=>"activity.ActivityBrowser",
          "action_type"=> "T"
         )
        )
        //" وب سرویس سایت"
);

//NO-IMEI_b133-20a9-33


// {
//   "applications": ["com.example.app"],
//   "filter": {
//   "imei": ["1234567890123456", "pid_20aa-ba40-a0"]
//   },
//   "notification": {
//     "title": "عنوان پیام",
//     "content": "محتوای پیام"
//   }
// }

// Create the context for the request
$context = stream_context_create(array(
    'http' => array(
        // http://www.php.net/manual/en/context.http.php
        'method' => 'POST',
        //"Authorization: Token 7fb1………………………………29b464c "
        'header' => "Authorization: Token $authToken\r\n".
            "Content-Type: application/json\r\n".
            "Accept: application/json",
            //Content-Type: application/json
        'content' => json_encode($postData)
    )
));

// Send the request
$response = file_get_contents('https://panel.pushe.co/api/v1/notifications/', FALSE, $context);

// Check for errors
if($response === FALSE){
    die('Error');
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
echo $responseData['published'];
}


?>