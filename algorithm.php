<?php
//GLOBAL CODING REFERENCE
//tkp = toki pona; epo = esperanto; ido = ido; ila = interlingua; nat = natural
//permitted characters: [ ], [a-z], [A-Z], [,.;"'], [\n], [ĥĝĵĉŭŝ]
//adj = adjective; adv = adverb; art = article; con = conjunction; int = interjection; nou = noun; pre = preposition; pro = pronoun; ver = verb; oth = other; alt = alternate translation
//tense -3:pluperfect, -2:perfect, -1:imperfect, 0:present, 1:future, 2:future perfect
//mood: 0:indicative, 1:subjunctive
//voice 0:active, 1:passive
//clause classification: tense, mood, voice

//----------------------------------------GET HTML SOURCE FROM SITE------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	
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

//------------------------------------------ADJECTIVES----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Comparatives and superlatives are covered by the word replacement
//------------------------------------------VERBS---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------ADVERBS-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement
//------------------------------------------PRONOUNS----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement and fixed by previous modifications
//------------------------------------------PREPOSITIONS----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement
//------------------------------------------WORD REPLACEMENT--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Split into words
		$words = preg_split("/ /", $original);
		foreach($words as &$word)
		{
			$word = strtolower($word);
//------------------------------------------PREFIXES----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------SUFFIXES----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//------------------------------------------ENDINGS----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------PUNCTUATION----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
		//Variable declaration
		$original = $message;
		$partsofspeech = array();
		$clauseinfo = array();
		for($asdf = 0; $asdf<4; $asdf++)
			$clauseinfo[$asdf] = 0;
//--------------------------------------------RANK 0 MODIFICATIONS: CONSTANTS--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$prefixes = "";
		$suffixes = "";
		if(preg_match('/anu seme\./', $original))
		{
			$prefixes = "ĉu ";
			$message = substr($message, 0, strlen($message)-9);
		}
		if(preg_match('/kin\./', $original))
		{
			$suffixes = " tiel";
			$message = substr($message, 3);		
		}
		preg_match('/[A-Z]\w*(?=[ \.,;\n])/', $message, $matches);
		print_r($matches);
		$message = preg_replace('/jan [A-Z]\w*(?= )/', strval($matches[0][0]), $message);
		$message = preg_replace('/[0] =>/', '', $message);
//------------------------------------------RANK 1 MODIFICATIONS: CLAUSE CLASSIFICATION----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Find tense/time
		if(preg_match('/tenpo .+ la'))
		{

		}
//------------------------------------------RANK 2 MODIFICATIONS: POS IDENTIFICATION----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$messagewords = explode(" ", $message);
		//Subject
		$firstword = $messagewords[0];
		if($firstword=="mi"||$firstword=="sina")
			$subject = $firstword;
		else
			$subject = substr($message, 0, strpos($message, ' li '));
		$subjectwords = explode(" ", $subject);
		$partsofspeech[0] = "nou";
		for($x = 1; $x<sizeof($subjectwords); $x++)
		{
			$partsofspeech[$x] = "adj";
		}
		//Verb
		$verb = substr($message, strlen($subject), strpos($message, ' e ') - strlen($subject));
		$verbwords = explode(" ", $verb);
		$partsofspeech[array_search("e", $messagewords) - sizeof($verbwords)+1] = "ver";
		for($z = array_search("e", $messagewords)-sizeof($verbwords)+2; $z<array_search("e", $messagewords); $z++)
		{
			$partsofspeech[$z] = "adv";
		}
		//Object
		$object = substr($message, strpos($message, ' e ')+3);
		$objectwords = explode(" ", $object);
		$partsofspeech[array_search("e", $messagewords)] = "oth";
		$partsofspeech[array_search("e", $messagewords)+1] = "nou";
		for($y = array_search("e", $messagewords)+2; $y<array_search("e", $messagewords)+sizeof($objectwords)+1; $y++)
		{
			$partsofspeech[$y] = "adj";
		}
//--------------------------------------------RANK 2 MODIFICATIONS: LITERAL WORD REPLACEMENT AND POS ADDITION-------------------------------------------------------------------------------------------------------------------------------------------------------
		$file = fopen("tkpepodict.txt", "r");
		$dictwords = explode("\n", fread($file, filesize("tkpepodict.txt")));
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
						if(strpos($dictword, "-")>0)
						{  
							$ending = "";
							switch($partsofspeech[array_search($msgword, $messagewords)])
							{
								case "adj":
								$ending = "a";
								break;
								case "adv":
								$ending = "e";
								break;
								case "nou":
								$ending = "o";
								break;
								case "ver":
								$ending = "as";
								break;
								case "pre":
								$ending = "";
								break;
								case "pro":
								$ending = "";
								break;
								case "oth":
								$ending = "";
								break;
								case "int":
								$ending = "";
								break;
								default:
								$ending = "";
								break;
							}
							$new = substr($new, 0, strlen($new)-2);
							$new.=$ending;
						}
					}
				}
				if(!$wordIsTranslatable && $msgword!="e" && $msgword!="li")
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