<?php
function retira_acentos($texto)
{
$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
return str_replace($array1, $array2, $texto);
}
//Link para voltar
echo "<a href=\"gerador.php\">Voltar</a>";

$rodadaFinal = $_POST['final'];

$n = $rodadaFinal+1;//da pra usar aqui???

$urlTodosJogos = 'backup/geraRodadas/rodada_'.$n.'_jogos.js';
$dadosTodosJogos = file_get_contents($urlTodosJogos);
$dadosTodosJogos = utf8_encode($dadosTodosJogos);
$dadosTodosJogos = retira_acentos($dadosTodosJogos);
$dadosTodosJogos = strtolower($dadosTodosJogos);
$dadosTodosJogos = str_replace(" ", "-", $dadosTodosJogos);
$dadosTodosJogos = json_decode($dadosTodosJogos, true);
echo "<pre>";
//print_r($dadosTodosJogos);
echo "</pre>";

$times = array();

foreach($dadosTodosJogos['jogos'] as $chave => $valor)
{
	if(!in_array($dadosTodosJogos['jogos'][$chave]['time1'], $times))
	{
		array_push($times, $dadosTodosJogos['jogos'][$chave]['time1']); 
	}
	if(!in_array($dadosTodosJogos['jogos'][$chave]['time2'], $times))
	{
		array_push($times, $dadosTodosJogos['jogos'][$chave]['time2']); 
	}
}

$vetorMediaEstatistica = array();
/*
echo "<pre>";
echo "<p>Array de times</p>";
print_r($times);
echo "</pre>";
*/

$vetorEstatisticas = $_POST['stats'];
$tam = count($vetorEstatisticas);

foreach($times as $k => $v)
{
	$vetorMediaEstatistica[$v] = array();
	foreach($vetorEstatisticas as $indice => $valor)
	{
		$vetorMediaEstatistica[$v] = array_flip($vetorEstatisticas);
	}
}

foreach($times as $k => $v)
{
	$vetorMediaEstatistica[$v] = array();
	foreach($vetorEstatisticas as $indice => $valor)
	{
		$vetorMediaEstatistica[$v][$valor] = 0;
	}
}

/*foreach($vetorMediaEstatistica as $k => $v)
{
	foreach($v as $k1 => $v1)
	{
		$v1 = 0;
	}
	//$vetorMediaEstatistica[$k][$v] = 0;
}*/


/*
echo "<pre>";
print_r($vetorEstatisticas);
echo "</pre>";

echo "<pre>";
print_r($vetorMediaEstatistica);
echo "</pre>";
*/

//geraArquivos.php
// --------------------------------------------------------------------------------------------------------------------------------------- //

// --------------------------------------------------- Gerando arquivo treinamento.data -------------------------------------------------- //

// --------------------------------------------------------------------------------------------------------------------------------------- //
$rodadaInicial = $_POST['inicio'];
$rodadaFinal = $_POST['final'];
$arquivo = fopen("testes_fann/treinamento.data", "w");
if($arquivo)
{
	//echo "<p>Abriu!</p>";
}

for($i=$rodadaInicial; $i <= $rodadaFinal; $i++)
{
	$diretorioListaJogosDaRodada = "./backup/geraRodadas/rodada_".$i."_jogos.js";
	$listaTodosOsJogosDaRodada = file_get_contents($diretorioListaJogosDaRodada); // copia o conteúdo do arquivo
	
	$listaTodosOsJogosDaRodada = utf8_encode($listaTodosOsJogosDaRodada);
	$listaTodosOsJogosDaRodada = retira_acentos($listaTodosOsJogosDaRodada);
	$listaTodosOsJogosDaRodada = strtolower($listaTodosOsJogosDaRodada); // tudo minúsculo
	$listaTodosOsJogosDaRodada = str_replace("sao paulo", "sao-paulo", $listaTodosOsJogosDaRodada); 
	$listaTodosOsJogosDaRodada = str_replace("ponte preta", "ponte-preta", $listaTodosOsJogosDaRodada);
	$tam = strlen($listaTodosOsJogosDaRodada); // tamanho do conteúdo
	
	$inicio = strpos($listaTodosOsJogosDaRodada,'{');
	$listaTodosOsJogosDaRodada = substr($listaTodosOsJogosDaRodada, $inicio, ($tam-$inicio));//substr($string, $start, $lenght)
	$listaTodosOsJogosDaRodada = json_decode($listaTodosOsJogosDaRodada, true);
	
	if($i <= 9)
	{
		$caminhoDoArquivoJogoParte1 = "backup/rodadas/0".$i; // ..01.02..
	}else
	{
		$caminhoDoArquivoJogoParte1  = "backup/rodadas/".$i; // 10, 11
	}
	
	$caminhoDoArquivoJogoParte2 = array();
	
	foreach($listaTodosOsJogosDaRodada['jogos'] as $chave => $valor) // Explosão da data
	{
		$time1 = $listaTodosOsJogosDaRodada['jogos'][$chave]['time1'];
		$time2 = $listaTodosOsJogosDaRodada['jogos'][$chave]['time2'];
		$listaTodosOsJogosDaRodada['jogos'][$chave]["datajogo"] = explode("-", $listaTodosOsJogosDaRodada["jogos"][$chave]["datajogo"]);
		$dataDia = $listaTodosOsJogosDaRodada['jogos'][$chave]['datajogo'][2];
		$dataMes = $listaTodosOsJogosDaRodada['jogos'][$chave]['datajogo'][1];
		$dataAno = $listaTodosOsJogosDaRodada['jogos'][$chave]['datajogo'][0];
		
		$caminhoDoArquivoJogoParte2[$chave] = $caminhoDoArquivoJogoParte1."/".$time1."-x-".$time2."-".$dataDia."-".$dataMes.".js";
		
		//echo $caminhoDoArquivoJogo."<BR><BR>";
	}
	/*
	echo "<pre>";
	  print_r($vetorEstatisticas);
	echo "</pre>";
	*/
	$contJogos= ($rodadaFinal-$rodadaInicial+1)*10;
	$contEstatisticas = count($vetorEstatisticas);
	
	//escreve a primeira linha do arquivo
	if($i==$rodadaInicial)
	{
		fwrite($arquivo, $contJogos." ".($contEstatisticas*2)." 3\n");
		
	}
	
	
	foreach($caminhoDoArquivoJogoParte2 as $chave => $valor)
	{
		
		//$contJogos++;
		$jogoStats = array();
		$jogoResult = array();
		// Jogo por jogo
		$dadosJogoAtual = file_get_contents($valor);
		$dadosJogoAtual = utf8_encode($dadosJogoAtual);
		$dadosJogoAtual = json_decode($dadosJogoAtual, true);
		//
		$time1 = retira_acentos($dadosJogoAtual['dados']['infoJogo']['nometime1']); // sem acento
		
		
		$time1 = strtolower($time1); // minúsculo
		$time1 = str_replace(" ", "-", $time1);
		
		$time2 = retira_acentos($dadosJogoAtual['dados']['infoJogo']['nometime2']); // sem acento
		$time2 = strtolower($time2); // minúsculo
		$time2 = str_replace(" ", "-", $time2);

		foreach($vetorEstatisticas as $chave => $valor)
		{
			array_push($jogoStats, $dadosJogoAtual['dados']['estatisticasJogo']['time1']['equipe'][$valor]/100);
			$vetorMediaEstatistica[$time1][$valor] += $dadosJogoAtual['dados']['estatisticasJogo']['time1']['equipe'][$valor];
			
		}
		
		foreach($vetorEstatisticas as $chave => $valor)
		{
			array_push($jogoStats, $dadosJogoAtual['dados']['estatisticasJogo']['time2']['equipe'][$valor]/100);
			$vetorMediaEstatistica[$time2][$valor] += $dadosJogoAtual['dados']['estatisticasJogo']['time2']['equipe'][$valor];
		}
		
		
		$gols1 = $dadosJogoAtual['dados']['estatisticasJogo']['time1']['equipe']['gols'];
		$gols2 = $dadosJogoAtual['dados']['estatisticasJogo']['time2']['equipe']['gols'];
		
		
		if($gols1 > $gols2)
		{
			$jogoResult = array(1, 0, 0);//vitória do time da casa
		}else if($gols1 < $gols2)
		{
			$jogoResult = array(0, 0, 1);//vitória do time visitante
		}else
		{
			$jogoResult = array(0, 1, 0);//empate
		}
		
		$textoStats = implode(" ", $jogoStats);
		$textoResult = implode(" ", $jogoResult);
		
		fwrite($arquivo, $textoStats."\n".$textoResult."\n");
		
		//echo $textoStats."\n".$textoResult."\n";
	}
	
	
} // rodadas

fclose($arquivo);
$contRodadas = $contJogos / 10;

/*
echo "<pre>";
print_r($vetorMediaEstatistica);
echo "</pre>";
*/

foreach($times as $k => $v)
{
	foreach($vetorEstatisticas as $indice => $valor)
	{
		$vetorMediaEstatistica[$v][$valor] /= $contRodadas;
		$vetorMediaEstatistica[$v][$valor] = round($vetorMediaEstatistica[$v][$valor], 4) / 100;
	}
}

// --------------------------------------------------------------------------------------------------------------------------------------- //

// ------------------------------------------------------ Gerando arquivo teste.data ----------------------------------------------------- //

// --------------------------------------------------------------------------------------------------------------------------------------- //
$arquivo = fopen("testes_fann/teste.data", "w");

$i = $rodadaFinal+1;
$diretorioListaJogosDaRodada = "./backup/geraRodadas/rodada_".$i."_jogos.js";
$listaTodosOsJogosDaRodada = file_get_contents($diretorioListaJogosDaRodada); // copia o conteúdo do arquivo

$listaTodosOsJogosDaRodada = utf8_encode($listaTodosOsJogosDaRodada);
$listaTodosOsJogosDaRodada = retira_acentos($listaTodosOsJogosDaRodada);
$listaTodosOsJogosDaRodada = strtolower($listaTodosOsJogosDaRodada); // tudo minúsculo
$listaTodosOsJogosDaRodada = str_replace("sao paulo", "sao-paulo", $listaTodosOsJogosDaRodada); 
$listaTodosOsJogosDaRodada = str_replace("ponte preta", "ponte-preta", $listaTodosOsJogosDaRodada);
$tam = strlen($listaTodosOsJogosDaRodada); // tamanho do conteúdo

$inicio = strpos($listaTodosOsJogosDaRodada,'{');
$listaTodosOsJogosDaRodada = substr($listaTodosOsJogosDaRodada, $inicio, ($tam-$inicio));//substr($string, $start, $lenght)
$listaTodosOsJogosDaRodada = json_decode($listaTodosOsJogosDaRodada, true);

foreach($listaTodosOsJogosDaRodada['jogos'] as $chave => $valor)
{
	$time1 = $valor['time1'];
	$time2 = $valor['time2'];
	$gols1 = $valor['gol1'];
	$gols2 = $valor['gol2'];
	$textoStats1 =  implode(" ", $vetorMediaEstatistica[$time1]);
	$textoStats2 =  implode(" ", $vetorMediaEstatistica[$time2]);
	$jogoResult = $textoStats1." ".$textoStats2." ";
	
	if($gols1 > $gols2)
	{
		$jogoResult .= implode(" ", array(1, 0, 0));
	}else if($gols1 < $gols2)
	{
		$jogoResult .= implode(" ", array(0, 0, 1));
	}else
	{
		$jogoResult .= implode(" ", array(0, 1, 0));
	}
	fwrite($arquivo, "\n".$jogoResult);
}

fclose($arquivo);

//Imprime o arquivo treinamento.data na tela
echo "<pre>";
echo "<p>treinamento.data</p>";
include("testes_fann/treinamento.data");
echo "<br><br><p>teste.data</p>";
include("testes_fann/teste.data");
echo "</pre>";



/*
echo "<pre>";
echo "<p>Array listaTodosOsJogosDaRodada</p>";
print_r($listaTodosOsJogosDaRodada);
echo "</pre>";

echo "<pre>";
echo "<p>Array VetorMediaEstatistica</p>";
print_r($vetorMediaEstatistica);
echo "</pre>";

*/

//Teste para verificar permissoes de escrita
/*
$arquivoTemporario = fopen('temp.csv', 'w');
if($arquivoTemporario)
{
	echo "<p>Abre arquivo</p>";
}

echo "<p>Escreve no arquivo</p>";
fwrite($arquivoTemporario, "teste de escrita\ncococo\ncocoocco\n");

echo "<p>Fecha arquivo</p>";
fclose($arquivoTemporario);
*/
echo "<a href=\"gerador.php\">Voltar</a>";
?>
