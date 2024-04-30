<?php //Verifica se o usuario esta logado
	session_start();
	if(isset($_SESSION["ConectedLT"])){
		echo"<script> window.location='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<meta name="author" content=""/>
	<meta name="description" content="Locatech - Sistema de locação de dispositivos IOS."/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/> <!--Meta tag responsiva -->
	<link rel="stylesheet" type="text/css" href="css/estilo.css" media="screen"/>
</head>
<body>
	<div class='Acesso'> 
		<div class='Formulario'>
			<h2 align='center'>Acesso</h2>
			<form action="validacao.php?act=login" method="post" >   
			             
					<div class="mylabel">Login:</div>
					<div ><input class="" type="text" id="login" name="login" required></div>
					<br/>
					<div class="mylabel">Senha: </div>
					<div ><input class="" type="password" id="senha" name="senha" required></div>
					<br/>
					<input class="buttons" type="submit" value="Entrar">
				
				<a class="buttons" href='index.php'>Voltar</a>
			</form>
		</div>
	</div>

</body>
</html>