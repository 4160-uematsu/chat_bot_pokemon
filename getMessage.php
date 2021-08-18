<!-- 受信したデータをinput.jsonに書き出すファイル -->

<?php
$json = file_get_contents("php://input"); // チャットプラスのAPIからPOSTされたデータを取得

$path = __DIR__ . '/json/input.json'; // input.jsonのパスを指定
file_put_contents($path, $json);// input.jsonに全データを保存
