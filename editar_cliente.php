<?php 
include('conexao.php');
$id = intval($_GET['id']);


function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
  }

$erro = false;

if(count($_POST) > 0) {


    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];




    if(empty($nome)) {
        $erro = "Preencha o nome";
    }


    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o email";
    }

    if(!empty($nascimento)) {

        $pedacos = explode('/', $nascimento);
        if(count($pedacos) === 3 ){
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro = "Data de nascimento deve seguir o padrão dia/mes/ano";
        }
       
    }

    if(!empty($telefone)) {
      
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11) 
            $erro = "o Telefone deve seguir o padrão (44)88888-8888";
        
    }

    if($erro) {
        echo "<p><b> ERRO: $erro </b> </p>";
    } else {
        $sql_code = 
        "UPDATE clientes SET 
        nome =  '$nome',
        email = '$email',
        telefone = '$telefone',
        nascimento = '$nascimento'
        WHERE id = '$id'";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if($deu_certo) {
            echo "<p><b> Cliente atualizado com sucesso!</b> </p>";
            unset($_POST);
        } 
    }

}


$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();
   
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar de clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>

        p {
            text-align: center;
        }

    </style>   

</head>
<body>
       <div class="container d-flex flex-column align-items-center pt-3">
       <a href="clientes.php">Voltar para a lista</a>
        <br><br>
        <form method="POST" action="">

        <label for="">Nome</label>
        <input value="<?php  echo $cliente['nome'];  ?>" type="text" name="nome" id=""> <br> <br>

        <label for="">Email</label>
        <input value="<?php 
            echo $cliente['email'];  ?>" type="text" name="email" id=""> <br> <br>

        
        <label for="">Telefone</label>
        <input value="<?php if(!empty($cliente['telefone']))
        echo formatar_telefone($cliente['telefone']);  ?>" placeholder="(44)88888-8888" type="text" name="telefone" id=""> <br> <br>


        <label for="">Data de Nascimento</label>
        <input value="<?php if(!empty($cliente['nascimento']))
        echo formatar_data($cliente['nascimento']); ?>" type="text" name="nascimento" id=""> <br> <br>

        <button type="submit">Salvar cliente</button>

        </form>
       </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>