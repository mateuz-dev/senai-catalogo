<?php
    require('../../database/conexao.php');

    $idProduto = $_GET['id'];
  
    $sql = "SELECT * FROM tbl_Produto WHERE id = $idProduto";
  
    $resultado = mysqli_query($conexao, $sql);
  
    $idProduto = mysqli_fetch_array($resultado);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles-global.css" />
  <link rel="stylesheet" href="./editar.css" />
  <link rel="shortcut icon" href="../../imgs/logo.png" type="image/x-icon">
  <title>WE | EDITAR PRODUTO</title>

</head>

<body>
 
  <div class="content">

    <section class="produtos-container">

      <main>

        <form class="form-produto" method="POST" action="../acoes.php" enctype="multipart/form-data">
         
          <input type="hidden" name="acao" value="editar" />
          
          <input type="hidden" name="produtoId" value="" />
          
          <h1>Editar Produto</h1>
          
          <ul>
      
          </ul>

          <div class="input-group span2">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" value="" id="descricao" value="<?php echo $idProduto["descricao"]; ?>" required>
          </div>

          <div class="input-group">
            <label for="peso">Peso</label>
            <input type="text" name="peso" value="" id="peso" value="<?php echo $idProduto["peso"]; ?>" required>
          </div>

          <div class="input-group">
            <label for="quantidade">Quantidade</label>
            <input type="text" name="quantidade" value="" id="quantidade" value="<?php echo $idProduto["quantidade"]; ?>" required>
          </div>

          <div class="input-group">
            <label for="cor">Cor</label>
            <input type="text" name="cor" value="" id="cor" value="<?php echo $idProduto["cor"]; ?>" required>
          </div>

          <div class="input-group">
            <label for="tamanho">Tamanho</label>
            <input type="text" value="" name="tamanho" id="tamanho" value="<?php echo $idProduto["tamanho"]; ?>">
          </div>

          <div class="input-group">
            <label for="valor">Valor</label>
            <input type="text" name="valor" value="" id="valor" value="<?php echo $idProduto["valor"]; ?>" required>
          </div>

          <div class="input-group">
            <label for="desconto">Desconto</label>
            <input type="text" name="desconto" value="" id="desconto" value="<?php echo $idProduto["desconto"]; ?>">
          </div>

          <div class="input-group">

            <label for="Produto">Categoria</label>

            <select id="categoria" name="categoria">

              <option value="">SELECIONE</option>

                <?php
                  while($categoria = mysqli_fetch_array($resultado)){
                ?>
                  <option value="<?php echo $categoria["id"] ?>"> <?php echo $categoria["descricao"] ?></option>
                <?php } ?>
              
            </select>

          </div>

          <div class="input-group">
            <label for="categoria">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*" />
          </div>
         
          <button onclick="javascript:window.location.href = '../'">Cancelar</button>
          <button>Salvar</button>

        </form>

      </main>

    </section>

  </div>

  <footer>
    SENAI 2021 - Todos os direitos reservados
  </footer>
  
</body>

</html>