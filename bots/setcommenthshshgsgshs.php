<?php

include ('../../wp-load.php');

// remove query string from request
//$request = preg_replace('#\?.*$#', '', $_SERVER['REQUEST_URI']);

// try and get the page name from the URI
//preg_match('#podpages/([a-z0-9_-]+)#', $matches);

//if ($matches && isset($matches[1])) {
    //$pagename = $matches[1];

    // try and find the WP representation page
    //$query = new WP_Query(array('pagename' => $pagename));

    //if (!$query->have_posts()) {
        // no WP page exists yet, so create one
        $id = wp_insert_post(array(
            'post_title' => 'بریم بسکت',
            //'post_type' => 'booking',
            //
            //            'post_type' => 'page',
            'post_type' => 'post',
            
            'post_status' => 'publish'
            , 'post_content'=>'روبات پست گذار در وردپرس'
            //,'post_name' => $pagename
        ));

        //if (!$id)
        //    do_something(); // something went wrong
    //}

    // this sets up the main WordPress query
    // from now on, WordPress thinks you're viewing the representation page       
//}


?>