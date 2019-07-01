<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  if ($text == "/start") {
  	if ($name) {
      $reply = "Здравствуй, " .$name;
    }
    else {
      $reply = "Здравствуй, странник";
    }
  } 
  
  $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
  echo("test");
?>
