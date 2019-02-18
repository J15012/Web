<?php
 session_start();
 //ログイン状態のチェック
 if(!isset($_SESSION["TEACHER_MAIL"])){
   header("Location:login.html");
   exit;
 }
 // echo $_SESSION["TEACHER"]."さん　登録画面";
 echo "ユーザID：".$_SESSION["TEACHER_MAIL"];
 ?><br>


 <!-- 入力情報の確認表示arry -->
 <?php
 // var_dump($_POST);
 // 変数の初期化
 $page_flag = 0;
 if( !empty($_POST['btn_confirm']) ) {
   $page_flag = 1;
 }
 elseif( !empty($_POST['btn_submit']) ) {
   $page_flag = 2;
 }
 ?>


 <!DOCTYPE>
 <html lang="ja">
 <head>
   <title>お問い合わせフォーム</title>
 </head>
 <body>
   <div style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333;">
     <!-- <h1>お問い合わせフォーム</h1> -->
     <?php if ($page_flag==1): ?>

       <form method="post" action="">

         <!-- 確認ボタン押された後の確認表示ページ -->
         <!-- 登録画面　確認画面 -->
         <div class="element_wrap">
           <label>日付</label>
           <p><?php echo $_POST['date']; ?>
           </p>
         </div>

         <div class="element_wrap">
           <label>時刻</label>
           <p><?php echo $_POST['time']; ?></p>
         </div>

         <div class="element_wrap">
           <label>訪問者名</label>
           <p><?php echo $_POST['name'].' 様'; ?></p>
         </div>

         <div class="element_wrap">
           <label>メモ</label>
           <p><?php echo $_POST['text']; ?></p>
         </div>


         <div class="element_wrap">

           <!-- ログイン者の確認のための表示 -->
           <!-- <label>ログイン者</label>
           <p><?php
           if(!isset($_SESSION["TEACHER_MAIL"])){
           header("Location:login.html");
           exit;
         }
         echo $_SESSION["TEACHER_MAIL"];
         ?> </p> -->


       </div>

     </div>

     <div align="left">
       <input type="submit" name="btn_back" value="戻る">

       <div align="right">
         <input type="submit" name="btn_submit" value="送信" >



         <input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
         <input type="hidden" name="time" value="<?php echo $_POST['time']; ?>">
         <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
         <input type="hidden" name="text" value="<?php echo $_POST['text']; ?>">
         <input type="hidden" name="teacher_mail" value="<?php
         if(!isset($_SESSION["TEACHER_MAIL"])){
           header("Location:login.html");
           exit;
         }
         echo $_SESSION["TEACHER_MAIL"];
         ?>">
       </form>

     <?php elseif( $page_flag === 2 ):
       $con = mysql_connect('127.0.0.1', 'J15012', 'j15012');
       if (!$con) {
         exit('データベースに接続できませんでした。');
       }
       $result = mysql_select_db('peppers', $con);
       if (!$result) {
         exit('データベースを選択できませんでした。');
       }
       $result = mysql_query('SET NAMES utf8', $con);
       if (!$result) {
         exit('文字コードを指定できませんでした。');
       }
       $date   = $_REQUEST['date'];
       $time = $_REQUEST['time'];
       $name  = $_REQUEST['name'];
       $text  = $_REQUEST['text'];
       $teacher_mail  = $_REQUEST['teacher_mail'];
       $result = mysql_query("INSERT INTO peppers(date, time, name,text,teacher_mail) VALUES('$date', '$time', '$name', '$text','$teacher_mail')", $con);
       if (!$result) {
         exit('データを登録できませんでした。');
       }
       $con = mysql_close($con);
       if (!$con) {
         exit('データベースとの接続を閉じられませんでした。');
       }
       ?>
       <p>送信が完了しました。</p>
       <div align="right">
         <input type="submit" name="button_save" value="一覧へ戻る" onClick="location.href='yoyaku_edit.php'">


       <?php else:?>
         <!-- 登録画面　入力 -->
         <form method="post" action="">
           <div class="element_wrap">
             <label>日　 付　<font color="red">*</font></label>
             <input type="date" name="date" value="" required>	</div>

             <div class="element_wrap">
               <label>時　 刻　<font color="red">*</font></label>
               <input type="time" name="time" required>
             </div>

             <div class="element_wrap">
               <label>訪問者名 <font color="red">*</font></label>
               <input type="text"pattern="[\u3041-\u3096]*" name="name" value=""placeholder="ひらがな入力" required >
             </div>

             <div class="element_wrap">
               <label>メ　モ　　</label>
               <input type="text" name="text">
             </div>


             <div class="element_wrap">

               <!-- ログイン者の確認のための表示 -->
               <!-- <label>ログイン者</label>
               <?php
               if(!isset($_SESSION["TEACHER_MAIL"])){
               header("Location:login.html");
               exit;
             }
             echo $_SESSION["TEACHER_MAIL"];
             ?> -->



             <!-- <input type="text" name="teacher_mail" value="" required>	 -->
           </div>

         </div>
         <div align="left">
           <input value="戻る" onClick="history.back();" type="button">
           <div align="right">
             <input type="submit" name="btn_confirm" value="確認画面">

           </form>
         <?php endif; ?>
       </body>
       </html>
