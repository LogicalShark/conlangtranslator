<html>
<head>
	<title>Conlang Translator</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<style>
	body {
		background-size: cover;
	}
	h1 {
		text-align: center;
		text-decoration: underline;
		font-family: sans-serif;
	}
	h2 {
		font-family: sans-serif;
	}

	a {
		color:#660066;}
	a:hover {
		color:#903390;}
	a:visited {
		color:#3D003D;}
	
	div {
		box-shadow: 10px 10px;
		max-width: 400px;
		padding: 15px;
		border: 10px solid gray;
		border-radius: 10px;
		margin: 15px;
		background-color: #CCCCCC;
		-webkit-transition: width 2s, height 2s, -webkit-transform 2s;
		transition: width 2s, height 2s, transform 2s;
	}
	
	#info {
		box-shadow: 0px 0px;
		max-width: 400px;
		margin: 10px;
		position: fixed;
		right: 0;
		top: 0;
	}

	#header {
		max-width: 600px;
		padding: 8px;
		border: 5px solid gray;
		border-radius: 5px;
		margin: 10px;
	}

	#message {padding: 1px;}

	#output {
		max-width: 350px;
		padding: 1px;
		border: 3px solid gray;
		border-radius: 1px;
		margin: 3px;
		-webkit-transition: width 2s, height 2s, -webkit-transform 2s;
		transition: width 2s, height 2s, transform 2s;	
	}

	.langname {	font-size: 20px; }
	.langimg { width: 60px; height: 50px; padding: 1px;}
	</style>
</head>
<body background="conlang.png">
	<div id="header">
	<h1 style="font-family: sans-serif; font-size: 40px;"><b>Constructed Language Resource Page<b></h1>
	<h2 style="font-size: 18px; text-indent: 10px;">Created by Marcus Alder</h2>
	</div>
	<font face="courier">
	<div id="translator">
		<h1>Translator</h1><br>
		<form method="POST" id="query">		
		<textarea rows="5" cols="40" id="message" name="message" size="20" style="padding: 1px;">Input here</textarea>
		<br>

		<button accesskey=c id="c" onClick="addC()" type="button">ĉ</button>
		<button accesskey=g id="g" onClick="addG()" type="button">ĝ</button>
		<button accesskey=h id="h" onClick="addH()" type="button">ĥ</button>
		<button accesskey=j id="j" onClick="addJ()" type="button">ĵ</button>
		<button accesskey=s id="s" onClick="addS()" type="button">ŝ</button>
		<button accesskey=u id="u" onClick="addU()" type="button">ŭ</button>		
		<br><br>

		<select name="starter" id="starter" size="1">
		  <option>toki pona</option>
		  <option>English</option>
		  <option>Esperanto</option>
		  <option selected="selected">Ido</option>
		  <option>Interlingua</option>
		</select>
		<br>to<br>
		<select name="target" id="target" size="1">
		  <option>toki pona</option>
		  <option>English</option>
		  <option selected="selected">Esperanto</option>
		  <option>Ido</option>
		  <option>Interlingua</option>
		</select>
		</form>
		<script type="text/javascript">
			//Adding Esperanto-specific characters
			function addH()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ĥ");}
			function addG()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ĝ");}
			function addJ()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ĵ");}
			function addC()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ĉ");}
			function addU()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ŭ");}
			function addS()
			{document.getElementById("message").value = (document.getElementById("message").value).concat("ŝ");}
		</script>
		<input type="submit" value="Submit" name="submit" id="submit">
		<br>
		</font>
		<span id="output">
		</span>
	</div>
	<div>
	<h1>About</h1>
		Translator instructions: choose a starting language, choose a target language, enter text, and press submit to translate.<br>
		Permitted characters are the Latin Alphabet as well as<br> , . ; " ' \n ĥ ĝ ĵ ĉ ŭ ŝ<br><br>
		Made by Marcus Alder, 2015-2016.
	</div>
	<div id="info">
		<p class="langname"><img src="esperanto.png" alt="Flag of Esperanto" class="langimg">Esperanto</p>
		<a href="http://www.esperanto.net/veb/faq.html">Overview</a><br>
		<a href="http://en.lernu.net">Lessons</a><br>
		<a href="http://www.esperanto.net/info/index_en.html">Other Resources</a><br><br>

		<p class="langname"><img src="tokipona.png" alt="Symbol of toki pona" class="langimg">toki pona</p>
		<a href="http://tokipona.org/">Official Site</a><br>
		<a href="http://rowa.giso.de/languages/toki-pona/english/latex/index.html">Lessons</a><br>
		<a href="https://aiki.pbworks.com/f/TP+words.pdf">Word List</a><br>
		<a href="https://docs.google.com/spreadsheets/d/12gDr-zsUuwwCWPme9DlAE0JWuFDAFrqh3_IA257ff1U/edit#gid=0">Compound Word List</a><br>
		<a href="http://tokipona.net/tp/default.aspx">Other Resources</a><br><br>

		<p class="langname"><img src="ido.png" alt="Flag of Ido" class="langimg">Ido</p>
		<a href="https://en.wikibooks.org/wiki/Easy_Ido">Lessons</a><br>
		<a href="http://interlanguages.net/yindex.html">Resources 1</a><br>
		<a href="http://idolinguo.org.uk/">Resources 2</a><br>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#submit").click(function()
			{
			    $.post("algorithm.php", $("#query").serialize()).done(function(result)
			    {
			        $("#output").html(result);
			    })
			})
		});
	</script>

</body>
</html>
