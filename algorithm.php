<?php
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------GLOBAL NAMING CONVENTIONS REFERENCE----------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Languages					| nat = natural; con = constructed; det = detect; tkp = toki pona; epo = esperanto; ido = ido; ila = interlingua 
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Permitted characters 		| [ ], [a-z], [A-Z], [,.;"'], [\n], [ĥĝĵĉŭŝ]            @ = exception, * = currently unused
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Parts of Speech			| adj = adjective; adv = adverb; art = article; con = conjunction; int = interjection; nou = noun; pre = preposition; pro = pronoun; ver = verb; oth = other; alt = alternate translation
//------------------------------------------------------------------------------------------------------------------------------------------
//Tense/time				| -1.0 pluperfect -.5 imperfect, -.3 yesterday, -.2 today, -.1 recently, 0 now, .1 soon, .2 today, .3 tomorrow, .5 future perfect, 1.0 future 
//							| Morning = -0.05, Noon = +0.01, Night = +0.05
//							| A long time: 2, a little time: -2
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Mood 						| 0:indicative, 1:subjunctive
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Voice 					| 0:active, 1:passive
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Clause classification 	| [0]:tense, [1]:mood, [2]:voice
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Example sentences
// tenpo pini la, jan pona li moku nasa e telo lili, anu seme?
// En la pasinteco, ĉu homo bona manĝis frenze akvo malgranda?
// In the past, did a good person crazily drink a little water?
// mi jan pona
// mi estas homo bona
// I am a good man

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------UTILITY FUNCTIONS----------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function getHTML($url,$timeout) //Get HTML from website
	{
	       $ch = curl_init($url); // initialize curl with given url
	       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
	       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
	       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
	       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
	       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
	       return @curl_exec($ch);
	}
	function substrToStrpos($string, $target, $addition=0) 			//Substring up to a pattern
	{return substr($string, 0, strpos($string, $target)+$addition);}
	function substrFromStrpos($string, $target, $addition=0)		//Substring after a pattern
	{return substr($string, strpos($string, $target)+$addition);}
	function strcont($string, $target)								//String contains
	{return (strpos($string, $target)>0);}

	function detectLanguage($message)
	{
		$dictTKP = fopen("dictionaries/tkplist.txt", "r");
		$wordTotal = str_word_count($message);
		$perTKP = 0;
		$perEPO = 0;
		$perIDO = 0;
		$perILA = 0;
		$perNAT = 0;
		$wordsTKP = explode("\n", fread($file, filesize("dictionaries/tkplist.txt")));
		for($wordsTKP as &$word)
		{
			$word = substrToStrpos($line, ":");
			if(preg_match("/[ ^]$word/", $message))
			{
				$perTKP+=1;
			}
		}
		fclose($file);
		$perTKP = $perTKP/$wordTotal;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------TRANSLATION FUNCTIONS------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function idoepo($message, $pr)
	{
		$original = $message;
//------------------------------------------ADJECTIVES---------------------------------------------------------------------------------------------------------------------------------
		//Comparatives and superlatives are covered by the word replacement
//------------------------------------------VERBS--------------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------ADVERBS------------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement
//------------------------------------------PRONOUNS-----------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement and fixed by previous modifications
//------------------------------------------PREPOSITIONS-------------------------------------------------------------------------------------------------------------------------------
		//Covered in word replacement
//------------------------------------------WORD REPLACEMENT---------------------------------------------------------------------------------------------------------------------------
		//Split into words
		$words = preg_split("/ /", $original);
		$output = "";
		foreach($words as &$word)
		{
			$word = strtolower($word);
//------------------------------------------PREFIXES-----------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------SUFFIXES-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------ENDINGS------------------------------------------------------------------------------------------------------------------------------------
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
//------------------------------------------PUNCTUATION--------------------------------------------------------------------------------------------------------------------------------
			if(strcont($word, '.'))
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.='.';
			}
			else if(strcont($word, ','))
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.=',';
			}
			else if(strcont($word, ';'))
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.=';';
			}
			else if(strcont($word, '\"'))
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.='\"';
			}
			else if(strcont($word, '\n'))
			{
				$w = substr($word, 0, strlen($word)-1);			
			}
			else
			{
				$w = $word;
			}
			$html = getHTML("https://glosbe.com/io/eo/$w", 5);
			preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches);
			if($pr)
			{
				echo $matches[2]." ";
			}
			$output .= preg_replace($matches[2]." ");
		}
		return $output;
	}
	function epoido($message, $pr)
	{
		$original = $message;
		//Replace special characters
		$message = preg_replace("/ĥ/", "h", $message);
		$message = preg_replace("/[ĝĵ]/", "j", $message);
		$message = preg_replace("/ĉ/", "ch", $message);
		$message = preg_replace("/ŭ/", "w", $message);
		$message = preg_replace("/ŝ/", "sh", $message);

		if($pr)
		{
			echo $message;
		}
		return $message;
	}
	function tkpepo($message, $pr)
	{
		//Variable declaration
		$original = $message;
		$partsofspeech = array();
		$clauseinfo = array();
		for($x = 0; $x<4; $x++)
			$clauseinfo[$x] = 0;
//--------------------------------------------RANK 0 MODIFICATIONS: CONSTANTS----------------------------------------------------------------------------------------------------------
		$prefixes = "";
		$suffixes = "";
		if(preg_match('/anu seme\?/', $original))//Yes or no question
		{
			$prefixes = "ĉu ";
			if(preg_match("/, anu seme\?/", $original))
				$message = substr($message, 0, strlen($message)-11)."?";
			else
				$message = substr($message, 0, strlen($message)-10)."?";
		}
		if(preg_match('/kin\./', $original))//As well/indeed
		{
			$suffixes = " tiel";
			$message = substr($message, 3);		
		}
		// $matches = array();
		// preg_match('/[A-Z]\w*(?=[ \.,;\n])/', $message, $matches);
		// $message = preg_replace('/jan [A-Z]\w*(?= )/', strval($matches[0]), $message);
		$message = preg_replace('/[0] =>/', '', $message);
//------------------------------------------RANK 1 MODIFICATIONS: CLAUSE CLASSIFICATION------------------------------------------------------------------------------------------------
		//Find tense/time
		$presentprefix = 0;//Default value is 0, if there is a "tenpo ni la" the tense stays 0 but a "now" needs to be added
		if(preg_match('/tenpo .+ la/', $message))
		{
			$clauseinfo[0] = 0;
			//Past
			if(preg_match('/tenpo pini la/', $message))//General past
				$clauseinfo[0] = -1;
			if(preg_match('/tenpo suno pini la/', $message))//Yesterday
				$clauseinfo[0] = -.3;
			if(preg_match('/tenpo pimeja pini la/', $message))//Last night
				$clauseinfo[0] = -.25;			
			if(preg_match('/tenpo pini lili la/', $message))//Recently
				$clauseinfo[0] =  -0.1;
			//Future
			if(preg_match('/tenpo kama lili la/', $message))//Soon
				$clauseinfo[0] =  0.1;
			if(preg_match('/tenpo pimeja ni la/', $message))//Tonight
				$clauseinfo[0] =  0.25;
			if(preg_match('/tenpo pimeja kama la/', $message))//Tonight (alt)
				$clauseinfo[0] =  0.25;
			if(preg_match('/tenpo suno kama la/', $message))//Tomorrow
				$clauseinfo[0] = .3;
			if(preg_match('/tenpo pini kama la/', $message))//Future perfect?
				$clauseinfo[0] = .5;
			if(preg_match('/tenpo kama la/', $message))//General future
				$clauseinfo[0] = 1;
			//Present
			if(preg_match('/tenpo suno ni la/', $message))//Future today
				$clauseinfo[0] =  0.2;
			if(preg_match('/tenpo ni la/', $message))//Now
			{
				$presentprefix = 1;
				$clauseinfo[0] = 0;
			}
			//Exception cases
			if(preg_match('/tenpo suli la/', $message))//For a long time
				$clauseinfo[0] = 2;
			if(preg_match('/tenpo lili la/', $message))//For a short time
				$clauseinfo[0] = -2;
			//Others can be added, this covers all the basic ones
		}
		$message = preg_replace('/tenpo .+ la. ?/', '', $message);//Get rid of "tenpo _ la"
		//Add prefixes to indicate time
		switch($clauseinfo[0])
		{
			case -2:
			$prefixes = "Mallongtempe, ".$prefixes;
			break;
			case -1:
			$prefixes = "En la pasinteco, ".$prefixes;
			break;
			case -.3:
			$prefixes = "Hieraŭ, ".$prefixes;
			break;
			case -.25:
			$prefixes = "Lasta nokto, ".$prefixes;
			break;
			case -.1:
			$prefixes = "ĵus, ".$prefixes;
			break;
			case .1:
			$prefixes = "Baldaŭ, ".$prefixes;
			break;
			case .2:
			$prefixes = "Hodiaŭ, ".$prefixes;
			break;
			case .25:
			$prefixes = "ĉinokte, ".$prefixes;
			break;
			case .3:
			$prefixes = "Morgaŭ, ".$prefixes;
			break;
			case .35:
			$prefixes = "Morgaŭ nokto, ".$prefixes;
			break;
			case 1:
			$prefixes = "En la estonteco, ".$prefixes;
			break;
			case 2:
			$prefixes = "Longtempe, ".$prefixes;
			break;
			case 0:
			if($presentprefix == 1)
				$prefixes = "Nun, ".$prefixes;
			break;
		}
		//Find voice/mood
		//?
//------------------------------------------RANK 2 MODIFICATIONS: PART OF SPEECH IDENTIFICATION----------------------------------------------------------------------------------------
		$messagewords = explode(" ", $message);
		//Subject + Adjectives
		$includesli = 3;
		$firstword = $messagewords[0];
		if($firstword=="mi"||$firstword=="sina")
		{
			$includesli = 0;
			$subject = $firstword;
		}
		else
			$subject = substr($message, 0, strpos($message, ' li '));
		$subjectwords = explode(" ", $subject);
		$partsofspeech[0] = "nou";
		for($x = 1; $x<sizeof($subjectwords); $x++)
		{
			$partsofspeech[$x] = "adj";
		}
		//Verb + Adverbs
		if(preg_match("/ e /", $original)!=false) //If it contains "e", i.e. not a "to be" sentence
		{
			$verb = substr($message, strlen($subject) + $includesli, strpos($message, ' e ') - (strlen($subject) + $includesli));
			$verbwords = explode(" ", $verb);
			$partsofspeech[array_search("e", $messagewords) - sizeof($verbwords)+1] = "ver";
			for($z = array_search("e", $messagewords)-sizeof($verbwords)+2; $z<array_search("e", $messagewords); $z++)
			{
				$partsofspeech[$z] = "adv";
			}
			//Object + Adjectives
			$object = substr($message, strpos($message, ' e ')+3);
			$objectwords = explode(" ", $object);
			$partsofspeech[array_search("e", $messagewords)] = "oth";
			$partsofspeech[array_search("e", $messagewords)+1] = "nou";
			for($y = array_search("e", $messagewords)+2; $y<array_search("e", $messagewords)+sizeof($objectwords)+1; $y++)
			{
				$partsofspeech[$y] = "adj";
			}
		}
		else //"to be" sentences
		{
			if($includesli==0)
			{
				//Verb
				$verb = "@tobe";
				$message = substrToStrpos($message, ' ', 1).$verb." e ".substrFromStrpos($message, ' ', 1);
				$messagewords = explode(" ", $message);
				$partsofspeech[1] = "ver";
				$partsofspeech[2] = "oth";
				$partsofspeech[3] = "nou";
				//Adjectives
				for($n = 4; $n<sizeof($messagewords); $n++)
				{
					$partsofspeech[$n] = "adj";
				}
			}
			else
			{
				//Verb
				$verb = "@tobe";
				$message = substrToStrpos($message, ' li ', 4).$verb." e ".substrFromStrpos($message,' li ',4);
				$messagewords = explode(" ", $message);
				$partsofspeech[array_search("li", $messagewords)+1] = "ver";
				//Subject + Adjectives
				$subject = substr($message, 0, strpos($message, ' li '));
				$subjectwords = explode(" ", $subject);
				$partsofspeech[0] = "nou";
				for($x = 1; $x<sizeof($subjectwords); $x++)
				{
					$partsofspeech[$x] = "adj";
				}
				//Object + Adjectives
				$object = substr($message, strpos($message, ' e ')+3);
				$objectwords = explode(" ", $object);
				$partsofspeech[array_search("e", $messagewords)] = "oth";
				$partsofspeech[array_search("e", $messagewords)+1] = "nou";
				for($y = array_search("e", $messagewords)+2; $y<array_search("e", $messagewords)+sizeof($objectwords)+1; $y++)
				{
					$partsofspeech[$y] = "adj";
				}
			}
		}
//--------------------------------------------RANK 2 MODIFICATIONS: LITERAL WORD REPLACEMENT AND P.O.S. ADDITION-------------------------------------------------------------------------------------------------------------------------------------------------------
		$file = fopen("dictionaries/tkpepodict.txt", "r");
		$dictwords = explode("\n", fread($file, filesize("dictionaries/tkpepodict.txt")));
		$new = "";
		$index = 0;
		$punct = "";
		foreach($messagewords as &$msgword)
		{
			if($msgword!="")
			{
				//Get rid of punctuation
				if(preg_match("/[?.,;:]/", $msgword)==1)
				{
					$punct=substr($msgword, strlen($msgword)-1);
					$msgword=substr($msgword, 0, strlen($msgword)-1);
				}
				$wordIsTranslatable = false;
				foreach($dictwords as &$dictword)
				{
					if(strpos($dictword, $msgword.":")==1)  						//If in the tkpepo dictionary
					{
						$wordIsTranslatable = true;									//Know word is translatable
						$new.=substr($dictword, strpos($dictword, ":")+1); 			//Append word to output
						if(strcont($dictword, "-")) 								//If it needs an ending
						{  
							$ending = "";
							switch($partsofspeech[$index])							//Assign ending based on part of speech
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
								//Past
								if(1>=$clauseinfo[0] && $clauseinfo[0]>0)
								{
									$ending = "os";
								}
								//Future
								else if(-1<=$clauseinfo[0]  && $clauseinfo[0] <0)
								{
									$ending = "is";
								}
								//Present
								else
								{
									$ending = "as";
								}
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
				//Add punctuation and space
				$new.=$punct." ";
				$punct = "";
			}
			$index+=1;
		}
		fclose($file);
		if($pr)
		{
			echo $prefixes.$new.$suffixes;
		}
		return $prefixes.$new.$suffixes;
	}
	function ilaepo($message, $pr)
	{
		$original = $message;
		$output = "";
		$words = preg_split("/ /", $original);
		foreach($words as &$word)
		{
			$word = strtolower($word);
			if(strcont($word, '.'))
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.='.';
			}
			else if(strcont($word, ','))
			{
				$w = substr($word, 0, strlen($word)-1);
				$extras.=',';
			}
			else if(strcont($word, ';'))
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.=';';
			}
			else if(strcont($word, '\"'))
			{
				$w = substr($word, 0, strlen($word)-1);			
				$extras.='\"';
			}
			else if(strcont($word, '\n'))
			{
				$w = substr($word, 0, strlen($word)-1);			
			}
			else
			{
				$w = $word;
			}
			$matches = array();
			$html = getHTML("https://glosbe.com/ia/eo/$w", 5);
			preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches);
			if($pr)
			{
				echo $matches[2]." ";
			}
			$output.=$matches[2]." ";
			$html = getHTML("https://glosbe.com/eo/en/$w", 5);
			preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches);
			$message = preg_replace("/ $word./", " $prefix$matches[2]$extras ", $message);
		}
		return $output;
	}
	function epotkp($message, $pr)
	{
		$original = $message;
		if($pr)
		{
			echo $message;
		}
		return $message;
	}
	function connat($lang, $message, $pr)
	{
		$funct = '$lang'+'epo'; 		//Language to epo function
		if($pr)
		{
			echo eponat($funct($message, 0), 1);	//Language to epo to nat
		}
	}
	//Esperanto transitions
	function tkpido($message, $pr)
	{
		return epoido(tkpepo($message, 0), 1);
	}
	function itotkp($message, $pr)
	{
		return epotkp(idoepo($message, 0), 1);
	}
	function ilatkp($message, $pr)
	{
		return epotkp(ilaepo($message, 0), 1);
	}
	function tkpila($message, $pr)
	{
		return epoila(tkpepo($message, 0), 1);
	}
	function eponat($message, $pr)
	{
		// INFO HERE
		// https://cloud.google.com/translate/v2/using_rest#Translate
		// Done in javascript on translator.php
		return $message;
	}
	function natepo($message, $pr)
	{
		// INFO HERE
		// https://cloud.google.com/translate/v2/using_rest#Translate
		// Done in javascript on translator.php
		return $message;
	}
	function dettkp($message, $pr)
	{
		$function = detectLanguage($message)."tkp";
		$function($message, $pr);
	}
	function detepo($message, $pr)
	{
		$function = detectLanguage($message)."epo";
		$function($message, $pr);
	}
	function detido($message, $pr)
	{
		$function = detectLanguage($message)."ido";
		$function($message, $pr);
	}
	function detila($message, $pr)
	{
		$function = detectLanguage($message)."ila";
		$function($message, $pr);
	}
	function detnat($message, $pr)
	{
		$function = detectLanguage($message)."nat";
		$function($message, $pr);
	}
	function detcon($message, $pr)
	{
		$function = detectLanguage($message)."con";
		$function($message, $pr);
	}
	$message = $_POST["input"];
	$translatecode = "";
	switch($_POST['source'])
	{
		case "Detect Language": $translatecode.="det";
		break;
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
	if($_POST['source']==$_POST['target'])
		echo $message;
	else if(substr($translatecode, 3)=="nat")
		connat(substr($translatecode, 0,3), $message);
	else
		$translatecode($message, 1);
?>