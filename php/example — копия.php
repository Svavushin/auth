<?php
$show_form = "block";
$IS_AUTH = false;





$servername = "localhost";
$username = "root";
$password = "100205";


$result_query = "";

//коннект к бд
$connect_sql = new mysqli($servername, $username, $password);

$db_users = $connect_sql->select_db('auth');


//проверяем подключение
if ($connect_sql->connect_error) {
  die("Connection failed: " . $connect_sql->connect_error);
}

// запрос на отображения данных о юзерах

// $result = $connect_sql->query("SELECT * FROM `users`");

// if ($result->num_rows > 0) {
//   while ($row = $result->fetch_assoc()) {
//     echo "users: " . $row["username"] . " - Password" . $row["password"] . "<br>";
//   }
// } else {
//   echo "0 results";
// }

// обработка пост запроса
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($connect_sql)) {

  $username_form = $_POST["username"];
  $password_form = $_POST["password"];


  // $user = '1234';
  // $pass = password_hash('1234', PASSWORD_DEFAULT);
  // $sql_enter_pass = "INSERT INTO users (`username`, `password`) VALUES (?, ?)";
  // $stmt1 = $connect_sql->prepare($sql_enter_pass);
  // $stmt1->bind_param('ss', $user, $pass);
  // $stmt1->execute();


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

      $show_form = "none"; // прячем форму
      $msg_succesfully .= ("<p>" . "Вы успешно авторизировались," . $username_form . "</p>");
    } else {
      $error_pass .= ('<p>' . "invalid password" . '</p>');
    }
  } else {
    $error_user .= ('<p>' . "invalid user" . '</p>');
  }
}
?>


<body style="background-color: #a7c8fc; display: flex; justify-content:center; align-items:center">

  <div style="color: #3ccf57; font-size: 64px">
    <? echo $msg_succesfully ?>
  </div>

  <div style="display: <?= $show_form ?> ; justify-content:center; align-items:center" id="form">

    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" style="display: block;" accept-charset="UTF-8">

      <label for="username" style="display: flex; justify-content:center;">
        Username: </label>

      <input type="text" id='username' name="username"> <br> <br>

      <label for="password" style="display: flex; justify-content:center;">
        Password:</label>

      <input type="text" id='password' name="password"> <br> <br>


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