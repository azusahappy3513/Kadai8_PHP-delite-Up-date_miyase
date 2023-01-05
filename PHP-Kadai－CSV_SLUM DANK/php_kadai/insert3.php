<?php
$name = $_POST['name'];
$email = $_POST['email'];
$sensyu = $_POST['sensyu'];
$school = $_POST['school'];
$word = $_POST['word'];
$content = $_POST['content'];
//2. DB接続します
try {
    $db_name = 'gs_db';    //データベース名
    $db_id   = 'root';      //アカウント名
    $db_pw   = '';      //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}
//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare('INSERT INTO
                        gs_bm_table(id, name, email, sensyu, school, word, content, date)
                        VALUES(NULL, :name, :email, :sensyu, :school, :word, :content, sysdate() );');

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':sensyu', $sensyu, PDO::PARAM_STR);
$stmt->bindValue(':school', $school, PDO::PARAM_STR);
$stmt->bindValue(':word', $word, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: index3.php');
}