<?php
function wikiPurify($raw)
{
	//Remove beginn of article
	$raw = preg_replace("/^.*\'\'\'/", "", $raw);											//'''
	//Remove end of article
	$raw = preg_replace("/{{Port.*$/i", "", $raw);											//Portal
	$raw = preg_replace("/==.*$/i", "", $raw);												//==
	//Links
	$raw = preg_replace("/https?:\/\/(\d|%|\w|\.|\/)+/i", "", $raw); 						//https?:
	$raw = preg_replace("/[^ ]+\.((php)|(html?))/i", "", $raw); 							//php/html/htm
	//Pics
	$raw = preg_replace("/[^ ]+\.((png)|(jpe?g)|(gif))/i", "", $raw); 						//png/jpg/gif
	$raw = preg_replace("/[0-9]+px/i", "", $raw); 											//px
	$raw = preg_replace("/file:/i", "", $raw); 												//file:
	$raw = preg_replace("/image\w*/i", "", $raw);											//image
	//Misc formatting
	$raw = preg_replace("/width:\d\d?\d?%/i", "", $raw);									//width
	$raw = preg_replace("/height:\d\d?\d?%/i", "", $raw);									//height
	$raw = preg_replace("/table./i", "", $raw);												//table
	$raw = preg_replace("/style((background)|(width)|(height)):\#(\w|,|;)+/i", "", $raw);	//stylebackground/width/height
	$raw = preg_replace("/align((center)|(left)|(right)) (\d+)?/i", "", $raw);				//align
	$raw = preg_replace("/align((center)|(left)|(right))/i", "", $raw);						//align2
	$raw = preg_replace("/scale(major|minor) unit:\w+ increment:\d+ start:\d+/i", "", $raw);//scale
	$raw = preg_replace("/legend position:/i", "", $raw);									//legend
	$raw = preg_replace("/(layer)|(color)|(id):\w+/i", "", $raw);							//layer/color/id
	$raw = preg_replace("/(row|col)span./", "", $raw);										//rowspan/colspan
	$raw = preg_replace("/category:?/", "", $raw);											//category
	$raw = preg_replace("/rd\d(\w|-)+/i", "", $raw);										//rd
	$raw = preg_replace("/[a-zA-z]+\d+/i", "", $raw);										//rd
	//Books
	$raw = preg_replace("/isbn [0-9 -]+/", "", $raw); 										//isbn
	//Misc symbols
	$raw = preg_replace("/(\[\[)|(\]\]?)/", "", $raw);										//[[  ]]
	$raw = preg_replace("/\{\{.*\}\}/", "", $raw);											//{{  }}
	$raw = preg_replace("/<.*>/", "", $raw);												//<  >
	$raw = preg_replace("/\'|=|\*/", "", $raw);												//' = *
	$raw = preg_replace("/!--/", "", $raw);													//!--	
	$raw = preg_replace("/\|/", "", $raw);													//\

	$raw = preg_replace("/\n\n+/", "\n", $raw);												//\n\n+

	return $raw;
}

function randomFile($dir = 'Markov/tkpcorp')
{
    $files = glob($dir . '/*.*');
    $file = array_rand($files);
    return $files[$file];
}

function createTable($input, $order=4, $text)
{
	if($text!="Text")
	{
		$corp = "";
		switch($text)
		{
			case "Esperanto Corpus":
				$corp = "Markov/epocorp";
				//Wikipedia
				break;
			case "toki pona Corpus":
				$corp = "Markov/tkpcorp";
				//Found at http://forums.tokipona.org/viewtopic.php?t=1343
				//All files at least 2KB, unmodified version is ogtkpcorp
				break;
			case "Interlingua Corpus":
				$corp = "Markov/ilacorp";
				//Wikipedia
				break;
			case "Ido Corpus":
				$corp = "Markov/idocorp";
				//Wikipedia
				break;
			case "English Corpus":
				$corp = "Markov/engcorp";
				//Wikipedia
				break;
			case "De Bello Gallico I":
				$corp = "Markov/dbg.txt";
				//J Caesar "Comentarii de Bello Galilco" Book 1
				break;
			case "Donald Trump Tweets":
				$corp = "Markov/trumptweet.txt";
				//twitter.com/realdonaldtrump
				break;
			case "TJCrushes Posts":
				$corp = "Markov/TJCrushes2.txt";
				//From their FB page
				break;
			case "1984 Full Text":
				$corp = "Markov/1984.txt";
				//Orwell 1984 found online
				break;
			case "US University List":
				$corp = "Markov/colleges.txt";
				//List of all universities in the U.S.
				break;
			case "Hearthstone Cards":
				$corp = "Markov/hearth.json";
				//All Hearthstone cards before WOTOG, from https://raw.githubusercontent.com/pdyck/hearthstone-db/master/cards/all-cards.json
				break;
			default:
				$corp = "Markov/trumptweet.txt";
		}
		if(preg_match("/tkp/", $corp)) //toki pona
		{
			//combine 3 random texts for the corpus
			$file1 = randomFile($corp);
			$file2 = randomFile($corp);
			$file3 = randomFile($corp);
			while($file1==$file2)
				$file2 = randomFile($corp);
			while($file1==$file3 || $file2==$file3)
				$file3 = randomFile($corp);
			
			$fcorp1 = fopen($file1, "r");
			$input .= fread($fcorp1, filesize($file1));
			fclose($fcorp1);

			$fcorp2 = fopen($file2, "r");
			$input .= fread($fcorp2, filesize($file2));
			fclose($fcorp2);

			$fcorp3 = fopen($file3, "r");
			$input .= fread($fcorp3, filesize($file3));
			fclose($fcorp3);

			if(strlen($input)<10000)
			{
				$file4 = randomFile($corp);
				$file5 = randomFile($corp);
				while($file1==$file4 || $file2==$file4 || $file3==$file4)
					$file4 = randomFile($corp);
				while($file1==$file5 || $file2==$file5 || $file3==$file5 || $file4==$file5)
					$file5 = randomFile($corp);

				$fcorp4 = fopen($file4, "r");
				$input .= fread($fcorp4, filesize($file4));
				fclose($fcorp4);
			
				$fcorp5 = fopen($file5, "r");
				$input .= fread($fcorp5, filesize($file5));
				fclose($fcorp5);
			}
		}
		else if(preg_match("/corp/", $corp)) //Wikipedia-based
		{
			if(preg_match("/epo/", $corp))
				$lang = "eo";
			if(preg_match("/ido/", $corp))
				$lang = "io";
			if(preg_match("/ila/", $corp))
				$lang = "ia";
			if(preg_match("/eng/", $corp))
				$lang = "en";

			$xml = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&list=random&rnlimit=20&rnnamespace=0&format=xml"); //20 articles
			for($x = 0; $x<20; $x++)
			{
				$title = $xml->query->random->page[$x]['title'];
				// echo $title;
				$xml2 = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&titles=".urlencode($title)."&prop=revisions&rvprop=content&format=xml");
				$wikitext = wikiPurify($xml2->query->pages->page->revisions->rev);
				if(strlen($wikitext)>2000)
					$input .= $wikitext;
			}
			$xml = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&list=random&rnlimit=20&rnnamespace=0&format=xml"); //20 articles
			for($x = 0; $x<20; $x++)
			{
				$title = $xml->query->random->page[$x]['title'];
				// echo $title;
				$xml2 = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&titles=".urlencode($title)."&prop=revisions&rvprop=content&format=xml");
				$wikitext = wikiPurify($xml2->query->pages->page->revisions->rev);
				if(strlen($wikitext)>2000)
					$input .= $wikitext;
			}
			$xml = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&list=random&rnlimit=20&rnnamespace=0&format=xml"); //20 articles
			for($x = 0; $x<20; $x++)
			{
				$title = $xml->query->random->page[$x]['title'];
				// echo $title;
				$xml2 = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&titles=".urlencode($title)."&prop=revisions&rvprop=content&format=xml");
				$wikitext = wikiPurify($xml2->query->pages->page->revisions->rev);
				if(strlen($wikitext)>2000)
					$input .= $wikitext;
			}

			if(strlen($input)<10000) //min length
			{
				$xml = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&list=random&rnlimit=10&rnnamespace=0&format=xml");
				for($x = 0; $x<10; $x++)
				{
					$title = $xml->query->random->page[$x]['title'];
					// echo $title;
					$xml2 = simplexml_load_file("https://".$lang.".wikipedia.org/w/api.php?action=query&titles=".urlencode($title)."&prop=revisions&rvprop=content&format=xml");
					$input .= wikiPurify($xml2->query->pages->page->revisions->rev);
				}
			}
		}
		else if(preg_match("/trump/", $corp))
		{
			$file1 = "Markov/trumptweet.txt";
			$fcorp1 = fopen($file1, "r");
			$input .= fread($fcorp1, filesize($file1));
			fclose($fcorp1);
			$file2 = "Markov/trumptweet2.txt";
			$fcorp2 = fopen($file2, "r");
			$input .= fread($fcorp2, filesize($file2));
			fclose($fcorp2);
		}
		else if(preg_match("/hearth/", $corp))
		{
			$file1 = $corp;
			$fcorp1 = fopen($file1, "r");
			$jcards = json_decode(fread($fcorp1, filesize($file1)));
			fclose($fcorp1);
			foreach($jcards->cards as $card)
			{
				$input.=" | | | ".($card->name).": (".($card->mana).") ".($card->attack)."/".($card->health)." --- ".($card->description);
			}
			$input = preg_replace("/<b>/", "", $input);
			$input = preg_replace("/<..+b>/", "", $input);
			$input = preg_replace("/ \/ /", " ", $input);
			$input = preg_replace("/\/b/", "", $input);
			$input = preg_replace("/b(?=(\w+ ))/", "", $input);
		}
		else
		{
			$file1 = $corp;
			$fcorp1 = fopen($file1, "r");
			$input .= fread($fcorp1, filesize($file1));
			fclose($fcorp1);
		}
		//Optional style modifications: all lowercase, no weird characters
		if(!preg_match("/(trump)|(colleges)/", $corp))
			$input = strtolower($input);
		if(!preg_match("/(colleges)/", $corp))
			$input = preg_replace("/\[|\]|\(|\)|\_|\"|\{|\}|<|>|~|\'/", "", $input);
	}
	if(!isset($input))
		return;
	$table = array();
	//Make the index table
	for ($i = 0; $i<strlen($input); $i++)
	{
		$char = substr($input, $i, $order);
		if(!isset($table[$char]))
			$table[$char] = array();
	}
	//Count the numbers
	for ($j = 0; $j<(strlen($input) - $order); $j++)
	{
		$index = substr($input, $j, $order);
		$char_count = substr($input, $j+$order, $order);
		if (isset($table[$index][$char_count]))
			$table[$index][$char_count]++;
		else
			$table[$index][$char_count] = 1;
	}
	return $table;
}

function createText($first=' ', $length=2000, $table, $order=4, $text)
{
	$chars = $first;
	if($first==' ')
	{
		$chars = array_rand($table);
	}
	$output = $chars;
	for ($k = 0; $k<($length/$order); $k++)
	{
		$newchars = createNextChars($table[$chars]);
		
		if ($newchars)
		{
			$chars = $newchars;
			$output .= $newchars;
		}
		else
		{
			$chars = array_rand($table);
		}
	}
	//Hearthstone card formatting
	if(preg_match("/Hearth/", $text))
	{
		$output = preg_replace("/(\| )+/", "<br>|||", $output);
		$output = preg_replace("/<br>\|\|\|(^:)+<br>/", "<br>", $output);
	}
	$output = preg_replace("/\n/", "<br>", $output);		
	return $output;
}
	

function createNextChars($array)
{
	if(!isset($array))
		return;
	$total = array_sum($array);
	$rand  = mt_rand(1, $total);
	foreach ($array as $item => $weight)
	{
		if ($rand <= $weight)
			return $item;
		$rand -= $weight;
	}
}
?>