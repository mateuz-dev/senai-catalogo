<?php

    session_start();

    require('../../database/conexao.php');

    function realizarLogin($usuario, $senha, $conexao) {
        $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario' AND senha = '$senha'";
        $resultado = mysqli_query($conexao, $sql);
        $dadosUsuario = mysqli_fetch_array($resultado);

        if(isset($dadosUsuario["usuario"]) && isset($dadosUsuario["senha"])){

        } else{
            session_unset();
            session_destroy();
            header("location: ../../index.php");
        }
    }

    realizarLogin('mateus', '19072005m', $conexao);
?>