<?php
    /**
     * config database
     */
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DBSA', 'receita');
    define('PORT', '3308');

    $conectar = mysqli_connect(HOST, USER, PASSWORD, '', PORT) or die('Error ao conectar ao servidor: '.mysqli_connect_error());
    $dbsa = mysqli_select_db($conectar, DBSA) or die('Error ao conectar com Banco de dados: '.mysqli_error($conectar));
    
?>