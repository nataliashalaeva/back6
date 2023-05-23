<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
echo "<link rel='stylesheet' href='style.css'>";
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
    header('Location: index.php');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="login.php" method="post">
  <input name="login" />
  <input name="password" type ="password"/>
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
    $login=$_POST['login'];
    $pswrd=$_POST['password'];
    $uid=0;
    $error=TRUE;
    $user = 'u52809';
    $pass = '3437720';
    $db1 = new PDO('mysql:host=localhost;dbname=u52809', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    if(!empty($login) and !empty($pswrd)){
        try{
            $check=$db1->prepare("SELECT * FROM login WHERE login=?");
            $check->bindParam(1,$login);
            $check->execute();
            $username=$check->fetchALL();
      //     echo '<pre>';
      //      print_r($username);
    //        var_dump($username);
     //       echo '</pre>';
            if(password_verify($pswrd,$username[0][2])){
                $uid=$username[0]['id'];
                $error=FALSE;
            }
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    if($error==TRUE){
        print('Неправильные логин или пароль <br> Создайте нового <a href="index.php">пользователя</a> или <a href="login.php">попробуйте войти снова</a> ');
        session_destroy();
        exit();
    }

  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $login;
  // Записываем ID пользователя.
  $_SESSION['uid'] = $uid;

  // Делаем перенаправление.
  header('Location: index.php');
}
