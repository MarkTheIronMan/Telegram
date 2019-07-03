<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 

  const RESP = "Введите название города";
 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $arg = 'london';
  $name = $result["message"]["from"]["username"]; 
  $wasStart = FALSE;
  $apikey = '2ef74c382ac90947f76e48a4cb24fca2';
  $city_name = 'moscow';
  $url = 'https://api.openweathermap.org/data/2.5/weather?q='. $city_name .'&appid='.$apikey.'';
 
   function printInfo($arg):string {
   	   $m = $arg;
   	   $url = 'https://api.openweathermap.org/data/2.5/weather?q='. $m .'&appid='.$apikey.'';
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $r = curl_exec($ch);
       curl_close($ch);
       $request = json_decode($r, true);
       $nme = $request["name"];
       $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $nme]);
       $tmp = $request["main"]["temp"];
    /*   $temp = round($temp - 273.15); */
       $wnd = $request["wind"]["speed"];
       $str = 'Температура в '. $nme .' составляет '. $tmp .' градусов. Скорость ветра'. $wnd .' метров в секунду.';
       return $str;
    }

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
    $response = "temperature is about ". $reply. 'K';
    echo($reply);
  /*  $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true ]);*/
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $response/*, 'reply_markup' => $reply_markup*/ ]);
  } 
/*
  if ($text == "/nw") {
  	$reply = RESP;
  	$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);
  	$city = 'london';
  	$va = printInfo($city);
  	  $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $va ]); 	
  } 

*/

  if ($text == "/fo") {
  	$params['text'] = 'Выберите операцию';
    $params['disable_notification'] = TRUE;
    $params['parse_mode'] = 'HTML';
    $params['chat_id'] = $result["message"]["chat"]["id"];

    $button_en = array('text' => 'Последние города', 'callback_data' => "checkCities");
    $button_ru = array('text' => 'Новый город', 'callback_data' => "newCity");
        
    $keyboard = array('inline_keyboard' => array(array($button_en, $button_ru)));
    $params['reply_markup'] =json_encode($keyboard, TRUE);  
    $telegram->sendMessage($params);

    if ($button_en['callback_data'] == "newCity") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => RESP]);

    }
  }


  
  echo("test");
?>
