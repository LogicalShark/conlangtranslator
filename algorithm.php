<?php
	//echo "Translated text here.";
	function getHTML($url,$timeout)
	{
	       $ch = curl_init($url); // initialize curl with given url
	       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
	       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
	       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
	       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
	       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
	       return @curl_exec($ch);
	}
	function idoepo($message)
	{
		$original = $message;
//------------------------------------------ARTICLES------------------------------------------
		//No change
//------------------------------------------NOUNS---------------------------------------------
		//Replace noun plural -i with -oj
		$message = preg_replace("/i /", "oj ", $message);
		$message = preg_replace("/i;/", "oj;", $message);
		$message = preg_replace("/i,/", "oj,", $message);
		$message = preg_replace("/i\./", "oj\.", $message);
		$message = preg_replace("/i\Z/", "oj\Z", $message);
		$message = preg_replace("/i\"/", "oj\"", $message);
		$message = preg_replace("/i\'/", "oj\'", $message);
//------------------------------------------ADJECTIVES------------------------------------------
		//Comparatives and superlatives are covered by the word replacement
//------------------------------------------VERBS-----------------------------------------------
		//Replace verb inperative ending -ez with -u
		$message = preg_replace("/ez /", "u ", $message);
		$message = preg_replace("/ez;/", "u;", $message);
		$message = preg_replace("/ez,/", "u,", $message);
		$message = preg_replace("/ez\./", "u\.", $message);
		$message = preg_replace("/ez\Z/", "u\Z", $message);
		$message = preg_replace("/ez\"/", "u\"", $message);
		$message = preg_replace("/ez\'/", "u\'", $message);
		//Replace verb infinitive ending -ar with -i
		$message = preg_replace("/ar /", "i ", $message);
		$message = preg_replace("/ar;/", "i;", $message);
		$message = preg_replace("/ar,/", "i,", $message);
		$message = preg_replace("/ar\./", "i\.", $message);
		$message = preg_replace("/ar\Z/", "i\Z", $message);
		$message = preg_replace("/ar\"/", "i\"", $message);
		$message = preg_replace("/ar\'/", "i\'", $message);
		//Replace verb participle endings .nta with .nt
		$message = preg_replace("/anta /", "ant ", $message);
		$message = preg_replace("/anta;/", "ant;", $message);
		$message = preg_replace("/anta,/", "ant,", $message);
		$message = preg_replace("/anta\./", "ant\.", $message);
		$message = preg_replace("/anta\Z/", "ant\Z", $message);
		$message = preg_replace("/anta\"/", "ant\"", $message);
		$message = preg_replace("/anta\'/", "ant\'", $message);
		$message = preg_replace("/inta /", "int ", $message);
		$message = preg_replace("/inta;/", "int;", $message);
		$message = preg_replace("/inta,/", "int,", $message);
		$message = preg_replace("/inta\./", "int\.", $message);
		$message = preg_replace("/inta\Z/", "int\Z", $message);
		$message = preg_replace("/inta\"/", "int\"", $message);
		$message = preg_replace("/inta\'/", "int\'", $message);
		$message = preg_replace("/onta /", "ont ", $message);
		$message = preg_replace("/onta;/", "ont;", $message);
		$message = preg_replace("/onta,/", "ont,", $message);
		$message = preg_replace("/onta\./", "ont\.", $message);
		$message = preg_replace("/onta\Z/", "ont\Z", $message);
		$message = preg_replace("/onta\"/", "ont\"", $message);
		$message = preg_replace("/onta\'/", "ont\'", $message);
//------------------------------------------ADVERBS-------------------------------------------
		//Covered in word replacement
//------------------------------------------PRONOUNS------------------------------------------
		//Covered in word replacement
//------------------------------------------PREPOSITIONS--------------------------------------
		//Covered in word replacement
//------------------------------------------WORD REPLACEMENT----------------------------------
		//Split into words
		$words = preg_split("/ /", $original);
		foreach($words as &$word)
		{
			$word = strtolower($word);
			$extras = "";
			if(strpos($word, ',')>=0)
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras=',';
			}
			if(strpos($word, ';')>=0)
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras=';';
			}
			if(strpos($word, '\"')>=0)
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras='\"';
			}
			if(strpos($word, '\n')>=0)
			{
				$w = substr($word, 0, strlen($word)-1);			
			}
			else
				$w = $word;
			$html = getHTML("https://glosbe.com/io/eo/$w", 5);
			preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches);
			echo $matches[1];
			echo $matches[2];
			echo $matches[3];
			// echo "word: $w<br>";
			// echo "match: $matches[2]<br>";
			$message = preg_replace("/ $word/", " $matches[2]", $message);
		}		
		// echo $message;
	}
	function epoido($message)
	{
		$original = $message;
		//Replace special characters
		$message = preg_replace("/ĥ/", "h", $message);
		$message = preg_replace("/[ĝĵ]/", "j", $message);
		$message = preg_replace("/ĉ/", "ch", $message);
		$message = preg_replace("/ŭ/", "w", $message);
		$message = preg_replace("/ŝ/", "sh", $message);

		echo $message;
	}
	function tkpepo($message)
	{
		$original = $message;
		$new = "";
		if(preg_match('/anu seme\./', $original))
		{
			$new = "ĉu ".$new;
		}
		if(preg_match('/kin\./', $original))
		{
			$new = $new.' tiel';
		}
		preg_match('/[A-Z]\w*(?=[ \.,;\n])/', $message, $matches);
		print_r($matches);
		$message = preg_replace('/jan [A-Z]\w*(?= )/', $matches[0][0], $message);
		$subject = substr($message, 0, strpos($message, ' li '));
		$object = substr($message, strpos($message, ' e ')+3);
		$subjectwords = preg_split("/ /", $subject);
		foreach($subjectwords as &$word)
		{

		}
		echo $message;
	}
	function epotkp($message)
	{
		$original = $message;
		echo $message;
	}
	// $word = "parallel";
	// $html=getHTML("http://www.thesaurus.com/browse/{$word}?s=t", 10);
	// preg_match_all('/class="text">(\w+)<(?=(.*container-info antonyms))/', $html, $matches);
	//for($x = 0; $x<sizeof($matches[1]); $x++)
		//echo $matches[1][$x]."\n";
	$message = $_POST["message"];
	//tkp==toki pona; epo==esperanto; ido==ido; ila==interlingua; nat==natural
	//permitted characters: [ ], [a-z], [A-Z], [,.;"'], [\n], [ĥĝĵĉŭŝ]
	$translatecode = "";
	switch($_POST['starter'])
	{
		case "toki pona": $translatecode.="tkp";
		break;
		case "Esperanto": $translatecode.="epo";
		break;
		case "Interlingua": $translatecode.="ila";
		break;
		case "Ido": $translatecode.="ido";
		break;
		default: $translatecode.="nat";
	}
	switch($_POST['target'])
	{
		case "toki pona": $translatecode.="tkp";
		break;
		case "Esperanto": $translatecode.="epo";
		break;
		case "Interlingua": $translatecode.="ila";
		break;
		case "Ido": $translatecode.="ido";
		break;
		default: $translatecode.="nat";
	}
	if($_POST['starter']==$_POST['target'])
		echo $message;
	else
		$translatecode($message);
?>