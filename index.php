<?php
require_once 'CLASSES/usuarios.php';


$us = new Usuario;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pianinho</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
		integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
		crossorigin="anonymous" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Arima+Madurai:wght@200&amp;family=Bungee&amp;family=Iceland&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
    
    
<!--Bem Vindo, <span id="result"></span> !
<script>
    document.getElementById("result").innerHTML=localStorage.getItem("textvalues");
</script> -->

    
   <!-- <label>$usuario</label> -->
   
   <div class="corpo-form">
       
    <form method="POST" action="jogo_logado.php"> <!--teste-->
    <!--
        <input type="text" placeholder="Usuário" name="usuario"> 
        <input type="password" placeholder="Senha" name="senha">
        <input type="submit" value="Acessar">
        <a href="cadastrar.php"><strong>Cadastre-se</strong></a>
       <?php   $_SESSION['nome_usuario']=$_POST['usuario'];
       echo $_SESSION['nome_usuario'] ?>
      -->
    </div> 
    <div>
        <?php   $_SESSION['nome_usuario']=$_POST['usuario'];
       echo $_POST['nome_usuario'];
       echo $_POST['nomeacesso'] ;
       echo $usuario;
       echo $_POST['usuario'];
       ?>
 </div>
 <?php
 if (isset($_POST['usuario'])){
    
    $usuario = addslashes($_POST['usuario']);
    $senha = addslashes($_POST['senha']);
  
    if(!empty($usuario) && !empty($senha)){
        $us->conectar("dimetatarsoquart_pianinho","localhost","dimetatarsoquart_user","Suporte@2021");
        if($us->msgErro == ""){ 
            if($us->logar($usuario,$senha)){
                echo $_SESSION['nome_usuario'];
                header("location: index.php");
            }else{
                ?>
                <div class="msg-erro">
                Usuario e/ou senha incorretos!
                </div>
                <?php
            }
        }else{
            ?>
            <div class="msg-erro">
            "Erro: ".$u->msgErro;
            </div>
            <?php
        }
    }else{
        ?>
        <div class="msg-erro">
        Preencha todos os campos!
        </div>
        <?php
    } 
 }
        
?>
    
    
    
	<div class="container">
		<div class="game">
			<div class="game__pad game__pad--tl"></div>
			<div class="game__pad game__pad--tr"></div>
			<div class="game__pad game__pad--bl"></div>
			<div class="game__pad game__pad--br"></div>
			<div class="game__pad game__pad--bm"></div>
			<div class="game__pad game__pad--tm"></div>

			<div class="game__options">
				<h1 class="game__tittle">Pianinho<span class="reg"></span></h1>

				<div class="gui">
					
					<div class="group">
						<div class="gui__counter">--</div>
						<p class="gui__label">PONTOS</p>
					</div> <!--group-->
					
					<div class="group">
						<div class="gui__btn gui__btn--start"></div>
						<p class="gui__label">start</p>
					</div> <!--.group-->

					<div class="group">
						<div class="gui__led"></div>
						<div class="gui__btn gui__btn--strict"></div>
						<p class="gui__label"></p>

					</div><!--group-->

					<div class="group group-large">
						<p class="gui__label gui__label--switch">ON</p>
						<div class="gui__btn-switch"></div>
						<p class="gui__label gui__label--switch">OFF</p>

					</div> <!--group-->

				</div><!--gui-->

			</div><!--game__options-->

		</div><!-- .game -->
		<footer>CEDUP TIMBÓ 2022</footer>
	</div> <!-- .container -->
	<script src="js/scripts.js"></script>
</body>
</html>