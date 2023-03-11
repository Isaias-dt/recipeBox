<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php
           
           require('config.php');

           if (!empty($_GET['del'])) {
                $urlDel = $_GET['del'];
                $queryDelete = "DELETE FROM receita WHERE ID = $urlDel";
                $execQueryDelete = mysqli_query($conectar, $queryDelete) or die('Erro ao excluir o item: '.mysqli_error($conectar));
                if ($execQueryDelete) {
                    echo 'Receita deletada com sucesso!';
                }
            }
            
            function consult2(){   
                global $conectar;       
                if (!empty($_GET['id'])) {
                    
                    $IDurl = mysqli_real_escape_string($conectar, $_GET['id']);
                    $queryConsult = "SELECT * FROM receita WHERE ID = $IDurl";
                    $execQueryConsult = mysqli_query($conectar, $queryConsult) or die('Error ao consultar: '.mysqli_error($conectar));
                    
                    if (mysqli_num_rows($execQueryConsult) > 0) {
                        if ($result = mysqli_fetch_assoc($execQueryConsult)) {
                            echo'
                                <span>Categoria: '.nl2br($result['IDCategoria']).'</span>
                                <h2>'.nl2br($result['Titulo']).'</h2>
                                <h3>Ingredientes</h3>
                                <p>'.nl2br($result['Ingrediente']).'</p>
                                <h3>Instrução</h3>
                                <p>'.nl2br($result['Instrucao']).'</p>
                            ';
                        } else {
                            echo '
                            <h3 class="corMsgError">
                                Erro ao consultar não há nenhum item cadastrado! 
                            </h3>';
                        } 
                    } else {
                        echo '
                            <h3 class="corMsgError">
                                Erro ao consultar item não está mais cadastratado! A página será atualiza em 5 segundos.
                            </h3>';
                        header('Refresh:5;url=consulta_Receita.php');
                    }      
                }
            }

            function consult(){
                global $conectar;
                $queryConsult = "SELECT ID, Titulo FROM receita";
                $execQueryConsult = mysqli_query($conectar, $queryConsult) or die('Erro ao consultar: '.mysqli_error($conectar));
                
                if (mysqli_num_rows($execQueryConsult) <= 0) {
                    echo '
                        <h3>
                            Nenhuma receita Cadastrada!
                        </h3>';
                } else {
                    while($result = mysqli_fetch_assoc($execQueryConsult)) {
                        echo' 
                            <tr>
                                <td>
                                    <a href="?id='.$result['ID'].'">'.$result['Titulo'].'</a>
                                </td>
                                <td class="tdImage">
                                    <a href="atualizar-Receita.php?id='.$result['ID'].'">
                                        <img src="img/icon_editar.png"/>
                                    </a>
                                </td>
                                <td class="tdImage">
                                    <a href="?del='.$result['ID'].'">
                                        <img src="img/icon_excluir.png"/>
                                    </a>
                                </td>
                            </tr>
                            ';
                    }
                }
            }            

        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Consultar receita</title>
    </head>
    <body>
        <div id="conteiner">
            <div class="consult">
                <table class="tablefull">
                    <tr>
                        <div>
                            <a href="nova-receita.php">
                                <div class="btnCriarReceita">Criar Receita?</div>
                            </a>
                        </div>
                        <div>
                            <div>
                                <input type="text" name="search" placeholder="pesquisar receitas">
                            </div>
                            <div>
                                <button>Pesquisar</button>
                            </div>
                        </div>
                    </tr>
                    <tr class="cabecalhoTable">
                        <th>Receitas</th>
                        <th>Atualizar</th>
                        <th>Deletar</th>
                    </tr>
                    <?php consult(); ?>                      
                </table>
            </div>
            <div class="linhaCentral"></div>
            <div class="content">
                <div class="styleText">
                    <?php consult2(); ?>
                </div>
            </div>
        </div>
    </body>
</html>
