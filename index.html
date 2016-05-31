<html>
<head>
	<title>Conlang Translator</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css">
	<link rel="stylesheet" href="css/skeleton.css" type="text/css">
	<link rel="icon" href="css/favicon.ico">
	<meta charset="utf-8">
</head>
<body style="background-color:#330033;">
	<div id="header" class="greybox container" style="background-image:url('images/conlang.png'); background-size: 100% 100%; border-color:#D67A0A">
		<h1><b>Constructed Language Translator<b></h1><br><br><br><br><br><br><br><br>
		<h2 style="text-align:center;color:#ffad33;">Created by Marcus Alder</h2>
	</div>
	<br>
	
	<font face="courier">
	<div id="translator" class="greybox container">
		<h1>Translator</h1><br>
		<form method="POST" id="query">
			<textarea id="input" name="input" size="20" style="padding: 1px; width:100%; height:120px;" placeholder="Input Here"></textarea>
			<div class="row">
				<button accesskey=c id="c" onClick="addC()" type="button">&#265;</button>
				<button accesskey=g id="g" onClick="addG()" type="button">&#285;</button>
				<button accesskey=h id="h" onClick="addH()" type="button">&#293;</button>
				<button accesskey=j id="j" onClick="addJ()" type="button">&#309;</button>
				<button accesskey=s id="s" onClick="addS()" type="button">&#349;</button>
				<button accesskey=u id="u" onClick="addU()" type="button">&#364;</button>
				<select name="source" id="source" size="1">
					<option selected="selected">Detect Conlang</option>
					<option>English</option>
					<option>Esperanto</option>
					<option>Ido</option>
					<option>Interlingua</option>
					<option>Latin</option>
					<option>toki pona</option>
				</select>
				to
				<select name="target" id="target" size="1">
					<option>English</option>
					<option>Esperanto</option>
					<option>Ido</option>
					<option>Interlingua</option>
					<option>Latin</option>
					<option>toki pona</option>
				</select>
			</div>
		</form>
		<button class="button-primary" value="Submit" name="submit" id="submit" accesskey="p">Translate</button>
		<br>
		</font>
		<br>
		<div id="output"> <!-- style = "display:none;" -->
		</div>
		<a href="mchains.php">Switch to text generator</a>

		<script type="text/javascript">
			//Adding Esperanto-specific characters
			function addC()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u0109");}
			function addG()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u011D");}
			function addH()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u0125");}
			function addJ()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u0135");}
			function addS()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u015D");}
			function addU()
			{document.getElementById("input").value = (document.getElementById("input").value).concat("\u016D");}
			
			//Google Translate API usage
			function translateText(response)
			{
				document.getElementById("output").innerHTML = response.data.translations[0].translatedText;
			}
			function findLangCode(start)
			{
				if(start=="English")
					return "en";
				if(start=="Latin")
					return "la";
				return "eo";
			}
			function translateNat(sourceText)
			{
				var newScript = document.createElement('script');
				newScript.type = 'text/javascript';

				// var sourceText = escape(document.getElementById("input").value);															//Input
				sourceText = escape(sourceText);
				var base = 'https://www.googleapis.com/language/translate/v2' + '?key=AIzaSyBoAUVrS3pBR4o6ii0tWBhDhC0Lkakq-RA';				//API Key
				var start = findLangCode(document.getElementById('source').options[document.getElementById('source').selectedIndex].value);	//Starting lang
				var target = findLangCode(document.getElementById('target').options[document.getElementById('target').selectedIndex].value);//Target lang
				var source = base + '&source=' + start +'&target=' + target + '&callback=translateText&q=' + sourceText;					//Final string
				console.log(source);
				newScript.src = source;
				document.getElementsByTagName('head')[0].appendChild(newScript);
			}
		</script>
	</div>
	<br>
	<div class="greybox container">
	<h1>Learn More</h1>
	
	<div class="two columns">
		<p class="langname"><img src="images/esperanto.png" alt="Flag of Esperanto" class="langimg"><br>Esperanto</p>
		<a href="http://www.esperanto.net/veb/faq.html">Overview</a><br>
		<a href="http://en.lernu.net">Lessons</a><br>
		<a href="http://www.esperanto.net/info/index_en.html">Other Resources</a><br>
	</div>

	<div class="three columns">
	<p class="langname"><img src="images/tokipona.png" alt="Symbol of toki pona" class="langimg"><br>toki pona</p>
		<a href="http://tokipona.org/">Official Site</a><br>
		<a href="http://rowa.giso.de/languages/toki-pona/english/latex/index.html">Lessons</a><br>
		<a href="https://aiki.pbworks.com/f/TP+words.pdf">Word List</a><br>
		<a href="https://docs.google.com/spreadsheets/d/12gDr-zsUuwwCWPme9DlAE0JWuFDAFrqh3_IA257ff1U/edit#gid=0">Compound Word List</a><br>
		<a href="http://tokipona.net/tp/default.aspx">Other Resources</a><br>
	</div>

	<div class="two columns">
		<p class="langname"><img src="images/ido.png" alt="Flag of Ido" class="langimg"><br>Ido</p>
		<a href="https://en.wikibooks.org/wiki/Easy_Ido">Lessons</a><br>
		<a href="http://interlanguages.net/yindex.html">Resources 1</a><br>
		<a href="http://idolinguo.org.uk/">Resources 2</a>
	</div>

	<div class="two columns">
		<p class="langname"><img src="images/interlingua.png" alt="Flag of Interlingua" class="langimg"><br>Interlingua</p>
		<a href="http://www.interlingua.com/">Official Site</a><br>
		<a href="http://members.optus.net/~ado_hall/interlingua/gi/home/preface.html">Grammar</a>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	</div>
	<br>

	<div id="about" class="container greybox">
	<h1>About</h1>
		<p style="font-size:17px;">Translator instructions: choose a starting language, choose a target language, enter text and press submit to translate.<br><br>
		Permitted characters are the Latin Alphabet and the following special characters:<br> , . ; " ' &#293; &#285; &#309; &#265; &#364; &#349;<br><br>
		<div id="google_translate_element">Translate this page to another language:</div>
		<script type="text/javascript">
			function googleTranslateElementInit()
			{
				new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
			}
		</script><br>
		Made by Marcus Alder 2015/2016.
		</p>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	
	<script type="text/javascript">
		document.getElementById("input").focus();
		$(document).ready(function()
		{
			$("#submit").click(function()
			{
				$.post("algorithm.php", $("#query").serialize()).done(function(result)
				{
					$("#output").html(result);
					// document.getElementById("output").style="display:inline;";
				})
			})
		});
	</script>

</body>
</html>
