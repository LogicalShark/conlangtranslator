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

//------------------------------------------ADJECTIVES------------------------------------------
		//Comparatives and superlatives are covered by the word replacement
//------------------------------------------VERBS-----------------------------------------------
		//Change back ilu, elu, olu, onu
		$message = preg_replace("/ilez/", "ilu", $message);
		$message = preg_replace("/elez/", "elu", $message);
		$message = preg_replace("/olez/", "olu", $message);
		$message = preg_replace("/onez/", "onu", $message);
		//Replace verb infinitive ending -ar with -i
		$message = preg_replace("/ar /", "i ", $message);
		$message = preg_replace("/ar;/", "i;", $message);
		$message = preg_replace("/ar,/", "i,", $message);
		$message = preg_replace("/ar\./", "i\.", $message);
		$message = preg_replace("/ar\Z/", "i", $message);
		$message = preg_replace("/ar\"/", "i\"", $message);
		$message = preg_replace("/ar\'/", "i\'", $message);
		//Replace verb participle endings .nta with .nt
		$message = preg_replace("/anta /", "ant ", $message);
		$message = preg_replace("/anta;/", "ant;", $message);
		$message = preg_replace("/anta,/", "ant,", $message);
		$message = preg_replace("/anta\./", "ant\.", $message);
		$message = preg_replace("/anta\Z/", "ant", $message);
		$message = preg_replace("/anta\"/", "ant\"", $message);
		$message = preg_replace("/anta\'/", "ant\'", $message);
		$message = preg_replace("/inta /", "int ", $message);
		$message = preg_replace("/inta;/", "int;", $message);
		$message = preg_replace("/inta,/", "int,", $message);
		$message = preg_replace("/inta\./", "int\.", $message);
		$message = preg_replace("/inta\Z/", "int", $message);
		$message = preg_replace("/inta\"/", "int\"", $message);
		$message = preg_replace("/inta\'/", "int\'", $message);
		$message = preg_replace("/onta /", "ont ", $message);
		$message = preg_replace("/onta;/", "ont;", $message);
		$message = preg_replace("/onta,/", "ont,", $message);
		$message = preg_replace("/onta\./", "ont\.", $message);
		$message = preg_replace("/onta\Z/", "ont", $message);
		$message = preg_replace("/onta\"/", "ont\"", $message);
		$message = preg_replace("/onta\'/", "ont\'", $message);
//------------------------------------------ADVERBS-------------------------------------------
		//Covered in word replacement
//------------------------------------------PRONOUNS------------------------------------------
		//Covered in word replacement and fixed by previous modifications
//------------------------------------------PREPOSITIONS--------------------------------------
		//Covered in word replacement
//------------------------------------------WORD REPLACEMENT----------------------------------
		//Split into words
		$words = preg_split("/ /", $original);
		foreach($words as &$word)
		{
			$word = strtolower($word);
//------------------------------------------PREFIXES------------------------------------------
			$prefix = "";

			if(preg_match("/\Ades/", $word))
			{
				$word = substr($word, 3, strlen($word)-3);
				$prefix='des';
			}
			else if(preg_match("/\Adis/", $word))
			{
				$word = substr($word, 3, strlen($word)-3);
				$prefix='dis';
			}
//------------------------------------------SUFFIXES------------------------------------------

//------------------------------------------ENDINGS------------------------------------------
			$extras = "";
//NOUNS		//Replace plural -i with -oj
			if(preg_match("/i(\Z|\.|\'|\"|;|:|\?|\!)/", $word)&&strpos($word, "ni")!=0&&strpos($word, "vi")!=0&&strpos($word, "li")!=0)//Don't include pronouns ni, vi, li
			{
				$word = preg_replace("/i(\Z|\.|\'|\"|;|:|\?|\!)/", "o", $word);
				$extras.='oj';
			}
//VERBS		//Replace imperative -ez with -u
			else if(preg_match("/ez(\Z|\.|\'|\"|;|:|\?|\!)/", $word))
			{
				$word = preg_replace("/ez(\Z|\.|\'|\"|;|:|\?|\!)/", "ar", $word);
				$extras.='u';
			}
			//Replace infinitive -ar with -i
			else if(preg_match("/ar(\Z|\.|\'|\"|;|:|\?|\!)/", $word))
			{
				$word = preg_replace("/ar(\Z|\.|\'|\"|;|:|\?|\!)/", "i", $word);
				$extras.='ar';
			}
			//Replace imperative -ez with -u
			else if(preg_match("/ez(\Z|\.|\'|\"|;|:|\?|\!)/", $word))
			{
				$word = preg_replace("/ez(\Z|\.|\'|\"|;|:|\?|\!)/", "ar", $word);
				$extras.='u';
			}
//------------------------------------------PUNCTUATION------------------------------------------
			if(strpos($word, '.')>0)
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.='.';
			}
			else if(strpos($word, ',')>0)
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.=',';
			}
			else if(strpos($word, ';')>0)
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.=';';
			}
			else if(strpos($word, '\"')>0)
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.='\"';
			}
			else if(strpos($word, '\n')>0)
			{
				$w = substr($word, 0, strlen($word)-1);			
			}
			else
			{
				$w = $word;
			}
			$html = getHTML("https://glosbe.com/io/eo/$w", 5);
			preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches);
			echo $matches[2]." ";
			// echo "word: $w<br>";
			// echo "match: $matches[2]<br>";
			$message = preg_replace("/ $word./", " $prefix$matches[2]$extras ", $message);
		}
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
		$prefixes = "";
		$suffixes = "";
		if(preg_match('/anu seme\./', $original))
		{
			$prefixes = "ĉu ";
		}
		if(preg_match('/kin\./', $original))
		{
			$suffixes = ' tiel';
		}
		
		preg_match('/[A-Z]\w*(?=[ \.,;\n])/', $message, $matches);
		print_r($matches);
		$message = preg_replace('/jan [A-Z]\w*(?= )/', strval($matches[0][0]), $message);
		$message = preg_replace('/[0] =>/', '', $message); 
		$subject = substr($message, 0, strpos($message, ' li '));
		$object = substr($message, strpos($message, ' e ')+3);
		$message = preg_replace('/ e /', '', $message);
		$message = preg_replace('/ li /', '', $message);
		$subjectwords = explode(" ", $subject);
		
		$file = fopen("tkpepodict.txt", "r");
		$dictwords = explode("\n", fread($file, filesize("tkpepodict.txt")));
		
		$messagewords = explode(" ", $message);
		$new = "";
		foreach($messagewords as &$msgword)
		{
			if($msgword!="")
			{
				$wordIsTranslatable = false;
				foreach($dictwords as &$dictword)
				{
					if(strpos($dictword, $msgword.":")==1)
					{
						$wordIsTranslatable = true;
						$new.=substr($dictword, strpos($dictword, ":")+1);
					}
				}
				if(!$wordIsTranslatable)
				{
					$new.=$msgword;
				}
				$new.=" ";
			}
		}
		fclose($file);
		echo $prefixes.$new.$suffixes;
	}
	function epotkp($message)
	{
		$original = $message;
		echo $message;
	}
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