<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  $wasStart = FALSE;
  $apikey = '2ef74c382ac90947f76e48a4cb24fca2';
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
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $r = curl_exec($ch);
    curl_close($ch);
    $request = json_decode($r, true);
    $reply = $request["main"]["temp"];
    echo($reply);
  /*  $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);*/
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply/*, 'reply_markup' => $reply_markup*/ ]);
  } 

  if ($text == "/fo") {
  	$params['text'] = 'Выберите операцию';
    $params['disable_notification'] = TRUE;
    $params['parse_mode'] = 'HTML';
    $params['chat_id'] = $result["message"]["chat"]["id"];

    $button_en = array('text' => 'Последние города', 'callback_data' => "/checkCities");
    $button_ru = array('text' => 'Новый город', 'callback_data' => "/newCity");
        
    $keyboard = array('inline_keyboard' => array(array($button_en, $button_ru)));
    $params['reply_markup'] = json_encode($keyboard, TRUE);
    $telegram->sendMessage($params);

    if ($text == "/newCity") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Введите название города']);
    }
  }

  
  echo("test");
?>
