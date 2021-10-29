<?php

    session_start();

    require('../../database/conexao.php');


    # F U N C Õ E S   D E   L O G I N  &  L O G O U T

    function realizarLogin($usuario, $senha, $conexao){
        $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario' AND senha = '$senha'";
        $resultado = mysqli_query($conexao, $sql);
        $dadosUsuario = mysqli_fetch_array($resultado);

        if(isset($dadosUsuario["usuario"]) && isset($dadosUsuario["senha"])){
            $_SESSION["usuarioId"] = $dadosUsuario["id"];
            $_SESSION["nome"] = $dadosUsuario["nome"];
            header("location: ../../produtos/index.php");
        } else{

        }

    }



    # E S T R TU R A   S W I T C H   C A S E

    switch($_POST["acao"]){
        case "login":
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            realizarLogin($usuario, $senha, $conexao);

        break;


        case "logout":
            session_unset();
            session_destroy();
            header("location: ../../index.php");

        break;

    }
?>