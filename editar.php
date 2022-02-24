<?php
session_start();
include 'config.php';



if(isset($_REQUEST['id']))
{
	try
	{
		$id = $_REQUEST['id']; 
		$sql = $pdo->prepare('SELECT * FROM tb_img WHERE id =:id'); 
		$sql->bindParam(':id',$id);
		$sql->execute(); 
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		extract($row);
	}
	catch(PDOException $e)
	{
        $e= $_SESSION['msg']="<p>arquivo não foi editado com sucesso!</p>";
	}
	
}

if(isset($_REQUEST['btn'])){

	try{
	
		$name	=$_REQUEST['nome'];	
		
		$nome_img	= $_FILES["img"]["name"];
		$type		= $_FILES["img"]["type"];	
		$size		= $_FILES["img"]["size"];
		$temp		= $_FILES["img"]["tmp_name"];
			
		$path="arquivo/".$nome_img; 
	
		
		if($nome_img){
		
			if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif'){
				
				if(!file_exists($path)){ 
				
					if($size < 5000000){
					
						unlink("arquivo/".$row['img']);
						move_uploaded_file($temp, "arquivo/" .$nome_img);
					}else{
					
                        $_SESSION['msg']="<p>o arquivo esta maior do que 5MB</p>";
					}


				}else{	
				
                    $_SESSION['msg']="<p>o arquivo já existe!</p>";
				}


			}else{
				
                $_SESSION['msg']="<p>o formato do arquivo deve ser JPG, JPEG, PNG & GIF!</p>";
			}


		}else{

			$nome_img=$row['img'];
		}
	
		if(!isset($_SESSION['msg']))
		{
			$sql=$pdo->prepare('UPDATE tb_img SET nome=:nome, img=:img WHERE id=:id');
			$sql->bindParam(':nome',$nome);
			$sql->bindParam(':img',$nome_img);	
			$sql->bindParam(':id',$id);
			 
			if($sql->execute())
			{
                $_SESSION['msg']="<p>arquivo foi editado com sucesso!</p>";
				header("refresh:3;index.php");
			}
		}


	}catch(PDOException $e){
	

       $e= $_SESSION['msg']="<p>arquivo não foi editado com sucesso!</p>";
	}
	
}


?>




<?php
  if(isset( $_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset( $_SESSION['msg']);
  }

  ?>


<form  method="POST" enctype="multipart/form-data">
<input name="id" type="hidden" value="<?=$row['id'];?>">
<input type="text" name="nome" placeholder="nome" value="<?=$row['nome'];?>">  
<br><br>
<input type="file" name="img" value="<?=$row['img'];?>">
<p><img src="arquivo/<?=$row['img'];?>" height="200" width="200" /></p>
<br>
<br>
<input type="submit" value="enviar" name="btn">
<button><a style="text-decoration: none;" href="index.php">cancelar</a></button>
</form>