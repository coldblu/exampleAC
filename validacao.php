<?php
    if($_GET["act"]=="login"){
        if(isset($_POST["login"])&&isset($_POST["senha"]) && !empty($_POST["login"])||!empty($_POST["senha"])){
            $NomeDeUsuario=$_POST["login"];
            $SenhaDoUsuario=$_POST["senha"];
            //Conexão com banco
            $pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $pdo->prepare("SELECT * FROM usuario where login = :login and senha = :senha");
            $consulta->bindParam(":login", $NomeDeUsuario, PDO::PARAM_STR);
            $consulta->bindParam(":senha", $SenhaDoUsuario, PDO::PARAM_STR);
            $consulta->execute();
            $linha = $consulta->fetch(PDO::FETCH_ASSOC);
            //salvando dados do banco coletado
            $Login = $linha['login'];
            $Senha = $linha['senha'];
            $CargoUsuario = $linha['cargo'];
            $IdUsuario = $linha['id'];

            //Validação dos dados do usuario
            if($NomeDeUsuario==$Login && $SenhaDoUsuario==$Senha){
                session_start();//Inicia a sessão
                $_SESSION["ConectedLT"] = "conectado";
                $_SESSION["Login"] = $Login;
                $_SESSION["CargoUsuario"] = $CargoUsuario;
                $_SESSION['IdUsuario'] = $IdUsuario;
                
                echo "<script> alert('Logado com sucesso'); </script>";
                echo "<script> window.location='painelDoUsuario.php';</script>";
            }
            else{
                echo"<script>alert('Acesso negado!'); </script>";
                echo"<script> window.location='login.php';</script>";
            }


        }
        else{
            echo"<script>alert('Acesso negado!'); </script>";
            echo"<script> window.location='login.php';</script>";
        }
    }
    else if($_GET["act"]=="logout"){
        session_start();
        // Inicializa a sessão.
	    // Se estiver sendo usado session_name("something"), não esqueça de usá-lo agora!
	    // Apaga todas as variáveis da sessão
	    $_SESSION = array();
	    // Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
	    // Nota: Isto destruirá a sessão, e não apenas os dados!
	    if (ini_get("session.use_cookies")) {
	    	$params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		    	$params["path"], $params["domain"],
		    	$params["secure"], $params["httponly"]
		    );
	    }
	    // Por último, destrói a sessão
	    session_destroy();
	    echo "<script> window.location='login.php';</script>";
    }
?>