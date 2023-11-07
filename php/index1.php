<?php
session_start();



    if(empty($_COOKIE['password']) && empty($_COOKIE['username'])){
        header('Location: /php/example.php');
    }

     $msg_succesfully .= ("<p>" . "Вы успешно авторизировались," . $_COOKIE['username'] . "</p>");
    

    if(isset($_POST['logout'])){
        header('Location: /php/example.php');
        $msg_logout = "<p>" . "Вы вышли из сессии" . "</p>";
        setcookie('log_msg', $msg_logout, time() + 2, '/php/example.php');


        session_destroy();

        // чистим куки
        setcookie('username', $username_form, -1, '/');
        setcookie('password', $_POST["password"], -1, '/');    
    }

?>


<body style="background-color: #a7c8fc; display: flex; justify-content:center; align-items:center">


  <div style="display: block;">

    <div style="color: #3ccf57; font-size: 64px">

         <? echo $msg_succesfully ?>
      
    </div>


    <!-- Кнопка выхода -->
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" style="display: block;" accept-charset="UTF-8">

      <div style="display: flex; justify-content:center;">
        <input type='submit' name='logout' value='Выйти' style="height: 50px;">
      </div>

    </form>
    <!-- Кнопка выхода -->

  </div>



</body>