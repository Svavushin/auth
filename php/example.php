<?php
include 'db.php';
session_start();

if ($_SESSION['auth'] == true){
  header('Location: /php/index1.php');
} else if($_COOKIE['AUTH'] == true){
  header('Location: /php/index1.php');
}


//проверяем подключение
// if ($connect_sql->connect_error) {
//   die("Connection failed: " . $connect_sql->connect_error);
// }

// запрос на отображения данных о юзерах

// $result = $connect_sql->query("SELECT * FROM `users`");

// if ($result->num_rows > 0) {
//   while ($row = $result->fetch_assoc()) {
//     echo "users: " . $row["username"] . " - Password" . $row["password"] . "<br>";
//   }
// } else {
//   echo "0 results";
// }


// $user = '1234';
// $pass = password_hash('1234', PASSWORD_DEFAULT);
// $sql_enter_pass = "INSERT INTO users (`username`, `password`) VALUES (?, ?)";
// $stmt1 = $connect_sql->prepare($sql_enter_pass);
// $stmt1->bind_param('ss', $user, $pass);
// $stmt1->execute();


// обработка пост запроса

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($connect_sql)) {

    $username_form = $_POST["username"];
    $password_form = $_POST["password"];


    // создаем запрос
    $sql_users = "SELECT * FROM users WHERE username = ?";


    // готовим запрос
    $stmt = $connect_sql->prepare($sql_users);
    $stmt->bind_param('s', $username_form);

    // делаем запрос
    $stmt->execute();

    // получаем результат
    $result_db = $stmt->get_result();


    // чек юзера
    if ($result_db->num_rows > 0) {

      $user = $result_db->fetch_assoc();


      // чек паролей
      if (password_verify($password_form, $user['password'])) {
        
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $username_form;
  
        setcookie('username', $username_form, time() + 3600 * 24, '/');
        setcookie('AUTH', true, time() + 3600 * 24, '/');



        header('Location: /php/index1.php');
        

      } else {
        $error_pass .= ('<p>' . "invalid password" . '</p>');
      }
    } else {
      $error_user .= ('<p>' . "invalid user" . '</p>');
    }
}
?>




<html>

<head>
  <title>Site</title>
  <meta charset="utf-8">



</head>




<body style="background-color: #a7c8fc; display: flex; justify-content:center; align-items:center">

  <div style="display: <?= $show_form ?> ; justify-content:center; align-items:center; width: 100%" id="form">

    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" style="display: block; width: 100%" accept-charset="UTF-8">

      <div style="color: #3ccf57; font-size: 30px; display: flex; justify-content:center; color:#ff4059">
        <? echo $msg_logout ?>
      </div>


      <label for="username" style="display: flex; justify-content:center;">
        Username: </label>

      <div style="display: flex; justify-content:center; height:25px; margin-bottom:10px">
        <input type="text" id='username' name="username"> <br> <br>
      </div>

      <label for="password" style="display: flex; justify-content:center;">
        Password:</label>


      <div style="display: flex; justify-content:center; height:25px; margin-bottom:10px">
        <input type="text" id='password' name="password"> <br> <br>
      </div>



      <div style="display: flex; justify-content:center;">
        <input type='submit' value="Enter">
      </div>



      <div style="display: flex; justify-content:center; color:#ff4059">
        <? echo $error_pass ?>
        <? echo $error_user ?>
      </div>


    </form>

  </div>

</body>


</html>