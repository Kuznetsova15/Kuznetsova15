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
