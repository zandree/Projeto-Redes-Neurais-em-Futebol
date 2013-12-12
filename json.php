<?php
function retira_acentos($texto)
{
$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
return str_replace($array1, $array2, $texto);
}

//Testes de escrita
//$arquivo = fopen("conteudo-jogo1.js", "w");
//$diretorio = "andre/01/rodada";
//mkdir($diretorio, 0777, true);

$ano = $_GET['ano'];

for($rodada=1;$rodada<=38;$rodada++)
{
	$url = 'http://esporte.uol.com.br/futebol/campeonatos/brasileiro/'.$ano.'/serie-a/estatisticas/fases/fase-unica/rodada_'.$rodada.'_jogos.js';

	echo $url."<BR><BR>";

	$dados = file_get_contents($url);
	$dados = utf8_encode($dados);
	$dados = retira_acentos($dados);
	$dados = strtolower($dados);
	$dados = str_replace("sao paulo", "sao-paulo", $dados);
	$dados = str_replace("ponte preta", "ponte-preta", $dados);
	$dados = str_replace("gremio prudente", "gremio-prudente", $dados);
	$tam = strlen($dados);

	$inicio = strpos($dados,'({');

	$dados = substr($dados, $inicio+1, ($tam-$inicio-4));//substr($string, $start, $lenght)
	
	//Salvando os arquivos JSON com as rodadas (geraRodadas)
	$nomeArquivo = "rodada_".$rodada."_jogos.js";
	$diretorio = "backup/geraRodadas-".$ano;
	mkdir($diretorio, 0777, true);
	$arquivo = fopen($diretorio."/".$nomeArquivo, "w");
	fwrite($arquivo, $dados);
	fclose($arquivo);

	//echo "<p>".$dados."</p>";
	
	//Converte JSON para array do PHP
	$dados = json_decode($dados, true);

	$error = json_last_error();//Verifica erros no json_decode()
	//echo "<p>Codigo do erro: ".$error."</p>";

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

	$EstatisticasURL = "http://esporte.uol.com.br/futebol/campeonatos/brasileiro/".$ano."/serie-a/estatisticas/jogos/";
	
	//Comentar o foreach abaixo para executar somente para salvar os geraRodadas
	

	foreach($dados['jogos'] as $jogo => $v)
	{
		$time1 = utf8_decode($dados['jogos'][$jogo]['time1']);
		$time2 = utf8_decode($dados['jogos'][$jogo]['time2']);		
		$linkJogo = $EstatisticasURL.$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js";
		$codigoFonteLink = file_get_contents($linkJogo);
		
		if($rodada <= 9)
		{
			$diretorio = ("backup/".$ano."/"."0".$rodada);
		}else
		{
			$diretorio = ("backup/".$ano."/".$rodada);
		}
		
		if(!file_exists($diretorio))
		{
			echo "Arquivo nao existe!"."<br>";
			mkdir($diretorio, 0777, true);
			echo "Diretorio: ".$diretorio."<br>";			
		}
		//echo "Arquivo existe!";
		$tam = strlen($codigoFonteLink);

		$inicio = strpos($codigoFonteLink,'({');

		$codigoFonteLink = substr($codigoFonteLink, $inicio+1, ($tam-$inicio-4));//substr($string, $start, $lenght)

		$arquivo = fopen($diretorio."/".$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js",  "w");
		fwrite($arquivo, $codigoFonteLink."\n");
		fclose($arquivo);
		
		
		
		
		//$arquivo = fopen("backup//".$rodada."//".$time1."-x-".$time2."-".$dados['jogos'][$jogo]['datajogo'][2]."-".$dados['jogos'][$jogo]['datajogo'][1].".js", "w");
		//echo "<a href=\"".$linkJogo."\">".$linkJogo."</a>";
		//echo $linkJogo."<br>";
	}
	

}

?>
