<?php
$host = "pgsql.onucleo.com.br";
$dbname = "onucleo";

$user = "onucleo";
$password = "e5z8t4";

$conn = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");


if(!$conn){
    exit("Erro ao conectar com Banco de Dados!");
}
?>
