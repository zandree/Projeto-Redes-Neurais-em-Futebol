<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Gerador de arquivos para FANN</title>
	<style>
	h1{
		text-align: center;
	}
	div#colunas{
		-webkit-column-count: 5;
		-moz-column-count: 5;
	}
	</style>
</head>
<body>
<?php
	//URL de um jogo isolado
	$pwd = getcwd();
	$url = $pwd.'/backup/rodadas/01/botafogo-x-sao-paulo-20-05.js';

	//Pega os dados do jogo e converte para UTF-8
	$dados = file_get_contents($url);
	$dados = utf8_encode($dados);

	//Retira as informações desnecessarias
	$tam = strlen($dados);
	$inicio = strpos($dados,'{');
	$dados = substr($dados, $inicio, ($tam-$inicio));//substr($string, $start, $lenght)

	//echo "<p>".$dados."</p>";

	//Transforma a string em array
	$dados = json_decode($dados, true);
	/*echo "<pre>";
	print_r($dados);
	echo "</pre>";
	
	echo json_last_error();
	*/
?>
<h1>Gerador de arquivos de treinamento e teste para FANN</h1>
<p>Esse código vai gerar dois arquivos: um de treinamento, e um arquivo de testes. O arquivo de treinamento contém todas as estatísticas de todos os jogos entre a rodada de início e a rodada final escolhidas [entrada], e contém o resultado da partida [saída] no seguinte formato:</p>
<ul>
	<li>1 0 0 - Vitória do time da casa</li>
	<li>0 1 0 - Empate</li>
	<li>0 0 1 - Vitória do time visitante</li>
</ul>

<p>Formato do arquivo de treinamento: <em>The first line consists of three numbers: The first is the number of training pairs in the file, the second is the number of inputs and the third is the number of outputs.  The rest of the file is the actual training data, consisting of one line with inputs, one with outputs etc.</em></p>

<p> O arquivo de testes contém as médias das estatísticas de cada time entre a rodada de início e a rodada final escolhidas. Não é a média do campeonato inteiro. As médias dos times no arquivo de testes deve estar na ordem dos jogos da rodada posterior a rodada final.</p> 

<form action="geraArquivos-06-12.php" method="POST">
	<fieldset>
	<legend>Rodadas</legend>
	<p>Rodada de início: 
		<select name="inicio">
			<?php
			for($i=1;$i<=38;$i++)
			{
				echo "<option value=\"".$i."\">".$i."</option>";
			}
			?>
		</select>
	</p>
	 
	<p>Rodada final: 
		<select name="final">
			<?php
			for($i=1;$i<=38;$i++)
			{
				echo "<option value=\"".$i."\">".$i."</option>";
			}
			?>
		</select>
	</p>
	</fieldset>
	<fieldset>
	<legend>Estatísticas</legend>
	<div id="colunas">
	<?php
	foreach($dados['dados']['estatisticasJogo']['time1']['equipe'] as $k => $v)
	{
		echo "<p><input type=\"checkbox\" name=\"stats[]\" value=\"".$k."\"> ".$k."</p>";
	}
	?>
	</div>
	</fieldset>
	<fieldset>
		<legend>Finalizar</legend>
		<input type="submit" value="Gerar arquivos">
		<input type="reset" value="Limpar">
	</fieldset>
		
</form>

</body>
</html>
