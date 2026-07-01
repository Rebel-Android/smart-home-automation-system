<?php

//1. Request to SQL:
$conn = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASSWORD,
    DB_NAME
);

// Connection checking
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT state FROM lls WHERE id in(1)";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $Str = json_encode($row);
    }
 } else {
     echo '0 results';
 }
 $State = mb_substr($Str, 10, -2);
mysqli_close($conn);

//2. Message to telegram chat-bot:
$token = "1234567890:ABCDEFGHIJKLMNOPQRSTUV-ABCDEFGHIJK0";
$chat_id = 0987654321;

$textMessage = "Освітлення у передпокої: ";
$textMessage = urlencode($textMessage);

$urlQuery = "https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $chat_id ."&text=" . $textMessage. $State;

$result = file_get_contents($urlQuery);

?>
