<?php
function createTable($input, $order=4) 
{
    if(!isset($input))
        return 0;
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

function createText($first=' ', $length=1000, $table, $order=4) 
{
    $char = $first; //First character
    if($first==' ')
    {
    	$char = array_rand($table);
    }
    $output = $char;
    for ($k = 0; $k<($length/$order); $k++) 
    {
        $newchar = return_weighted_char($table[$char]);            
        
        if ($newchar) 
        {
            $char = $newchar;
            $output .= $newchar;
        } 
        else 
        {       
            $char = array_rand($table);
        }
    }
    
    return $output;
}
    

function createNextChars($array) 
{
    $total = array_sum($array);
    $rand  = mt_rand(1, $total);
    foreach ($array as $item => $weight) 
    {
        if ($rand <= $weight) return $item;
        $rand -= $weight;
    }
}
?>

