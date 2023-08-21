<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //traigo los datos del formulario
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $phone = $_POST["phone"];
    $bio = $_POST["bio"];
    // incluyo mi conexion a la base de datos

    $route;

    if (isset($_FILES['photo']['name'])) {

        $photoname = $_FILES['photo']['name'];
        $dir = $_FILES['photo']['tmp_name'];
        $route = "./uploads/$photoname";
        move_uploaded_file($dir, $route);
    }

    require("conectar_bd.php");

    if ($_POST["password"] != null) {
        $hash =  password_hash($pass, PASSWORD_DEFAULT);
        $mysqli->query("UPDATE users SET `password`='$hash'");
    }

    if ($_FILES['photo']['name'] != null) {

        $hash =  password_hash($pass, PASSWORD_DEFAULT);
        $mysqli->query("UPDATE users SET `photo`='$route' ");
    }



    //preparo el query


    $query = "UPDATE users SET `name`='$name',`phone`='$phone',`bio`='$bio' WHERE `email` = '$email'";

    // ejecutar query
    $mysqli->query($query);


    session_start();

    // adquirir datos del usuario
    $mysqli->query($query);
    $querySelect = "SELECT * FROM users WHERE email= '$email'";
    $resultado = $mysqli->query($querySelect);
    $datos = $resultado->fetch_assoc();
    $_SESSION["usuario"] = $datos;
    header("Location: perfil.php");
};
