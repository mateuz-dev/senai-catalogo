<?php

session_start();

require ("../database/conexao.php");


function validaCampos(){

    $erros = [];

    if(!isset($_POST['descricao']) || $_POST['descricao'] == " "){
        $erros[] = "O campo descrição é de Preenchimento Obrigatório!";
    }
    return $erros;
}



switch ($_POST["acao"]) {
    case 'inserir':

        $erros = validaCampos();

        if(count($erros) > 0){
            $_SESSION["erros"] = $erros;
            header("location: index.php");
            exit();
        }
        
        $descricao = $_POST["descricao"];

        // Montagem da Instrução SQL de Inserção de Dados:
        $sql = "INSERT INTO tbl_categoria(descricao) VALUES('$descricao')";

        /* Parâmetros mysqli_query()
            1 - Uma conexão aberta e válida
            2 - Uma instrução sql válida */
        $resultado = mysqli_query($conexao, $sql);

        header("location: index.php");
        
        /* echo '<pre>';
        var_dump($resultado);
        echo '</pre>'; */

        break;



        case 'deletar':
            $categoriaId = $_POST["categoriaId"];

            $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaId";

            $resultado = mysqli_query($conexao, $sql);

            header("location: index.php");

            exit;
    


    default:
        # code...
        break;
}