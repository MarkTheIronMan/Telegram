<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  $wasStart = false;
  $key = 11020a5d-6bfd-4b23-9b79-a24644bd3105;
  $city = "Москва";
  $country_name = "Russia";
  $keyboard = [["Да"], ["Нет"]];
  if ($text == "/start") {
  	$wasStart = true;
  	if ($name) {
      $reply = "Здравствуй, " .$name;
    }
    else {
      $reply = "Здравствуй, странник";
    }
  }

  if ($wasStart) {
    $request = 'api.airvisual.com/v2/states?country='.$country_name.'&key='.$key.'';
    $reply = ($request);
  } 
  
  $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
  echo("test");
?>
