<?php
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
				break;
			case "toki pona Corpus":
				$corp = "Markov/tkpcorp";
				//Found at http://forums.tokipona.org/viewtopic.php?t=1343
				//All files at least 2KB, unmodified version is ogtkpcorp
				break;
			case "Interlingua Corpus":
				$corp = "Markov/ilacorp";
				break;
			case "Ido Corpus":
				$corp = "Markov/idocorp";
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
			default:
				$corp = "Markov/trumptweet.txt";
		}
		//combine 3 random texts for the corpus
		$file1 = randomFile($corp);
		$file2 = randomFile($corp);
		$file2 = randomFile($corp);
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

		//Optional style modifications: all lowercase, no weird characters
		$input = strtolower($input);
		$input = preg_replace("/\[|\]|\(|\)|\_|\"/", "", $input);
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