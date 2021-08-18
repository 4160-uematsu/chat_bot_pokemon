<!-- 受信データを出力するファイル -->

<!DOCTYPE html>

<head>
    <title>受信データ</title>
</head>

<?php
$json = file_get_contents(__DIR__ . '/json/input.json'); // input.jsonの中身を取得
$array = json_decode($json, true); // $jsonを配列に変換

echo ('<pre>');
var_dump($array);
echo ('</pre>');
