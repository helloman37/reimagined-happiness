<?php
    session_start();
    require_once("controles/usuarios.php");
    require_once("controles/listas.php");
    include 'pagination.class.php';
    if (checarUsuario()) {
        require_once("cabecalho.php");
        $logs = listarLogs($_GET['id_usuario']);
?>
                    <div id="conteudo-painel" class="container">
                        <div class="mb-3">
                            <div class="col-12 col-lg-12 col-xl-12" style="padding-left:0px; padding-right:0px">
                                <div class="form-row">
                                    <div class="col col-md-10">
                                        <input type="text" class="pesquisar form-control" placeholder="Pesquisar...">
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <table class='table table-bordered table-hover table-responsive'>
                            <thead class="thead-light">
                                <tr>
                                    <th class='nomecol' scope="col" >Assistindo</th>
                                    <th class='nomecol' scope="col" >Data e Hora</th>
                                    <th class='nomecol' scope="col" >Conectado</th>
                                </tr>
                            </thead>
                            <?php 
                                if ($logs){
                                    foreach($logs as $log) { 
                                        $dados[] = array(
                                            'nome' => $log['nome'],
                                            'data' => $log['data'],
                                            'ip' => $log['ip']
                                        );
                                    }
                                    if (count($dados)) {
                                        $pagination = new pagination($dados, (isset($_GET['page']) ? $_GET['page'] : 1), 11);
                                        $pagination->setShowFirstAndLast(false);
                                        $pagination->setMainSeperator(' | ');
                                        $dadosPages = $pagination->getResults();
                                        if (count($dadosPages) != 0) {
                                            $pageNumbers = '<div class="numbers">'.$pagination->getLinks($_GET).'</div>';                                        
                                            echo '<tbody id="conteudo">';
                                                foreach ($dadosPages as $dadosArray) {
                                                    echo '<tr>';
                                                        echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['nome'].'</td>';
                                                        echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['data'].'</td>';
                                                        echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['ip'].'</td>';
                                                    echo '</tr>';
                                                }
                                            echo '</tbody>';
                                        }else{
                                            $pagina = $_GET['page'];
                                            $pagina = $pagina - 1;
                                            if($pagina >= 1){
                                                $pagina = (string)$pagina;
                                                 echo '<script>history.go(-1)</script>';
                                            }
                                        }
                                    }
                                }
                            ?>
                        </table>
                        <?php echo $pageNumbers; ?>
                        <div class='semresultado'>Nenhum resultado</div>
                        <i id="totop" class="btn btn-outline-info text-dark fas fa-angle-double-up"></i>                        
                        <button id="voltar" class="btn btn-primary" type="button" onClick="history.go(-1); return false;">Voltar</button>
                    </div>
                </div>
            </div>
        </main>
        <!-- page-content" -->
    </div>
</body>
<script>
    speed_to_top = 1000;
    $('#totop').hide();
    $('#totop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, speed_to_top);
        return false;
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#totop').fadeIn();
        } else {
            $('#totop').fadeOut();
        }
    });
</script>
<?php 
    require_once("comum.php"); 
    require_once("alerta.php");
?>
</html>
<?php 
} else {
    header("Location: login");
    die();
}
?>