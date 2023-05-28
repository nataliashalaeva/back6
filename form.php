<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.

?>


    <form action="" method="POST">
     <p> Форма </p>
 <p> Напишите имя, год и email. <br>
      <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name'];?>" />
        <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
    <?php
    for ($i = 2023; $i >= 1922; $i--) {
        if ($i == $values['year']) {
            printf('<option selected value="%d">%d год</option>', $i, $i);
        } else {
            printf('<option value="%d">%d год</option>', $i, $i);
        }
    }?>
  </select>
  <input name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
  </p>
  <p>Выберите пол: <br>
  <INPUT name="gender" <?php if ($errors['gender']) {print 'class="error"';}?>
  <?php if ($values['gender'] == 'm') {print 'checked'; }?> type="radio" value="m">
М
<INPUT name="gender" <?php if ($errors['gender']) {print 'class="error"';}?>
<?php if ($values['gender'] == 'j') {print 'checked'; }?> type="radio" value="j">
Ж
</p>
  <p>Выберите суперсилу: <br>
  <select name="superpower" <?php if ($errors['superpower']) {print 'class="error"';} ?> size="1">
  <option value="t" <?php if ($values['superpower'] == 't') {print 'selected'; }?>>God</option>
  <option value="b" <?php if ($values['superpower'] == 'b') {print 'selected'; }?>>fly</option>
  <option value="c" <?php if ($values['superpower'] == 'c') {print 'selected'; }?>>idclip</option>
  <option value="p" <?php if ($values['superpower'] == 'p') {print 'selected'; }?>>fireball</option>
</select></p> 
<p>
Сколько у вас конечностей <br>

<INPUT name="limbs" <?php if ($errors['limbs']) {print 'class="error"';} ?> <?php if ($values['limbs'] == '0') {print 'checked'; }?> type="radio" value="0">

0
<INPUT name="limbs" <?php if ($errors['limbs']) {print 'class="error"';} ?> <?php if ($values['limbs'] == '1') {print 'checked'; }?>  type="radio" value="1">
1
<INPUT name="limbs" <?php if ($errors['limbs']) {print 'class="error"';} ?> <?php if ($values['limbs'] == '2') {print 'checked'; }?>  type="radio" value="2">
2
<INPUT name="limbs" <?php if ($errors['limbs']) {print 'class="error"';} ?> <?php if ($values['limbs'] == '3') {print 'checked'; }?>  type="radio" value="3">
3
<INPUT name="limbs" <?php if ($errors['limbs']) {print 'class="error"';} ?> <?php if ($values['limbs'] == '4') {print 'checked'; }?>  type="radio" value="4">
4
</p>
<INPUT type="text" <?php if ($errors['text']) {print 'class="error"';} ?> value="<?php print $values['text']; ?>" name="text" size="100" maxlength="100">
<div class="checkbox <?php if ($errors['check']) {print 'error';} ?> ">
                <input type="checkbox" name="check" <?php if($values['check']==TRUE){print 'checked';} ?>/> С контактом ознакомлен(а)
            </div>
<p>
  <input type="submit" value="ok" />
</p>

<?php
            if(empty($_SESSION['login'])){
            echo'
            <div class="login">
                <p> <a href="login.php">Если имеется аккаунт, то нажмите здесь</a></p>
            </div>';
            }
            else{
                echo '
            <div class ="logout">
                <form action="index.php" method="post">
                    <input name="logout" type="submit" value="Выйти">
                </form>
                </div>';
                
            } ?>

    </form>
  </body>
</html>
	
                
                <input name='dd' hidden value=<?php print($_GET['edit_id']);?>>
                <input type="submit" name='save' value="Save"/>
                <input type="submit" name='del' value="Delete"/>
    </form>
             <a href='admin.php' class="button">Назад</a>

    </div>
</body>
