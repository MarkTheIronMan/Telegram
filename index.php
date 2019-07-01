<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  $wasStart = FALSE;
  $apikey = '11020a5d-6bfd-4b23-9b79-a24644bd3105';
  $city = "Moscow";
  $country_name = "canada";
  $keyboard = [["Да"], ["Нет"]];

  if (($text == "/sayHello") && ($wasStart == false)) {
  	$wasStart = TRUE;
  	if ($name) {
      $reply = "Здравствуй, " .$name;
    }
    else {
      $reply = "Здравствуй, Cтранник";
    }
  }
  $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);

  if ($text = "/more") {
  	$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $city, 'reply_markup' => $reply_markup ]);
  }

  if (($text == "/info") && ($wasStart)) {
    $request = 'http://api.airvisual.com/v2/states?country='.$country_name.'&key='.$apikey.'';
    $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);
    $reply = $request;
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
  } 
  
  echo("test");
?>
