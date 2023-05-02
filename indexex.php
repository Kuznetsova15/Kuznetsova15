<?php
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}

$errors = FALSE;
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['year']) || empty($_POST['bio']) || empty($_POST['check1']) || $_POST['check1'] == false || !isset($_POST['super']) ){
	print('Заполните пустые поля!');
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
if($pol !== 'male' && $pol !== 'female'){
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
  $stmt = $db->prepare("INSERT INTO application SET name=:name, mail=:email, year=:byear, sex=:pol, number_limb=:limbs, biography=:bio");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':byear', $birth_year);
  $p =  $pol == 'female' ? 2 : 1;
  $stmt->bindParam(':pol', $p);
  $stmt->bindParam(':limbs', $limbs);
  $stmt->bindParam(':bio', $bio);

  if($stmt->execute()==false){
  print_r($stmt->errorCode());
  print_r($stmt->errorInfo());
  exit();
  }
  
  
  $id = $db->lastInsertId();
  $sppe= $db->prepare("INSERT INTO power_pers SET id=:person, power=:name");
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
