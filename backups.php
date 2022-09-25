                    <?php
                    require_once("cabecalho.php");
                    ?>
                    <style>
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                        div.fas{
                            color:#6B8E23;
                            font-size: 38px;
                        }
                        .loaderBKPG {
                          border: 16px solid #f3f3f3;
                          border-radius: 50%;
                          border-top: 16px solid #3498db;
                          width: 80px;
                          height: 80px;
                          -webkit-animation: spin 2s linear infinite;
                          animation: spin 2s linear infinite;
                        }
                        .statusMessage{
                            display:none;
                            position:fixed;
                        }
                        .statusMessage p{
                            left:20px;
                            position:relative;
                            font-size:13px;
                            line-height:30px;
                            color:red;
                            font-weight:700
                        }
                        .btn:focus, .btn:active {
                            outline: none!important;
                        }
                        .custom-file-input{cursor:pointer!important;}
                        .page-2content {
                            padding-left: 240px !important;
                            padding-right: 240px !important;
                        }                        
                    </style>                    
                    <div id="conteudo-painel" class="container">
                        <table class="table table-bordered table-responsive" style="width:100%; display:inline-table!important">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th class='nomecol' style="width: 100%; font-size:15px" scope="col" >Módulo de Backup</th>
                                </tr>
                            </thead>
                            <tbody id="conteudo">
                                <tr class="post" align="center">
                                    <td style="text-align: left; vertical-align: middle;">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <form style="padding:20px 20px 0px 20px" id="formBKP" name="formBKP">
                                                    <label for="backup">BACKUP</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button id="exec_backup" class="btn btn-primary" type="button">Executar</button>
                                                        </div>
                                                        <input id="backup" name="backup" readonly type="text" class="form-control">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <form style="padding:20px 20px 0px 20px" id="formRST" name="formRST" enctype="multipart/form-data">
                                                    <label for="backup">RESTORE</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button id="exec_restore" class="btn btn-primary" type="button">Executar</button>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="text" class="custom-file-input" name="file" id="file" readonly data-toggle="modal" data-target="#modalList">
                                                            <label id="label_file" class="custom-file-label" for="file">Selecione o arquivo</label>
                                                        </div>													
                                                    </div>
                                                </form>
                                                <div id="mensagem" class="statusMessage" style="display:none"><p>Nenhum arquivo selecionado!</p></div>
                                            </div>
                                        </div>
                                    </td>                                    
                                </tr>
                            </tbody>
                        </table>
                        <button id="voltar" class="btn btn-primary" type="button" onClick="history.go(-1); return false;">Voltar</button>
                        <button id="limpar" class="btn btn-secondary" type="button" onClick="Limpar();">Limpar Campos</button>
                    </div>
                </div>
            </div>
        </main>
        <!-- page-content" -->
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loadingModal_label">
                        Módulo de Backup
                    </h5>
                </div>
                <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                    <div class='alert' role='alert'>
                        <center>
                            <div class="loaderBKPG" id="loader"></div><br>
                            <h4><b style="font-weight:700; font-size:18px" id="loadingModal_content"></b></h4>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="loadingModal2" tabindex="-1" role="dialog" aria-labelledby="loadingModal2_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loadingModal2_label">
                        Módulo de Restore
                    </h5>
                </div>
                <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                    <div class='alert' role='alert'>
                        <center>
                            <div class="loaderBKPG" id="loader2"></div><br>
                            <h4><b style="font-weight:700; font-size:18px" id="loadingModal2_content"></b></h4>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loadingModal2_label">
                        Arquivos de Backup
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>                    
                </div>
                <div class="modal-body" style="max-height:460px; overflow-y:auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th class='nomecol' style="width: 100%" scope="col" >Arquivo</th>
                                    <th class='nomecol' style="width: 100%" scope="col" >Sel</th>
                                </tr>
                            </thead>                                        
                            <tbody class="tab-arquivos">
                                <?php
                                    $dir = "BACKUP_DIR/";
                                    if(!is_dir($dir)) {
                                        mkdir($dir, 0777, true);
                                    }                                
                                    $path = new DirectoryIterator('BACKUP_DIR/');
                                    $files = array();
                                    foreach($path as $directory) {
                                        if($directory->isDot()) continue;
                                            $files[$directory->getCTime()] = $directory->__toString();
                                    }
                                    krsort($files);
                                    foreach($files as $k => $v) {
                                        echo '<tr>';
                                            echo '<td>'.$v.'</td>';
                                            echo '<td><input type="radio" id="arquivo" name="arquivo" value="'.$v.'"></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>											
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="subSel" type="button" class="btn btn-primary" data-dismiss="modal">Selecionar</button>
                    <button id="subExc" type="button" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>				
            </div>
        </div>
    </div>     
</body>
<script src="js/backup.js"></script>
<script>
    function Limpar(){
        $('#formBKP')[0].reset();
        $('#formRST')[0].reset();
        $(".custom-file-label").html('Selecione o arquivo');
    }
    $('#modalList').on('hide.bs.modal', function (event) {
        $('input[name="arquivo"]').prop('checked', false);
    })
</script>
</html>