<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require 'vendor/autoload.php'; // If you're using Composer (recommended)
require 'mailingfunctionality.php';

$trigger_email = new \EmailFunctionality\Email;
$trigger_email->respond_to_post();

function getReplyToAddress($temp_get_reply_email) {
  $ch_main = curl_init();
  curl_setopt($ch_main, CURLOPT_URL, $temp_get_reply_email);
  curl_setopt($ch_main, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch_main, CURLOPT_SSL_VERIFYPEER, 0);
  $result_main = curl_exec($ch_main);

  if(preg_match_all('/<p class="result-info">([\s\S]*?)<\/p>/', $result_main, $apartment_lists)) {
    foreach($apartment_lists[1] as $apartment_list) {
      ini_set('memory_limit', '1024M');
  		ini_set('max_execution_time', 300);
      if(preg_match('/<a href="([\s\S]*?)"/', $apartment_list, $apartment_url)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apartment_url[1]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);

        if(preg_match('/<button class="reply-button js-only" data-href="([\s\S]*?)"/', $result, $reply_email)) {
          $email_url = preg_replace('/__SERVICE_ID__/', 'contactinfo', $reply_email[1]);

          $ch2 = curl_init();
          curl_setopt($ch2, CURLOPT_URL, 'https://portland.craigslist.org'.$email_url);
          curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
          $result2 = curl_exec($ch2);

          if(preg_match('/mailto:([\s\S]*?)\?/', $result2, $reply_email)) {
            echo $reply_email[1]."<br>";
          }
          curl_close($ch2);
        }
        curl_close($ch);
      }
    }
  }
  curl_close($ch_main);
}

?>
