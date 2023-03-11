<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php
            require('config.php');

            $msgCadInvalido = ''; 
            
            function categoria(){
                global $conectar;
                $urlID = $_GET['id'];
                $queryTabRec = "SELECT IDCategoria FROM receita WHERE ID = $urlID";
                $execQueryRec = mysqli_query($conectar, $queryTabRec) or die('Erro ao tentar encontrar o item: '.mysqli_error($conectar));
                $resultQueryRec = mysqli_fetch_assoc($execQueryRec);

                $queryTabCat = "SELECT ID, Nome FROM categoria";
                $execQueryCat = mysqli_query($conectar, $queryTabCat) or die('Erro ao tentar encontrar o item: '.mysqli_error($conectar));
                
                while($result = mysqli_fetch_assoc($execQueryCat)){
                    if ($result['ID'] == $resultQueryRec['IDCategoria']) {
                        echo '<option value="'.$result['ID'].'" selected="selected">'.$result['Nome'].'</option>';
                    } else {
                        echo '<option value="'.$result['ID'].'">'.$result['Nome'].'</option>';
                    }                      
                }
            }

            if (isset($_POST['sendReceita'])) {
                
                if ($_POST['Titulo'] != '' && $_POST['Ingrediente'] != '' && $_POST['Instrucao'] != '' && $_POST['Categoria'] != '') {
                    
                    $urlID = mysqli_real_escape_string($conectar, $_GET['id']);

                    $values['Titulo']       = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Titulo']));
                    $values['Categoria']    = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Categoria']));
                    $values['Ingrediente']  = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Ingrediente']));
                    $values['Instrucao']    = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Instrucao']));
                    
                    $query = "UPDATE receita SET Titulo = '$values[Titulo]', IDCategoria = '$values[Categoria]', Ingrediente = '$values[Ingrediente]', Instrucao = '$values[Instrucao]' WHERE ID = $urlID"; 

                    $execQuery = mysqli_query($conectar, $query) or die('Erro ao execultar a query: '.mysqli_error($conectar));
                    if ($execQuery) {
                        echo 'Atualização efetuada com Sucesso!';
                    } else {
                        header('Refresh:5;url=receita.php');
                    }
                    
                } else {
                    $msgCadInvalido = 'Preencha todos os campos para efetuar o cadastro!';
                    unset($_POST);
                }
            }

            // funtion inseri valores no campo.
            if (!empty($_GET['id'])) {
                $urlID = mysqli_real_escape_string($conectar, $_GET['id']);
                $querySelect = "SELECT * FROM receita WHERE ID = $urlID";
                $execQuerySelect = mysqli_query($conectar, $querySelect) or die('Erro ao encontrar o item: '.mysqli_error($conectar)); 
                
                $result = mysqli_fetch_assoc($execQuerySelect);                    
            } 
                                
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastrar receita</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <form action="" name="cadReceita" method="POST">
                <label>
                    <span>Nome:</span>
                    <br>
                    <input type="text" name="Titulo" value="<?php echo $result['Titulo']; ?>" size="50">
                </label>   
                <br> 
                <label>
                    <span>Categoria:</span>
                    <br>
                    <select name="Categoria">
                        <option value="" disabled="disabled" selected="selected">Escolha uma categoria?</option>
                        <?php categoria();?>
                    </select>
                </label>            
                <br>
                <label>
                    <span>Ingredientes:</span>
                    <br>
                    <textarea name="Ingrediente" rows="10" cols="50"><?php echo $result['Ingrediente']; ?></textarea>
                </label>
                <br>
                <label>
                    <span>Instruções:</span>
                    <br>
                    <textarea name="Instrucao" rows="10" cols="50"><?php echo $result['Instrucao']; ?></textarea>
                </label>
                <br>
                <br>
                <input type="submit" name="sendReceita" value="Atualizar receita">
                <br>
                <span style="color: red;"><?php echo $msgCadInvalido; ?></span>
            </form>
            <a href="consulta-Receitas.php">Consultar Receitas?</a>
        </div>
    </body>
</html>
