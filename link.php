<?php
    session_start();
    require_once("controles/usuarios.php");
    require_once("controles/links.php");
    require_once("controles/categorias.php");
    include 'pagination.class.php';
    if (checarUsuario()) {
        require_once("cabecalho.php");
        if($_SESSION['admin']){
        }
        $links = listarlinks();
        $categorias = listarCategorias();
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
                            <th class='nomecol' style="width: 5%" scope="col" >ID</th>
                            <th class='nomecol' style="width: 5%" scope="col" >Logo</th>
                            <th class='nomecol' style="width: 30%" scope="col" >Título</th>
                            <th class='nomecol' style="width: 30%" scope="col" >Categoria</th>
                            <th class='nomecol' scope="col" >Link</th>
                            <th class='nomecol' style="width: 5%" scope="col">Exc</th>
                            <th class='nomecol' style="width: 5%" scope="col">Alt</th>
                        </tr>
                    </thead>
                    <?php 
                        if ($links){
                            foreach($links as $link) { 
                                $dados[] = array(
                                    'id_link'        => $link['id_link'],
                                    'logo_link'      => $link['logo'],
                                    'nome_link'      => $link['nome_link'],
                                    'link_link'      => $link['link_link'],
                                    'id_categoria'   => $link['id_categoria'],
                                    'nome_categoria' => nomeCategoria($link['id_categoria'])
                                );
                            }
                            if (count($dados)) {
                                $pagination = new pagination($dados, (isset($_GET['page']) ? $_GET['page'] : 1), 260);
                                $pagination->setShowFirstAndLast(false);
                                $pagination->setMainSeperator(' | ');
                                $dadosPages = $pagination->getResults();
                                if (count($dadosPages) != 0) {
                                    $pageNumbers = '<div class="numbers">'.$pagination->getLinks($_GET).'</div>';
                                    echo '<tbody id="conteudo">';
                                        foreach ($dadosPages as $dadosArray) {
                                            echo '<tr class="post" align="center">';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['id_link'].'</td>';
                                                echo '<td><img src='.'"'.$dadosArray['logo_link'].'"'.'style="text-align:center; vertical-align:middle; width:45px; height:45px;" /></td>';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['nome_link'].'</td>';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['nome_categoria'].'</td>';
                                                echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['link_link'].'</td>';
                                                echo '<td><button class="btn btn-outline-danger" onclick="removerConfirma('."'".$dadosArray['id_link']."'".','."'".$dadosArray['nome_link']."'".')"><i class="far fa-trash-alt"></i></button></td>';
                                                echo '<td><button class="btn btn-outline-secondary" onclick="editarConfirma('."'".$dadosArray['id_link']."'".','."'".$dadosArray['nome_link']."'".','."'".$dadosArray['link_link']."'".','."'".$dadosArray['id_categoria']."'".','."'".$dadosArray['logo_link']."'".')"><i class="fas fa-edit"></i></button></td>';
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
                <h5 class="modal-title">Adicionar Conteúdo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="cadastro-form">
                    <div class="container">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" placeholder="Nome do Link" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Logo:</label>
                            <input type="text" class="form-control" name="logo" placeholder="Link da Imagem" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Url:</label>
                            <input type="text" class="form-control" name="link" placeholder="Url do Link" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Categoría:</label>
                            <div class="ml-0 row">
                                <select class="selectpicker" title="Categoria" name="categoria" required autofocus>
                                    <?php if ($categorias) {
                                        foreach($categorias as $categoria) {?>
                                            <option value="<?= $categoria['id']?>" > <?= $categoria['nome']?> </option>
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
                <h5 class="modal-title">Editar Conteúdo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="editar-form">
                    <div class="container">
                        <input type="hidden" name="id" id="idE">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" id="nomeE" name="nome" placeholder="Nome do Link" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Logo:</label>
                            <input type="text" class="form-control" id="logoE" name="logo" placeholder="Link da Imagem" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Url:</label>
                            <input type="text" class="form-control" id="linkE" name="link" placeholder="Url do Link" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Categoría:</label>
                            <div class="ml-0 row">
                                <select class="selectpicker" title="Categoría" id="categoriaE" name="categoria" required autofocus>
                                    <?php  if ($categorias) { 
                                        foreach($categorias as $categoria) {?>
                                            <option value="<?= $categoria['id']?>" > <?= $categoria['nome']?> </option>
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
    function editarConfirma(id,nome, link, categoria, logo) {
        $('#idE').val(id);
        $('#nomeE').val(nome);
        $('#logoE').val(logo);
        $('#linkE').val(link);
        if (categoria !== "") {
          $('#categoriaE').val(categoria);
          $('#categoriaE').selectpicker('render');
        }
        $('#editar').modal();
    }
    function remover(id) {
        $.ajax({
            type: "POST",
            url: "controles/remover-link.php",
            data: {id: id},
            success: function(data) {
                location.reload();
            }
        });
    }
    $( "#cadastro-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/adicionar-link.php",
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
            url: "controles/editar-link.php",
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