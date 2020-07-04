<?php
require 'conexao.php';
session_start();
if (!isset($_SESSION["email"]) || !isset($_SESSION["senha"])) {
    header("Location: Login.php ");
    exit;
} else {
    echo "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--meta charset="iso-8859-1"-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="media/js/jquery.js"></script>
    <title>Orientações</title>
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/shop-item.css" rel="stylesheet">
    <script type="text/javascript" src="js/DataTables/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.css" />
    <link href="css/shop-item.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>


    <?php
    require 'menu.php';
    ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">


            <!-- /.col-lg-3 -->

            <div class="col-lg-12" style="margin: auto">

                <div class="card mt-4">

                    <div class="card-body" style="margin-top: 5%;color: black;">
                        <ol class="breadcrumb" style="background-color: #DCDCDC;">
                            <li><a href="Orientacoes.php" style="margin-right: 5px; color: black;">Orientacoes /</a></li>
                            <li><a href="CadTCC.php" style="color: black;"> Novo</a></li>
                        </ol>
                        <h3 class="fonte " style="text-align: center">Orientações Cadastradas</h3>
                        <br>

                        <?php
                        include 'conexao.php';
                        $codigo_prof = $_SESSION['pro_codigo'];
                        $nivel = $_SESSION['pro_nivel'];
                        if ($nivel == 'Pro') {

                            $sql = "select p.pjt_codigo,pjt_tema,alu_nome, pro_nome, p.pjt_status,p.pjt_projetosfuturos from projeto p,alunos a, professores pr, orientacao o
                                         where p.pjt_codigo = o.pjt_codigo and a.alu_codigo = o.alu_codigo and pr.pro_codigo = o.pro_codigo and pr.pro_codigo= '$codigo_prof'"
                                . "order by p.pjt_codigo, pro_nome, alu_nome";
                        } else {
                            $sql = "select p.pjt_codigo, p.pjt_tema, alu_nome, pro_nome, p.pjt_status,p.pjt_projetosfuturos
                                from projeto p,alunos a, professores pr, orientacao o
                                where p.pjt_codigo = o.pjt_codigo and a.alu_codigo = o.alu_codigo and pr.pro_codigo = o.pro_codigo
                                order by p.pjt_codigo, pro_nome, alu_nome";
                        }
                        $result = pg_query($conn, $sql);

                        $total = pg_num_rows($result);

                        if ($total == 0) {
                            echo "<p>Não foram encontrados registros</p>";
                        } else {
                            $arr_dados = array();

                            $array_projetos = array();

                            while ($dados = pg_fetch_assoc($result)) {
                                $cod_projeto = $dados['pjt_codigo'];
                                $tema = $dados['pjt_tema'];
                                $aluno = $dados['alu_nome'];
                                $prof = $dados['pro_nome'];
                                $status = $dados['pjt_status'];

                                $row = array(
                                    "pjt_codigo" => $cod_projeto,
                                    "pjt_tema" => $tema,
                                    "alu_nome" => $aluno,
                                    "pro_nome" => $prof,
                                    "pjt_status" => $status
                                );

                                array_push($arr_dados, $row);
                                array_push($array_projetos, $cod_projeto);
                            }

                            $array_projetos_uniq = array_count_values($array_projetos);

                            $i = 1;
                            $cod_projeto_tmp = "";
                            $alunos_concat = array();
                            foreach ($arr_dados as $key => $dados) {
                                $cod_projeto = $dados['pjt_codigo'];
                                $aluno = $dados['alu_nome'];

                                if ($cod_projeto_tmp != $cod_projeto) {
                                    $cod_projeto_tmp = $cod_projeto;
                                    $i = 1;
                                }

                                if ($array_projetos_uniq[$cod_projeto] > 1) {

                                    if ($i == $array_projetos_uniq[$cod_projeto]) {
                                        array_push($alunos_concat, $aluno);
                                        $arr_dados[$key]['alu_nome'] = implode(",<br> ", $alunos_concat);
                                        $alunos_concat = array();
                                    } else {
                                        array_push($alunos_concat, $aluno);
                                        unset($arr_dados[$key]);
                                    }
                                }

                                $i++;
                            }
                        ?>

                            <div></div>
                            <table title="Orientações" id="example" class="display table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Tema</th>
                                        <th>Professor</th>
                                        <th>Status</th>
                                        <th>Aluno</th>
                                        <th>Alterar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($arr_dados as $dados) {
                                        $cod_projeto = $dados['pjt_codigo'];
                                        $tema = $dados['pjt_tema'];
                                        $aluno = $dados['alu_nome'];
                                        $prof = $dados['pro_nome'];
                                        $status = $dados['pjt_status'];
                                    ?>
                                        <tr>
                                            <td><?php echo $cod_projeto; ?></td>
                                            <td><?php echo utf8_encode($tema); ?></td>
                                            <td><?php echo utf8_encode($prof); ?></td>
                                            <td><?php echo utf8_encode($status); ?></td>
                                            <td><?php echo utf8_encode($aluno); ?></td>
                                            <td><a class="btn btn-primary" href="CadTCC.php?pjt_codigo=<?php echo $cod_projeto; ?>" onclick="">Alterar </a></td>
                                            <td><a class="btn btn-danger" href="excluir_orientacoes.php?pjt_codigo=<?php echo $cod_projeto; ?>" onclick=" return confirm('Tem certeza que deseja excluir?');">Excluir</a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                <?php
                            }
                                ?>
                                </tbody>
                            </table>
                    </div>

                </div>
                <!-- /.card -->

                <!-- /.card -->
            </div>
            <!-- /.col-lg-9 -->

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Endereço: Av. Jerônimo Figueira da Costa, 3014 - Pozzobon, Votuporanga - SP, 15503-110</p>
            <p style="color: white; text-align: center;"> Acesse: <a href="http://vtp.ifsp.edu.br/">http://vtp.ifsp.edu.br/ </a>

        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->


</body>

</html>