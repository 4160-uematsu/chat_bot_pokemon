<!-- APIの使い方サンプル -->

<!DOCTYPE html>

<head>
    <title>APIサンプル</title>
</head>

<body>

    <?php
    // try...catchでエラーを画面に出力している
    try {
        // APIの名前（APIの軽い説明）難易度★★★★★（5段階）


        // 気象庁API（天気情報が取得できる）難易度★★★☆☆================================================================================================================================================
        // 参考url  https://mindtech.jp/?p=1754 

        $weather_area = '130000'; // 1300000は東京の地点番号

        // ↑数字を変更すると天気を取得する地点が変更される

        // ↓コメントアウトを外すと地点番号一覧が表示される
        // $area_url = 'http://www.jma.go.jp/bosai/common/const/area.json';
        // $area_json = file_get_contents($area_url);
        // $area_data = json_decode($area_json);
        // print '<pre>';
        // var_export($area_data);
        // print '</pre>';

        $weather_url = "https://www.jma.go.jp/bosai/forecast/data/forecast/$weather_area.json"; // GETリクエストを送る形式に成形
        $weather_json = file_get_contents($weather_url); // jsonデータを取得
        $weather_data = json_decode($weather_json); // jsonから配列に直す（扱いやすくする）
        $weaher_text = $weather_data[0]->timeSeries[0]->areas[0]->weathers[0]; // 必要な情報（今日の天気）

        print('気象庁API：' . $weaher_text); // 画面に出力
        print('<br><hr>');


        // DogAPI（ランダムな犬の画像が取得できる）難易度★☆☆☆☆===========================================================================================================================================
        // 参考url https://dog.ceo/dog-api/

        $dog_url = "https://dog.ceo/api/breeds/image/random";
        $dog_json = file_get_contents($dog_url); // jsonデータを取得
        $dog_data = json_decode($dog_json); // jsonから配列に直す（扱いやすくする）
        $dog_img = $dog_data->message; // 画像のurlを取得

        print('DogAPI：');
        print("<img src=$dog_img height=128>"); // 画像をブラウザに表示
        print('<br><hr>');


        // NHK番組表API（番組情報を取得できる）難易度★★★★☆===============================================================================================================================================
        // 参考url https://api-portal.nhk.or.jp/doc-list-v2-con

        $area = 130; // 地域を指定（130は東京）
        $service = 'g1'; // NHKのチャンネルを指定（g1はNHK総合）
        $date = date('Y-m-d'); // 日付を指定（今回は今日を指定している）

        // ↑この3つのパラメータを変更して使用する

        $apikey = '5XedDlmDGFAwJYzyxzgmmsi49SV7iLE9'; // このまま使う
        $nhk_url = "https://api.nhk.or.jp/v2/pg/list/$area/$service/$date.json?key=$apikey"; // GETリクエストを送る形式に成形
        $nhk_json = file_get_contents($nhk_url); // jsonデータを取得
        $nhk_data = json_decode($nhk_json); // jsonから配列に直す（扱いやすくする）

        print('NHK番組表API：' . $nhk_data->list->g1[0]->title); // ブラウザに出力
        print('<br><hr>');


        // 郵便番号API（郵便番号から住所を検索する）難易度★★☆☆☆===========================================================================================================================================
        // 参考url http://zipcloud.ibsnet.co.jp/doc/api

        $zip_code = '7830060'; // 郵便番号7桁を指定

        // ↑郵便番号を変更して使用する

        $zip_url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=$zip_code"; // GETリクエストを送る形式に成形
        $zip_json = file_get_contents($zip_url); // jsonデータを取得
        $zip_data = json_decode($zip_json); // jsonから配列に直す（扱いやすくする）

        $address1 = $zip_data->results[0]->address1; // 都道府県名
        $address2 = $zip_data->results[0]->address2; // 市町村名
        $address3 = $zip_data->results[0]->address3; // 町域名

        print('郵便番号API：' . $address1 . $address2 . $address3);
        print('<br><hr>');

        // ポケモンAPI（ポケモンの図鑑番号を指定するとそのポケモンの情報（英語）が取得できる）難易度☆☆★★★======================================================================================================
        // 参考url https://taiyosite.com/pokeapi-elementary/ (個人のブログだが、わかりやすい)

        $pokemon_id = "151"; // 151はミューの図鑑番号

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

        // 図書館API 難易度★★★★☆=======================================================================================================================================================================
        // 参考url  https://calil.jp/doc/api_ref.html

        //送るデータ
        $library_data = [
            "appkey" => "16f991728e853245f170421bec3d3607",
            "format" => "json",
            "callback" => "",
            // ここから上のパラメータ（appkey, format, callback）は変更しない

            "limit" => 1, // データを何件取得するか数字で指定する
            "pref" => "千葉県", // 都道府県名を指定する
            "city" => "千葉市", // 市町村名を指定する
        ];

        // ↑pref, city, limit, などを変更して使用する

        $library_url = "https://api.calil.jp/library"; //リクエスト先のurl
        $library_url .= "?" . http_build_query($library_data); // GETリクエストを送る形式に成形
        $library_json = file_get_contents($library_url); // jsonデータを取得
        $library_data = json_decode($library_json); // jsonから配列に直す（扱いやすくする）

        print('図書館API：' . $library_data[0]->formal); // 図書館の正式名称を出力


    } catch (Exception $e) {
        print($e->getMessage());
    }

    print '<pre>';
    print '</pre>';

    ?>

</body>