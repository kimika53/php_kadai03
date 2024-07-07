<?php
//security設定
require_once('funcs.php');


//1.  DB接続します
try {
  $db_name = 'booklist'; //データベース名
  $db_id   = 'root'; //アカウント名
  $db_pw   = ''; //パスワード：MAMPは'root'
  $db_host = 'localhost'; //DBホスト
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
  // $pdo = new PDO('mysql:dbname='. $prod_db .';charset=utf8;host='. $prod_host, $prod_id, $prod_pw);
} catch (PDOException $e) {
  exit('DB Connect Error:'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM booklist_table");
$status = $stmt->execute(); ///実行した結果、成功か、falseか、

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>"; /// 「. 」がないと、上書きされてしまう
    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .= $result['id'] . ' : ' . $result['author'] . ' : ' . $result['title']. ' : ' . $result['publisher'];
    $view .= '</a>';
    $view .= '<a href="delete.php?id=' . $result['id'] . '">';
    $view .= '<button type="delete">削除</button> ';
    $view .= '</a>';
    $view .= "</p>";
  }

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お気に入り登録</title>
    <style>
        .container{
          background-color: silver;
        }
        a {
          text-decoration: none;
          color: inherit;
        }
        p :hover {
          text-decoration-line: underline;
        }
    </style>
</head>

<body>
  <header>
      <h3>お気に入り登録</h3>
  </header>
  <div>
    <div class="container">
      <a href="detail.php"></a> 
      <?= $view ?>
    </div>
  </div>
</body>
</html>
