<body>

  <div class="table1">
    <table border="1">
      <tr>
        <th>Name</th>
        <th>EMail</th>
        <th>Year</th>
        <th>Pol</th>
        <th>Limbs</th>
        <th>Superpower</th>
        <th>Bio</th>
      </tr>
      <?php
     // echo '<pre>';
    //  print_r($pwrs);
     // var_dump($pwrs);
     // echo '</pre>';
      foreach($users as $user){
          echo '
            <tr>
              <td>'.$user['name'].'</td>
              <td>'.$user['email'].'</td>
              <td>'.$user['year'].'</td>
              <td>'.$user['pol'].'</td>
              <td>'.$user['limbs'].'</td>
              <td>';
                $user_pwrs=array(
                    "God"=>FALSE,
                    "fly"=>FALSE,
                    "idclip"=>FALSE,
                    "fireball"=>FALSE,
                );
       
                foreach($pwrs as $pwr){
                    if($pwr['id_per']==$user['id']){
                        if($pwr['id_sup']=='10'){
                            $user_pwrs['God']=TRUE;
                        }
                        if($pwr['id_sup']=='20'){
                            $user_pwrs['fly']=TRUE;
                        }
                        if($pwr['id_sup']=='30'){
                            $user_pwrs['idclip']=TRUE;
                        }
                        if($pwr['id_sup']=='40'){
                            $user_pwrs['fireball']=TRUE;
                        }
                    }
                }
                if($user_pwrs['God']){echo 'God<br>';}
                if($user_pwrs['idclip']){echo 'idclip<br>';}
                if($user_pwrs['fly']){echo 'fly<br>';}
                if($user_pwrs['fireball']){echo 'fireball<br>';}
              echo '</td>
              <td>'.$user['bio'].'</td>
              <td>
                <form method="get" action="ind.php">
                  <input name=edit_id value='.$user['id'].' hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>';
       }
      ?>
    </table>
    <?php
    printf('Пользователи с God: %d <br>',$pwrs_count[0]);
    printf('Пользователи с idclip: %d <br>',$pwrs_count[2]);
    printf('Пользователи с fly: %d <br>',$pwrs_count[1]);
    printf('Пользователи с fireball: %d <br>',$pwrs_count[3]);
    ?>
  </div>
</body>
