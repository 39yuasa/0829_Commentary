<?php
//SESSIONを使えるように宣言
session_start();
include('connect.php');
$error['user'] = '';
$error['pass']='';
//連想配列→｛user:'',pass:''｝の形

// POSTの中身(下のformの内容(sub,user,pass))が入っていたら、trueが入る。なかったらfalseが入る
// ページに入ったときにはPOSTの中身は空だからfalseが返り、下のHTMLが描画される
if(!empty($_POST)):
    // 打ち込まれた「user」エリアが空だったら、error['user']の中身を''(空)から'blank'に変更するよという処理
    if($_POST['user']==''):
        $error['user'] = 'blank';
    endif;
      // 打ち込まれた「pass」エリアが空だったら、error['pass']の中身を''(空)から'blank'に変更するよという処理
    if($_POST['pass']==''):
        $error['pass'] = 'blank';
    // パスワードの文字数が6文字より少なかったら、error['pass']の中身を''(空)から'length'に変更するよという処理
    elseif(strlen($_POST['pass'])<6):
        $error['pass'] ='length';
    endif;

    // error配列の中身を確認
    $judge = array_filter($error);
    // コールバック関数が与えられなかった場合、 $judgeのエントリの中で空の要素はすべて削除される。
    // blank or length ?  judgeの中にはlengthかblankが入る : (空だったら)errorの中で要素が消され、judgeの中身は空が返る。  
    
    //上の処理のあとのjudgeの中身を確認する
    //judgeの中身が空だったらtrueが返り下の処理が動く,blankかlengthだったらfalseが返り、動かずHTMLが動く
    if(empty($judge)):
        $_SESSION['join']=$_POST;
        // $_POSTの中には、user,password,subの内容が入っている
        header("Location: check.php");
        // このページには、もうようがないのでcheckへ移動
endif;
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
<h2>ユーザー登録</h2>
    <form action="" method = 'post'>
    <p>ユーザ名：<input type="text" name="user"></p>
        <!-- 上の変数、error[user]==''だったら起動しない。登録が押された後、userが空だったらerror[user]の中身がblankに替わり下の処理は起動する -->
        <?php
            if( $error["user"] == "blank" ):
        ?>
            <p>ユーザ名を入力してください</p>
        <?php
            endif;
        ?>
        <p>パスワード：<input type="password" name="pass"></p>
        <!-- 上の変数、error[pass]==''だったら起動しない。登録が押された後、passが6文字以下だったらerror[pass]の中身がlengthに替わり下の処理は起動する -->
        <?php
            if( $error["pass"] == "blank" ):
        ?>
            <p>パスワードを入力してください</p>
        <?php
            endif;
        ?>
         <!-- 上の変数、error[pass]==''だったら起動しない。登録が押された後、passが6文字以下だったらerror[pass]の中身がlengthに替わり下の処理は起動する -->
        <?php
            if( $error["pass"] == "length" ):
        ?>
            <p>パスワードは6文字以上で入力してください</p>
        <?php
            endif;
        ?>
        <input type="submit" name="sub" value="登録">
    </form>
</body>
</html>