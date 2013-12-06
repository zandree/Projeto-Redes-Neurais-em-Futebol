<?php
function retira_acentos($texto)
{
$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
return str_replace($array1, $array2, $texto);
}

$arquivo = fopen("conteudo-jogo1.js", "w");

for($rodada=1;$rodada<=38;$rodada++)
{
	$url = 'http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/fases/fase-unica/rodada_'.$rodada.'_jogos.js';

	//echo $url."<BR><BR>";

	$dados = file_get_contents($url);
	$dados = utf8_encode($dados);
	$dados = retira_acentos($dados);
	$dados = strtolower($dados);
	$dados = str_replace("sao paulo", "sao-paulo", $dados);
	$dados = str_replace("ponte preta", "ponte-preta", $dados);
	$tam = strlen($dados);

	$inicio = strpos($dados,'{');

	$dados = substr($dados, $inicio, ($tam-$inicio-2));//substr($string, $start, $lenght)

	//echo "<p>".$dados."</p>";

	$dados = json_decode($dados, true);

	//$error = json_last_error();//Verifica erros no json_decode()
	//echo <p>Codigo do erro: ".$error."</p>";

	//echo $error;

	//Dados da rodada
	/*
	echo "<pre>";
	print_r($dados);
	echo "</pre>";
	*/

	//Converte a data do jogo em array ([0]=>ano, [1]=>mes, [2]=>dia)
	foreach($dados["jogos"] as $k => $v)
	{
		$dados["jogos"][$k]["datajogo"] = explode("-", $dados["jogos"][$k]["datajogo"]);
	}

	//Dados da rodada com data em array
	/*
	echo "<pre>";
	print_r($dados);
	echo "</pre>";
	*/

	//Construção dos links dos jogos
	/*
	var linkJogo = Estatisticas.statsURL+'/jogos/'
	+Estatisticas.Util.normalizeString(obj.jogos[i].time1)
	+'-x-'
	+Estatisticas.Util.normalizeString(obj.jogos[i].time2)
	+'-'+dataJogo[2]+'-'+dataJogo[1]+'.jhtm';
	*/

	$EstatisticasURL = "http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogos/";
	
		
		


	foreach($dados['jogos'] as $jogo => $v)
	{
		$time1 = utf8_decode($dados['jogos'][$jogo]['time1']);
		$time2 = utf8_decode($dados['jogos'][$jogo]['time2']);		
		$linkJogo = $EstatisticasURL.$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js";
		$codigoFonteLink = file_get_contents($linkJogo);
		
		if($rodada <= 9)
		{
		   $diretorio = ("backup/"."0".$rodada);
		}else
		{
			$diretorio = ("backup/".$rodada);
		}
		
		if(file_exists($diretorio))
		{
			echo "Arquivo existe";
			$tam = strlen($codigoFonteLink);

			$inicio = strpos($codigoFonteLink,'{');

			$codigoFonteLink = substr($codigoFonteLink, $inicio, ($tam-$inicio-2));//substr($string, $start, $lenght)

			$arquivo = fopen($diretorio."/".$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js",  "w");
			fwrite($arquivo, $codigoFonteLink."\n");
		}else{
			echo "Arquivo nao existe";
			mkdir($diretorio);
		}
		
		
		
		//$arquivo = fopen("backup//".$rodada."//".$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js", "w");
		//echo "<a href=\"".$linkJogo."\">".$linkJogo."</a>";
		echo $linkJogo."<br>";
	}

}

?>
