<?php

	session_start(); 

	Global $selfID;

	if(isset($_SESSION["id"])){
		$selfID = $_SESSION["id"];
	}

	include("./tech/tech.php");
	include("requestHandler.php");
	
	conectar();
	header('Content-Type: text/html; charset=utf-8');

	include("./mod/cab.php");

?>

<div class = "conteudo">
	<input type="submit" class="eBotao" value="Gerar escala para o mês atual (Abril)" style="font-weight: bold;" onclick="gerarEscalaMesAtual()">
	<input type="submit" class="eBotao" value="Gerar escala para o mês seguinte (Maio)" style="font-weight: bold;" onclick="gerarEscalaMesSeguinte()">

	Consultar Funcionário:

	<select id = "funcionarios" class = "ePeqCombo"></select>

	<input type="submit" class="eBotao" value="Consultar Funcionário" style="font-weight: bold;" onclick="consultarFuncionario()">

	<div id = "consulta">

	</div>

</div>

<script src="jquery-latest.js"></script>
<script src="js/cpn.js?anticache=<?php echo alea(16); ?>"></script>

<script>
	function gerarEscalaMesAtual(){
		var data = informationRequest("gerarEscalaMesAtual", {} );

		if(data.status == "OK"){
			alert("Operação efetuada com sucesso!");
		}
	}

	function gerarEscalaMesSeguinte(){
		var data = informationRequest("gerarEscalaMesSeguinte", {} );

		if(data.status == "OK"){
			alert("Operação efetuada com sucesso!");
		}
	}

	function carregarFuncionarios(){
		var data = informationRequest("carregarFuncionarios", {} );

		var inner = "";
		for (const funcionario of data) {
			$('#funcionarios').append(" <option value = '"+ funcionario.id +"'>"+ funcionario.nome +"</option> ");
		}
	}

	carregarFuncionarios();

	function consultarFuncionario(){
		var data = informationRequest("consultarFuncionario", {
			"idFuncionario": $('#funcionarios').find(":selected").val()
		});

		var turno = "";
		if(data.result.dados[0].turno == 0){ turno = "Manhã"; }
		if(data.result.dados[0].turno == 1){ turno = "Tarde"; }
		if(data.result.dados[0].turno == 2){ turno = "Noite"; }
		
		var ficha = `Numero matricula: `+ data.result.dados[0].numero_matricula +` <br>
					 Equipe: `+ data.result.dados[0].equipe +`<br>
					 Turno: `+ turno +`
		`;


		var diasQueVaiTrabalhar = "";
		for (const dados of data.result.escala) {
			diasQueVaiTrabalhar += dados.data + "<br>";
		}

		$("#consulta").html(ficha + "<br> -------------------- <br> " + diasQueVaiTrabalhar);
	}
</script>

<?php
	include("./mod/fim.php"); 
?>
