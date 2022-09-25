<?php
    session_start();
    require_once("cabecalho.php");
?>
                    <style>
                        .flex-center {
                            align-items: center;
                            display: flex;
                            justify-content: center;
                            margin:0;
                            padding:0
                        }
                        .position-ref {
                            position: relative;
                        }
                        .content {
                            margin-top:-20px;
                            text-align: center;
                            font-size: 20px;
                            background-color:yellow;
                            width:100%
                        }
                    </style>
                    <div class='flex-center '>
                        <div class='content'>
                            <div class='title' style="padding-top:5px">
                               <img class="mx-auto d-block mb-2" src="img/logo.png" alt="Logo" height="65">
                               <span style='font-size:20px;'>Manual de Utilização</span>
                            </div>
                        </div>
                    </div>        
                    <div id="conteudo-painel" class="container" style="background-color:#CCC; max-height:100%; max-width:100%;">
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>1º procedimento - Importação de Lista</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>                        
                        <p>Somente o usuário com nível administrador poderá fazer importação de lista.</p>
                        <p>O administrador deverá possuir um arquivo no formato m3u e salvá-lo em um local específico no seu computador ou então possuir um link com o caminho de um arquivo no mesmo formato.</p>
                        <p>Ao clicar em "Importar Lista", irá abrir uma janela para onde o administrador poderá selecionar o arquivo do local do seu computador ou inserir o link do arquivo e clicar em "Carregar arquivo".</p>
                        <p>Finalizada a importação, será criado as categorias e os conteúdos automaticamente.</p>
                        <p>Este processo de inserir categorias e conteúdos podem ser feitos manualmente também, bastando apenas entrar em cada seção respectiva no menu, lembrando que, primeiramente e obrigatoriamente deve-se cadastrar a categoria e somente depois o conteúdo.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>2º procedimento - Criação das Listas</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>                        
                        <p>As Listas são na verdade os "pacotes" para distribuição, por exemplo, "Lista de Canais + Filmes + Series + Adultos" ou "Lista de Canais + Filmes + Series". Estes foram apenas 2 exemplos, podendo assim o administrador criá-las conforme sua necessidade e conforme as categorias e conteúdos importados e/ou criados.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>3º procedimento - Criação dos Vendedores</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>
                        <p>Os administradores devem criar os vendedores, e os vendedores que irão criar/vender para os clientes, testes e sub-revendedores. O administrador tem a visibilidade total dos menus, porém, fica necessariamente obrigado a somente aos vendedores e sub-revendedores cadastrarem clientes, testes e sub-revendedores.</p>
                        <p>Ao ser cadastrado um vendedor, o mesmo irá especificar quais Listas este vendedor terá direito de trabalhar.</p>
                        <p>Cabe somente ao administrador definir a quantidade de créditos para cada vendedor e os vendedores assim o solicitarão para seus administradores.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>4º procedimento - SOMENTE PARA OS VENDEDORES e SUB-REVENDEDORES</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>
                        <p>Após o vendedor receber seu acesso, o mesmo irá logar em sua área.</p>
                        <p>O vendedor poderá criar sub-revendedor, cliente e teste.</p>
                        <p>Cada sub-revendedor ou cliente criado pelo vendedor, os seus creditos irão ser subtraídos de acordo com o nº de creditos utilizados em seus cadastros criados.</p>
                        <p>Quando zerar o nº de créditos, o vendedor ou sub-revendedor deverá solicitar mais creditos para o seu "criador" direto, ou seja, para quem o cadastrou no sistema.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>Outros detalhes do sistema</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>                        
                        <p>Usuário cliente não tem acesso ao sistema.</p>
                        <p>O sistema dispõe de um serviço de criação de tipo de evento e suas mensagens específicas, onde é servido de informação universal para os utilizadores do sistema, com sinalização visual e sonora.</p>
                        <p>O sistema possui um gerenciamento de Backup, onde o administrador pode executar no seu momento desejado, onde ele irá criar os arquivos referentes aos dias e horários gerados, também com a possibilidade de restauração, bastando apenas selecionar o arquivo desejado e iniciar o restore do mesmo.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>** Geração de Lista m3u **</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>                        
                        <p>Agora você pode gerar a lista em formato m3u, podendo utilizar o link normal e o link encurtado, para acesso aos players em modo "lista m3u".</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>** API **</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>                        
                        <p>Agora o sistema possui uma api para utilização dos player em modo XC.</p>
                        <p>Esta API está ainda em fase BETA, porém funcional, já testado nos aplicativos sugeridos na página de Dashboard.</p>
                        <p>Importante salientar que, ainda não está aplicado o EPG e TMDB no sistema, pois ele ainda está em fase de desenvolvimento, não tendo um prazo específico para a finalização, porém, suas TMDBs e seu EPG estão Defaults quando visualizados nos aplicativos em modo XC.</p>
                        <p>A url para informar a API, é a url que está nas configurações do arquivo de api (vide manual de instalação), bastando apenas informar a url, o usuário e a senha do cliente.</p>
                        <div class="page-title" style="margin-top:20px">
                            <li><strong>** OBSERVAÇÃO **</strong></li>
                            <h1 class="page-heading1 heading-center"></h1>
                        </div>
                        <p>Finalização da área SERIES da API até o dia 31/05/2021.</p>
                        <p>Pedimos que os utilizadores, conforme uso e se, porventura venham notar algum problema ou que tenha alguma sugestão para implementação, que informem os seus "criadores" diretos, para assim ser informado aos desenvolvedores.</p>
                    </div>
                    <div style="height:20px"></div>
                    <i id="totop" class="btn btn-outline-info text-dark fas fa-angle-double-up"></i>                        
                    <button id="voltar" class="btn btn-primary" type="button" onClick="history.go(-1); return false;">Voltar</button>              
                </div>
            </div>
        </main>
        <!-- page-content" -->
    </div>
</body>
<script>
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
</html>