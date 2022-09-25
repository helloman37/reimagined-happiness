<?php
    session_start();
    require_once("controles/usuarios.php");
    require_once("controles/links.php");
    require_once("controles/categorias.php");
    require_once("controles/listas.php");
    include 'pagination.class.php';
    if (checarUsuario()) {
        require_once("cabecalho.php");
        $links = listarlinks();
        $categorias = listarCategorias();
        $categoriasNVazias = listarCategoriasNaoVazias();
        $listas = listarListas();
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
                            <?php if($_SESSION['admin']) { ?>
                                <div class="col col-md-2">
                                    <i onclick="$('#cadastroGlobal').modal()" class="btn btn-outline-info text-dark fas fa-plus" style="line-height:1.45;float:right"></i>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>            
                <table class='table table-bordered table-hover table-responsive'>
                    <thead class="thead-light">
                        <tr align="center">
                            <th class='nomecol' style="width: 20%" scope="col" >ID</th>
                            <th class='nomecol' style="width: 70%" scope="col" >Lista</th>
                            <?php if($_SESSION['admin']){ ?>
                                <th class='nomecol' style="width: 5%" scope="col">Exc</th>
                                <th class='nomecol' style="width: 5%" scope="col">Alt</th>
                            <?php } ?>
                            <th class='nomecol' style="width: 5%" scope="col">Gerar</th>
                        </tr>
                    </thead>
                    <?php 
                        if ($listas){
                            foreach($listas as $lista) { 
                                $dados[] = array(
                                    'id'   => $lista['id_lista'],
                                    'nome' => $lista['nome_lista']
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
                                                if($_SESSION['admin']){ 
                                                ?>
                                                    <td><button class="btn btn-outline-danger" onclick="removerConfirma('<?=$dadosArray['id']?>','<?=$dadosArray['nome']?>')"><i class="far fa-trash-alt"></i></button></td>
                                                    <td><button class='btn btn-outline-secondary' onclick="editarGlobalConfirma('<?=$dadosArray['id']?>','<?=$dadosArray['nome']?>', [<?php foreach (categoriasLista($dadosArray['id']) as $categoria) echo $categoria['id'] .',' ?> ] )"><i class="fas fa-edit"></i></button></td>
                                                <?php } 
                                                echo '<td><button class="btn btn-outline-primary" onclick="obterListaUsuarios('."'".$dadosArray['id']."'".')"><i class="fas fa-link"></i></button></td>';
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
<!-- Cadastro Global Inicio -->
<div class="modal fade bd-modal-lg" id="cadastroGlobal" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="cadastro-form-global">
                    <div class="container">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" placeholder="Nome da Lista" required autofocus>
                        </div>  
                        <div class="form-group"> 
                            <label>Categorías:</label>
                            <div class="mb-3 ml-0 row">
                                <select name="categoria[]" class="selectpicker" title="Categoria..." required multiple>
                                    <?php if ($categorias) {
                                        foreach($categorias as $categoria) {?>
                                            <option value="<?= $categoria['id']?>"><?= $categoria['nome']?></option>
                                        <?php } 
                                    } ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
			<div class="modal-footer">
				<button type="submit" form="cadastro-form-global" class="btn btn-primary">Adicionar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>            
        </div>
    </div>
</div>
<!-- Cadastro Global Fim-->
<!-- Editar Global Inicio -->
<div class="modal fade bd-modal-lg" id="editarGlobal" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                <form id="editar-form-global">
                    <input type="hidden" id="idGE" name="id">
                    <div class="container">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" id="nomeGE" placeholder="Nome da Lista" required autofocus>
                        </div>
                        <div class="form-group"> 
                            <label>Categorías:</label>
                            <div class="mb-3 ml-0 row">
                                <select id="categoriaGE" name="categoria[]" class="selectpicker" title="Categoria..." required multiple>
                                    <?php if ($categorias) {
                                        foreach($categorias as $categoria) {?>
                                            <option value="<?= $categoria['id']?>"><?= $categoria['nome']?></option>
                                        <?php } 
                                    } ?>
                                </select>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
			<div class="modal-footer">
				<button type="submit" form="editar-form-global" class="btn btn-primary">Editar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>             
        </div>
    </div>
</div>
<!-- Editar Global Fim-->
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
<!-- Obter Link Inicio -->
<div class="modal fade" id="obterLinkdaLista" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Obter Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formObterLinkdaLista">
                    <input type="hidden" id="idLista" name="idLista">
                    <div class="form-group">
                        <label>Selecione o Usuário:</label>
                        <div class="select-users ml-0 row"></div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Obter</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Obter Link Fim-->
<!-- Link Inicio -->
<div class="modal fade" id="linkLista" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="text" class="form-control" id="linkIn" readonly><br>
                    <h5 class="form-control" name="novolink" id="novolink" readonly></h5>
                    <button type="button" class="btn btn-danger" onclick="copiar()">Copiar</button>
                    <button type="button" class="btn btn-danger" onclick="encurtar()">Encurtar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Link Fim-->
</body>
<script>
    $("#obterLinkdaLista").on('hidden.bs.modal', function (e) {
        $(".select-users").empty();
    });
    function obterListaUsuarios(id) {
        $('#idLista').val(id);
        $.ajax({
            type: "POST",
            url: "controles/obter-lista-usuarios.php",
            data: {id: id},
            dataType:"json",
            success: function(data) {
                var $select = $('<select/>', {
                    'class':"selectpicker",
                    'title':"Usuário...",
                    'name': "idUsuario"
                });
                for (j=0; j < data.length; j++) {
                    $select.append('<option value=' + data[j].id_usuario + '>' + data[j].nome_usuario + '</option>');
                }
                $select.appendTo('.select-users').selectpicker('refresh');
            }
        });
        $('#obterLinkdaLista').modal();
    }
    function listaGlobal() {
        $('#cadastro').modal('hide');
        $('#cadastroGlobal').modal();
    }
    function removerConfirma(id,nome) {
        $('#remover-conteudo').html('<div class="alert alert-danger" role="alert"><strong> Remover </strong>' + nome + '?</div><button type="button" class="btn btn-secondary float-right" style="margin-left:10px" data-dismiss="modal">Fechar</button><button onclick="remover(' + id + ')" type="submit" class="btn btn-danger float-right">Remover</button>');
        $('#remover').modal();
    }
    function editarGlobalConfirma(id,nome, lista) {
        $('#idGE').val(id);
        $('#nomeGE').val(nome);
        $('#nomeGE').val(nome);
        $('#categoriaGE').val(lista);
        $('#categoriaGE').selectpicker('render');
        $('#editarGlobal').modal();
    }
    function remover(id) {
        $.ajax({
            type: "POST",
            url: "controles/remover-lista.php",
            data: {id: id},
            success: function(data) {
              location.reload();
            }
        });
    }
    $( "#cadastro-form-global" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/adicionar-lista-global.php",
            data: $("#cadastro-form-global").serialize(),
            success: function(data) {
              location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
    $( "#editar-form-global" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/editar-lista-global.php",
            data: $("#editar-form-global").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });
    $( "#formObterLinkdaLista" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/obter-link-lista.php",
            data: $("#formObterLinkdaLista").serialize(),
            success: function(data) {
                $('#linkIn').val(data);
                $('#obterLinkdaLista').modal('hide');
                $('#linkLista').modal();
            }
        });
        event.preventDefault();
    });
    function copiar() {
        $('#linkIn').select();
        document.execCommand("copy");
    }
	
    function encurtar() {
        var valor = document.getElementById("linkIn").value;
        $.getJSON( "https://is.gd/create.php?callback=?", {
            url: valor,
            format: "json"
        }).done(function( data ) {
            let novolink = data.shorturl;
            console.log(novolink);
            if(novolink!==undefined)
                document.getElementById("novolink").innerHTML = novolink;
            else document.getElementById("novolink").innerHTML = "Erro Link";
        });
    }
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