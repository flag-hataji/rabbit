<?php

//PEARライブラリのmimeDecodeを読み込み
require_once("/usr/local/lib/php/Mail/mimeDecode.php");
require_once("/usr/local/lib/php/Mail.php");

//mailの文字列取得
$source = file_get_contents("test.txt");
if($source===false){
    echo "読み込みエラー";
}
/*
//mimeDecodeのパラメーターの設定
$params['include_bodies'] = true;   //分解する文字列に本文を含むかどうか
$params['decode_bodies'] = true;    //本文をデコードするかどうか
$params['decode_headers'] = true;   //ヘッダーをデコードするかどうか
*/
//mimeDecodeのインスタンス生成
$decoder = new Mail_mimeDecode($source); // MIME分解
$parts = $decoder->getSendArray();  // それぞれのパーツを格納
list($recipients,$headers,$body) = $parts; // 各パーツを配列に格納
print_r($headers['From']);

/*
//設定した値をmimeDecodeにセット
$structure = $decoder->decode($params);
*/