<?php
	session_start();
	require_once('controlador.php');
?>
<html>
<head>
	<title>Painel do Usuario</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<meta name="author" content=""/>
	<meta name="description" content="Locatech - Sistema de locação de dispositivos IOS."/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/> <!--Meta tag responsiva -->
	<link rel="stylesheet" type="text/css" href="css/estilo.css" media="screen"/>
</head>
<body>
    <div class="MenuContaTop"><!--Menu top -->
		<?php
			if(isset($_SESSION["ConectedLT"])){				
				echo"<ul align='right'>";	
					echo"<li><a class='buttons2' href='#' >Pagina Inicial</a></li>";				
					echo"<li>Usuario:  <a href='painelDoUsuario.php'> ".$_SESSION["Login"]."</a></li>";
					echo"<li><a href='validacao.php?act=logout'>Desconectar</a></li>";
				echo"</ul>";
			}
			else{
				echo"<script>alert('Acesso negado!'); </script>";
				echo"<script> window.location='i#';</script>";
			}
		?>
	</div>
	<div >
		<?php
		$pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$idUsuario =  $_SESSION['IdUsuario']; // Assuming you have the user ID in a session variable
		$funcionalidade = 'produtos';
		
		$desabilitarBotao = true; // Suponha que 'true' signifique desabilitar o botão

		echo "<div class='Painel' >";
			echo "<h1>Painel do usuário!</h1>";	
					
				echo "<div class=''>";
					echo "<ul>";
						//Read
						$acao = 'ler';
						if (possuiPermissao($idUsuario, $funcionalidade, $acao)) {
							echo "<li class='buttons2'><a href='#'>Listar produtos</a></li>";
						} else {
							echo "<li class='buttons3'><a href='#'>Listar produtos</a></li>";
						}
						//Create
						$acao = 'incluir';
						if (possuiPermissao($idUsuario, $funcionalidade, $acao)) {
							echo "<li class='buttons2'><a href='#'>Inclur produtos</a></li>";
						} else {
							echo "<li class='buttons3'><a href='#' disabled>Inclur produtos</a></li>";
						}
						//Update
						$acao = 'alterar';
						if (possuiPermissao($idUsuario, $funcionalidade, $acao)) {
							echo "<li class='buttons2'><a href='#'>Alterar produtos</a></li>";
						} else {
							echo "<li class='buttons3'><a href='#'>Alterar produtos</a></li>";
						}
						//Delete
						$acao = 'excluir';
						if (possuiPermissao($idUsuario, $funcionalidade, $acao)) {
							echo "<li class='buttons2'><a href='#'>Excluir produtos</a></li>";
							echo "Usuário pode excluir produtos.";
						} else {
							echo "<li class='buttons3'><a href='#'>Excluir produtos</a></li>";
						}
					echo "</ul>";							
				echo "</div>";
		echo "</div>";    
        ?>
    </div>
</body>
</html>