<?php


//(3-1)
$dsn='�f�[�^�x�[�X';
$user='���[�U�[��';
$password='�p�X���[�h';

//�ڑ�
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));


//(3-2)
//�e�[�u���쐬
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
//�쐬�m�F
/*$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
	echo $row[0];
	echo '<br>';
}
echo "<hr>";*/


//(3-4)
//���e�m�F
/*$sql='SHOW CREATE TABLE mission4db';
$result=$pdo->query($sql);
foreach($result as $row){
	echo $row[1];
}
echo "<hr>";*/


//(3-5)
//�f�[�^����
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


//�f�[�^�ҏW�I��
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
			echo "--�p�X���[�h���Ⴂ�܂�--";
		}
	}
}


//(3-7)
//�f�[�^�ҏW���s
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
//�f�[�^�폜
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
			echo "--�p�X���[�h���Ⴂ�܂�--";
		}
	}
}


?>


<html>
<head><title>mission_4.php</title></head>
<body>
	<form action="mission_4.php" method="POST">	
		<input type="text" name="name" value="<?php echo $ediname;?>" placeholder="���O">
		<br>
		<input type="text" name="comment" value="<?php echo $edicom;?>" placeholder="�R�����g">
		<input type="hidden" name="proedi" value="<?php echo $edinum;?>">
		<br>
		<input type="text" name="pass" placeholder="�p�X���[�h">
		<input type="submit">
		<br>
		<br>
		<input type="text" name="delete"  placeholder="�폜�Ώ۔ԍ�">
		<br>
		<input type="text" name="delpass" placeholder="�p�X���[�h">
		<input type="submit" value="�폜">
		<br>
		<br>
		<input type="text" name="edit" placeholder="�ҏW�Ώ۔ԍ�">
		<br>
		<input type="text" name="edipass" placeholder="�p�X���[�h">
		<input type="submit" value="�ҏW">
	</form>
</body>
</html>


<?php


//(3-6)
//�f�[�^�\��
$sql='SELECT*FROM mission4db ORDER BY id DESC';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
	//$row�̒��ɂ̓e�[�u���̃J������������
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
}

?>