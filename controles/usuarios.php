<?php
    require_once("conexao.php");

    function buscaUsuario($usuario, $senha, $cliente = false) {
        global $conexao;
        $usuario = mysqli_real_escape_string($conexao, $usuario);
        if($cliente)
        $cliente = ' or vendedor = 0';

        $query = "select * from usuario where login_usuario = '{$usuario}' and senha_usuario = '{$senha}' and (admin = 1 or vendedor = 1".$cliente.") and estado_usuario = 1";
        $resultado = mysqli_query($conexao, $query);
        $usuario = mysqli_fetch_assoc($resultado);
        return $usuario;
    }
    
    function buscaUsuarioLogin($usuario, $senha) {
        global $conexao;
        $usuario = mysqli_real_escape_string($conexao, $usuario);
        $query = "select * from usuario where login_usuario = '{$usuario}' and senha_usuario = '{$senha}' and (admin = 1 or vendedor = 1 or vendedor = 0) and estado_usuario = 1";
        $resultado = mysqli_query($conexao, $query);
        $usuario = mysqli_fetch_assoc($resultado);
        return $usuario;
    }
    
    function listarLogs($id_usuario){
        global $conexao;
        $query = "select * from logs where  id_usuario= " . $id_usuario . " order by id_log DESC limit 50";
        $resultado = mysqli_query($conexao, $query);
        $logs = [];
        while ($log = mysqli_fetch_assoc($resultado)) {
        $logs[] = $log;
        }
        return $logs;
    }
    
    function porid($id){
        global $conexao;
        $query = "SELECT * from usuario where id_usuario = ".$id."";
        $resultado = mysqli_query($conexao, $query);
        echo  $id;
        return mysqli_fetch_assoc($resultado);
    }
    
    function logarUsuario($usuario) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['logado'] = true;
    }

    function usuarioLogado() {
        return $_SESSION['usuario'];
    }

    function checarUsuario() {
        if (isset($_SESSION['usuario']) && $_SESSION['logado']) {
            return true;
        } else {
            return false;
        }
    }

    function listarUsuarios() {
        $usuarios = array();
        global $conexao;
        session_start();
        $query = "select * from usuario where id_criador = ".$_SESSION['id_usuario']."";
        if($_SESSION['admin']){
            $query = "select * from usuario";
        }
        if($_SESSION['original'] !== $_SESSION['id_usuario']){
        $query = "select * from usuario where id_criador = ".$_SESSION['id_usuario']." or id_usuario = ".$_SESSION['original']."";
        }
        $resultado = mysqli_query($conexao, $query);
        while($usuario = mysqli_fetch_assoc($resultado)) {
        $q = "select * from usuario where id_usuario = ".$usuario['id_criador']."";
        $q = mysqli_query($conexao, $q);
        $usuario['criador'] = mysqli_fetch_assoc($q);
            array_push($usuarios, $usuario);
        }
        return $usuarios;
    }

    function listasUsuario($id) {
        $listas = array();
        global $conexao;
        $query = "select lista.* FROM lista_usuario INNER JOIN usuario ON (usuario.id_usuario = lista_usuario.id_usuario) INNER JOIN lista ON (lista.id_lista = lista_usuario.id_lista) where usuario.id_usuario = $id";
        $resultado = mysqli_query($conexao, $query);
        while($lista = mysqli_fetch_assoc($resultado)) {
            array_push($listas, $lista);
        }
        return $listas;
    }

    function removerUsuario($id) {
        global $conexao;
        $query = "delete from usuario where id_usuario=$id";
        return mysqli_query($conexao, $query);
    }
    
    function adicionarAdministrador($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia) {
        global $conexao;
        $query = "insert into usuario(nome_usuario, senha_usuario, login_usuario, admin, vendedor, estado_usuario, conectado, credito, acesso, id_criador, data, dia, uso, uso_dia) values('{$nome}', '{$senha}', '{$login}', {$admin}, {$vendedor}, {$estado}, '{$conectado}', '{$credito}', '{$acesso}', {$criador}, '{$data}', {$dia}, {$uso}, {$uso_dia})";
        $resultado = mysqli_query($conexao, $query);
        $id = mysqli_insert_id($conexao);
        $resul = "INSERT INTO passwords(senha, id_usuario) VALUES('{$password}', '$id')";
        mysqli_query($conexao, $resul);
        return $resultado;        
    }

    function adicionarVendedor($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia, $lista) {
        global $conexao;
        $query = "insert into usuario (nome_usuario, senha_usuario, login_usuario, admin, vendedor, estado_usuario, conectado, credito, acesso, id_criador, data, dia, uso, uso_dia) values('{$nome}', '{$senha}', '{$login}', {$admin}, {$vendedor}, {$estado}, '{$conectado}', '{$credito}', '{$acesso}', {$criador}, '{$data}', {$dia}, {$uso}, {$uso_dia})";
        $resultado = mysqli_query($conexao, $query);
        $id = mysqli_insert_id($conexao);
        if (count($lista) > 0) {
            for ($i =0; $i < count($lista); $i++) {
                mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
            }
        }
        $resul = "INSERT INTO passwords(senha, id_usuario) VALUES('{$password}', '$id')";
        mysqli_query($conexao, $resul);
        return $resultado;        
    }
    
    function adicionarSubrevendedor($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia, $lista) {
        global $conexao;
        $query = "insert into usuario (nome_usuario, senha_usuario, login_usuario, admin, vendedor, estado_usuario, conectado, credito, acesso, id_criador, data, dia, uso, uso_dia) values('{$nome}', '{$senha}', '{$login}', {$admin}, {$vendedor}, {$estado}, '{$conectado}', '{$credito}', '{$acesso}', {$criador}, '{$data}', {$dia}, {$uso}, {$uso_dia})";
        $resultado = mysqli_query($conexao, $query);
        $id = mysqli_insert_id($conexao);
        if (count($lista) > 0) {
            for ($i =0; $i < count($lista); $i++) {
                mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
            }
        }
        $resul = "INSERT INTO passwords(senha, id_usuario) VALUES('{$password}', '$id')";
        mysqli_query($conexao, $resul);
        
		$result = "update usuario set credito = credito - $credito where id_usuario = '$criador'";
		mysqli_query($conexao, $result);
        return $resultado;         
    }    

    function adicionarCliente($nome, $senha, $password, $login, $admin, $vendedor, $estado, $conectado, $credito, $acesso, $criador, $data, $dia, $uso, $uso_dia, $lista) {
        global $conexao;
        $query = "INSERT INTO usuario(nome_usuario, senha_usuario, login_usuario, admin, vendedor, estado_usuario, conectado, credito, acesso, id_criador, data, dia, uso, uso_dia) VALUES('{$nome}', '{$senha}', '{$login}', {$admin}, {$vendedor}, {$estado}, '{$conectado}', '{$credito}', '{$acesso}', {$criador}, '{$data}', {$dia}, {$uso}, {$uso_dia})";
        $resultado = mysqli_query($conexao, $query);
        $id = mysqli_insert_id($conexao);
        if (count($lista) > 0) {
            for ($i =0; $i < count($lista); $i++) {
                mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
            }
        }
        $resul = "INSERT INTO passwords(senha, id_usuario) VALUES ('{$password}','$id')";
        mysqli_query($conexao, $resul);  

		$result = "update usuario set credito = credito - $conectado where id_usuario = ".$_SESSION['id_usuario']."";
		mysqli_query($conexao, $result);
        return $resultado;        
    }

    function adicionarTeste($nome, $login, $senha, $password, $admin, $vendedor, $estado, $conectado, $acesso, $criador, $credito,  $data, $dia, $uso, $uso_dia,  $lista) {
        global $conexao;
        $query = "INSERT INTO usuario(nome_usuario, login_usuario, senha_usuario, admin, vendedor, estado_usuario, conectado, acesso, id_criador, credito, data, dia, uso, uso_dia) VALUES('{$nome}', '{$login}', '{$senha}', {$admin}, {$vendedor}, {$estado}, '{$conectado}', '{$acesso}', {$criador}, '{$credito}', '{$data}', {$dia}, {$uso}, {$uso_dia})";
        $resultado = mysqli_query($conexao, $query);
        $id = mysqli_insert_id($conexao);
        if (count($lista) > 0) {
            for ($i =0; $i < count($lista); $i++) {
                mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
            }
        }
        $resul = "INSERT INTO passwords(senha, id_usuario) VALUES ('{$password}','$id')";
        mysqli_query($conexao, $resul);
        return $resultado;        
    }    

    function editarVendedor($id, $nome, $login, $senha, $password, $credito, $estado, $lista) {
        global $conexao;
        $query = "update usuario set nome_usuario='$nome', login_usuario='$login', estado_usuario=$estado, senha_usuario='$senha', credito=$credito where id_usuario=$id";
        $resultado = mysqli_query($conexao, $query);
        if (count($lista) > 0) {
            mysqli_query($conexao, "delete from lista_usuario where id_usuario= $id");
            for ($i =0; $i < count($lista); $i++) {
                if (mysqli_num_rows(mysqli_query($conexao, "select * from lista_usuario where id_usuario= $id and id_lista = $lista[$i]")) == 0) {
                    mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
                }
            }
        } else {
            mysqli_query($conexao, "delete from lista_usuario where id_usuario= $id");
        }
        $resul = "update passwords set senha='{$password}' where id_usuario='$id'";
        mysqli_query($conexao, $resul);
        return $resultado;        
    }

    function editarSubrevendedor($id, $nome, $login, $senha, $password, $credito, $estado, $lista) {
        global $conexao;
        $query = "select credito from usuario where id_usuario=$id";
        $resultado = mysqli_query($conexao, $query);
        $ccredito  = $resultado['credito'];
        
        
        $query = "update usuario set nome_usuario='$nome', login_usuario='$login', estado_usuario=$estado, senha_usuario='$senha', credito=$credito where id_usuario=$id";
        $resultado = mysqli_query($conexao, $query);
        if (count($lista) > 0) {
            mysqli_query($conexao, "delete from lista_usuario where id_usuario= $id");
            for ($i =0; $i < count($lista); $i++) {
                if (mysqli_num_rows(mysqli_query($conexao, "select * from lista_usuario where id_usuario= $id and id_lista = $lista[$i]")) == 0) {
                    mysqli_query($conexao, "insert into lista_usuario (id_lista, id_usuario) values ($lista[$i], $id)");
                }
            }
        } else {
            mysqli_query($conexao, "delete from lista_usuario where id_usuario= $id");
        }
        $resul = "update passwords set senha='{$password}' where id_usuario='$id'";
        mysqli_query($conexao, $resul);
        
		$result = "update usuario set credito = credito - $credito where id_usuario = '$id'";
		mysqli_query($conexao, $result);
        return $resultado;         
    }    
    
    function editarCliente($id, $nome, $login, $senha, $password, $estado, $lista) {
        global $conexao;
        $query = "update usuario set nome_usuario='$nome', login_usuario='$login', estado_usuario=$estado, senha_usuario='$senha' where id_usuario=$id";
        $resultado = mysqli_query($conexao, $query);
        mysqli_query($conexao, "update lista_usuario set id_lista=$lista where id_usuario=$id");
        $result = "UPDATE passwords SET senha='$password' WHERE id_usuario='$id'";
        mysqli_query($conexao, $result);
        return $resultado;
    }

    function acessoLista($acesso, $idlista) {
        global $conexao;
        $resultadoUsuario = mysqli_query($conexao,"select * from usuario where acesso= '$acesso' and estado_usuario = 1");
        $usuario = mysqli_fetch_assoc($resultadoUsuario);
        if ($usuario) {
            $resultadoLista = mysqli_query($conexao,"select lista.* FROM lista_usuario INNER JOIN usuario ON (usuario.id_usuario = 
            lista_usuario.id_usuario) INNER JOIN lista ON (lista.id_lista = lista_usuario.id_lista) where usuario.id_usuario = 
            {$usuario['id_usuario']} and lista.id_lista = $idlista");
            $lista = mysqli_fetch_assoc($resultadoLista);
            if ($lista) {
                return $lista;
            }
        }
    }
?>