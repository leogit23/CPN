<?php
    /*function unitTest($body){
        echo $body->value2->nested;
        exit;
    }*/

    /**
     *
     * 
     * 
     *  REQUESTS
     * 
     * 
     * 
    */

    function gerarEscalaMesAtual($body){
        gerarEscala( array(4, 3, 2, 1) , "04", "April");

        echo '{ "status": "OK" }';

        exit;
    }

    function gerarEscalaMesSeguinte($body){
        $ultimosATrabalhar = select("escala", array("id_funcionario"), "ORDER BY id DESC LIMIT 0, 2");

        $funcionarios = select("funcionarios", array("id"), "");

        $quemVaiAbrirOMes = array_values ( array_diff($funcionarios, $ultimosATrabalhar) ) ;
        $quemVaiFolgarNaAbertura = array_values ( array_diff($funcionarios, $quemVaiAbrirOMes ) ) ;

        $ordemFuncionarios = array();
        array_push($ordemFuncionarios, $quemVaiAbrirOMes[0]);
        array_push($ordemFuncionarios, $quemVaiAbrirOMes[1]);
        array_push($ordemFuncionarios, $quemVaiFolgarNaAbertura[0]);
        array_push($ordemFuncionarios, $quemVaiFolgarNaAbertura[1]);

        gerarEscala($ordemFuncionarios, "05", "May");

        echo '{ "status": "OK" }';

        exit;
    }

    function carregarFuncionarios($body){
        conectar();

        $funcionarios = queryBy("funcionarios", array("id", "nome"), "");
		
		$outputFuncionarios = array();
		foreach ( $funcionarios AS $funcionario ) {
			array_push($outputFuncionarios, array( 
                "id" 	=> 	$funcionario["id"],
                "nome" 	=> 	$funcionario["nome"],
			));
		}

        echo json_encode($outputFuncionarios);
    }

    function consultarFuncionario($body){
        conectar();

        $dados = queryBy("funcionarios", array("numero_matricula", "equipe", "turno"), "WHERE id = '". $body->idFuncionario ."'");
        $escala = queryBy("escala", array("data"), "WHERE id_funcionario = '". $body->idFuncionario ."'");

        $jayParsedAry = [
			"result" => [
				 "dados" => $dados,
                 "escala" => $escala
			] 
		];

        echo json_encode($jayParsedAry);
		exit;
    }

    /**
     *
     * 
     * 
     *  MÉTODOS
     * 
     * 
     * 
    */


    function gerarEscala($ordemFuncionarios, $mesNumerico, $mesIngles){
		conectar();

		$dataAtual = date('2023-'. $mesNumerico .'-01', time());
		$checarMes = date("F", strtotime($dataAtual));

		$escalaAtual = 0;

		while($checarMes == $mesIngles){
			$somaData = strtotime("1 day", strtotime($dataAtual));
			$dataSomada = date("Y-m-d", $somaData);

			insert("escala", array("data", "id_funcionario", "mes"), array($dataAtual, $ordemFuncionarios[$escalaAtual], $mesNumerico) );
			insert("escala", array("data", "id_funcionario", "mes"), array($dataAtual, $ordemFuncionarios[$escalaAtual + 1], $mesNumerico) );

			$dataAtual = $dataSomada;
			$checarMes = date("F", strtotime($dataAtual));

			if($escalaAtual == 0){ $escalaAtual = 2; }
			else { $escalaAtual = 0; }
		}

	}
?>