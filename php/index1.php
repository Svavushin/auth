<?php

session_start();

  if($_SESSION['auth'] == false){
    header('Location: /php/example.php');
  }else if($_COOKIE['AUTH'] == false){
    header('Location: /php/index1.php');
  }

  if(isset($_POST['logout'])){

    $msg_logout = "<p>" . "Вы вышли из сессии" . "</p>";
    setcookie('log_msg', $msg_logout, time() + 2, '/php/example.php');



    $_SESSION['auth'] = false;

    // чистим куки
    setcookie('AUTH', false, -1, '/');
    setcookie('username', $username_form, -1, '/');

    // чистим массив $_SESSION
    session_unset();
    session_destroy();


    $msg_logout = "<p>" . "Вы вышли из сессии" . "</p>";

    header('Location: /php/example.php');
}


     $msg_succesfully .= ("<p>" . "Вы успешно авторизировались," . $_COOKIE['username'] . "</p>");
    

   
    // echo '<pre>';
    // var_dump($_SESSION);
    // echo '</pre>';

?>


<body style="background-color: #a7c8fc; display: flex; justify-content:center; align-items:center">


  <div style="display: block;">

    <div style="color: #3ccf57; font-size: 64px">

         <? echo $msg_succesfully ?>
      
    </div>


    <!-- Кнопка выхода -->
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" style="display: block;" accept-charset="UTF-8">

      <div style="display: flex; justify-content: center;">
        <input type='submit' name='logout' value='Выйти' style="height: 50px;">
      </div>

    </form>
    <!-- Кнопка выхода -->

  </div>



</body>

