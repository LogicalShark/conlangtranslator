<?php
function createTable($input, $look_forward) 
{
    $table = array();
    //Make the index table
    for ($i = 0; $i<strlen($input); $i++)
    {
        $char = substr($input, $i, $look_forward);
        if (!isset($table[$char]))
        	$table[$char] = array();
    }              
    //Count the numbers
    for ($i = 0; $i<(strlen($input) - $look_forward); $i++) 
    {
        $char_index = substr($input, $i, $look_forward);
        $char_count = substr($input, $i+$look_forward, $look_forward);
        
        if (isset($table[$char_index][$char_count])) 
            $table[$char_index][$char_count]++; 
        else
            $table[$char_index][$char_count] = 1;            
    } 
    return $table;
}

function createText($first, $length, $table, $look_forward) 
{
    $char = $first; //First character
    if($first==' ')
    {
    	$char = array_rand($table);
    }
    $output = $char;
    for ($i = 0; $i<($length/$look_forward); $i++) 
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
    

function return_weighted_char($array) {
    if (!$array) return false;
    
    $total = array_sum($array);
    $rand  = mt_rand(1, $total);
    foreach ($array as $item => $weight) {
        if ($rand <= $weight) return $item;
        $rand -= $weight;
    }
}

/*
	Heavily based on:
    PHP Markov Chain text generator 1.0
    Copyright (c) 2008, Hay Kranen <http://www.haykranen.nl/projects/markov/>
    License (MIT / X11 license)    
    Permission is hereby granted, free of charge, to any person
    obtaining a copy of this software and associated documentation
    files (the "Software"), to deal in the Software without
    restriction, including without limitation the rights to use,
    copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following
    conditions:    
    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

*/

?>

