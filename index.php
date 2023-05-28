<?php
echo "<link rel='stylesheet' href='style.css'>";
header('Content-Type: text/html; charset=UTF-8');

$user = 'u52809';
$pass = '3437720';

$db = new PDO('mysql:host=localhost;dbname=u52809', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$pass_hash=array();
try{
    $get=$db->prepare("select password from admin where name=?");
    $get->execute(array('admin'));
    $pass_hash=$get->fetchAll()[0][0];
   // echo '<pre>';
    //print_r($pass_hash);
   // var_dump($pass_hash);
   // echo '</pre>';
}

catch(PDOException $e){
    print('Error: '.$e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
        setcookie('name_value', '', 100000);
        setcookie('email_value', '', 100000);
        setcookie('year_value', '', 100000);
        setcookie('gender_value', '', 100000);
        setcookie('limb_value', '', 100000);
        setcookie('bio_value', '', 100000);
        setcookie('superpower_value', '', 100000);
        setcookie('check_value', '', 100000);
    }
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    password_verify($_SERVER['PHP_AUTH_PW'],$pass_hash[0][0])) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Unauthorized (Требуется авторизация)</h1>');
        exit();
    }
    if(empty($_GET['edit_id'])){
        header('Location: admin.php');
    }
    header('Content-Type: text/html; charset=UTF-8');
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $messages = array();
        if (!empty($_COOKIE['save'])) {
            setcookie('save', '', 100000);
            $messages[] = 'Спасибо, результаты сохранены.';
            setcookie('fio_value', '', 100000);
            setcookie('email_value', '', 100000);
            setcookie('year_value', '', 100000);
            setcookie('gender_value', '', 100000);
            setcookie('limbs_value', '', 100000);
            setcookie('text_value', '', 100000);
            setcookie('superpower_value', '', 100000);
            setcookie('check_value', '', 100000);
        }
        
        $errors = array();
        $error=FALSE;
        $errors['name'] = !empty($_COOKIE['name_error']);
        $errors['email'] = !empty($_COOKIE['email_error']);
        $errors['year'] = !empty($_COOKIE['year_error']);
        $errors['gender'] = !empty($_COOKIE['pol_error']);
        $errors['limbs'] = !empty($_COOKIE['limb_error']);
        $errors['superpower'] = !empty($_COOKIE['superpower_error']);
        $errors['text'] = !empty($_COOKIE['text_error']);
        $errors['check'] = !empty($_COOKIE['check_error']);
        if ($errors['name']) {
            setcookie('name_error', '', 100000);
            $messages[] = '<div class="error">Заполните имя или у него неверный формат (only English)</div>';
            $error=TRUE;
        }
        if ($errors['email']) {
            setcookie('email_error', '', 100000);
            $messages[] = '<div class="error">Заполните имейл или у него неверный формат</div>';
            $error=TRUE;
        }
        if ($errors['year']) {
            setcookie('year_error', '', 100000);
            $messages[] = '<div class="error">Выберите год.</div>';
            $error=TRUE;
        }
        if ($errors['gender']) {
            setcookie('pol_error', '', 100000);
            $messages[] = '<div class="error">Выберите пол.</div>';
            $error=TRUE;
        }
        if ($errors['limbs']) {
            setcookie('limb_error', '', 100000);
            $messages[] = '<div class="error">Укажите кол-во конечностей.</div>';
            $error=TRUE;
        }
        if ($errors['superpower']) {
            setcookie('superpower_error', '', 100000);
            $messages[] = '<div class="error">Выберите суперспособности(хотя бы одну).</div>';
            $error=TRUE;
        }
        if ($errors['text']) {
            setcookie('text_error', '', 100000);
            $messages[] = '<div class="error">Заполните биографию или у неё неверный формат (only English)</div>';
            $error=TRUE;
        }
        $values = array();
        
        $user = 'u52809';
        $pass = '3437720';
        $db = new PDO('mysql:host=localhost;dbname=u52809', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try{
            $id=$_GET['edit_id'];
            $get=$db->prepare("SELECT * FROM form WHERE id=?");
            $get->bindParam(1,$id);
            $get->execute();
            $inf=$get->fetchALL();
            $values['name']=$inf[0]['name'];
            $values['email']=$inf[0]['email'];
            $values['year']=$inf[0]['year'];
            $values['gender']=$inf[0]['pol'];
            $values['limbs']=$inf[0]['limbs'];
            $values['text']=$inf[0]['bio'];
            $values['superpower'] = 't';
            $values['check'] = TRUE;
           // echo '<pre>';
          //  print_r($inf);
          //  var_dump($inf);
          ////  echo '</pre>';
            $get2=$db->prepare("SELECT * FROM Sform WHERE id_per=?");
            $get2->bindParam(1,$id);
            $get2->execute();
            foreach ($get2 as $row){
                
            }
            $inf2=$get2->fetchALL();
        //    echo '<pre>';
        //     print_r($inf2);
         //     echo '</pre>';
            if($inf2 == '10'){
            $values['superpower']='t';
            }
            if($inf2 == '20'){
            $values['superpower']='b';
            }
            if($inf2 == '30'){
            $values['superpower']='c';
            }
            if($inf2 == '40'){
            $values['superpower']='p';
           }
        }
        catch(PDOException $e){
            print('Error: '.$e->getMessage());
            exit();
        }
        include('form.php');
    }
    else {
        if(!empty($_POST['save'])){
            $id=$_POST['dd'];
            $name = $_POST['fio'];
            $email = $_POST['email'];
            $year = $_POST['year'];
            $pol=$_POST['gender'];
            $limbs=$_POST['limbs'];
            $powers=$_POST['superpower'];
            $bio=$_POST['text'];
            
            //Регулярные выражения
            $bioregex = "/^\s*\w+[\w\s\.,-]*$/";
            $nameregex = "/^\w+[\w\s-]*$/";
            $mailregex = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
            $errors = FALSE;
            
            if (empty($name) || (!preg_match($nameregex,$name))) {
                setcookie('name_error', '1', time() + 24*60 * 60);
                setcookie('name_value', '', 100000);
                $errors = TRUE;
            }
            
            if (empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL) ||
                (!preg_match($mailregex,$email))) {
                    setcookie('email_error', '1', time() + 24*60 * 60);
                    setcookie('email_value', '', 100000);
                    $errors = TRUE;
                }
                
                if ($year=='Год') {
                    setcookie('year_error', '1', time() + 24 * 60 * 60);
                    setcookie('year_value', '', 100000);
                    $errors = TRUE;
                }
                
                if (!isset($pol)) {
                    setcookie('gender_error', '1', time() + 24 * 60 * 60);
                    setcookie('gender_value', '', 100000);
                    $errors = TRUE;
                }
                
                if (!isset($limbs)) {
                    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
                    setcookie('limbs_value', '', 100000);
                    $errors = TRUE;
                }
                
                if (!isset($powers)) {
                    setcookie('superpower_error', '1', time() + 24 * 60 * 60);
                    $errors = TRUE;
                }
                
                if ((empty($bio)) || (!preg_match($bioregex,$bio))) {
                    setcookie('bio_error', '1', time() + 24 * 60 * 60);
                    setcookie('bio_value', '', 100000);
                    $errors = TRUE;
                }
                
                if ($errors) {
                    setcookie('save','',100000);
                    header('Location: index.php?edit_id='.$id);
                }
                else {
                    setcookie('name_error', '', 100000);
                    setcookie('email_error', '', 100000);
                    setcookie('year_error', '', 100000);
                    setcookie('pol_error', '', 100000);
                    setcookie('limb_error', '', 100000);
                    setcookie('superpower_error', '', 100000);
                    setcookie('bio_error', '', 100000);
                    setcookie('check_error', '', 100000);
                }
                
                $user = 'u52809';
                $pass = '3437720';
                $db = new PDO('mysql:host=localhost;dbname=u52809', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
                if(!$errors){
                    $upd=$db->prepare("UPDATE form SET name=:name, email=:email, year=:byear, pol=:pol, limbs=:limbs, bio=:bio WHERE id=:id");
                    $cols=array(
                        ':name'=>$name,
                        ':email'=>$email,
                        ':byear'=>$year,
                        ':pol'=>$pol,
                        ':limbs'=>$limbs,
                        ':bio'=>$bio
                    );
                    $upd->bindParam(':id',$id);
                    $upd->execute();
                    $del=$db->prepare("DELETE FROM Sform WHERE id_per=?");
                    $del->execute(array($id));
                    $upd1=$db->prepare("INSERT INTO Sform SET id_sup=:power,per_id=:id");
                    $upd1->bindParam(':id',$id);
                }
                
                if(!$errors){
                    setcookie('save', '1');
                }
                header('Location: index.php?edit_id='.$id);
         }
        else {
            $id=$_POST['dd'];
            $user = 'u52809';
            $pass = '3437720';
            $db = new PDO('mysql:host=localhost;dbname=u52809', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            try {
                $del=$db->prepare("DELETE FROM Sform WHERE id_per=?");
                $del->execute(array($id));
                $stmt = $db->prepare("DELETE FROM form WHERE id=?");
                $stmt -> execute(array($id));
            }
            catch(PDOException $e){
                print('Error : ' . $e->getMessage());
                exit();
            }
            setcookie('del','1');
            setcookie('del_user',$id);
            header('Location: admin.php');
        }
        
    }
    
