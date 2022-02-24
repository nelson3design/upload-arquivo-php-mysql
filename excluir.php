<?php

include 'config.php';
$id= $_REQUEST['id'];


    if($id){
        
    $sql= $pdo->prepare("SELECT * FROM tb_img WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

        $info= $sql->fetch( PDO::FETCH_ASSOC);

        unlink("arquivo/".$info['img']);

        $sql= $pdo->prepare("DELETE FROM tb_img WHERE id= :id");
        $sql->bindValue(':id', $id );
        $sql->execute();
    
     header("location: index.php");
     exit;
    
    }else{
        header("location: index.php");
        exit;
    }


?>