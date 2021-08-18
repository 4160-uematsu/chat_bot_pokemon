<!-- メッセージに返信するファイル -->

<?php
$json = file_get_contents("php://input"); // チャットプラスのAPIからPOSTされたデータを取得
$input_data = json_decode($json, true); // $jsonを配列に変換

// 受信データ
$to = $input_data['room']['room_id'];
$agent = $input_data['agent']['agent_id'];
$siteId = $input_data['site']['site_id'];

// ↓↓↓↓      入力してね！      ↓↓↓↓
$accessToken = 'アクセストークン';

// ここから下のコードを編集しよう！===========================================================================================================================

// 参考URL https://app.chatplus.jp/admin/cp/api/send

$text = $input_data['message']['text']; // 相手の送信したメッセージ
$pokemon_id = $input_data['message']['text']; // $input_dataからメッセージの部分を取り出す


$pokemon_url = "https://pokeapi.co/api/v2/pokemon/$pokemon_id/"; // GETリクエストを送る形式に成形
$pokemon_json = file_get_contents($pokemon_url); // jsonデータを取得
$pokemon_data = json_decode($pokemon_json); // jsonから配列に直す（扱いやすくする）
$pokemon_name = $pokemon_data->name; // ポケモンの英語名
$pokemon_img = $pokemon_data->sprites->front_default; // ポケモンの画像
$pokemon_type = $pokemon_data->types[0]->type->name; // ポケモンのタイプ

// 複数のメッセージを送りたい場合
$messages = [
    [
        'type' => 'text',
        'text' => 'あなたの探しているポケモンは' . $pokemon_name
    ],
    [
        'type' => 'image',
        'url' => $pokemon_img 
    ]
];




// $messages = [
//     [
//         'type' => 'text',
//         'text' => 'ありがとうございます'
//     ]
// ];

/* 
テキスト以外にもいろいろな返信方法がある
参考URL https://app.chatplus.jp/admin/cp/api/send


// 複数のメッセージを送りたい場合
$messages = [
    [
        'type' => 'text',
        'text' => '1つ目のメッセージ'
    ],
    [
        'type' => 'text',
        'text' => '2つ目のメッセージ'
    ]
];

// 画像を送りたい場合

$messages = [
    [
        'type' => 'image',
        'url' => 'https://www.ec-cube.net/upload/save_image/09281534_59cc97dd5bcab.png'
    ]
];

*/

// ここから下は変更しない！=================================================================================================================================

// HTTPパラメータの設定
$data = [
    'to' => $to,
    'agent' => $agent,
    'accessToken' => $accessToken,
    'siteId' => $siteId,
    'messages' => $messages,
];
$header = [
    'Content-Type: application/json; charset=utf-8',
];
$context = [
    "http" => [
        "method"  => "POST",
        "header"  => implode(PHP_EOL, $header),
        "content" => json_encode($data) //$dataをjsonにしている
    ]
];

$url = 'https://app.chatplus.jp/api/v1/send'; // チャットプラス返信用APIのurl

// チャットボットへ返信
file_get_contents(
    $url,
    false,
    stream_context_create($context)
);
