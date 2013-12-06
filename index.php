<html>
<head></head>
<body>
<?php
//$url = file_get_contents("http://esporte.uol.com.br/futebol/campeonatos/brasileiro/2012/serie-a/estatisticas/jogos/botafogo-x-sao-paulo-20-05.jhtm");
echo "<p>Abre arquivo</p>";
$arquivoTemporario = fopen('temp.csv', 'w');

echo "<p>Escreve no arquivo</p>";
fwrite($arquivoTemporario, "teste de escrita");

echo "<p>Fecha arquivo</p>";
fclose($arquivoTemporario);

$pwd = getcwd();
echo $pwd;
?>


// W




</body>
</html>
