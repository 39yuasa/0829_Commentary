<?php
//SESSIONを使えるように宣言
session_start();
include('connect.php');

// $_POSTの中身が空、つまりページに入ったときに動かないようにしている。
// 訳:$POSTが空じゃなかったらtrueを返すよ
if(!empty($_POST)):
    // $_POST[name]と$_POST['pass]が空じゃない→nameとpassが打ち込まれていたら下記の処理が動く。
    if($_POST['name'] != '' && $_POST['pass'] != ''):
        // $_POST['name']の値を$nameの変数に入れる
        $name = $_POST['name'];
        // $_POST['pass']の値を$passの変数に入れる
        $pass = $_POST['pass'];
        // table(tsetusers)を指定し、そのtable(testusers)の中にあるnameカラムの中にある$name、passカラムの中にある$passが揃っている要素があったら取ってくる
        $sql = "SELECT * FROM testusers WHERE (name = '$name' AND pass = '$pass')";  
        // $comはconnect.phpで処理した内容が入っている

        // queryで指定されたtableに訪れる。$comに対して、$sqlの処理をしてねと俺は思っている
        $rst =mysqli_query($com , $sql);
        // $rstに返る値は成功した場合、オブジェクト型で情報が返る、失敗した場合falseが返る

        // オブジェクトの形を$rowの連想配列に入れる。その際に、falseだったらelseが動く
        if($row = mysqli_fetch_assoc($rst)):
            // SESSION['userID']という変数に$row['id']を入れる。SESSIONで移動した先のファイルでも使えるようにする
            $_SESSION['userId'] = $row['id'];
            // SESSION['username']という変数に$row['name']を入れる。SESSIONで移動した先のファイルでも使えるようにする
            $_SESSION['username'] = $row['name'];
            // 打ち込まれた値がつなげたデータベースの中に存在したらどのページでも使える変数に入れるという処理をするページ
            header('Location:end.php');
        else:
            echo '登録されていません';
        endif;
        // rstメモリを開放する。データ量が多くなると、パフォーマンスが低下するため使い終わったら開放して軽くする
        mysqli_free_result($rst);
    endif;
    // データベースの接続を切断する。切断してあげないと他のデータベースを取得するときに遅くなる
    mySqli_close($com);
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- formにおいて大事なは、name=''。こいつが上で呼び出すときの鍵みたいなもの。jsのクラス名みたいなもの-->
    <h2>ログイン画面</h2>
    <form action="" method = 'post'>
       <p>ユーザー名：<input type="text" name = 'name'></p> 
       <p>パスワード：<input type="password" name = 'pass'></p>
       <p><input type="submit" name ='sub' value ='ログイン'></p> 
    </form>
</body>
</html>