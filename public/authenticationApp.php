<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  //traigo los datos del formulario
  $email = $_POST["email"];
  $pass = $_POST["password"];

  // incluyo mi conexion a la base de datos

  require("conectar_bd.php");

  //preparo el query

  $query = "SELECT * FROM users WHERE email= '$email'";



  // Ejecuto el query.

  $resultado = $mysqli->query($query);


  //extraigo el numero de filas
  $numFilas = $resultado->num_rows;


  // corroboro el numero de filas

  if ($numFilas === 1) {

    //convierto los datos en un array asociativo
    $datos = $resultado->fetch_assoc();
    $hashVerify = password_verify($pass, $datos["password"]);
    // verifica el password hasheada
    if (password_verify($pass, $datos["password"])) {

      //guardo los datos en la variable de sesion usuario
      session_start();
      $_SESSION["usuario"] = $datos;

      //redireccionando al usuario al dashboard

      header("Location: perfil.php");
    } else {
      session_start();

      // redireccionando al usuario al index.php
      header("location: index.php");

      $_SESSION["error_login"] = "No existe la cuenta";

      header("Location: login.php");
    }
  } else {
    session_start();

    // redireccionando al usuario al index.php
    header("location: index.php");

    $_SESSION["error_login"] = "No existe la cuenta";

    header("Location: login.php");
  }
};
