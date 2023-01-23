<?php include('conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>

        p {
            text-align: center;
        }
        
     </style>   
    

</head>
<body>
    <div class="container d-flex flex-column align-items-center pt-3">
        <a href="cadastrar_cliente.php">Cadastrar Cliente</a>
    <h1>Lista de Clientes</h1>
    <p>Estes são os clientes cadastrados no seu sistema:</p>
    <table border="1" cellpadding="10">
        <thead>
            <th>id</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
            <th>Data</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php 
            if($num_clientes == 0) { ?>
                <td colspan="7">Nenhum cliente foi cadastrado.</td>
                </tr>
        
           <?php
          }  else {
                while($cliente = $query_clientes->fetch_assoc()) {

                    $telefone = "Não informado";
                    if(!empty($cliente['telefone'])) {
                        $telefone = formatar_telefone($cliente['telefone']);
                    }

                    $nascimento = "Nascimento informada";
                    if(!empty($cliente['nascimento'])) {
                        $nascimento = formatar_data($cliente['nascimento']);
                    }

                    $data_cadastro = date("d/m/Y H:i", strtotime($cliente['data']));
                

            ?>
            <tr>
                <td><?php echo $cliente['id'];?></td>
                <td><?php echo $cliente['nome'];?></td>
                <td><?php echo $cliente['email'];?></td>
                <td><?php echo $telefone;?></td>
                <td><?php echo $nascimento;?></td>
                <td><?php echo $data_cadastro;?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id'];?>">Editar</a>
                    <a href="deletar_cliente.php?id=<?php echo $cliente['id'];?>">Deletar</a>
                </td>
            </tr>

            <?php
                }
        } ?>
        </tbody>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>