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
  $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $city_name .'&appid=' . myapikey . ''; 

   function getInfo($arg) {
   	   $newurl = 'https://api.openweathermap.org/data/2.5/weather?q=' . $arg .'&appid=' . myapikey . '';
       $ch = curl_init($newurl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $r = curl_exec($ch);
       curl_close($ch);
       $request = json_decode($r, true);
       if ($request["cod"] == "200") {
         $nameCity = $request["name"];
         $tempCity = $request["main"]["temp"];
         $tempCels = /*0 +*/ $tempCity;
        /* $tempCels = round($tempCels - 273.15); */
         $windCity = $request["wind"]["speed"];
         $str = "Температура в ".$nameCity." составляет ".$tempCels." градусов Цельсия. Скорость ветра ".$windCity." метров в секунду.";
         return $str;
       }
       else {
       	 $str = "Введите корректные данные";
       }
    }
     
  if ($text) {
  	$data = [
         "city" =>$text
       ];
  	if ($text == "!newyork") { 	
  	   $k = $text;
  	   $k = ltrim($k, "!");
  	   $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $k]);
  	   $mem = getInfo($k);
  	   $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $mem]);
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
      $nm = $request["name"];
      $response = "temperature in ".$nm." is about ". $reply. 'K';
      echo($reply);
      $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $response]);
      $kek = 'moscow';
      $lol = getInfo($kek);
      $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $lol]);

    } 
    elseif ($text == "/погода") {
  	  $reply = "Окей, я могу рассказать тебе про погоду";
  	  $keyboard = [["Увидеть последние запросы"],["Новый город"]];
  	  $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    }
    elseif ($text == "Увидеть последние запросы") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Как скажешь, мой повелитель']);
      $otvet = $text;
      $lul = getInfo($otvet);
      $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $lul]);
    }
    elseif ($text == "Новый город") {
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Введите название города']);
    }
    elseif (substr($data["city"], 0, 1) === '!') {
      $telegram->sendMassage(['chat_id' => $chat_id, 'text' => 'ну ты и пидор']);
 /*      $city = ltrim($text, '!');   
       $reply = getInfo($city);
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $city]);
 */ } 
    elseif ($text == "/testo") {
      $data = [
      	"city" => $text,
      	"id_user" => $chat_id
      ]; 
      $mom = $data["city"];
      $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $mom]);
    }
  }

  
  echo("test");
?>
