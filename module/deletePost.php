<?php

$connect = mysqli_connect("localhost", "root", "root", "newsboard") or die("Ошибка - подключение к БД");

$idDeletePost = $_POST['idDeletePost'];

mysqli_query($connect, "DELETE FROM `news` WHERE `id` = '".$idDeletePost."'") or die("Пост не удалён");

echo "deleted";

?>