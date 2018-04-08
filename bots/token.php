<?php

//admin

$chat_ch_id=222909344;  
$chat_ch_id2=434590301; //not found
$chat_ch_id3=83674896; // not found
$chat_ch_id4=151370482; //not found
$chat_ch_id5=127562196; //not found

//certs



//bot token
function getToken($botname)
{
    $bottoken='';

    if($botname=="mj23")
    $bottoken='369147560:AAEVq707XPH_nH3pTl1kMNLKPhkyQWsmUCA';
    if($botname=='botSample')
        $bottoken='414412688:AAG8E8xq8tBaV2bYZNOqKRFl-FbKCNVsoY0';
    else if ($botname=='botVideo')
        $bottoken='362542059:AAGcdc_aCkdfqg2NXm3kaKjbru_7pjQZzqc';
    else if ($botname=='botMap')
        $bottoken='384494354:AAFX0sfjenQcXTMudsrNatuZM7K-CnEsShY';
    else if ($botname=='botdrtamir')
        $bottoken='415037096:AAE6dZvpNlYUrG5hCwj2djI0OjBD6yEoxF4';
    else if ($botname=='botSign')
        $bottoken='437556079:AAGxyg_oHxRGa86noiyaJdLHis1ZV05WGVk';
    else if ($botname=='botTwitter')
        $bottoken='328017920:AAHr_xy1xlDldQhiMoKwUCWY-0mDyt5TLpw';
    else if ($botname=='botProfile')
        $bottoken='418345611:AAGRq2nc1yYtpVZxBV6jqyMSadQauCJvdBU';
    else if ($botname=='bot3x3')
        $bottoken='433104398:AAFBv8XfxoYEsJ3-_saq6S6OWaQVEPJzAaA';
    else if ($botname=='botRegister')
        $bottoken='465001534:AAEXvlWeMa-sr8XPSs69AtCUqz4PRR9RiyI';
    else if ($botname=='botVoice')
        $bottoken='429715709:AAGE5j11QZr01OQ843_BJ22OG2NYmLNlFZ4';
    else if ($botname=='botZheel')
        $bottoken='185734706:AAGxHo6ViL5WCrBelUYhF39pq5LSlhRgPjQ';
    else if ($botname=='botUpload')
        $bottoken='492741547:AAGF09Qa_d9MrTaPYGCC7QZliC_kKS3o-E0';
    else if ($botname=='botMoshavere')
        $bottoken='430079800:AAEh991xGMOzOyTpt0iWTUA0S4Gk-TLifhE';
    else if ($botname=='botMezaj')
        $bottoken='457256722:AAFBySwpKfkhPdqClS2ucX7zcob6efybvQA';
    else if ($botname=='botReport')
        $bottoken='393090649:AAGXD6_I4DPYDOKSgELtBHDJG74AXprLBqQ';
    else if ($botname=='botReserve')
        $bottoken='497288325:AAGbc_p1h-QUKCGgw1UX1Kcad_AOCmtJGR8';
    else if ($botname=='botScore')
        $bottoken='420116416:AAGpZ7wyV0SUGjv0zHidwsBKkPv7SqtgO1A';
    else if ($botname=='botNba')
        $bottoken='477355411:AAFTHMgBr7e5UamJkCtrf7D0hSNA8-CwTJ0';
    else if ($botname=='botAdmin')
        $bottoken='469104097:AAHLPKFJoI_n_54kRllaYYCuohx2ji245SI';
    else if ($botname=='botJomle')
        $bottoken='505791973:AAGasxdBB3onkQBPlA15dXJTm8gs20rB5kA';
    else if ($botname=='botV360')
        $bottoken='424821493:AAEx5_-eJhCa_7zXmGJVl6QsD3mgObwVII0';
    else if ($botname=='botBazaryabi')
        $bottoken='377509652:AAGMKlpNm1bZPmlrm1cvyCcON6KHsIWStwI';
    else if ($botname=='botNBAvote')
        $bottoken='456068819:AAFYj0QPHAL5BpWwawd8m_SW59sqPcqC8hs';
    else if ($botname=='botPlayerName')
        $bottoken='477232573:AAHjxi0aXq_pFUqSXjthIpBuLw-HXingK5Y';
    else if ($botname=='pushe')
        $bottoken='28f5b834263ead61c25404c516c3fc2959543edd';

    return $bottoken;    
}
?>