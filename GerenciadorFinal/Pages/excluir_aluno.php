<!DOCTYPE html>
<html>
    <head>
        <title>Cargos</title>
        <meta charset="UTF-8">      
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="estilo.css" />
        <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.css">   
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="styles.css">
		</head>
		<body>
		</body>
		</html>
<?php

 require 'conexao.php';

      $codigo_aluno = $_GET["alu_codigo"];
        
         $sql = "delete from alunos where alu_codigo = $codigo_aluno";
        $retorno = pg_query($conn,$sql);
        if (!$retorno){
            echo "<p>Erro ao executar sql.<br>" .  pg_last_error(). "</p>";
             echo "<p>SQL Executado:<br>" .  $sql. "</p>";
             
        }
        else {
  echo "<script>alert(' Aluno excluído com Sucesso!');"
            . " window.location='Alunos.php'"
                    . "</script>";        }
      
        
        ?>
<nav style ="margin: 10px;" aria-label="...">
  <ul class="pager">
      <li class="previous"><a href="Alunos.php"><span aria-hidden="true">&larr;</span> Voltar</a></li>
  </ul>
</nav>
