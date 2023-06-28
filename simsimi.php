<?php

// Token bot Telegram
$token = '6243723922:AAG9ivbai1JOMCEjmlUiW9JXWJ_lhcdQOLs';

// Mendapatkan data dari webhook
$update = file_get_contents('php://input');
$update = json_decode($update, true);

// Mendapatkan informasi pesan
$message = $update['message'];
$chatId = $message['chat']['id'];
$text = $message['text'];

// URL API SimSimi
$url = 'https://api.simsimi.vn/v1/simtalk';

// Parameter untuk permintaan ke API SimSimi
$params = array(
    'key' => '848362ba-ce7f-4eba-b90d-c5f5f6ce999f', // Ganti dengan kunci API SimSimi Anda
    'text' => $text,
    'lang' => 'id',
);

// Mengecek perintah /start
if ($text == '/start') {
    $responseText = 'Hai, saya adalah bot SimSimi!';
} 
// Mengecek perintah /help
elseif ($text == '/help') {
    $responseText = 'Gunakan bot dengan baik!';
} 
// Mengirim pesan ke API SimSimi dan mendapatkan jawaban
else {
    // Membuat permintaan ke API SimSimi
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch);
    curl_close($ch);

    // Mendapatkan jawaban dari SimSimi
    $response = json_decode($response, true);
    $responseText = $response['messages'][0]['content'];
}

// Mengirimkan jawaban dari SimSimi ke pengguna
$sendMessageUrl = 'https://api.telegram.org/bot' . $token . '/sendMessage';
$sendMessageParams = array(
    'chat_id' => $chatId,
    'text' => $responseText,
);

// Mengirimkan permintaan untuk mengirim pesan ke pengguna
$ch = curl_init($sendMessageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $sendMessageParams);
curl_exec($ch);
curl_close($ch);

//selesaiiiii
$bot->run();
