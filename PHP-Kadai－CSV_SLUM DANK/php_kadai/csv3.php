<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意

 */
try {
    $db_name = 'gs_db';    //データベース名
    $db_id   = 'root';      //アカウント名
    $db_pw   = '';      //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//２．CSVデータ出力SQL作成
// $stmt = $pdo->prepare('SELECT * FROM gs_bm_table;');
// $status = $stmt->execute();

$stmt = $pdo->prepare('SELECT * FROM gs_bm_table;');
$status =$stmt->execute();

//３．データCSV出力

$time = time();
$filename = 'gs_bm_table' . $time . '.csv';

if(!touch($filename)) {
	echo 'すでにファイルが存在します';
	exit;
}else{
	if($fp = fopen($filename,'w')) {
		while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
			stream_filter_prepend($fp,'convert.iconv.utf-8/cp932');  //ストリームフィルタ指定
			fputcsv($fp, $rec);
			
						}
		
		if(fclose($fp)) {
			header('Location: select3.php');
		}

		if(!fclose($fp)) {
			echo 'ファイルを閉じるのに失敗しました';
			exit;
		}
	}else{
		echo 'ファイルの書き込みに失敗しました';
		exit;
	}
}





