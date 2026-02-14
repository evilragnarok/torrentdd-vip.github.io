<?php

$BOT_TOKEN = "ใส่บอทโทเคนของคุณที่นี่";
$CHAT_ID = "6678480860";

$message = $_POST['message'] ?? '';

if (!$message) {
    exit;
}

function sendMessage($text) {
    global $BOT_TOKEN, $CHAT_ID;

    $url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";

    $data = [
        'chat_id' => $CHAT_ID,
        'text' => $text
    ];

    file_get_contents($url . "?" . http_build_query($data));
}

function sendDocument($fileTmp, $fileName) {
    global $BOT_TOKEN, $CHAT_ID;

    $url = "https://api.telegram.org/bot$BOT_TOKEN/sendDocument";

    $post = [
        'chat_id' => $CHAT_ID,
        'document' => new CURLFile($fileTmp, mime_content_type($fileTmp), $fileName)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);
    curl_close($ch);
}

sendMessage($message);

if (!empty($_FILES['slip']['tmp_name'])) {
    sendDocument($_FILES['slip']['tmp_name'], $_FILES['slip']['name']);
}

?>
