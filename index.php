<?php
session_start();

include('config.php');
$lista=[];

$sql=$pdo->query('SELECT * FROM tb_img');
    
if($sql->rowCount() > 0){

    $lista= $sql->fetchAll( PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="add.php">adicionar</a></button>
  <?php
  if(isset( $_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset( $_SESSION['msg']);
  }

  ?>

 <table width="100%" border="1px">
     <thead>
         <tr>
             <th>id</th>
             <th>nome</th>
             <th>imagem</th>
             <th>acões</th>
         </tr>
     </thead>

     <tbody>
     <?php foreach( $lista as $usuario): ?>
         <tr>
             <td><?=$usuario['id']?></td>
             <td><?=$usuario['nome']?></td>
           
             <td><img src="arquivo/<?=$usuario['img']?>" alt="" width="200px;" height="200px;"></td>
            
             <td>
             <a href="editar.php?id=<?=$usuario['id'];?>"><button>editar</button></a>
                 <a href="excluir.php?id=<?=$usuario['id'];?>" onclick="return confirm('tem certeza de excluir esse usuario?')"><button>excluir</button></a>
            </td>
         </tr>
         <?php endforeach;?>

     </tbody>
 </table>

</body>
</html>

<!-- https://www.onlyxcodes.com/2018/04/how-to-upload-insert-update-and-delete.html -->