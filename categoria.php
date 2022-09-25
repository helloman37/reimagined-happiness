<?php
    session_start();
    require_once("controles/usuarios.php");
    require_once("controles/categorias.php");
    include 'pagination.class.php';
    if (checarUsuario()) {
        require_once("cabecalho.php");
        $categorias = false;
        if($_SESSION['admin']){
            $categorias = listarCategorias();
        }
?>
            <style id="checkme">
                .page-2content {
                    padding-left: 240px !important;
                    padding-right: 240px !important;
                }
            </style>
            <div id="conteudo-painel" class="container">
                <div class="mb-3">
                    <div class="col-12 col-lg-12 col-xl-12" style="padding-left:0px; padding-right:0px">
                        <div class="form-row">
                            <div class="col col-md-10">
                                <input type="text" class="pesquisar form-control" placeholder="Pesquisar...">
                            </div>
                            <div class="col col-md-2">
                                <i onclick="$('#cadastro').modal()" class="btn btn-outline-info text-dark fas fa-plus" style="line-height:1.45;float:right"></i>
                            </div>
                        </div>
                    </div>
                </div>            
                <table class='table table-bordered table-hover table-responsive'>
                    <thead class="thead-light">
                        <tr align="center">
                            <th class='nomecol' style="width: 20%" scope="col" >ID</th>
                            <th class='nomecol' style="width: 80%" scope="col" >Categoria</th>
                            <th class='nomecol' style="width: 5%" scope="col">Exc</th>
                            <th class='nomecol' style="width: 5%" scope="col">Alt</th>
                        </tr>
                    </thead>
                    <?php 
                        if ($categorias) { 
                            foreach($categorias as $categoria) { 
                                $dados[] = array(
                                    'id'   => $categoria['id'],
                                    'nome' => $categoria['nome']
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
                                            echo '<tr class="post" align="center">';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['id'].'</td>';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['nome'].'</td>';
                                                echo '<td><button class="btn btn-outline-danger" onclick="removerConfirma('."'".$dadosArray['id']."'".','."'".$dadosArray['nome']."'".')"><i class="far fa-trash-alt"></i></button></td>';
                                                echo '<td><button class="btn btn-outline-secondary" onclick="editarConfirma('."'".$dadosArray['id']."'".','."'".$dadosArray['nome']."'".')"><i class="fas fa-edit"></i></button></td>';
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
            </div>
        </div>
    </main>
    <!-- page-content" -->
</div>
<!-- Cadastro Inicio -->
<div class="modal fade" id="cadastro" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="cadastro-form">
                    <div class="container">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" placeholder="Nome da categoria" required autofocus>
                        </div>
                     </div>
                </form>
            </div>
			<div class="modal-footer">
				<button type="submit" form="cadastro-form" class="btn btn-primary">Adicionar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>	            
        </div>
    </div>
</div>
<!-- Cadastro Fim-->
<!-- Remove Inicio -->
<div class="modal fade" id="remover" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tem certeza?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="remover-conteudo" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- Remove Fim-->
<!-- Edita Inicio -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editar-form" style="max-height:460px; overflow-y:auto;">
                    <div class="container">
                        <input type="hidden" id="idE" name="id">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" id="nomeE" name="nome" placeholder="Nome da Categoria" required autofocus>
                        </div>
                    </div>
                </form>
            </div>
			<div class="modal-footer">
				<button type="submit" form="editar-form" class="btn btn-primary">Editar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>            
        </div>
    </div>
</div>
<!-- Edita Fim-->
</body>
<script>
    function removerConfirma(id,nome) {
        $('#remover-conteudo').html('<div class="alert alert-danger" role="alert"><strong> Remover </strong>' + nome + '?</div><button type="button" class="btn btn-secondary float-right" style="margin-left:10px" data-dismiss="modal">Fechar</button><button onclick="remover(' + id + ')" type="submit" class="btn btn-danger float-right">Remover</button>');
        $('#remover').modal();
    }
    function editarConfirma(id,nome) {
        $('#idE').val(id);
        $('#nomeE').val(nome);
        $('#editar').modal();
    }
    function remover(id) {
        $.ajax({
            type: "POST",
            url: "controles/remover-categoria.php",
            data: {id: id},
            success: function(data) {
                location.reload();
            }
        });
    }
    $( "#cadastro-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/adicionar-categoria.php",
            data: $("#cadastro-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
    $( "#editar-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/editar-categoria.php",
            data: $("#editar-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
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