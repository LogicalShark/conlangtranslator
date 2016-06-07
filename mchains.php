<html>
<head>
	<title>Conlang Text Generator</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css">
	<link rel="stylesheet" href="css/skeleton.css" type="text/css">
	<link rel="icon" href="css/favicon.ico">
	<meta charset="utf-8">
	<?php
	require 'markov.php';

	if (isset($_POST['submit']))
	{
		$order  = $_REQUEST['order'];
		$length = $_REQUEST['length'];
		$input  = $_REQUEST['input'];
		$first = $_REQUEST['first'];
		$text = $_REQUEST['text'];
		if(isset($input))
		{
			$markov_table = createTable($input, $order, $text);
			$markov = createText($first, $length, $markov_table, $order, $text);
			if (get_magic_quotes_gpc())
				$markov = stripslashes($markov);
		}
	}
	?>
</head>
<body style="background-color:#330033;">
	
	<div id="header" class="greybox container" style="background-image:url('images/conlang.png'); background-size: 100% 100%; border-color:#D67A0A">
		<h1><b>Conlang Text Generator<b></h1><br><br><br><br><br><br><br><br>
		<h2 style="text-align:center;color:#ffad33;">Created by Marcus Alder</h2>
	</div>
	<br>
	
	<!-- <font face="courier"> -->
	<div id="translator" class="greybox container">
		<h1>Text Generator</h1>
		<br>
		<form method="post" action="" name="markov">
			<textarea type="text" name="input" style="width:100%;height:120px;" placeholder="Input (Optional)"></textarea>
			<br>
			<div class="row">
			<input type="text" name="order" placeholder="Order" class="two columns">
			<input type="text" name="length" placeholder="Length" class="two columns">
			<input type="text" name="first" placeholder="Seed" class="two columns">
			<select class="two columns" name = "text" value="text">
				<option selected="selected">Text</option>
				<option>Esperanto Corpus</option>
				<option>English Corpus</option>
				<option>Ido Corpus</option>
				<option>Interlingua Corpus</option>
				<option>toki pona Corpus</option>
				<option>1984 Full Text</option>
				<option>De Bello Gallico I</option>
				<option>Hearthstone Cards</option>
				<option>TJCrushes Posts</option>
				<option>Trump's Tweets</option>
				<option>US University List</option>
			</select>
			<input type="submit" name="submit" value="Submit" class="three columns"/>
			</div>
		</form>
		<br><br>
		<div id="output">
		<?php
			if(isset($markov))
				echo $markov;
		?>
		</div>
<!--         <textarea style="width:100%;height:240px;" placeholder="Output">
		</textarea> -->
		<br>
		<a href="translator.php">Switch to translator</a>
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
		<p style="font-size:17px;">
		<p>
			Instructions: Either input text (more is better) or choose a text as a basis for generating text.
			<br><br>Input    -- Put in custom input to create new writing based on. More input will be better for the generator but slower.
			<br><br>Order    -- How close it is to the original text/how creative the generator is. Lower numbers make less sense, higher numbers may copy sections of the input, 3-8 is normal.
			<br><br>Length   -- The number of characters in the output.
			<br><br>Seed     -- The first characters of the output, which the generator will procede from.
			<br><br>Text	 -- Choose a text to generate text with, an alternative to custom input. This may be slow due to the large corpus size.
		</p><br><br>
		<div id="google_translate_element">Translate this page to another language:</div>
		<script type="text/javascript">
			function googleTranslateElementInit()
			{
				new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
			}
		</script>
		<br>
		Made by Marcus Alder 2015/2016.
		</p>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

	<script type="text/javascript">
		document.getElementById("input").focus();
		// $(document).ready(function()
		// {
		// 	$("#submit").click(function()
		// 	{
		// 		$.post("markov.php", $("#query").serialize()).done(function(result)
		// 		{
		// 			$("#output").html(result);
		// 			// document.getElementById("output").style="display:inline;";
		// 		})
		// 	})
		// });
	</script>
</body>
</html>