<?php
	session_start();
	require_once("controles/usuarios.php");
	include 'pagination.class.php';
	if (checarUsuario()) {
		require_once("cabecalho.php");
		$usuarios = listarUsuarios();
?>
		<style id="checkme">
			.page-2content {
				padding-left: 240px !important;
				padding-right: 240px !important;
			}
		</style>
		<div id="conteudo-painel" style="padding-left: 0px;" class="table-responsive container">
			<div class="mb-3">
				<div class="col-12 col-lg-12 col-xl-12" style="padding-left:0px; padding-right:0px">
					<div class="form-row">
						<div class="col col-md-10">
							<input type="text" class="pesquisar form-control" placeholder="Pesquisar...">
						</div>
						<?php if($_SESSION['admin']) { ?>
							<div class="col col-md-2">
								<i onclick="$('#cadastro').modal()" class="btn btn-outline-info text-dark fas fa-user-plus" style="line-height:1.45;float:right"></i>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>		
			<div class="mb-5 form-group float-right"></div>
			<table class='table table-bordered table-hover table-responsive'>
				<thead class="thead-light">
					<tr align="center">
						<th class='nomecol' style="width: 20%" scope="col">Administrador</th>
						<th class='nomecol' style="width: 10%" scope="col">Login</th>
						<th class='nomecol' style="width: 20%" scope="col">Senha</th>
						<th class='nomecol' style="width: 20%" scope="col">Criador</th>
						<th class='nomecol' style="width: 10%" scope="col">Estado</th>
						<th class='nomecol' style="width: 5%" scope="col">Opções</th>
					</tr>
				</thead>
				<?php 
					if ($usuarios) { 
						foreach($usuarios as $usuario) {
							$dados[] = array(
								'id_usuario'      => $usuario['id_usuario'],
								'nome_usuario'    => $usuario['nome_usuario'],
								'login_usuario'   => $usuario['login_usuario'],
								'criador'         => $usuario['criador'],
								'estado_usuario'  => $usuario['estado_usuario'],
								'admin'           => $usuario['admin'],
								'vendedor'        => $usuario['vendedor']
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
										if ($dadosArray['admin'] == 1 && $dadosArray['vendedor'] == 0){
											$passwords = "SELECT * FROM passwords WHERE id_usuario = ".$dadosArray['id_usuario']."";
											$results   = mysqli_query($conexao, $passwords);
											$password = mysqli_fetch_assoc($results);
											echo '<tr class="post" align="center">';
												echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['nome_usuario'].'</td>';
												echo '<td style="text-align: center; vertical-align: middle;">'.$dadosArray['login_usuario'].'</td>';
												echo '<td style="text-align: center; vertical-align: middle;">'.$password['senha'].'</td>';
												?>
												<td align="center"> <?php echo $dadosArray['criador'] ? $dadosArray['criador']['nome_usuario'] : 'Sistema'; ?> </td>
												<?php
												if($dadosArray['estado_usuario'] == 1){
													echo '<td style="text-align: center; vertical-align: middle;">Ativo</td>';
												}else{
													echo '<td style="text-align: center; vertical-align: middle;">Inativo</td>';
												}
												?>
												<td style="display: contents;">
													<div class="dropdown">
														<style>.no-zero { padding-top: 0px; padding-bottom: 0px; position: relative; }</style>
														<button class="btn" type="button" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport" style="top: 5px; margin: 0 auto; position: relative; display: block">Opções<span class="fa fa-caret-down" style="left: 4px; position: relative" aria-hidden="true"></span></button>
														<style>.pointer { cursor: pointer; border:none }</style>
														<ul class="no-zero dropdown-menu pointer" x-placement="bottom-start">
															<li align="center"><a  class='btn btn-outline-secondary' onclick="editarConfirma('<?=$dadosArray['id_usuario']?>','<?=$dadosArray['nome_usuario']?>','<?=$dadosArray['login_usuario']?>','<?=$password['senha']?>','<?=$dadosArray['estado_usuario']?>')" style="width: 100%;display: block;padding: 5px;top: -10px;"><i class="fas fa-user-edit"></i> Editar</a></li>
															<?php if($dadosArray['id_usuario'] > 1){ ?>
																<li align="center"><a  class='btn btn-outline-secondary' onclick="removerConfirma('<?=$dadosArray['id_usuario']?>', '<?=$dadosArray['nome_usuario']; ?>')" style="width: 100%; display: block; padding: 5px"><i class="far fa-trash-alt"></i> Excluir</a></li>
															<?php } ?>																
														</ul>
													</div>
												</td>
												<?php												
											echo '</tr>';
										}
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
<?php if($_SESSION['admin']) { ?>
<!-- Cadastro Inicio -->
<div class="modal fade" id="cadastro" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="TituloModalLongoExemplo">Adicionar Administrador</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="max-height:460px; overflow-y:auto;">
				<form id="cadastro-form">
					<div class="container">
						<div class="form-group">
							<label>Nome:</label>
							<input type="text" class="form-control" name="nome" placeholder="Nome" required autofocus>
						</div>
						<div class="form-group">
							<label>Login:</label>
							<input type="text" class="form-control" name="login" placeholder="Login" required autofocus>
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input type="text" id="divSenhaC" class="form-control" name="senha" placeholder="Senha" required autofocus>
						</div>
						<!--<button type="submit" class="btn btn-danger">Salvar</button>-->
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
<?php } ?>
<?php if($_SESSION['admin']) { ?>
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
<?php } ?>
<?php if($_SESSION['admin']) { ?>
<!-- Edita Inicio -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Editar Administrador</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="max-height:460px; overflow-y:auto;">
				<form id="editar-form">
					<div class="container">
						<input type="text" id="idE" name="id" hidden>
						<div class="form-group">
							<label>Nome:</label>
							<input type="text" class="form-control" id="nomeE" name="nome" placeholder="Nome" required autofocus>
						</div>
						<div class="form-group">
							<label>Login:</label>
							<input type="text" class="form-control" id="loginE" name="login" placeholder="Login" required autofocus>
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input type="text" id="divSenha" class="form-control" id="senhaE" name="senha" placeholder="Senha" required autofocus>
						</div>
					   <div class="form-group">
							<label>Estado:</label>
							<div class="ml-0 row">
								<select id="estadoE" class="selectpicker" title="Estado" name="estado" required autofocus>
									<option value="1">Ativo</option>
									<option value="0">Inativo</option>
								</select>
							</div>
						</div>
						<!--<button type="submit" class="btn btn-danger">Salvar</button>-->
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
<?php } ?>
</body>
<script>
    function editarConfirma(id, nome, login, senha, estado) {
        $('#nomeE').val(nome);
		$('#idE').val(id);
        $('#loginE').val(login);
		$('#divSenha').val(senha);
        $('#estadoE').val(estado);
        $('#estadoE').selectpicker('render');
        $('#editar').modal();
    }
    function removerConfirma(id,nome) {
        $('#remover-conteudo').html('<div class="alert alert-danger" role="alert"><strong> Remover </strong>' + nome + '?</div> <button type="button" class="btn btn-secondary float-right" style="margin-left:10px" data-dismiss="modal">Fechar</button><button onclick="remover(' + id + ')" type="submit" class="btn btn-danger float-right">Remover</button>');
        $('#remover').modal();
    }
	function remover(id){
        window.location.href = 'controles/remover-administrador.php?id_usuario=' + id;
    }
	$( "#cadastro-form" ).submit(function( event ) {
		$.ajax({
			type: "POST",
			url: "controles/adicionar-administrador.php",
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
			url: "controles/editar-administrador.php",
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
	function setCookie(name,value,days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*60*60*1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "")  + expires + "; path=/";
	}
	function getCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {   
		document.cookie = name+'=; Max-Age=-99999999;';  
	}
    if(window.mobilecheck()){
		$('#checkme').remove();
    }
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