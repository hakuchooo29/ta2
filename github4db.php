<?php


//(3-1)
$dsn='データベース';
$user='ユーザー名';
$password='パスワード';

//接続
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));


//(3-2)
//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission4db"
."("
."id int auto_increment,"
."name char(32),"
."comment text,"
."date timestamp,"
."pass char(32),"
."primary key(id)"
.");";
$stmt=$pdo->query($sql);


//(3-3)
//作成確認
/*$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
	echo $row[0];
	echo '<br>';
}
echo "<hr>";*/


//(3-4)
//内容確認
/*$sql='SHOW CREATE TABLE mission4db';
$result=$pdo->query($sql);
foreach($result as $row){
	echo $row[1];
}
echo "<hr>";*/


//(3-5)
//データ入力
$name=$_POST["name"];
$comment=$_POST["comment"];
$pass=$_POST["pass"];
$proedi=$_POST["proedi"];
if(!empty($name) && !empty($comment) && $proedi=="" && !empty($pass)){
	$sql=$pdo->prepare("INSERT INTO mission4db(name,comment,date,pass)VALUES(:name,:comment,:date,:pass)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
	$date=date("y/m/d H:i:s");
	$sql->execute();
}


//データ編集選択
$edit=$_POST["edit"];
$edipass=$_POST["edipass"];
if(!empty($edipass)){
	$sql="SELECT*FROM mission4db where id='{$edit}'";
	$stmt=$pdo->query($sql);
	$results=$stmt->fetchAll();
	foreach($results as $row){
		if($row["pass"]==$edipass){
			$edinum=$row["id"];
			$ediname=$row["name"];
			$edicom=$row["comment"];
		}
		else{
			echo "--パスワードが違います--";
		}
	}
}


//(3-7)
//データ編集実行
if(!empty($pass)){
	$proedi=$_POST["proedi"];
	$sql="update mission4db set name='{$name}',comment='{$comment}',pass='{$pass}' where id='{$proedi}'";
	$stmt=$pdo->prepare($sql);
	$stmt->bindParam(':name',$name,PDO::PARAM_STR);
	$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
	$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
	$stmt->bindParam(':id',$id,PDO::PARAM_INT);
	$stmt->execute();
}

//(3-8)
//データ削除
$delpass=$_POST["delpass"];
$delete=$_POST["delete"];
if(!empty($delpass)){
	$sql="SELECT*FROM mission4db where id='{$delete}'";
	$stmt=$pdo->query($sql);
	$results=$stmt->fetchAll();
	foreach($results as $row){
		if($row["pass"]==$delpass){
			$sql="delete from mission4db where id='{$delete}'";
			$stmt=$pdo->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
		}
		else{
			echo "--パスワードが違います--";
		}
	}
}


?>


<html>
<head><title>mission_4.php</title></head>
<body>
	<form action="mission_4.php" method="POST">	
		<input type="text" name="name" value="<?php echo $ediname;?>" placeholder="名前">
		<br>
		<input type="text" name="comment" value="<?php echo $edicom;?>" placeholder="コメント">
		<input type="hidden" name="proedi" value="<?php echo $edinum;?>">
		<br>
		<input type="text" name="pass" placeholder="パスワード">
		<input type="submit">
		<br>
		<br>
		<input type="text" name="delete"  placeholder="削除対象番号">
		<br>
		<input type="text" name="delpass" placeholder="パスワード">
		<input type="submit" value="削除">
		<br>
		<br>
		<input type="text" name="edit" placeholder="編集対象番号">
		<br>
		<input type="text" name="edipass" placeholder="パスワード">
		<input type="submit" value="編集">
	</form>
</body>
</html>


<?php


//(3-6)
//データ表示
$sql='SELECT*FROM mission4db ORDER BY id DESC';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
}

?>