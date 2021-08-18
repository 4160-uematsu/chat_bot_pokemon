<!-- ポケモン番号の結果を出力するファイル -->

<!DOCTYPE html>

<head>
    <!-- ページのタイトル -->
    <title>ポケモン</title>
</head>

<?php
// ポケモンAPI（ポケモンの図鑑番号を指定するとそのポケモンの情報（英語）が取得できる）難易度☆☆★★★======================================================================================================

$json = file_get_contents(__DIR__ . '/json/input.json'); // input.jsonの中身を取得
$input_data = json_decode($json, true); // jsonをarray型に変更

$pokemon_id = $input_data['message']['text']; // $input_dataからメッセージの部分を取り出す


        // $pokemon_id = "150"; // 151はミューの図鑑番号

        // ↑ポケモンの図鑑番号を変更して使用する

        $pokemon_url = "https://pokeapi.co/api/v2/pokemon/$pokemon_id/"; // GETリクエストを送る形式に成形
        $pokemon_json = file_get_contents($pokemon_url); // jsonデータを取得
        $pokemon_data = json_decode($pokemon_json); // jsonから配列に直す（扱いやすくする）

        $pokemon_name = $pokemon_data->name; // ポケモンの英語名
        $pokemon_img = $pokemon_data->sprites->front_default; // ポケモンの画像
        $pokemon_type = $pokemon_data->types[0]->type->name; // ポケモンのタイプ

        print('PokemonAPI：');
        print('<br>');
        print('名前：' . $pokemon_name);
        print('<br>');
        print('タイプ：' . $pokemon_type);
        print('<br>');
        print("<img src=$pokemon_img height=128>"); // 画像をブラウザに表示
        print('<br><hr>');


        

