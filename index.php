<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  $wasStart = FALSE;
  $apikey = "2ef74c382ac90947f76e48a4cb24fca2";
  $city = 'moscow';
  $country_name = 'canada';
  $keyboard = [["Да"], ["Нет"]];
  $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$apikey.'';

  if (($text == "/start") and ($wasStart == false)) {
  	$wasStart = TRUE;
  	if ($name) {
      $reply = "Здравствуй, " .$name;
    }
    else {
      $reply = "Здравствуй, Cтранник";
    }
    $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
  }

  if ($text == "/sayHello") {
  	if ($name) {
      $reply = "Здравствуй, " .$name;
    }
    else {
      $reply = "Здравствуй, Cтранник";
    }
    $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
  }
  /*
  if ($text == "/more") {
  	$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $city, 'reply_markup' => $reply_markup ]);
  } */

  if ($text == "/info") {
  	$ch = curl_init($url);
  	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($s,CURLOPT_HEADER, 0);
    curl_setopt($s,CURLOPT_RETURNTRANSFER, 1);
    $request = curl_exec($ch);

  /*  $request = file_get_contents($url); */
    $request = json_decode($request, true);
    $reply = $request->main->temp;
    curl_close($ch);
    echo($reply);


  /*  $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);*/
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply/*, 'reply_markup' => $reply_markup*/ ]);
  } 
  
  $request = file_get_contents($url);
    $request = json_decode($request, true);
    $reply = $request->main->temp;
    echo($reply);

  
  echo("test");
?>
