<?php

/*

PÁRTAMETROS DE CONEXÃO MYSQL I

1 - host ---------> onde está o banco de dados
2 - user ---------> usuário do bamnco de dados
3 - password -----> senha do usuário
4 - database -----> nome do banco de dados

*/ 


const HOST = "localhost";
const USER = "root";
const PASSWORD = "bcd127";
const DATABASE = "icatalogo";


$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE);



if($conexao === false){
    die(mysqli_connect_error());
}

/* echo '<pre>';
var_dump($conexao);
echo '</pre>'; */