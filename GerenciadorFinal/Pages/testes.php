<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">-->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <style>
            .va{
                vertical-align: middle !important;
            }
        </style>

    </head>
    <body>
        <div class="container">

            <h1>OrientaÃ§Ãµes cadastradas</h1>
            <br><br>

            <?php
            include 'conexao.php';
            $sql = "select p.pjt_codigo,pjt_tema,alu_nome, pro_nome, p.pjt_status,p.pjt_projetosfuturos from projeto p,alunos a, professores pr, orientacao o
          where p.pjt_codigo = o.pjt_codigo and a.alu_codigo = o.alu_codigo and pr.pro_codigo = o.pro_codigo";

            $result = pg_query($sql);
            
            while ($row = pg_fetch_assoc($result)) {
                $arraypjt[] = $row["pjt_codigo"];
                $arraytema[] = $row["pjt_tema"];
                $arrayaluno[] = $row["alu_nome"];
                $arraypro[] = $row["pro_nome"];
                $arrayastatus[] = $row["pjt_status"];
                $arrayastatus[] = $row["pjt_status"];
                $arraypf[] = $row["pjt_projetosfuturos"];
            }
            $array_dados = array();

            array_push($array_dados, array("pjt_codigo" => $arraypjt, "tema" => $arraytema, "aluno" => $arrayaluno, "prof" => $arraypro, "status" => $arrayastatus, "projetosfuturos" => $arraypf));
            ?>

            <table class="table table-bordered">
                <tr>
                    <th>CÃ³digo</th>
                    <th>Tema</th>
                    <th>Aluno</th>
                    <th>Professor</th>
                    <th>Status</th>
                    <th>Projetos Futuros</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>

<?php
for ($i = 0; $i < count($array_dados); $i++) {
    $key = $i;
    $value = $array_dados[$i];

    if ($array_dados[($key + 1)]["pjt_codigo"] == $value["pjt_codigo"]) {
        ?>
                        <tr>
                            <td rowspan="2" class="va"><?php echo $value["pjt_codigo"] . " $a"; ?></td>
                            <td rowspan="2" class="va"><?= $value["tema"]; ?></td>
                            <td><?= $value["aluno"]; ?></td>
                            <td rowspan="2" class="va"><?= $value["aluno"]; ?></td>
                            <td rowspan="2" class="va"><?= $value["prof"]; ?></td>
                            <td rowspan="2" class="va"><?= $value["status"]; ?></td>
                                                        <td rowspan="2" class="va"><?= $value["projetosfuturos"]; ?></td>

                            <td>Alterar</td>
                            <td>Excluir</td>
                        </tr>
                        <tr>
                            <td><?= $value["aluno"]; ?></td>
                            <td>Alterar</td>
                            <td>Excluir</td>
                        </tr>
        <?php
        $i++;
    } else {
        ?>
                        <tr>
                            <td><?php echo $value["pjt_codigo"] . " $a"; ?></td>
                            <td><?= $value["tema"]; ?></td>
                            <td><?= $value["aluno"]; ?></td>
                            <td><?= $value["prof"]; ?></td>
                            <td><?= $value["status"]; ?></td>
                            <td><?= $value["pjt_projetosfuturos"]; ?></td>
                            <td>Alterar</td>
                            <td>Excluir</td>
                        </tr>
        <?php
    }
}
?>


            </table>

        </div>
    </body>
</html>

