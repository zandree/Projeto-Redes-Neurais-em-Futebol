{
	classe = (menuUOL[i+1].match(/^1-/)) ? "item" : "sub"; // seta itens e subitens
	if (!menuUOL[i].match(/redir=http/)) menuUOL[i] = menuUOL[i].replace(/redir=/,"redir=http://"); // poe http no redir de clicklogger
	document.write("<li><a class="+classe+" href='http://click.uol.com.br/?rf=pagina404-menu&u=http://"+menuUOL[i]+"'>" + menuUOL[i+1].replace(/^1-/,'') + "</a></li>");	// poe http nos links
}
</script>

<script type="text/javascript" src="http://barra.uol.com.br/b/scripts/1024/bv1.js?refbusca=erro404"></script>

<style type="text/css">
body {background:#f4f3ef; margin:0}
a {text-decoration:none}
a:hover {text-decoration:underline}
img {border:0}
.bgbarrauol {background:#363636; border-bottom: 1px solid #5C5C5C; height:30px}
.barrauol {width:988px; margin-left:auto; margin-right:auto}

#centraliza {background:#fff; width:990px; margin-left:auto; margin-right:auto; }

#logouol {text-align:center; padding:40px 0 30px}
#mensagem h1 {font: bold 30px arial; text-align:center; margin:0}
#mensagem h2 {font: normal 16px arial; text-align:center; margin-top:5px}
#busca {padding-top:10px}
#busca .uolbusca {margin:10px 10px 10px 0; vertical-align:middle;}

#submitbutton button, #submitbutton input[type="submit"] {
    background: url("http://r.i.uol.com.br/d/btn-home.jpg") repeat scroll 0 0 #8BC53D;
    border-color: #C1D4A7 #A0BB78 #C2D5A8 #9BBC65;
    border-width: 1px;
    color: #FFFFFF;
    font-size: 17px;
    font-weight: bold;
    height: 33px;
    line-height: 1.3em;
    margin: 0 0 0 16px;
    padding: 0 18px;
    text-shadow: 1px 1px 2px #999999;
    vertical-align: inherit;
}

#q {
    border: 2px solid #A9CB39;
    font-size: 16px;
    font-weight: bold;
    line-height: 1.2em;
    padding: 4px 0 5px 5px;
    width: 300px;
}

#conteudo {margin-bottom:20px; float:left; padding-left:30px; font-family:arial}
#conteudo .linha {width:930px; height:1px; background:#ccc; margin-bottom:15px}

#conteudo h2 {font:normal 26px arial; margin-bottom:5px; margin-top:0; padding-top:20px}
#conteudo h2, #conteudo .coluna.first {margin-left:6px}
#conteudo .coluna {float:left; width:229px}
#conteudo .coluna ul {padding:0; margin:0; list-style-type:none}
#conteudo .coluna ul li {height:20px}
#conteudo .coluna ul li a {font:normal 13px arial}
#conteudo .coluna ul li a.item {color:#000; background: url("http://n.i.uol.com.br/modulos/bullet-red.gif") no-repeat scroll 5px 3px; padding-left:20px}
#conteudo .coluna ul li a.sub {color:#666; padding-left:20px}

#mixed #noticias, #mixed #esporte, #mixed #entretenimento {width:310px; float:left}
#mixed ul {list-style-type:none; padding:0; margin:0 0 0 9px}
#mixed li {margin-bottom:20px; clear:left}
#mixed li .imagem {width:142px; float:left; margin-bottom:20px}
#mixed li .texto {width:135px; height:90px; float:left; padding:10px 5px 0 10px; margin-bottom:20px;}
#mixed li .noimg {padding-right:10px;}
#mixed #noticias li .texto {background: #f3f4ef}
#mixed #esporte li .texto {background: #f7f8f2}
#mixed li img {width:142px; height:100px}
#mixed li a {color:black; font-size:12px}
#mixed li span {font:bold 12px arial; height:5px; display:block}

#mixed #noticias li span {color:#c70100}
#mixed #esporte li span {color:#9fb435}
#mixed #entretenimento li span {color:#fa8714}

#mixed #noticias h2, #mixed #esporte h2, #mixed #entretenimento h2 {padding-top:0; margin-bottom:15px}

#mixed #noticias h2 a {color:#c70100}
#mixed #esporte h2 a {color:#9fb435}
#mixed #entretenimento h2 a {color:#fa8714}

#rodape {width:990px; margin-left:auto; margin-right:auto;  text-align:center; font:normal 11px arial}
#copyright {width:990px; margin-bottom:5px}
#uol-host {width:990px }
#uol-host a {color:#000}
</style>

<script type="text/javascript">
function refreshList(){
	var ul = document.getElementById('indice-listas');
	while (ul.firstChild){
		ul.removeChild(ul.firstChild)
	}
	for(var i=0, index; index = indice[i]; i++){
		var li = document.createElement('li');
		var liul = document.createElement('ul');
		for(var j=0, station; station = index[j]; j++){
			var data = station.split('|')
			var innerLi = document.createElement('li');
			var link = document.createElement('a');
			var text = document.createTextNode(data[1]);
			if( data[0].match(/http(s?)\:\/\//) ){
						link.href = data[0];
			} else {
						link.href = 'http://indice.uol.com.br/' + data[0];
			}
			link.appendChild(text);
			innerLi.appendChild(link);
			liul.appendChild(innerLi)
		}
		li.appendChild(liul)
		ul.appendChild(li)
	}
}
</script>
</head>
	
<body>

	<div class="bgbarrauol">
		<div class="barrauol"><script type="text/javascript">writeUOLBar();</script></div>
	</div>

	<div id="centraliza">

		<div id="logouol"><a href="http://click.uol.com.br/?rf=pagina404-conteudo&u=http://www.uol.com.br/"><img src="http://imguol.com/c/noticias/logouol404.png" alt="UOL - O melhor conte�do" /></a></div>
		
		<div id="mensagem">
			<h1>404 - Desculpe, p�gina n�o encontrada</h1>
			<h2>A p�gina que voc� procura n�o existe nos servidores do UOL</h2>
		</div>
		
		<div id="busca" style="text-align:center">

			<form id="simples" name="simples" action="http://busca.uol.com.br/uol/" style="position:relative">
				<img src="http://r.i.uol.com.br/c/com_google.gif" id="comgoogle" alt="com google" style="position:absolute; top:45px; left:721px" />
				<label for="squery"><a href="http://busca.uol.com.br/"><img src="http://imguol.com/c/noticias/logouolbusca.png" class="uolbusca" alt="UOL Busca" /></a></label>
					<input id="q" type="text" id="squery" name="q" size="40" value="" />
					<input type="hidden" name="ref" value="erro" />
					<input type="hidden" name="ie" value="iso" />
					<div id="submitbutton" style="display:inline"><input type="submit" value="Buscar" /></div>
			</form>
    	
			<script type="text/javascript">
			var sSearch = location.search;
			if (sSearch.match(/\?url\=/)) {document.locbar.locurl.value=location.search.substring(5,location.search.length)}
			else if (sSearch.match(/\?q\=/)) {document.simples.q.value=unescape(location.search.substring(3,location.search.length))}
			</script>

		</div>


		<div id="conteudo">

			<div id="mixed">
			
				<h2>�ltimas Not�cias</h2>
				<div class="linha"></div>
				
				<div id="noticias">
					<h2><a href="http://click.uol.com.br/?rf=pagina404-conteudo&u=http://noticias.uol.com.br/">Not�cias</a></h2>
					<ul>
						<script>document.write(noticias404);</script>
					</ul>
				</div>
      	
      	
				<div id="esporte">
					<h2><a href="http://click.uol.com.br/?rf=pagina404-conteudo&u=http://esporte.uol.com.br/">Esporte</a></h2>
					<ul>
						<script>document.write(esporte404);</script>
					</ul>
				</div>
      	
      	
				<div id="entretenimento">
					<h2><a href="http://click.uol.com.br/?rf=pagina404-conteudo&u=http://entretenimento.uol.com.br/">Entretenimento</a></h2>
					<ul>
						<script>document.write(entretenimento404);</script>
					</ul>
				</div>
			
			</div>



			<br clear="all" />
			
			<h2>Continue navegando no UOL</h2>
			<div class="linha"></div>
		
			<div class="coluna first"><ul>
			<script language="JavaScript" type="text/javascript">for (i=0;i<col-1;i+=2) lista();</script>
			</ul></div>
			
			<div class="coluna"><ul>
			<script language="JavaScript" type="text/javascript">for (i=col;i<col*2-1;i+=2) lista();</script>
			</ul></div>
			
			<div class="coluna"><ul>
			<script language="JavaScript" type="text/javascript">for (i=col*2;i<col*3-1;i+=2) lista();</script>
			</ul></div>
			
			<div class="coluna"><ul>
			<script language="JavaScript" type="text/javascript">for (i=col*3;i<menuUOL.length;i+=2) lista();</script>
			</ul></div>

		</div><br clear="all" />
		
	</div>

	<div class="bgbarrauol">
		<div class="barrauol"><script type="text/javascript">writeUOLBar();</script></div>
	</div>

        <div id="rodape">
        	<script type="text/javascript">writeCopyright();</script>
        	<div id="uol-host"><a href="http://clicklogger.rm.uol.com.br/?prd=16&grp=src:13;chn:103;creative:hospedagem&msr=Cliques%20de%20Origem:1&oper=7&redir=http://www.uolhost.com.br/hospedagem-de-sites.html" target="_blank">Hospedagem:</a> <a href="http://clicklogger.rm.uol.com.br/?prd=16&grp=src:13;chn:103;creative:uolhost&msr=Cliques%20de%20Origem:1&oper=7&redir=http://www.uolhost.com.br/" target="_blank">UOL Host</a></div>
        </div>

<!-- SiteCatalyst code version: H.19.3. Copyright 1997-2009 Omniture, Inc. More info available at http://www.omniture.com -->
<script language="JavaScript" type="text/javascript" src="http://me.jsuol.com/omtr/paginadeerro.js"></script>
<script language="JavaScript" type="text/javascript"><!--
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=uol_sc.t();if(s_code)document.write(s_code)//--></script>
<!-- End SiteCatalyst code version: H.19.3. -->

</body>
</html>
