<?php
$servername = "localhost";
$_username = "root";
$_password = "100205";

//коннект к бд
$connect_sql = new mysqli($servername, $_username, $_password);


$db_users = $connect_sql->select_db('auth');


$msg_logout = $_COOKIE['log_msg'];