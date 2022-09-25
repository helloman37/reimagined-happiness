<?php
	ini_set('memory_limit', '-1');
	include('categorias.php');
	include('links.php');
	session_start();
	require_once('conexao.php');
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name){
		$file_tmp = $_FILES['files']['tmp_name'][$key];
		$data = file_get_contents($file_tmp);
		if (strpos($data, '#EXTINF') !== false) {
			$data = str_replace("'", '"', $data);
			$data = explode('#EXTINF:', $data);
			$groups = [];
			$channels = [];
			foreach($data as $item){
				$groupName = explode('title=', $item);
				if(count($groupName) > 1){
					$groupName = $groupName[1];
					$groupName = explode('"', $groupName)[1];
					if(strlen(trim($groupName)) > 0){
						if(!array_key_exists($groupName, $groups)){
							$category = obterCategoria(0, $groupName);
							if(sizeof($category) == 0){
								adicionarCategoria($groupName);
								$category = obterCategoria(0, $groupName);
							}
							$groups[$groupName] = $category;
						} else {
							$category = $groups[$groupName];
						}
					}
					$channelName = explode('tvg-name="', $item);
					if(count($channelName) > 1){
						$channelName = $channelName[1];
						$channelName = explode('"', $channelName)[0];
						$channelName = str_replace('"', "'", $channelName);
						$channelName = trim($channelName);
					}
					$link = explode('tvg-name', $item)[1];
					$link = explode("\n", $link);
					$link = $link[1];
					$link = trim($link);

					$logo = explode('tvg-logo="', $item)[1];
					$logo = explode('"', $logo)[0];
					$image_url = trim($logo);			

					if(!array_key_exists($channelName, $channels)){
						$channel = obterLink(0, $channelName);
						if(sizeof($channel) == 0 || !$channel){
							$category_id = $category[0]['id'];
							$channels[$channelName] = true;
							$acesso = md5($channelName);
							$usuario = $_SESSION['id_usuario'];
							mysqli_autocommit($conexao, FALSE);
							$query = "insert into link(id_usuario, nome_link, link_link, id_categoria, logo, acessoLink) values ('$usuario', '$channelName', '$link', '$category_id', '$image_url', '$acesso')";
							mysqli_query($conexao, $query);
						} 
					}			
				}
			}
			mysqli_commit($conexao);
		}
	}