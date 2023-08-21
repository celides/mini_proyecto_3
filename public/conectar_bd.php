<?php
try {
    $mysqli = new mysqli("localhost", "root", "", "authenticationapplogin");
    //echo "conectado a base de dato";
} catch (mysqli_sql_exception $e) {
    echo "Error:" . $e->getMessage();
}
