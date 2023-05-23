<?php

if($_SERVER['REQUEST_METHOD']=='GET'){
  $user = 'u52809';
  $pass = '3437720';
  $db = new PDO('mysql:host=localhost;dbname=u52813', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $pass_hash=array();
  try{
    $get=$db->prepare("select password from admin where name=?");
    $get->execute(array('admin'));
    $pass_hash=$get->fetchAll()[0][0];
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
  }
  
  
  //аутентификация
  if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      password_verify($_SERVER['PHP_AUTH_PW'], $pass_hash[0][0])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  if(!empty($_COOKIE['del'])){
    echo 'Пользователь '.$_COOKIE['del_user'].' был удалён <br>';
    setcookie('del','');
    setcookie('del_user','');
  }
  print('Вы успешно авторизовались и видите защищенные паролем данные');
  $users=array();
  $pwrs=array();
  $pwr_def=array('10','20', '30', '40');
  $pwrs_count=array();
  try{
    $get=$db->prepare("select * from form");
    $get->execute();
    $inf=$get->fetchALL();
    $get2=$db->prepare("select id_per,id_sup from Sform");
    $get2->execute();
    $inf2=$get2->fetchALL()
    ;
    $count=$db->prepare("select count(*) from Sform where id_sup=?");
    foreach($pwr_def as $pw){
      $i=0;
      $count->execute(array($pw));
      $pwrs_count[]=$count->fetchAll()[$i][0];
      $i++;
    }
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }
  $users=$inf;
  $pwrs=$inf2;
 // echo '<pre>';
 // print_r($inf2);
 // var_dump($inf2);
 // echo '</pre>';
  include('list.php');
}
