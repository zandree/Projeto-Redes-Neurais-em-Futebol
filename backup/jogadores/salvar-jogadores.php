<?php
function retira_acentos($texto)
{
$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
return str_replace($array1, $array2, $texto);
}

//http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogadores/abuda-11327/estatisticas.js
// http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogadores/lista-jogadores.js
$urlTodosJogadores = 'http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogadores/lista-jogadores.js';
$urlJogadorUnico = 'http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogadores/';
$dadosTodosJogadores = file_get_contents($urlTodosJogadores);
//$dadosTodosJogadores = utf8_encode($dadosTodosJogadores);
$dadosTodosJogadores = retira_acentos($dadosTodosJogadores);
$dadosTodosJogadores = strtolower($dadosTodosJogadores);
$dadosTodosJogadores = str_replace(" ", "-", $dadosTodosJogadores);
$dadosTodosJogadores = json_decode($dadosTodosJogadores, true);
/*echo "<pre>";
print_r($dadosTodosJogadores);
echo "</pre>";
*/
$times = array();

foreach($dadosTodosJogadores as $chave => $valor)
{
	if(!in_array($dadosTodosJogadores[$chave]['time'], $times))
	{
		array_push($times, $dadosTodosJogadores[$chave]['time']); 
	}
}
/*
echo "<pre>";
print_r($times);
echo "</pre>";
*/

/*
foreach($times as $chave => $valor)
{
	$diretorio = "/backup/jogadores/";
	echo $valor."<BR>";
	mkdir("/vasco");
	if(!file_exists($diretorio))
	{
		mkdir("/".$valor);
	}
	
}
*/
$cont = 0;
foreach($dadosTodosJogadores as $chave => $valor)
{
	
	$nome = $dadosTodosJogadores[$chave]['nome'];
	$idJogador = $dadosTodosJogadores[$chave]['id'];
	
	$urlJogador = $urlJogadorUnico.$nome."-".$idJogador."/estatisticas.js";
	//echo $urlJogador."<BR><BR>";
	
	$dadosJogador = file_get_contents($urlJogador);
	$tamanho = strlen($dadosJogador);
	$inicio = strpos($dadosJogador, '{');
	$dadosJogador = substr($dadosJogador, $inicio, ($tamanho-$inicio-2));//substr($string, $start, $lenght)
	
	//$dadosJogador = json_decode($dadosJogador, true);
	$diretorio = strtolower($dadosTodosJogadores['dados']['estatisticas']['clube']);
	if($cont == 0)
	{
	  $arquivo = fopen($diretorio."/".$nome."-".$idJogador.".js", "w");
	  fwrite($arquivo, $dadosJogador);
	  fclose($arquivo);
    }
    $cont++;
  
}
?>
