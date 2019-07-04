<?php
  include('vendor/autoload.php'); 
  use Telegram\Bot\Api; 

  const RESP = "Введите название города";
  const myapikey = '2ef74c382ac90947f76e48a4cb24fca2';

 
  $telegram = new Api('698149481:AAFNPsmhDJ2a_dzbVFjiiGCc3TgpGft-0Xk');
  $result = $telegram -> getWebhookUpdates(); 
  $text = $result["message"]["text"];
  $chat_id = $result["message"]["chat"]["id"]; 
  $name = $result["message"]["from"]["username"]; 
  $city_name = 'moscow';
  $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city_name.'&appid='.myapikey.''; 

   function getInfo($arg): string {
   	   $newurl = 'https://api.openweathermap.org/data/2.5/weather?q='.$arg.'&appid='.myapikey.'';
       $ch = curl_init($newurl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $r = curl_exec($ch);
       curl_close($ch);
       $request = json_decode($r, true);
       $nameC = $request["name"];
       $tempC = $request["main"]["temp"];
       $tempCels = 0 + $tempC;
       $tempCels = round($tempCels - 273.15); 
       $windC = $request["wind"]["speed"];
       $str = 'Температура в '.$nameC.' составляет '.$tempCels.' градусов. Скорость ветра '.$windC.' метров в секунду.';
       return $str;
    }

  if (substr($text, 0, 1) === '!') {
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => 'ну ты и пидор']);
       $city = 'москва';/* (ltrim($text, '!'));  */
       $reply = getInfo($city);
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $reply]);
   }

   if (strpos($text, '!') === 0) {
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => 'ну ты и пидор']);
   }

   

  if ($text) { 	
  	$m = $text[0];
  	if ($m == "5") {
  	   $telegram->sendMassage(['chat_id' => $chat_id, 'text' => 'ну ты и пидор']);
  	} 
    if ($text == "/start") {
      if ($name) {
        $reply = "Добро пожаловать, " .$name;
      }
      else {
      $reply = "Приветствую тебя, Cтранник";
      } 
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
    }
    elseif ($text == "/sayHello") {
  	  if ($name) {
      $reply = "Здравствуй, " .$name;
      }
      else {
      $reply = "Здравствуй, Cтранник";
      }
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
    }
    elseif ($text == "/test") {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $r = curl_exec($ch);
      curl_close($ch);
      $request = json_decode($r, true);
      $reply = $request["main"]["temp"];
      $response = "temperature in Moscow is about ". $reply. 'K';
      echo($reply);
      $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $response/*, 'reply_markup' => $reply_markup*/ ]);
    } 
    elseif ($text == "/погода") {
  	  $reply = "Окей, я могу рассказать тебе про погоду";
  	  $keyboard = [["Увидеть последние запросы"],["Новый город"]];
  	  $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    }
    elseif ($text == "Увидеть последние запросы") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Как скажешь, мой повелитель']);
    }
    elseif ($text == "Новый город") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Введите название города']);
    }
    elseif (substr($text, 0, 1) === '!') {
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => 'ну ты и пидор']);
       $city = ltrim($text, '!');   
       $reply = getInfo($city);
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $city]);
    } 
  }

  
  echo("test");
?>
