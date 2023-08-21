<?php
// registro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        //traigo los datos del formulario
        $email = $_POST["email"];
        $pass = $_POST["password"];

        // incluyo mi conexion a la base de datos

        require("conectar_bd.php");
        $hash =  password_hash($pass, PASSWORD_DEFAULT);
        //preparo el query

        $query = "INSERT INTO users(`email`, `password`)VALUES( '$email' , '$hash')";

        // adquirir datos del usuario
        $mysqli->query($query);
        $querySelect = "SELECT * FROM users WHERE email= '$email'";
        $resultado = $mysqli->query($querySelect);
        $datos = $resultado->fetch_assoc();

        session_start();

        $_SESSION["usuario"] = $datos;
        header("Location: perfil.php");
    } catch (mysqli_sql_exception $th) {
        echo  $th->getMessage();
    }
};
