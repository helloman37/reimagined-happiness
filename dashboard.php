<?php
	session_start();
	include("controles/conexao.php");
	require_once("controles/usuarios.php");
	require_once("controles/novidades.php");
	require_once("controles/listas.php");
	require_once("controles/categorias.php");
	if (checarUsuario()){
		require_once("cabecalho.php");
		$novidades = listarNovidades();
?>
<link rel="stylesheet" type="text/css" href="css/dashboard.min.css" />
<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
<style>
	.btn:focus, .btn::-moz-focus-inner{
	  outline:none;
	  border:none;
	}
	.btn{
	  font-family: arial;
	  font-size:14px;
	  font-weight:700;
	  border:none;
	  padding:10px;
	  cursor: pointer;
	  display:inline-block;
	  text-decoration: none;
	}
	.btn-green{
	  background:green;
	  color:#fff;
	  box-shadow:0 5px 0 #006000;
	}
	.btn-green:hover{
	  background:#006000;
	  color:#fff;
	  box-shadow:0 5px 0 #003f00;
	}
	a:link
	{
	text-decoration:none;
	}
</style>
<body class="layout-boxed sidebar-mini">
	<header class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#" id="logoTopo"><b>Dashboard</b></a>
	</header>
	<?php if($_SESSION['admin']){?>
		<div class="wrapper">
			<section class="content">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-aqua"><i class="fas fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-green"><i class="fas fa-user-check"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Ativos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE estado_usuario = 1 AND vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-red"><i class="fas fa-user-times"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Bloqueados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE estado_usuario = 0  AND vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="vendedores">
							<div class="info-box">
								<span class="info-box-icon bg-blue"><i class="fas fa-user-tag"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Vendedores<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE vendedor = 1 AND admin = 0 AND dia = 0");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="vendedores">
							<div class="info-box">
								<span class="info-box-icon bg-red"><i class="fas fa-user-lock"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Vendedores<br>Bloqueados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE estado_usuario = 0 AND vendedor = 1 AND admin = 0 AND dia = 0");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="conteudos">
							<div class="info-box">
								<span class="info-box-icon bg-orange"><i class="fas fa-video"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total<br>Conteúdos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM link");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="categorias">
							<div class="info-box">
								<span class="info-box-icon bg-purple"><i class="fas fa-list"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Categorias</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM categoria");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="listas">
							<div class="info-box">
								<span class="info-box-icon bg-green"><i class="fas fa-archive"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Listas</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM lista");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="administradores">
							<div class="info-box">
								<span class="info-box-icon bg-purple"><i class="fas fa-user-cog"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Administradores<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE vendedor = 0 AND admin = 1 AND dia = 0");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="testes">
							<div class="info-box">
								<span class="info-box-icon bg-blue"><i class="fas fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Testes<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE vendedor = 0 AND admin = 0 AND dia = 1");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="mensagens">
							<div class="info-box">
								<span class="info-box-icon bg-maroon"><i class="far fa-envelope"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Mensagens</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM mensagens order by id_mensagem");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="eventos">
							<div class="info-box">
								<span class="info-box-icon bg-navy"><i class="far fa-calendar-alt"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Eventos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM eventos order by id_evento");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</section>
		</div>
		<br />
	<?php } ?>
	<?php if($_SESSION['vendedor']) { ?>
		<div class="wrapper">
			<section class="content">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-aqua"><i class="fas fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-green"><i class="fas fa-user-check"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Ativos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND estado_usuario = 1 AND vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-red"><i class="fas fa-user-times"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Clientes<br>Bloqueados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND estado_usuario = 0  AND vendedor = 0 AND admin = 0 AND dia = 31");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="conteudos">
							<div class="info-box">
								<span class="info-box-icon bg-orange"><i class="fas fa-video"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total<br>Conteúdos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM link");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="testes">
							<div class="info-box">
								<span class="info-box-icon bg-maroon"><i class="fas fa-user"></i></span>									
								<div class="info-box-content">
									<span class="info-box-text">Testes<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND estado_usuario = 1  AND vendedor = 0 AND admin = 0 AND dia = 1");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="testes">
							<div class="info-box">
								<span class="info-box-icon bg-orange"><i class="fas fa-user-check"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Testes<br>Ativos</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND estado_usuario = 1  AND vendedor = 0 AND admin = 0 AND dia = 1");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="testes">
							<div class="info-box">
								<span class="info-box-icon bg-navy"><i class="fas fa-user-times"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Testes<br>Bloqueados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND estado_usuario = 0  AND vendedor = 0 AND admin = 0 AND dia = 1");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<a href="clientes">
							<div class="info-box">
								<span class="info-box-icon bg-aqua"><i class="fas fa-users"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Sub-Revendedores<br>Cadastrados</span>
									<span class="info-box-number">
										<?php
											$buscarusuario = ("SELECT * FROM usuario WHERE id_criador = ". $_SESSION['id_usuario']." AND vendedor = 1 AND admin = 0");
											$result = mysqli_query($conexao, $buscarusuario);
											echo mysqli_num_rows($result);
										?>
									</span>
								</div>
							</div>
						</a>
					</div>					
				</div>
			</section>
		</div>
		<br />
	<?php } ?>
	<div class="row" style="height: auto;">
		<div class="col-md-6" style="height: auto;">
			<div class="panel panel-default StatusBodyOP" style="height: auto;">
				<div class="panel-body" style="height: auto;">
					<div class="panel-heading">
						<h3 align="center" class="panel-title">Últimos Adicionados</h3>
					</div>
					<span id="StatusOperadora" style="height: auto;">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><center>Logotipo:</center></th>
									<th><center>Nome:</center></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($novidades as $novidade) { ?>
									<tr>
										<td style="vertical-align: middle;"><center> <?php echo '<img src="'.$novidade['logo'].'" width="30px" height="30px"/>'?> </center></td>
										<td style="vertical-align: middle;"><center> <?=$novidade['nome_link']?> </center></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</span>
				</div>                       
			</div>                        
		</div>
		<?php if($_SESSION['vendedor']) { ?>
			<div class="col-md-6" style="height: auto;">
				<div class="panel panel-default StatusBodyOP" style="height: auto;">
					<div class="panel-body" style="height: auto;">
						<div class="panel-heading">
							<h3 align="center" class="panel-title">Últimos Acessos</h3>
						</div>
						<span id="StatusOperadora" style="height: auto;">
							<table class="table table-striped">
								<thead>
									<tr>
										<th><center>Logotipo:</center></th>
										<th><center>Nome:</center></th>
										<th><center>Data e Hora:</center></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$usuario = "SELECT * FROM usuario WHERE id_criador = ".$_SESSION['id_usuario']."";
										$resut = mysqli_query($conexao, $usuario);
										while($usuario = mysqli_fetch_array($resut)){
											$logs = "SELECT * FROM logs WHERE id_usuario = ".$usuario['id_usuario']." limit 5";
											$resut = mysqli_query($conexao, $logs);
											while($log = mysqli_fetch_array($resut)){
									?>
												<tr>
													<?php 
														echo "<td style='vertical-align: middle;'><center> <img src='".$log['logo']."' width='30px' height='30px'/> </center></td>
														<td style='vertical-align: middle;'><center> ".$log['nome']." </center></td>
														<td style='vertical-align: middle;'><center> ".$log['data']." </center></td>";}}
													?>
												</tr>
								</tbody>
							</table>
						</span>
					</div>                       
				</div>                        
			</div>
		<?php } ?>
		<?php if($_SESSION['admin']) { ?>
			<div class="col-md-6" style="height: auto;">
				<div class="panel panel-default StatusBodyOP" style="height: auto;">
					<div class="panel-body" style="height: auto;">
						<div class="panel-heading">
							<h3 align="center" class="panel-title">Últimos Acessos</h3>
						</div>
						<span id="StatusOperadora" style="height: auto;">
							<table class="table table-striped">
								<thead>
									<tr>
										<th><center>Logotipo:</center></th>
										<th><center>Nome:</center></th>
										<th><center>Data e Hora:</center></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$conexao = mysqli_query($conexao, "SELECT * FROM logs order by id_log DESC limit 5") or die( 
											mysqli_error($conexao)
										);
										while($log = mysqli_fetch_assoc($conexao)) { 
									?>
										<tr>
											<?php 
												echo "<td style='vertical-align: middle;'><center> <img src='".$log['logo']."' width='30px' height='30px'/> </center></td>
												<td style='vertical-align: middle;'><center> ".$log['nome']." </center></td>
												<td style='vertical-align: middle;'><center> ".$log['data']." </center></td>";} 
											?>
										</tr>
								</tbody>
							</table>
						</span>
					</div>                       
				</div>                        
			</div>
		<?php } ?>
		<div class="col-md-6" style="height: auto;">
			<div class="panel panel-default StatusBodyOP" style="height: auto;">
				<div class="panel-body" style="height:auto; padding-top:18px; padding-bottom:18px;">
					<div class="panel-heading">
						<h3 align="center" class="panel-title">Sugestões de aplicativos</h3>
					</div>
					<span id="StatusOperadora" style="height: auto;">
						<table class="table table-striped" cellspacing="2">
							<tbody>
								<tr>
									<td style="vertical-align: middle; width:10%"><img src="img/duplexplay.png" /></td>
									<td style="vertical-align: middle; text-align:left; width:45%">DuplexPlay IPTV</td>
									<td style="vertical-align: middle; text-align:left; width:45%">https://www.duplexplay.com/</td>
								</tr>
								<tr>
									<td style="vertical-align: middle; width:10%"><img src="img/xciptv.png" /></td>
									<td style="vertical-align: middle; text-align:left; width:45%">XC IPTV</td>
									<td style="vertical-align: middle; text-align:left; width:45%">https://www.ottrun.com/</td>
								</tr>
								<tr>
									<td style="vertical-align: middle; width:10%"><img src="img/iptvsmarters.png" /></td>
									<td style="vertical-align: middle; text-align:left; width:45%">IPTV Smarters</td>
									<td style="vertical-align: middle; text-align:left; width:45%">https://www.iptvsmarters.com/</td>
								</tr>
								<tr>
									<td style="vertical-align: middle; width:10%"><img src="img/ssiptv.png" /></td>
									<td style="vertical-align: middle; text-align:left; width:45%">SSIPTV</td>
									<td style="vertical-align: middle; text-align:left; width:45%">http://ss-iptv.com/</td>
								</tr>
								<tr>
									<td style="vertical-align: middle; width:10%"><img src="img/gseiptv.png" /></td>
									<td style="vertical-align: middle; text-align:left; width:45%">GSE IPTV</td>
									<td style="vertical-align: middle; text-align:left; width:45%">https://gsesmartiptv.com/</td>
								</tr>								
							</tbody>
						</table>
					</span>
				</div>                       
			</div>                        
		</div>
		<div class="col-md-6" style="height: auto;">
			<div class="panel panel-default StatusBodyOP" style="height: auto;">
				<div class="panel-body" style="height: auto;">
					<div class="form-group">
						<label>URL EPG</label>
						<input type="text" class="form-control" name="epg" placeholder="EPG" readonly>
					</div>
				</div>                       
			</div>
			<?php if($_SESSION['admin']) { ?>
				<div class="panel panel-default StatusBodyOP" style="height: auto;">
					<div class="panel-body" style="height: auto;">
						<div class="form-group">
							<label>CHAVE TMDB</label>
							<input type="text" value="" class="form-control" name="chavetmdb" placeholder="CHAVE TMDB" readonly>
						</div>
					</div>                       
				</div>
			<?php } ?>
			<div class="panel panel-default StatusBodyOP" style="height: auto;">
				<div class="panel-body" style="height: auto;">
					<div class="form-group">
						<label>URL DE TESTE VIA EMAIL</label>
						<input type="text" class="form-control" name="emailteste" placeholder="URL DE TESTE VIA EMAIL" readonly>
					</div>
				</div>                       
			</div>
		</div>		
		<?php
			require_once("comum.php");
			require_once("alerta.php"); 
		?>
		<?php 
			} else {
				header("Location: login");
				die();
			}
		?>