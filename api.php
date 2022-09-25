<?php
    function cors() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
    cors(); 

    session_start();
    require_once('controles/usuarios.php');
    require_once('controles/categorias.php');
    require_once('controles/listas.php');
    require_once("controles/links.php");    

    if(isset($_POST['username']) && isset($_POST['password'])){
         $_GET['username'] = $_POST['username'];
         $_GET['password'] = $_POST['password'];
    }
    
    if(isset($_POST['action'])){
         $_GET['action'] = $_POST['action'];
    }
    
    if(!$_GET['password'] || !$_GET['username']){
        exit();
    }
    $pass     = md5(sha1($_GET['password'] . "iptv"));
    
    $usuarioB = buscaUsuario($_GET['username'], $pass, true);
    
    if(!$usuarioB){
        $auth   = 0;
        $active = 'Inactive';
        exit('[]');
    }else{
        $auth      = 1;
        $active    = 'Active';
        $data      = strtotime($usuarioB['data']);
        $conectado = $usuarioB['conectado'];
        $criado    = time();
        $url       = 'http://frajson.tk:80/api.php';
    }

    function includes($search, $str)
    {
        return strpos($str, $search) !== false;
    }
    
    $listas = "SELECT * FROM lista_usuario WHERE id_usuario = ".$usuarioB['id_usuario']."";
    
    $resut = mysqli_query($conexao, $listas);

    while($lista = mysqli_fetch_array($resut)){
        $idlista = $lista['id_lista'];
        
        if ($usuarioB !== "" && $idlista !== "") {
            $lista = acessoLista($usuarioB['acesso'], $idlista);
            if ($lista) {
                if ($lista['global'] == 0) {
                    //echo $lista['lista'];
                } else {
                    $links = listaGlobal($idlista);
                    
                    if ($links) {
                        $types                      = [];
                        $channels[]                 = [];
                        $movies[]                   = [];
                        $series[]                   = [];
                        $types['channels']          = [];
                        $channels['types_channels'] = [];
                        $types['movies']            = [];
                        $movies['types_movies']     = [];
                        $types['series']            = [];
                        $series['types_series']     = [];
                        
                        foreach($links as $link) {
                            $id_link        = $link['id_link'];
                            $nome_link      = $link['nome_link'];
                            $link_link      = $link['link_link'];
                            $logo_link      = $link['logo'];
                            $acesso_link    = $link['acessoLink'];
                            $id_categoria   = $link['id_categoria'];
                            $nome_categoria = $link['nome'];
                            
                            if (!includes('/MOVIE/', strtoupper($link_link)) && !includes('/SERIES/', strtoupper($link_link)))
                            {
                                $types['channels'][] = [
                                    "id_link"        => $id_link,
                                    "nome_link"      => $nome_link,
                                    "link_link"      => $link_link,
                                    "logo_link"      => $logo_link,
                                    "acesso_link"    => $acesso_link,
                                    "id_categoria"   => $id_categoria,
                                    "nome_categoria" => $nome_categoria
                                ];
                            }
                            
                            if (includes('/MOVIE/', strtoupper($link_link)))
                            {
                                $types['movies'][] = [
                                    "id_link"        => $id_link,
                                    "nome_link"      => $nome_link,
                                    "link_link"      => $link_link,
                                    "logo_link"      => $logo_link,
                                    "acesso_link"    => $acesso_link,
                                    "id_categoria"   => $id_categoria,
                                    "nome_categoria" => $nome_categoria
                                ];                                
                            }                            
        
                            if (includes('/SERIES/', strtoupper($link_link)))
                            {
                                $types['series'][] = [
                                    "id_link"        => $id_link,
                                    "nome_link"      => $nome_link,
                                    "link_link"      => $link_link,
                                    "logo_link"      => $logo_link,
                                    "acesso_link"    => $acesso_link,
                                    "id_categoria"   => $id_categoria,
                                    "nome_categoria" => $nome_categoria
                                ];                                
                            }
                        }
                    }
                }
            }
        }
    }

    $channels['types_channels'] = $types['channels'];
    $movies['types_movies']     = $types['movies'];
    $series['types_series']     = $types['series'];

    $output_channels_categories = array();
    foreach($channels['types_channels'] as $key => $val){
        $arrPos = array_search($val['nome_categoria'], array_column($output_channels_categories, "category_name"));
        if($arrPos === false){
            $output_channels_categories[] = array(
              "category_id"   => $val["id_categoria"],
              "category_name" => $val['nome_categoria'],
              "parent_id"     => 0                                     
            ); 
        }
    }
                        
    $output_movies_categories = array();
    foreach($movies['types_movies'] as $key => $val){
        $arrPos = array_search($val['nome_categoria'], array_column($output_movies_categories, "category_name"));
        if($arrPos === false){
            $output_movies_categories[] = array(
              "category_id"   => $val["id_categoria"],
              "category_name" => $val['nome_categoria'],
              "parent_id"     => 0                                     
            ); 
        }
    }

    $output_series_categories = array();
    foreach($series['types_series'] as $key => $val){
        $arrPos = array_search($val['nome_categoria'], array_column($output_series_categories, "category_name"));
        if($arrPos === false){
            $output_series_categories[] = array(
              "category_id"   => $val["id_categoria"],
              "category_name" => $val['nome_categoria'],
              "parent_id"     => 0                                     
            );
        }
    }
   
    $_GET['action'] = $_GET['action'];
    if(isset($_GET['action'])){
        
        switch ($_GET['action'])
        {
            case "get_live_categories":                        
                echo json_encode($output_channels_categories);
            break;
            
            case "get_vod_categories":                        
                echo json_encode($output_movies_categories);
            break;

            case "get_series_categories":                        
                echo json_encode($output_series_categories);
            break;                                
            
            case "get_live_streams":
                $categoria = $_REQUEST['category_id'];
                $output_channels_streams = array();
                if($categoria > 0){
                    $i = 0;                                        
                    foreach($channels['types_channels'] as $key => $val){
                        If ($val['id_categoria'] == $categoria){
                            $i++;
                            $output_channels_streams[] = array(
                                "num" => (int)$i,
                                "name" => $val["nome_link"],
                                "stream_type" => "live",
                                "stream_id" => (int)$val["id_link"],
                                "stream_icon" => $val["logo_link"],
                                "epg_channel_id" => null,
                                "added" => "",
                                "category_id" => $val['id_categoria'],
                                "custom_sid" => "",
                                "tv_archive" => 0,
                                "direct_source" => "",
                                "tv_archive_duration" => 0
                            );
                        }
                    }
                }else{
                    $i = 0;
                    foreach($channels['types_channels'] as $key => $val){
                        $i++;
                        $output_channels_streams[] = array(
                            "num" => (int)$i,
                            "name" => $val["nome_link"],
                            "stream_type" => "live",
                            "stream_id" => (int)$val["id_link"],
                            "stream_icon" => $val["logo_link"],
                            "epg_channel_id" => null,
                            "added" => "",
                            "category_id" => $val['id_categoria'],
                            "custom_sid" => "",
                            "tv_archive" => 0,
                            "direct_source" => "",
                            "tv_archive_duration" => 0
                        );
                    }
                }
                echo json_encode($output_channels_streams);
            break; 

            case "get_vod_streams":
                $vod_cat = $_GET['category_id'];
                $output_movies_streams = array();
                if($vod_cat > 0){
                    $i = 0;
                    foreach($movies['types_movies'] as $key => $val){
                        If ($val['id_categoria'] == $vod_cat){
                            $i++;
                            $output_movies_streams[] = array(
                                "num" => (int)$i,
                                "name" => $val['nome_link'],
                                "stream_type" => "movie",
                                "stream_id" => (int)$val['id_link'],
                                "stream_icon" => $val['logo_link'],
                                "rating" => "",
                                "rating_5based" => 0,
                                "added" => "",
                                "category_id" => $val['id_categoria'],
                                "container_extension" => "mp4",
                                "custom_sid" => null,
                                "direct_source" => ""
                            );
                        }
                    }
                }else{
                    $i = 0;
                    foreach($movies['types_movies'] as $key => $val){
                        $i++;
                        $output_movies_streams[] = array(
                            "num" => (int)$i,
                            "name" => $val['nome_link'],
                            "stream_type" => "movie",
                            "stream_id" => (int)$val['id_link'],
                            "stream_icon" => $val['logo_link'],
                            "rating" => "",
                            "rating_5based" => 0,
                            "added" => "",
                            "category_id" => $val['id_categoria'],
                            "container_extension" => "mp4",
                            "custom_sid" => null,
                            "direct_source" => "",
                        );
                    }
                }
                echo json_encode($output_movies_streams);                                
            break;
            
            case "get_vod_info":
                $vod_id = $_REQUEST['vod_id'];
                $response = array();
                foreach($movies['types_movies'] as $key => $val){
                    if ($val['id_link'] == $vod_id){
                        $rating = rand(5*10, 10*10)/10;
                        $movie_info = array (
                            "kinopoisk_url" => "", 
                            "tmdb_id" => "",
                            "name" => $val['nome_link'],
                            "o_name" => $val['nome_link'],
                            "cover_big" => $val['logo_link'],
                            "movie_image" => $val['logo_link'],
                            "releasedate" => 'Sem release',
                            "episode_run_time" => '',
                            "youtube_trailer" => '',
                            "director" => 'Sem informação de diretor',
                            "actors" => 'Sem informação de atores',
                            "cast" => 'Sem informação de elenco',
                            "description" => 'O filme ' . $val['nome_link'] . ' é um filme de ' . $val['nome_categoria'],
                            "plot" => 'O filme ' . $val['nome_link'] . ' é um filme de ' . $val['nome_categoria'],
                            "age" => 'Sem informação de ano',
                            "mpaa_rating" => (string)$rating,
                            "rating_count_kinopoisk" => 0,
                            "country" => 'Sem informação de país',
                            "genre" => $val['nome_categoria'], 
                            "backdrop_path" => 
                            array (
                              0 => $val['logo_link']
                            ),
                            "duration_secs" => 0,
                            "duration" => '00:00:00',
                            "video" => 
                            array (
                            ),
                            "audio" => 
                            array (
                            ),
                            "bitrate" => 0,
                            "rating" => (string)$rating
                        );
                        
                        $movie_data = array (
                            "stream_id" => (int)$val['id_link'],
                            "name" => $val['nome_link'],
                            "added" => 'Sem data',
                            "category_id" => $val['id_categoria'],
                            "container_extension" => "mp4",
                            "custom_sid" => "",
                            "direct_source" => "",
                        );                            
                    }
                }         
                $response["info"] = $movie_info;
                $response["movie_data"] = $movie_data;                       
                echo json_encode($response);
            break;                            
            
            case "get_series":
                $vod_cat = $_GET['category_id'];
                $output_series_streams = array();
                if($vod_cat > 0){
                    $i = 0;
                    foreach($series['types_series'] as $key => $val){
                        
                        If ($val['id_categoria'] == $vod_cat){
                            $i++;
                            $rating = rand(5*10, 10*10)/10;
                            $output_series_streams[] = array(
                                "num" => (int)$i,
                                "name" => $val['nome_link'],
                                "series_id" => (int)$val['id_link'],
                                "cover" => $val['logo_link'],
                                "plot" => 'A serie ' . $val['nome_link'] . ' é uma serie de ' . $val['nome_categoria'],
                                "cast" => "Sem informação de elenco",
                                "director" => "Sem informação de diretor",
                                "genre" => $val['nome_categoria'],
                                "releaseDate" => "Sem relase",
                                "last_modified" => "Sem data",
                                "rating" => (string)$rating,
                                "rating_5based" => $rating,
                                "backdrop_path" => 
                                    array (
                                        0 => $val['logo_link']
                                    ),
                                "youtube_trailer" => "",
                                "episode_run_time" => "",
                                "category_id" => $val['id_categoria']
                            );
                        }
                        
                    }
                }else{
                    $i = 0;
                    foreach($series['types_series'] as $key => $val){
                        
                        $i++;
                        $output_series_streams[] = array(
                            "num" => (int)$i,
                            "name" => $val['nome_link'],
                            "series_id" => (int)$val['id_link'],
                            "cover" => $val['logo_link'],
                            "plot" => 'A serie ' . $val['nome_link'] . ' é uma serie de ' . $val['nome_categoria'],
                            "cast" => "Sem informação de elenco",
                            "director" => "Sem informação de diretor",
                            "genre" => $val['nome_categoria'],
                            "releaseDate" => "Sem relase",
                            "last_modified" => "Sem data",
                            "rating" => (string)$rating,
                            "rating_5based" => $rating,
                            "backdrop_path" => 
                                array (
                                    0 => $val['logo_link']
                                ),
                            "youtube_trailer" => "",
                            "episode_run_time" => "",
                            "category_id" => $val['id_categoria']
                        );
                        
                    }
                }
                echo json_encode($output_series_streams, JSON_UNESCAPED_SLASHES);                                
            break;  

            case "get_series_info":
                $vod_id = $_REQUEST['series_id'];
                $response = array();
                $seanum = 0;
                $i = 0;
                 foreach($series['types_series'] as $key => $val){
                    if ($val['id_link'] == $vod_id){
                        $i++;
                        $rating = rand(5*10, 10*10)/10;
                       
                        $seasons[] = array (
                            "air_date" => "Sem data", 
                            "episode_count" => (int)$i,
                            "id" => (int)$val['id_link'],
                            "name" => $val['nome_link'],
                            "overview" => 'A serie ' . $val['nome_link'] . ' é uma serie de ' . $val['nome_categoria'],
                            "season_number" => $seanum,
                            "cover" => $val['logo_link'],
                            "cover_big" => $val['logo_link']
                        );
                        $seanum++;
                        
                        $info = array (
                          "name" => $val['nome_link'],
                          "cover" => $val['logo_link'],
                          "plot" => 'A serie ' . $val['nome_link'] . ' é uma serie de ' . $val['nome_categoria'],
                          "cast" => "Sem informação de elenco",
                          "director" => "Sem informação de diretor",
                          "genre" => $val['nome_categoria'],
                          "releaseDate" => "Sem relase",
                          "last_modified" => "Sem data",
                          "rating" => (string)$rating,
                          "rating_5based" => $rating,
                          "backdrop_path" => 
                          array (
                            0 => $val['logo_link']
                          ),
                          "youtube_trailer" => "",
                          "episode_run_time" => "",
                          "category_id" => $val['id_categoria']
                        );
                    
                        $episodes[$i][] = array(
                            "id" => $val['id_link'],
                            "episode_num" => (int)$i,
                            "title" => $val['nome_link'],
                            "container_extension" => "mp4",
                            "info" => array(
                               "movie_image" => $val['logo_link'],
                               "backdrop_path" => [
                                  
                               ],
                               "youtube_trailer" => "",
                               "genre" => $val['nome_categoria'],
                               "plot" => 'A serie ' . $val['nome_link'] . ' é uma serie de ' . $val['nome_categoria'],
                               "cast" => "Sem informação de elenco",
                               "rating" => (string)$rating,
                               "director" => "Sem informação de diretor",
                               "releasedate" => "Sem relase",
                               "tmdb_id" => ""
                            ),
                            "custom_sid" => null,
                            "added" => "",
                            "season" => $seanum,
                            "direct_source" => ""
                        ); 
                        
                    }
                    
                }         
                $response["seasons"] = $seasons;
                $response["info"] = $info;                       
                $response["episodes"] = $episodes; 
                echo json_encode($response);
            break;
            
            default:
                echo '{"user_info":{"username":"'.$_GET['username'].'","password":"'.$_GET['password'].'","message":"Bem vindo ao Xtream Server 4.9","auth":'.$auth.',"status":"'.$active.'","exp_date":"'.$data.'","is_trial":"0","active_cons":"'.$conectado.'","created_at":"'.$criado.'","max_connections":"'.$conectado.'","allowed_output_formats":["m3u8","ts","rtmp","mp4"]},"server_info":{"url":"'.$url.'","port":"80","https_port":"443","server_protocol":"http","rtmp_port":"25462","timezone":"America\/Argentina\/San_Luis","timestamp_now":' . time() . ',"time_now":"' . date('y-m-d H:m:s') . '"}}';
            break;            
        }
    }else{
        echo '{"user_info":{"username":"'.$_GET['username'].'","password":"'.$_GET['password'].'","message":"Bem vindo ao Xtream Server 4.9","auth":'.$auth.',"status":"'.$active.'","exp_date":"'.$data.'","is_trial":"0","active_cons":"'.$conectado.'","created_at":"'.$criado.'","max_connections":"'.$conectado.'","allowed_output_formats":["m3u8","ts","rtmp","mp4"]},"server_info":{"url":"'.$url.'","port":"80","https_port":"443","server_protocol":"http","rtmp_port":"25462","timezone":"America\/Argentina\/San_Luis","timestamp_now":' . time() . ',"time_now":"' . date('y-m-d H:m:s') . '"}}';
    }
                        
?>