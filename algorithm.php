<?php
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------REFERENCE----------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Coding 					| $pr tells you if you need to print the function output
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Languages					| nat = natural; con = constructed; det = detect; tkp = toki pona; epo = esperanto; ido = ido; ila = interlingua
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Permitted characters 		| [ ], [a-z], [A-Z], [,.;"'], [\n], [ĥĝĵĉŭŝ]            @ = exception, * = currently unused
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Parts of Speech			| adj = adjective; adv = adverb; art = article; con = conjunction; int = interjection; nou = noun; pre = preposition; pro = pronoun; ver = verb
//							| oth = other; alt = alternative translation
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Tense/time				| -1.0 pluperfect -.5 imperfect, -.3 yesterday, -.2 today, -.1 recently, 0 now, .1 soon, .2 today, .3 tomorrow, .5 future perfect, 1.0 future
//							| Morning = -0.05, Noon = +0.01, Night = +0.05
//							| A long time 2, A short time -2
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Mood 						| 0 indicative, 1 subjunctive
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Voice 					| 0 active, 1 passive
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Clause classification 	| [0] tense, [1] mood, [2] voice
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Translate API 			| Google Translate REST API, Pricing: $1.00/5,000 chars
//Wikipedia API 			| Wikimedia API Free
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Test cases
// tenpo pini la, jan pona li moku nasa e telo lili, anu seme?
// En la pasinteco, ĉu homo bona manĝis frenze akvo malgranda?
// In the past, did a good person crazily drink a little water?
//Patre nostre, qui es in le celos, que tu nomine sia sanctificate; que tu regno veni; que tu voluntate sia facite como in le celo, etiam super le terra.
//Patro Nia, kiu estas en la ĉielo,	via nomo estu sanktigita. Venu via regno, plenumiĝu via volo, kiel en la ĉielo, tiel ankaŭ sur la tero.


//Compound words in toki pona:
	//https://docs.google.com/spreadsheets/d/12gDr-zsUuwwCWPme9DlAE0JWuFDAFrqh3_IA257ff1U/edit#gid=0
	//https://docs.google.com/spreadsheets/d/1qpN-x6g6LEXIllq5eIKkamL7dpsIcLzjOYpHSGCzHUs/edit?hl=en#gid=0
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------UTILITY FUNCTIONS---------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function getHTML($url,$timeout) //Get HTML from website (don't mess with this)
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
		$wordTotal = str_word_count($message);
		//Highest number of words in a language wins
		//0 tkp, 1 epo, 2 ido, 3 ila, 4 nat
		$counts = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0);

		//Check for things only found in one language
		if(preg_match("/ĝ|ĥ|ĵ|ĉ|ŭ|ŝ/", $message))
			return "epo";
		if(preg_match("/\bmal\w+\b/", $message))
			return "epo";
		//Find words matching each language
		//toki pona
		$dictTKP = fopen("dictionaries/tkplist.txt", "r");
		$wordsTKP = explode("\n", fread($dictTKP, filesize("dictionaries/tkplist.txt")));
		foreach($wordsTKP as &$line)
		{
			$word = substr($line, 0, strlen($line)-1);
			if(preg_match("/\b$word\b/", $message))
			{
				$counts[0]+=1;
			}
		}
		fclose($dictTKP);
		// if($counts[0] >= $wordTotal)
		// {
		// 	return "tkp";
		// }
		// echo $counts[0]."tkp\n";
		//Esperanto
		$dictEPO = fopen("dictionaries/epodict.txt", "r");
		$wordsEPO = explode("\n", fread($dictEPO, filesize("dictionaries/epodict.txt")));
		foreach($wordsEPO as &$line)
		{
			$word = substrToStrpos($line, ":");
			if(preg_match("/\b$word\b/", $message))
			{
				$counts[1]+=1;
			}
		}
		fclose($dictEPO);
		// if($counts[1] >= $wordTotal)
		// {
		// 	return "epo";
		// }

		// echo $counts[1]."epo\n";
		//Ido
		$dictIDO = fopen("dictionaries/idodict2.txt", "r");
		$wordsIDO = explode("\n", fread($dictIDO, filesize("dictionaries/idodict2.txt")));
		foreach($wordsIDO as &$line)
		{
			$word = substrToStrpos($line, ":");
			if(preg_match("/\b$word\b/", $message))
			{
				$counts[2]+=1;
			}
		}
		fclose($dictIDO);
		// if($counts[2] >= $wordTotal)
		// {
		// 	return "ido";
		// }

		// echo $counts[2]."ido\n";

		//Interlingua
		$dictILA = fopen("dictionaries/iladict.txt", "r");
		$wordsILA = explode("\n", fread($dictILA, filesize("dictionaries/iladict.txt")));
		foreach($wordsILA as &$line)
		{
			$word = substrToStrpos($line, " ");
			if(preg_match("/(^| )$word( |,|'|;|\"|\Z)/", $message))
			{
				$counts[3]+=1;
			}
		}
		fclose($dictILA);

		// if($counts[3] >= $wordTotal)
		// {
		// 	return "ila";
		// }

		// echo $counts[3]."ila\n";
		//Other?

		//Find winner
		$max = 0;
		for($x = 0; $x<4; $x++)
		{
			// echo $x." ".$counts[$x]."<br>";
			if($counts[$x]>$counts[$max])
				$max = $x;
		}	
		switch($max)
		{
			case 0:
			$lang = "tkp";
			break;
			case 1:
			$lang = "epo";
			break;
			case 2:
			$lang = "ido";
			break;
			case 3:
			$lang = "ila";
			break;
			default:
			$lang = "nat";
		}
		return $lang;
	}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------TRANSLATION FUNCTIONS-----------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function idoepo($message, $pr)
	{
		$original = $message;
//ADJECTIVES
		//Comparatives and superlatives are covered by the word replacement
//VERBS
		//Change back ilu, elu, olu, onu
		$matches = preg_match("/ez\b/", "u ", $message);
		//Replace verb infinitive ending -ar with -i
		$message = preg_replace("/ar\b/", "i ", $message);
		//Replace verb participle endings .nta with .nt
		$message = preg_replace("/nta\b/", "nt ", $message);
//ADVERBS
		//Covered in word replacement
//PRONOUNS
		//Covered in word replacement and fixed by previous modifications
//PREPOSITIONS
		//Covered in word replacement
//WORD REPLACEMENT
		//Split into words
		$words = preg_split("/ /", $original);
		$output = "";
		foreach($words as &$word)
		{
			$caps = 0;
			if($word!=strtolower($word))
				$caps = 1;
			$word = strtolower($word);
//PREFIXES
			$prefix = "";
			if(preg_match("/\bdes/", $word))
			{
				$word = substr($word, 3, strlen($word)-3);
				$prefix='des';
			}
			else if(preg_match("/\bdis/", $word))
			{
				$word = substr($word, 3, strlen($word)-3);
				$prefix='dis';
			}
//SUFFIXES AND ENDINGS
			$extras = "";
//NOUNS		
			//Replace plural -i with -oj
			if(preg_match("/i\b/", $word))
			{
				$word = preg_replace("/i\b/", "o", $word);
				$extras.='j';
			}
//VERBS
			//Replace infinitive -ar with -i
			if(preg_match("/ar\b/", $word))
			{
				$word = preg_replace("/ar\b/", "i", $word);
				$extras.='ar';
			}
			//Replace imperative -ez with -u
			// else if(preg_match("/ez\b/", $word))
			// {
			// 	$word = preg_replace("/ez\b/", "ar", $word);
			// 	$extras.='u';
			// }
//PUNCTUATION
			
			$w = substr($word, 0, strlen($word)-1);
			if(strcont($word, '.'))
				$extras.='.';
			else if(strcont($word, ','))
				$extras.=',';
			else if(strcont($word, ';'))
				$extras.=';';
			else if(strcont($word, '\"'))
				$extras.='\"';
			else if(strcont($word, '\n'))
				$extras.='\n';
			else
				$w = $word;

			$html = getHTML("https://glosbe.com/io/eo/$w", 5);
			if(preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches))
			{
				if($pr)
				{
					echo $prefix.$matches[2].$extras." ";
				}
				$output .= $prefix.$matches[2].$extras." ";
			}
			else
			{
				if($pr)
				{
					echo $w.$extras." ";
				}
				$output .= $prefix.$w.$extras." ";
			}
			$extras = "";
		}
		return $output;
	}
	function epoido($message, $pr)
	{
		$original = $message;
		
//ADJECTIVES
		//Comparatives and superlatives are covered by the word replacement
// //VERBS
// 		//Change back ilu, elu, olu, onu
// 		$matches = preg_match("/ez\b/", "u ", $message);
// 		//Replace verb infinitive ending -ar with -i
// 		$message = preg_replace("/ar\b/", "i ", $message);
// 		//Replace verb participle endings .nta with .nt
// 		$message = preg_replace("/nta\b/", "nt ", $message);
//ADVERBS
		//Covered in word replacement
//PRONOUNS
		//Covered in word replacement and fixed by previous modifications
//PREPOSITIONS
		//Covered in word replacement
//WORD REPLACEMENT
		//Split into words
		$words = preg_split("/ /", $original);
		$output = "";
		foreach($words as &$word)
		{
			$caps = 0;
			if($word!=strtolower($word))
				$caps = 1;
			$word = strtolower($word);
// //PREFIXES
// 			$prefix = "";
// 			if(preg_match("/\bdes/", $word))
// 			{
// 				$word = substr($word, 3, strlen($word)-3);
// 				$prefix='des';
// 			}
// 			else if(preg_match("/\bdis/", $word))
// 			{
// 				$word = substr($word, 3, strlen($word)-3);
// 				$prefix='dis';
// 			}
// //SUFFIXES AND ENDINGS
			$extras = "";
// //NOUNS		
// 			//Replace plural -i with -oj
// 			if(preg_match("/i\b/", $word))
// 			{
// 				$word = preg_replace("/i\b/", "o", $word);
// 				$extras.='j';
// 			}
// //VERBS
// 			//Replace infinitive -ar with -i
// 			if(preg_match("/ar\b/", $word))
// 			{
// 				$word = preg_replace("/ar\b/", "i", $word);
// 				$extras.='ar';
// 			}
			//Replace imperative -ez with -u
			// else if(preg_match("/ez\b/", $word))
			// {
			// 	$word = preg_replace("/ez\b/", "ar", $word);
			// 	$extras.='u';
			// }
//PUNCTUATION
			
			$w = substr($word, 0, strlen($word)-1);
			if(strcont($word, '.'))
				$extras.='.';
			else if(strcont($word, ','))
				$extras.=',';
			else if(strcont($word, ';'))
				$extras.=';';
			else if(strcont($word, '\"'))
				$extras.='\"';
			else if(strcont($word, '\n'))
				$extras.='\n';
			else
				$w = $word;
			//https://glosbe.com/gapi/{function-name}[?[{function-parameter1}={value}[&{function-parameter2}={value}[&{function-parameter3}={value}...]]]]
			// $xml = simplexml_load_file("https://glosbe.com/gapi/translate[?[from=eo[&dest=io[&phrase=".$w."[format=xml]]]]]");
			// $wt = $xml->map->entry[1]->list->map->entry->string->com.google.common.collect.RegularImmutableMap->values;
			$html = getHTML("https://glosbe.com/eo/io/$w", 5);
			if(preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches))
			{
				if($pr)
				{
					echo $prefix.$matches[2].$extras." ";
				}
				$output .= $prefix.$matches[2].$extras." ";
			}
			else
			{
				if($pr)
				{
					echo $w.$extras." ";
				}
				$output .= $prefix.$w.$extras." ";
			}
			$extras = "";
		}
		//Replace special characters
		$output = preg_replace("/ĥ/", "h", $output);
		$output = preg_replace("/[ĝĵ]/", "j", $output);
		$output = preg_replace("/ĉ/", "ch", $output);
		$output = preg_replace("/ŭ/", "w", $output);
		$output = preg_replace("/ŝ/", "sh", $output);
		return $output;
	}
	function tkpepo($message, $pr)
	{
		if(count(explode(" ", $message))==1)
		{
			$file = fopen("dictionaries/tkpepodict.txt", "r");
			$dictwords = explode("\n", fread($file, filesize("dictionaries/tkpepodict.txt")));
			$new = "";
			$punct = "";
			$msgword = $message;
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
						if(strcont($new, "-"))
							$new = substrToStrpos($new, "-")."o";
					}
				}
				if(!$wordIsTranslatable && $msgword!="e" && $msgword!="li")			//Use original if no translation available
				{
					$new.=$msgword;
				}
				//Add punctuation
				$new.=$punct;
			}
			fclose($file);
			if($pr)
				echo $new;
			return $new;
		}
		//Variable declaration
		$original = $message;
		$partsofspeech = array();
		$clauseinfo = array();
		for($x = 0; $x<4; $x++)
			$clauseinfo[$x] = 0;
//--------------------------------------------RANK 0 MODIFICATIONS: CONSTANTS---------------------------------------------------------------------------------------------------------
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
//------------------------------------------RANK 1 MODIFICATIONS: CLAUSE CLASSIFICATION-----------------------------------------------------------------------------------------------
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
				$clauseinfo[0] =  0.35;
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
//------------------------------------------RANK 2 MODIFICATIONS: PART OF SPEECH IDENTIFICATION---------------------------------------------------------------------------------------
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
//--------------------------------------------RANK 2 MODIFICATIONS: LITERAL WORD REPLACEMENT AND P.O.S. ADDITION----------------------------------------------------------------------
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

	function epotkpWord($word)
	{
		//"http://www.thesaurus.com/browse/".$word."?s=t"
		// $base = 'https://www.googleapis.com/language/translate/v2'.'?key=AIzaSyBoAUVrS3pBR4o6ii0tWBhDhC0Lkakq-RA';				//API Key
		// $start = "eo";	//Starting lang
		// $target = "en";	//Target lang
		// $html = $base.'&source=eo&target=en&callback=translateText&q='.$word;					//Final string
		// echo file_get_contents($html);

		//find synonyms on dictionaries ("see also")
	}

	function epotkp($message, $pr)
	{
		if(count(explode(" ", $message))==1) //One-word queries
		{
			$output = epotkpWord($message);
			if($pr)
				echo $output;
			return $output;
		}
		//Variable declaration
		$original = $message;
		$partsofspeech = array();
		$clauseinfo = array();
		for($x = 0; $x<4; $x++)
			$clauseinfo[$x] = 0;
//--------------------------------------------RANK 0 MODIFICATIONS: CONSTANTS---------------------------------------------------------------------------------------------------------
		$prefixes = "";
		$suffixes = "";
		if(preg_match('/^ĉu\b/', $original))//Yes or no question
		{
			$suffixes = "anu seme?";
			$message = substr($message, 3);
		}
		if(preg_match('/tiel\./', $original))//As well/indeed
		{
			$suffixes = "kin ".$suffeixes;
			$message = substrToStrpos($message, "tiel");		
		}
		$message = preg_replace('/[0] =>/', '', $message);
//------------------------------------------RANK 1 MODIFICATIONS: CLAUSE CLASSIFICATION-----------------------------------------------------------------------------------------------
		//Find tense/time
		$presentprefix = 0;//Default value is 0, if there is a "tenpo ni la" the tense stays 0 but a "now" needs to be added
		if(preg_match('/tenpo .+ la/', $message))
		{
			$clauseinfo[0] = 0;
			//Past
			if(preg_match('/pasinteco/i', "tenpo pini", $message))//General past
				$clauseinfo[0] = -1;
			if(preg_match('/hieraŭ/i', "tenpo suno pini la", $message))//Yesterday
				$clauseinfo[0] = -.3;
			if(preg_match('/lasta nokto/', "tenpo pimeja pini la", $message))//Last night
				$clauseinfo[0] = -.25;			
			if(preg_match('/ĵus/', "tenpo pini lili la", $message))//Recently
				$clauseinfo[0] =  -0.1;
			//Future
			if(preg_match('/baldaŭ/', "tenpo kama lili la", $message))//Soon
				$clauseinfo[0] =  0.1;
			if(preg_match('/ĉinokte/', "tenpo pimeja ni la", $message))//Tonight
				$clauseinfo[0] =  0.25;
			if(preg_match('/morgaŭ nokto/', "tenpo pimeja kama la", $message))//Tonight (alt)
				$clauseinfo[0] =  0.35;
			if(preg_match('/morgaŭ/', "tenpo suno kama la", $message))//Tomorrow
				$clauseinfo[0] = .3;
			if(preg_match('//', "tenpo pini kama la", $message))//Future perfect?
				$clauseinfo[0] = .5;
			if(preg_match('/estonteco/', "tenpo kama", $message))//General future
				$clauseinfo[0] = 1;
			//Present
			if(preg_replace('/hodiaŭ/i', "tenpo suno ni la", $message))//Future today
				$clauseinfo[0] =  0.2;
			if(preg_match('/tenpo ni la/', $message))//Now
			{
				$presentprefix = 1;
				$clauseinfo[0] = 0;
			}
			//Exception cases
			if(preg_replace('/mallongtempe/i', "tenpo lili la", $message))//For a long time
				$clauseinfo[0] = 2;
			if(preg_replace('/longtempe/i', "tenpo suli la", $message))//For a short time
				$clauseinfo[0] = -2;
			//Others can be added, this covers all the basic ones
			//Can be improved with looking at verb tenses to determine tkp tense prefix
		}
		//Find voice/mood?
//-----------------------------------------RANK 2 MODIFICATIONS: PART OF SPEECH IDENTIFICATION----------------------------------------------------------------------------------------
		$messagewords = explode(" ", $message);
		//Subject + Adjectives
		$firstword = $messagewords[0];
		$subject = "";
		$subjectwords = explode(" ", $subject);
		$partsofspeech[0] = "nou";
		for($x = 1; $x<sizeof($subjectwords); $x++)
		{
			$partsofspeech[$x] = "adj";
		}
		//Verb + Adverbs
		$verb = "";
		$verbwords = explode(" ", $verb);
		$partsofspeech[0] = "ver";
		$partsofspeech[0] = "adv";
		//Object + Adjectives
		$object = "";
		$objectwords = explode(" ", $object);
		$partsofspeech[0] = "oth";
		$partsofspeech[0] = "nou";
		$partsofspeech[0] = "adj";
//-----------------------------------------RANK 2 MODIFICATIONS: COMMON COMPOUND WORDS------------------------------------------------------------------------------------------------
		//do this at some point
//-------------------------------------------RANK 2 MODIFICATIONS: LITERAL WORD REPLACEMENT AND P.O.S. ADDITION-----------------------------------------------------------------------
		//Look for synonyms of epo words
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
				//"http://www.thesaurus.com/browse/word?s=t"
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
			$caps = 0;
			if($word!=strtolower($word))
				$caps = 1;
			$word = strtolower($word);

			$extras='';
			$w = substr($word, 0, strlen($word)-1);
			if(strcont($word, '.'))
				$extras.='.';
			else if(strcont($word, ','))
				$extras.=',';
			else if(strcont($word, ';'))
				$extras.=';';
			else if(strcont($word, '\"'))
				$extras.='\"';
			else if(strcont($word, '\n'))
				$extras.='\n';
			else
				$w = $word;
			$html = getHTML("https://glosbe.com/ia/eo/$w", 20);
			if(preg_match("/(?<=(phr\">))(\w+)(?=(<\/strong))/", $html, $matches))
			{
				if($pr)
				{
					echo $matches[2].$extras." ";
				}
				$output.=$matches[2].$extras." ";
			}
			else
			{
				if($pr)
				{
					echo $w.$extras." ";
				}
				$output.=$w.$extras." ";
			}
		}
		return $output;
	}

	// function epotkp($message, $pr)
	// {
	// 	$original = $message;
	// 	if($pr)
	// 	{
	// 		echo $message;
	// 	}
	// 	return $message;
	// }

	//Natural languages
	function eponat($message, $pr)
	{
		// Done in javascript on translator
		$message = preg_replace( "/\r|\n/", "", $message);
		echo "<script type='text/javascript'>translateNat(\"".$message."\");</script>";
		return $message;
	}
	function natepo($message, $pr)
	{
		// Done in javascript on translator
		$message = preg_replace( "/\r|\n/", "", $message);
		echo "<script type='text/javascript'>translateNat(\"".$message."\");</script>";
		return $message;
	}
	function connat($lang, $message, $pr)
	{
		if($lang=="epo")
		{
			return eponat($message, $pr);
		}
		else
		{
			$funct = $lang."epo";				//Language to epo function
			eponat($funct($message, 0), $pr);	//Language to epo to nat
		}
	}
	function detnat($message, $pr)
	{
		connat(detectLanguage($message), $message, $pr);
	}
	function natnat($message, $pr)
	{
		echo "<script type='text/javascript'>translateNat(\"".$message."\");</script>";
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

	//Detect Language
	function dettkp($message, $pr)
	{
		$function = detectLanguage($message)."tkp";
		$function($message, $pr);
	}
	function detepo($message, $pr)
	{
		$function = detectLanguage($message)."epo";
		if($function=="epoepo")
		{
			if($pr)
				echo $message;
			return $message;
		}
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
		connat(substr($translatecode, 0, 3), $message, 1);
	else
		$translatecode($message, 1);
?>