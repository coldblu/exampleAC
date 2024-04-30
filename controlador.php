<?php
// Conexão com o banco
$pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function buscaCargoUsuario($idUsuario){
	$pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$consulta = $pdo->prepare("
	  SELECT r.nome AS nome_role
	  FROM usuario u
	  JOIN usuario_possui_role upr ON upr.usuario_id = u.id
	  JOIN role r ON r.id = upr.role_id
	  WHERE u.id = :idUsuario;
	");
	$consulta->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$consulta->execute();
	$linha = $consulta->fetch(PDO::FETCH_ASSOC);
	if ($linha) {		
		$cargo = $linha['nome_role'];
		return $cargo;
	} else {
		echo "Usuário não encontrado ou não possui role atribuída.";
	}
	
}

function buscaPermissaoRoles($nomeRole){
	$pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$consulta = $pdo->prepare("
		SELECT
		  r.nome AS nome_role,
		  f.nome AS nome_funcionalidade,
		  a.nome AS nome_acao
		FROM role r
		JOIN permissao_role pr ON pr.role_id = r.id
		JOIN funcionalidade f ON f.id = pr.funcionalidade_id
		JOIN acao a ON a.id = pr.acao_id
		WHERE r.nome = :nomeRole
	");
	$consulta->bindParam(":nomeRole", $nomeRole, PDO::PARAM_STR);
	$consulta->execute();

	// Retorna um array com as permissões do usuário
	$permissoes = [];
	while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		$permissoes[] = [
		  "nomeRole" => $linha["nome_role"],
		  "nomeFuncionalidade" => $linha["nome_funcionalidade"],
		  "nomeAcao" => $linha["nome_acao"],
		];
	}
	return $permissoes;
}


function buscarPermissoesDoUsuario($idUsuario) {
	// Consulta para buscar permissões do usuário
	$pdo = new PDO('mysql:host=localhost;dbname=exemploac;charset=utf8', "root", "");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$consulta = $pdo->prepare("
		SELECT
		f.nome AS nome_funcionalidade,
		a.nome AS nome_acao
		FROM permissao p
		INNER JOIN funcionalidade f ON f.id = p.funcionalidade_id
		INNER JOIN acao a ON a.id = p.acao_id
		WHERE p.usuario_id = :idUsuario
	");
	$consulta->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$consulta->execute();

	// Retorna um array com as permissões do usuário
	$permissoes = [];
	while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		$permissoes[] = [
		  "nomeFuncionalidade" => $linha["nome_funcionalidade"],
		  "nomeAcao" => $linha["nome_acao"],
		];
	}
	return $permissoes;
}


function possuiPermissao($idUsuario, $funcionalidade, $acao){
	//Inicializar variáveis
	$permissoesDoUsuario = [];
	$permissoesDaRole = [];
	$roleDoUsuario= "";
	//Atribuir os valores
	$roleDoUsuario = buscaCargoUsuario($idUsuario);
	$permissoesDoUsuario = buscarPermissoesDoUsuario($idUsuario);
	$permissoesDaRole = buscaPermissaoRoles($roleDoUsuario);
	if(in_array($funcionalidade, array_column($permissoesDaRole, "nomeFuncionalidade"))){
		if(in_array($acao, array_column($permissoesDaRole, "nomeAcao"))){
			return 1;
		}
	}//Validar se o cargo do usuario tem permissão
	if(in_array($funcionalidade, array_column($permissoesDoUsuario, "nomeFuncionalidade"))){
		if(in_array($acao, array_column($permissoesDoUsuario, "nomeAcao"))){
			return 1;
		}
	}//Caso o cargo do usuario não possuir permissão, veririficar se ele tem permissão especifica
	else{
		return 0;//Retorna 0 se ele não possuir nenhuma permissão.
	}	
}


?>