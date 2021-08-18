<!-- 形態素解析した結果を出力するファイル -->

<!DOCTYPE html>

<head>
    <!-- ページのタイトル -->
    <title>形態素解析</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<?php
$json = file_get_contents(__DIR__ . '/json/input.json'); // input.jsonの中身を取得
$input_data = json_decode($json, true); // jsonをarray型に変更

$message = $input_data['message']['text']; // $input_dataからメッセージの部分を取り出す

//送るデータ
$data = [
    "app_id" => "2d0269532d3b6f7a84698730672ecf46d81a7646dbfc4d4f1653fd994ef6dddf", // goo apiのトークン ※今回はこのままで良い
    "sentence" => $message,
];

// httpパラメータを指定
$header = [
    'Content-Type: application/json; charset=utf-8',
];
$context = [
    "http" =>
    [
        "method" => "POST",
        'header' => implode(PHP_EOL, $header),
        "content" => json_encode($data),
    ]
];
$url = "https://labs.goo.ne.jp/api/morph"; //リクエスト先のurl

// goo apiにPOSTリクエスト
$json = file_get_contents(
    $url,
    false,
    stream_context_create($context)
);

$morph = json_decode($json, true); // 返ってきたjsonの値をarrayに変換
$word_list = $morph['word_list']; // 形態素解析された配列を取得

// 空の配列に単語を入れる
$words = [];
foreach ($word_list as $sentence) {
    foreach ($sentence as $word) {
        $words[] = $word[0];
    }
}

$count = array_count_values($words); // 重複している値の数を数える
arsort($count); // 降順に並べ替える
?>

<body>
    <div class="container">
        <table class="table w-50" align="center">
            <thead>
                <tr>
                    <th scope="col">単語</th>
                    <th scope="col">回数</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($count as $word => $times) {
                    echo '<tr><td>' . $word . '</td>';
                    echo '<td>' . $times . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>