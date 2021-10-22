<?php

    session_start();

    require ("../database/conexao.php");


    function validarCampos(){
        
        $erros = [];


        // VALIDAÇÕES:

        // descricão
        if ($_POST["descricao"] = "" || !isset($_POST["descricao"])){
            $erros[] = "O campo DESCRIÇÃO é OBRIGATÓRIO";  
        }


        // peso
        if ($_POST["peso"] = "" || !isset($_POST["peso"])){
            $erros[] = "O campo PESO é OBRIGATÓRIO";
        } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))){
            $erros[] = "O campo PESO deve ser um NÚMERO";
        }
        

        // cor
        if ($_POST["cor"] = "" || !isset($_POST["cor"])){
            $erros[] = "O campo COR é OBRIGATÓRIO";  
        }


        // valor
        if ($_POST["valor"] = "" || !isset($_POST["valor"])){
            $erros[] = "O campo VALOR é OBRIGATÓRIO";
        } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))){
            $erros[] = "O campo VALOR deve ser um NÚMERO";
        }


        // desconto
        if ($_POST["desconto"] == "" || !isset($_POST["desconto"])) {
            
            $erros[] = "O CAMPO DESCONTO É OBRIGATÓRIO";

        } elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
            
            $erros[] = "O CAMPO DESCONTO DEVE SER UM NUMERO";

        }


        // categoria
        if ($_POST["categoria"] = "" || !isset($_POST["categoria"])){
            $erros[] = "O campo CATEGORIA é OBRIGATÓRIO";  
        }


        // quantidade
        if ($_POST["quantidade"] = "" || !isset($_POST["quantidade"])){
            $erros[] = "O campo QUANTIDADE é OBRIGATÓRIO";
        } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))){
            $erros[] = "O campo QUANTIDADE deve ser um NÚMERO";
        }


        // tamanho
        if ($_POST["tamanho"] = "" || !isset($_POST["tamanho"])){
            $erros[] = "O campo TAMANHO é OBRIGATÓRIO";  
        }


        // desconto
        if ($_POST["desconto"] = "" || !isset($_POST["desconto"])){
            $erros[] = "O campo DESCONTO é OBRIGATÓRIO";
        } elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))){
            $erros[] = "O campo DESCONTO deve ser um NÚMERO";
        }


        // imagem
        if ($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE){
            $erros[] = "O campo Imagem PRECISA de uma IMAGEM";
        } 
        else{
            $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

            if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
                $erros[] = "O ARQUIVO NÃO PODE SER MAIOR QUE 2MB";
            }

            $width = $imagemInfos[0];
            $height = $imagemInfos[1];

            if ($width != $height) {
                $erros[] = "A IMAGEM PRECISA SER QUADRADA";
            }
        }

        return $erros;

    }


    switch($_POST["acao"]){

        case "inserir":

            $erros = validarCampos();

            if (count($erros) > 0){
                $_SESSION["erros"] = $erros;

                header("location: novo/index.php");

                exit;
            }

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



        case "deletar":

            $produtoId = $_POST["produtoId"];
    
            $sql = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";
    
            $resultado = mysqli_query($conexao, $sql);
    
            $produto = mysqli_fetch_array($resultado);
    
            // echo $produto[0];exit;
    
            $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";
    
            $resultado = mysqli_query($conexao, $sql);
    
            unlink("./fotos/" . $produto[0]);
    
            header("location: index.php");
    
        break;
        
    

        case "editar":

            $produtoId = $_POST["produtoId"];

            $erros = validarCampos();

            if (count($erros) > 0){
                $_SESSION["erros"] = $erros;

                header("location: editar/index.php id=".$produtoId);

                exit;
            }

            /** ATUALIZANDO A IMAGEM DO PRODUTO **/

            

            if($_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE){

                $sqlImagem = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";
                
                $resultado = mysqli_query($conexao, $sqlImagem);
                $produto = mysqli_fetch_array($resultado);

                // echo $_FILES["foto"]["name"];
                // echo '<br />';
                // echo '/fotos/' . $produto["imagem"];
                // exit;

                //EXCLUSÃO DA FOTO (ARQUIVO) ANTIGA DA PASTA
                unlink("./fotos/" . $produto["imagem"]);

                //RECUPERA O NOME ORIGINAL DA IMAGEM E ARMAZENA NA VARIÁVEL
                $nomeArquivo = $_FILES["foto"]["name"];

                //EXTRAI A EXTENSÃO DO AQUIVO DE IMAGEM
                $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

                //DEFINE UM NOME ALEATORIO PARA A IMAGEM QUE SERÁ ARMAZENA
                //NA PASTA "fotos"
                $novoNomeArquivo = md5(microtime()) . ".$extensao";

                //REALIZAMOS O UPLOAD DA IMAGEM COM O NOVO NOME
                move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNomeArquivo");

            }


            /** CAPTURA OS DADOS DE TEXTO E DE NUMERO **/
            $descricao = $_POST["descricao"];

            $peso = str_replace(".", "", $_POST["peso"]);
            $peso = str_replace(",", ".", $peso);
            
            $valor = str_replace(".", "", $_POST["valor"]);
            $valor = str_replace(",", ".", $valor);

            $quantidade = $_POST["quantidade"];
            $cor = $_POST["cor"];
            $tamanho = $_POST["tamanho"];
            $desconto = $_POST["desconto"];
            $categoriaId = $_POST["categoria"];


            /** MONTAGEM E EXECUÇÃO DA INSTRUÇÃO SQL DE UPDATE **/

            $sqlUpdate = "UPDATE tbl_produto SET 
                          descricao = '$descricao',
                          peso = $peso,
                          quantidade = $quantidade,
                          cor = '$cor',
                          tamanho = '$tamanho',
                          valor = $valor,
                          desconto = $desconto,
                          categoria_id = $categoriaId";

            //Verifica se tem imagem nova para atualizar
            $sqlUpdate .= isset($novoNomeArquivo) ? ", imagem = '$novoNomeArquivo'" : "";

            $sqlUpdate .= " WHERE id = $produtoId"; 

            // echo $sqlUpdate; exit;

            $resultado = mysqli_query($conexao, $sqlUpdate);

            header("location: index.php");

        break;


        default:
            #code...
            break;
    
    }

?>