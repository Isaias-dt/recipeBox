<!DOCTYPE html>
<html lang="pt-br">
    <head>
        
        <?php
            require('config.php');
            
            $msgCadInvalido = '';
            
            function categoria(){
                require('config.php');

                $queryTabCat = "SELECT ID, Nome FROM categoria";
                $execQueryCat = mysqli_query($conectar, $queryTabCat);
                while($result = mysqli_fetch_assoc($execQueryCat)){
                    echo '<option value="'.$result['ID'].'">'.$result['Nome'].'</option>';
                }
            }            
                    
            if (isset($_POST['sendReceita'])) {
                
                if ($_POST['Titulo'] != '' && $_POST['Ingrediente'] != '' && $_POST['Instrucao'] != '' && $_POST['Categoria'] != '') {
                    
                    $values['Titulo'] = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Titulo']));
                    $values['Categoria'] = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Categoria']));
                    $values['Ingrediente'] = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Ingrediente']));
                    $values['Instrucao'] = htmlspecialchars(mysqli_real_escape_string($conectar, $_POST['Instrucao']));
                    
                    $query  = "INSERT INTO ".DBSA."(Titulo, IDCategoria, Ingrediente, Instrucao)"; 
                    $query .= "VALUES('$values[Titulo]', '$values[Categoria]', '$values[Ingrediente]', '$values[Instrucao]')";

                    $execQuery = mysqli_query($conectar, $query) or die('Erro ao execultar a query: '.mysqli_error($conectar));
                    if ($execQuery) {
                        echo 'Cadastrado com Sucesso!';
                        unset($_POST);
                    } else {
                        header('Refresh:5;url=receita.php');
                    }
                    
                } else {
                    $msgCadInvalido = 'Preencha todos os campos para efetuar o cadastro!';
                    unset($_POST);
                }
            }
            
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastrar receita</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <form action="" name="cadReceita" method="POST">
            <label>
                <span>Nome:</span>
                <br>
                <input type="text" name="Titulo" size="50">
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
                <textarea name="Ingrediente" rows="10" cols="50"></textarea>
            </label>
            <br>
            <label>
                <span>Instruções:</span>
                <br>
                <textarea name="Instrucao" rows="10" cols="50"></textarea>
            </label>
            <br>
            <br>
            <input type="submit" name="sendReceita" value="Cadastrar receita">
            <br>
            <span style="color: red;"><?php echo $msgCadInvalido; ?></span>
        </form>
    </body>
</html>
