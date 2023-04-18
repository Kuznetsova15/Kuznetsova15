<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] != 'POST'){
	print_r('Не POST методы не принимаются');
}
$errors = FALSE;
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['year']) || empty($_POST['bio']) || empty($_POST['check1']) || $_POST['check1'] == false || !isset($_POST['super']) ){
	print_r('Заполните пустые поля!');
	exit();
}
$name = $_POST['name'];
$email = $_POST['email'];
$birth_year = $_POST['year'];
$pol = $_POST['radio-1'];
$limbs = intval($_POST['radio-2']);
$superpowers = array($_POST['super']);
$bio= $_POST['bio'];

$bioreg = "/^\s*\w+[\w\s\.,-]*$/";
$reg = "/^\w+[\w\s-]*$/";
$mailreg = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
$list_sup = array(1, 2, 3);

if(!preg_match($reg,$name)){
	print_r('Неверный формат имени');
	exit();
}
if($limbs == 0){
	print_r('Нет конечностей');
	exit();
}
if(!preg_match($bioreg,$bio)){
	print_r('Неверный формат биографии');
	exit();
}
if(!preg_match($mailreg,$email)){
	print_r('Неверный формат email');
	exit();
}
if($pol !== 1 && $pol !== 2){
	print_r('Неверный формат пола');
	exit();
}
foreach($superpowers as $checking){
	if(array_search($checking,$list_sup)=== false){
			print_r('Неверный формат суперсил');
			exit();
	}
}

$user = 'u53002';
$pass = '8089091';
$db = new PDO('mysql:host=localhost;dbname=u53002', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
try {
  $stmt = $db->prepare("INSERT INTO application SET name=:name, email=:email, year=:byear, pol=:pol, limbs=:limbs, bio=:bio");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':byear', $birth_year);
  $stmt->bindParam(':pol', $pol);
  $stmt->bindParam(':limbs', $limbs);
  $stmt->bindParam(':bio', $bio);

  if($stmt->execute()==false){
  print_r($stmt->errorCode());
  print_r($stmt->errorInfo());
  exit();
  }
  
  
  $id = $db->lastInsertId();
  $sppe= $db->prepare("INSERT INTO super SET name=:name, per_id=:person");
  $sppe->bindParam(':person', $id);
  foreach($superpowers as $inserting){
	$sppe->bindParam(':name', $inserting);
	if($sppe->execute()==false){
	  print_r($sppe->errorCode());
	  print_r($sppe->errorInfo());
	  exit();
	}
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

print_r("Данные отправлены");
?>
