<?php

function getProfile($row)
{
    $x=$row ['familynamefa'];
    
    $u=$row['username'];
    
    $rp=': پروفایل شما'
    .PHP_EOL
    .' @'
    .$u
    .PHP_EOL
    .' نام خانوادگی:'
    .$x
    .PHP_EOL;
    
    $x=$row['firstnamefa'];
    $rp.=
    ' نام:'
    .$x
    .PHP_EOL;
     
    $x=$row['fathersnamefa'];
    $rp.=
    ' نام پدر:'
    .$x
    .PHP_EOL;       
             
    $x=$row['telegram'];
    $rp.=
    'تلگرام:'
    .$x
    .PHP_EOL;       
             
    $x=$row['chat_id'];
    $rp.=
    'تلگرام نامبر:'
    .$x
    .PHP_EOL;       
             
    $x=$row['email'];
    $rp.=
    'ایمیل:'
    .$x
    .PHP_EOL;       

     
    $x=$row['height'];
    $rp.=
    '  قد:'
    .$x
    .PHP_EOL;       
    
             
    $x=$row['weight'];
    $rp.=
    ' وزن:'
    .$x
    .PHP_EOL;       
    
             
    $x=$row['city'];
    $rp.=
    ' شهر:'
    .$x
    .PHP_EOL;       
     
    $x=$row['urbanfa'];
    $rp.=
    ' حومه:'
    .$x
    .PHP_EOL;    
     
    $x=$row['provincefa'];
    $rp.=
    '  استان:'
    .$x
    .PHP_EOL;       
     
    $x=$row['age'];
    $rp.=
    '  سن:'
    .$x
    .PHP_EOL;             
    $x=$row['birthdayday'].'/'
    .$row['birthdaymonth'].'/'
    .$row['birthdayyear'];
    $rp.=
    '  تولد:'
    .$x
    .PHP_EOL;             
    $x=$row['sex'];
    $rp.=
    'جنسیت:'
    .($x==0?'خانم':'آقا')
    .PHP_EOL;             
    $x=$row['coach'];
    $rp.=
    ' نام مربی:'
    .$x
    .PHP_EOL;    
    $x=$row['teamname'];
    $rp.=
    ' نام تیم:'
    .$x
    .PHP_EOL;    
    $x=$row['jerseyNo3'];
    $rp.=
    ' شماره پیرهن 3 به 3 :'
    .$x
    .PHP_EOL;    
    $x=$row['jerseyNo5'];
    $rp.=
    ' شماره پیرهن دوزمینه :'
    .$x
    .PHP_EOL;    
    $x=$row['teamname3x3'];
    $rp.=
    '  نام تیم سه نفره:'
    .$x
    .PHP_EOL;    
    $x=$row['experience'];
    $rp.=
    '  سابقه رسمی:'
    .$x
    .PHP_EOL;    

    $x=$row['experienceofficial'];
    $rp.=
    '  سابقه بسکتبال خیابونی:'
    .$x
    .PHP_EOL;           

    $x=$row['post'];
    $rp.=
    ' پست بسکتبال:'
    .$x
    .PHP_EOL;    
    $x=$row['nationalcode'];
    $rp.=
    '  کد ملی:'
    .$x
    .PHP_EOL;    
    $x=$row['address'];
    $rp.=
    '  آدرس:'
    .$x
    .PHP_EOL;    
    $x=$row['postalcode'];
    $rp.=
    '  کد پستی:'
    .$x
    .PHP_EOL;    
    $x=$row['postnonprof'];
    $rp.=
    '  پست غیر تخصصی و غیر حرفه ای:'
    .$x
    .PHP_EOL;    
    $x=$row['telegramphone'];
    $rp.=
    '  موبایل تلگرامی:'
    .$x
    .PHP_EOL;           

    $x=$row['telegramcellphone'];
    $rp.=
    '  موبایل:'
    .$x
    .PHP_EOL;    
    
    $x=$row['homephone'];
    $rp.=
    ' تلفن منزل :'
    .$x
    .PHP_EOL;    
    
    
    $x=$row['cellphone'];
    $rp.=
    ' موبایل دیگر :'
    .$x
    .PHP_EOL;    
    
    return $rp;
}
?>