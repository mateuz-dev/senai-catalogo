<?php

require ("../database/conexao.php");

switch($_POST["acao"]){
    case "inserir":

        // TRATAMENTO DA IMAGEM PARA UPLOAD:
        $nomeArquivo = $_FILES["foto"]["name"];

        // RECUPERAR A EXTENÇÃO DO ARQUIVO
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
        
        // DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM
        $novoNome = md5(microtime()) . "." . $extensao;

        // UPLOAD DO ARQUIVO
        move_uploaded_file($_FILES["foto"]["tmp_name"], "./fotos/$novoNome");

        $descricao = $_POST["descricao"];
        $peso = $_POST["peso"];
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = $_POST["valor"];
        $desconto = $_POST["desconto"];
        $categoriaId = $_POST["categoria"];

        // INSTRUÇÃO SQL DE INSERÇÃO DE DADOS
        $sql = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id)
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNome', '$categoriaId')";

        $resultado = mysqli_query($conexao, $sql);

        header("location: ./novo/index.php");

        break;
}

?>