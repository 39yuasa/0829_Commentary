<?php
    // SESSIOnを使えるように宣言
    session_start();
    include('connect.php');
    // このページに直接入ってきたときに、$_SESSION['join']が空だったら、newuser（新規登録）の

    if( empty( $_SESSION['join']) ){ 
        header( 'Location: newuser.php');
        exit();
    }

    if(!empty($_POST['sub'])):
        // ユーザー登録の処理を行う
        // SESSIONで持ってきたuser(名前)を$nameという変数に格納する
         $name = $_SESSION['join']['user'];
        // SESSIONで持ってきたpass(パスワード)を$passという変数に格納する
         $pass =$_SESSION['join']['pass'];
        // insert intoはデータベースに情報を挿入するときに使う 
        // mysqli_real_escape_stringはsql用の文字列に変換する
        // sprintfはフォーマットされた文字で返す。つまりtable上で設定したintやvarcharのフォーマットで返されるのではないかと思います
         $sql = sprintf("INSERT INTO testusers SET name = '%s' , pass ='%s'", mysqli_real_escape_string($com,$name), mysqli_real_escape_string($com,$pass));
        //  形式はこれで返される→INSERT INTO testusers SET name = 'afdasfa' , pass ='asdfassdfa'

        // tableをつなげる、$comに対して$sqlをしてねと俺は思っている
        mysqli_query($com , $sql);
        //  SESSIONを削除
        unset($_SESSION['join']);
        // データベースとの接続切断
        mySqli_close($com);
        //  完了したためページ移動
         header('Location:thanks.html');
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
<h2>確認</h2>

<dl>
    <dt>ユーザ名</dt>
        <dd>
            <!-- htmlspecialchars 特殊文字を HTML エンティティに変換する -->
            <?php
                echo htmlspecialchars( $_SESSION['join']['user'], ENT_QUOTES, 'UTF-8');
            ?>
            <!-- ユーザー名の表示 -->
        </dd>
    <dt>パスワード</dt>
        <dd>
            [表示されません]
        </dd>
    
</dl>
<p><a href="newuser.php?action=rewrite">変更</a></p>
<form method="post" action="">
    <input type="submit" name="sub" value="登録">
</form>
</body>
</html>