<?php
    session_start();
    require_once("controles/usuarios.php");
    require_once("controles/mensagens.php");
    require_once("controles/eventos.php");
    include 'pagination.class.php';
    if (checarUsuario() && $_SESSION['admin']) {
        require_once("cabecalho.php");
        $mensagens = listarMensagens();
        $eventos = listarEventos();
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
                            <th class='nomecol' style="width: 16%" scope="col" >Título</th>
                            <th class='nomecol' style="width: 15%" scope="col" >Evento</th>
                            <th class='nomecol' style="width: 55%" scope="col" >Mensagem</th>
                            <th class='nomecol' style="width: 20%" scope="col" >Data</th>
                            <th class='nomecol' style="width: 5%" scope="col" >Exc</th>
                            <th class='nomecol' style="width: 5%" scope="col" >Alt</th>
                        </tr>
                    </thead>
                    <?php
                        if ($mensagens){
                            foreach($mensagens as $mensagem) { 
                                $dados[] = array(
                                    'titulo'      => $mensagem['titulo'],
                                    'mensagem'    => $mensagem['mensagem'],
                                    'data'        => $mensagem['data'],
                                    'id_evento'   => $mensagem['id_evento'],
                                    'id_mensagem' => $mensagem['id_mensagem']
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
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['titulo'].'</td>';
                                                ?>
                                                <td style="text-align: center; vertical-align: middle;"> <?=obterEvento($dadosArray['id_evento'])[0]['nome'];?> </td>
                                                <?php
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['mensagem'].'</td>';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['data'].'</td>';
                                                ?>
                                                <td><button class='btn btn-outline-danger' onclick="removerConfirma('<?=$dadosArray['id_mensagem']?>','<?=$dadosArray['titulo']?>')"><i class="far fa-trash-alt"></i></button></td>
                                                <td><button class='btn btn-outline-secondary' onclick="editarConfirma('<?=$dadosArray['id_mensagem']?>','<?=$dadosArray['titulo']?>','<?=$dadosArray['mensagem']?>','<?=$dadosArray['id_evento']?>')"><i class="fas fa-edit"></i></button></td>
                                                <?php
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
                <h5 class="modal-title">Adicionar Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="cadastro-form">
                    <div class="container">
                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" class="form-control" name="titulo" placeholder="Título" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Mensagem:</label>
                            <input type="text" class="form-control" name="mensagem" placeholder="Mensagem" required>
                        </div>
                        <div class="form-group">
                            <label>Evento:</label>
                            <div class="ml-0 row">
                                <select class="selectpicker" title="Evento" name="id_evento" required>
                                    <?php if ($eventos) {
                                        foreach($eventos as $evento) {?>
                                            <option value="<?= $evento['id_evento']?>" > <?= $evento['nome']?> </option>
                                    <?php } } ?>
                                </select>
                            </div>
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
                <h5 class="modal-title">Editar Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="editar-form">
                    <div class="container">
                        <input type="hidden" name="id" id="idE">
                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" class="form-control" id="tituloE" name="titulo" placeholder="Título" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Mensagem:</label>
                            <input type="text" class="form-control" id="mensagemE" name="mensagem" placeholder="Mensagem" required>
                        </div>
                        <div class="form-group">
                            <label>Evento:</label>
                            <div class="ml-0 row">
                                <select class="selectpicker" title="Evento" id="id_eventoE" name="id_evento" required>
                                    <?php  if ($eventos) { 
                                        foreach($eventos as $evento) {?>
                                            <option value="<?= $evento['id_evento']?>" > <?= $evento['nome']?> </option>
                                    <?php } } ?>
                                </select>
                            </div>
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
    function editarConfirma(id, titulo, mensagem, id_evento) {
        $('#idE').val(id);
        $('#tituloE').val(titulo);
        $('#mensagemE').val(mensagem);
        $('#id_eventoE').val(id_evento);
        $('#id_eventoE').selectpicker('render');
        $('#editar').modal();
    }
    function remover(id) {
        $.ajax({
            type: "POST",
            url: "controles/remover-mensagem.php",
            data: {id: id},
            success: function(data) {
                location.reload();
            }
        });
    }
    $( "#cadastro-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/adicionar-mensagem.php",
            data: $("#cadastro-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function (data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
    $( "#editar-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/editar-mensagem.php",
            data: $("#editar-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function (data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
    speed_to_top = 1000;
    $('#totop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, speed_to_top);
        return false;
    });
    $('#totop').hide();
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