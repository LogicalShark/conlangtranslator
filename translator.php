<html>
<head>
	<title>Conlang Translator</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="translatorstyle.css" type="text/css">
	<script>
	function translateText(response) 
	{
		document.getElementById("output").innerHTML = response.data.translations[0].translatedText;
  	}
	</script>
</head>
<!-- <body background="conlang.png"> -->
<body style="background-color:#91008c;">
	<div id="header" class="greybox">
	<h1 style="font-family: sans-serif; font-size: 40px;"><b>Constructed Language Resource Page<b></h1>
	<h2 style="font-size: 18px; text-indent: 10px;">Created by Marcus Alder</h2>
	</div>
	<font face="courier">
	<div id="translator" class="greybox">
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

		<select name="source" id="source" size="1">
		  <option selected="selected">toki pona</option>
		  <option>English</option>
		  <option>Esperanto</option>
		  <option>Ido</option>
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
		  	var newScript = document.createElement('script');
			newScript.type = 'text/javascript';
			var sourceText = escape(document.getElementById("message").innerHTML);
			var source = 'https://www.googleapis.com/language/translate/v2?key=YOUR-API-KEY&source=eo&target=en&callback=translateText&q=' + sourceText;
			newScript.src = source;
			document.getElementsByTagName('head')[0].appendChild(newScript);
		</script>
		<input type="submit" value="Submit" name="submit" id="submit" accesskey="p">
		<br>
		</font>
		<br>
		<div id="output">
		</div>
	</div>
	
	<div id="about" class="greybox">
	<h1>About</h1>
		Translator instructions: choose a starting language, choose a target language, enter text, and press submit to translate.<br>
		Permitted characters are the Latin Alphabet as well as<br> , . ; " ' \n ĥ ĝ ĵ ĉ ŭ ŝ<br>Currently available translations: simple toki pona to Esperanto, Ido to Esperanto.<br><br>
		Made by Marcus Alder, 2015-2016.<br><br>
		Translate Page:<br>
		
		<div id="google_translate_element"></div>
		<script type="text/javascript">
			function googleTranslateElementInit() 
			{
				new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
			}
		</script>

	</div>
	
	<div id="info" class="greybox grow">
		<h1>Information</h1>
		<br><br>
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
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#submit").click(function()
			{
			    $.post("algorithm.php", $("#query").serialize()).done(function(result)
			    { 
			    	$("#output").html(result.substring(10));
			    })
			})
		});
	</script>

</body>
</html>
