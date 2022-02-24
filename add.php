<?php
session_start();
include('config.php');
if(isset($_REQUEST['btn'])){
    $nome= $_REQUEST['nome'];
    	
	$nome_img= $_FILES["img"]["name"];
	$type= $_FILES["img"]["type"];	
	$size= $_FILES["img"]["size"];
	$temp= $_FILES["img"]["tmp_name"];

    $link_img= "arquivo/".$nome_img;

    if(empty($nome)){
        $_SESSION['msg']="<p>preemche o campo nome</p>";
    }else if(empty($nome_img)){
        $_SESSION['msg']="<p>escolhe um arquivo</p>";
    }else if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif'){
        if(!file_exists($link_img)){
            if($size < 5000000){
                move_uploaded_file($temp, "arquivo/" .$nome_img);
            }else{
                $_SESSION['msg']="<p>o arquivo esta maior do que 5MB</p>";
            }

        }else{
            $_SESSION['msg']="<p>o arquivo já existe</p>";
        }

    }else{
        $_SESSION['msg']="<p>só aceita arquivo em JPG , JPEG , PNG & GIF</p>";
    }

    if(!isset($_SESSION['msg'])){
        $sql= $pdo->prepare("SELECT * FROM tb_img WHERE nome=:nome");
        $sql->bindValue(':nome', $nome);
        $sql->execute();
        
        if($sql->rowCount() ===0){

        $sql= $pdo->prepare('INSERT INTO tb_img (nome,img,data) VALUES (:nome,:nome_img, NOW())');
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':nome_img', $nome_img);

        if($sql->execute()){
            $_SESSION['msg']="<p>arquivo foi enviado com sucesso!</p>";
            header("refresh:3;index.php");
        }
    }else{
        $_SESSION['msg']="<p>o nome já existe!</p>";
    }
    }else{
        $_SESSION['msg']="<p>arquivo não foi enviado com sucesso!</p>";
        header("add.php");
    }

}

?>
<?php
if(isset($_SESSION['msg'])){
   echo  $_SESSION['msg'];
   unset($_SESSION['msg']);
}

?>
<form action="" method="POST" enctype="multipart/form-data">
<input type="text" name="nome" placeholder="nome">
<br>
<br>
<input type="file" name="img">
<br>
<br>
<input type="submit" value="enviar" name="btn">
<button><a style="text-decoration: none;" href="index.php">cancelar</a></button>
</form>