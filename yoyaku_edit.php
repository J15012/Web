  <?php
  session_start();

  //ログイン状態のチェック
  if(!isset($_SESSION["TEACHER"])){
    header("Location:login.php");
    exit;
  }

  echo "ユーザID：".$_SESSION["TEACHER"];
  ?>

            <?php
            // データベースに接続するために必要なデータソースを変数に格納
            // mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
            $dsn = 'mysql:host=localhost;dbname=peppers;charset=utf8';
            // データベースのユーザー名
            $user = 'J15012';
            // データベースのパスワード
            $password = 'j15012';

  try{
            // tryにPDOの処理を記述
            $dbh = new PDO($dsn, $user, $password);
  	// echo "接続成功";

  	$sql = 'SELECT * FROM peppers';
  	$statement = $dbh -> query($sql);

  	//レコード件数取得
  	$row_count = $statement->rowCount();

  	while($row = $statement->fetch()){
  		$rows[] = $row;
  	}
  	/*
  	foreach ($statement as $row) {
  		$rows[] = $row;
  	}
  	*/

  	//データベース接続切断
  	$dbh = null;

  }catch (PDOException $e){
  	print('Error:'.$e->getMessage());
  	die();
  }

  ?>

            <!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
            <head>
              <meta http-equiv="content-type" content="text/html; charset=UTF-8N">
              <title>新規登録画面</title>
            </head>
            <body>
              <font size="4">
                <div align="right">


                  <input type="button" value="ログアウト" onClick="location.href='logout.php'"></div>
                <fieldset>
                  <div align="center">
                    <!-- <div align="right"> -->
                      <input type="submit" name="button_save" value="新規" onClick="location.href='formTest.php'"></br></br>
                    <form method="post" action="">
                      <!-- レコード件数：<?php echo $row_count; ?> -->

                      <table border='1'>
                      <tr><td>日付</td><td>時間</td><td>訪問者名</td><td>メモ</td></tr>

                      <?php

                      foreach($rows as $row){
                        if( $_SESSION["TEACHER"] == $row['teacher']){
                      ?>
                      <tr>

                      	<td><?php echo $row['date']; ?></td>
                      	<td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['text']; ?></td>
                      </tr>
                      <?php
                    }}
                      ?>


          </form>
        </div>
      </fieldset>
      </font>
    </body>
    </html>
