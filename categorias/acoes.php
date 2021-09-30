<?php

require ("../database/conexao.php");



switch ($_POST["acao"]) {
    case 'inserir':
        
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
    
    default:
        # code...
        break;
}