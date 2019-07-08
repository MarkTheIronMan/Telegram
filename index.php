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
  $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $city_name .'&appid=' . myapikey . ''; 

   function getInfo($arg): string {

   	   $newurl = 'https://api.openweathermap.org/data/2.5/weather?q=' . $arg .'&appid=' . myapikey . '';
       $s = curl_init($newurl);
       curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
       $r = curl_exec($s);
       curl_close($s);
       $request = json_decode($r, true);
       if ($request["cod"] == "200") {
         $nameCity = $request["name"];
         $img = $request["weather"][0]["icon"];
         $tempCity = $request["main"]["temp"];
         $tempCels = 0 + $tempCity;
         $tempCels = round($tempCels - 273.15); 
         $windCity = $request["wind"]["speed"];
         $imgUrl = 'http://openweathermap.org/img/wn/'. $img .'@2x.png';
         $res = "Температура в ".$nameCity." составляет ".$tempCels." градусов Цельсия. Скорость ветра ".$windCity." метров в секунду. <a href='". $imgUrl ."'>&#8205;</a>";
         return $res;
       }
       else {
       	 $res = "Введите корректные данные";
       	 return $res;
       }
    }

  if ($text) {
  	$data = [
         "city" =>$text
       ];

    if (substr($data["city"], 0, 1) === '!') {
      $cityName = ltrim($data["city"], '!');
      $format = str_replace(" ","",$cityName);
      $reply = getInfo($format);
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'HTML']);
 /*      $city = ltrim($text, '!');   
       $reply = getInfo($city);
       $telegram->sendMassage(['chat_id' => $chat_id, 'text' => $city]);
 */ } 

  	if ($text == "!newyork") { 	
  	   $k = $data["city"];
  	   $k = ltrim($k, "!");
  	   $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $k]);
  	   $mem = getInfo($k);
  	   $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $mem]);
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
    elseif ($text == "/help") {
      $help = 'Список доступных команд:
      /sayHello - Приветствие
      /погода - Меню погоды
      /фото - Фотографии;'
      $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $help]);
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
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Введите название города.
      Например: !Москва']);
    } 
    elseif ($text == "/testo") {
      $data = [
      	"city" => $text,
      	"id_user" => $chat_id
      ]; 
      $mom = $data["city"];
      $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $mom]);
    }
  }

  
  echo("test");
?>
