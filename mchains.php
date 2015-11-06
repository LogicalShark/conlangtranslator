<?php
require 'markov.php';

if (isset($_POST['submit'])) {
    $order  = $_REQUEST['order'];
    $length = $_REQUEST['length'];
    $input  = $_REQUEST['input'];
    $ptext  = $_REQUEST['text'];
    if ($input) $text = $input;
    if ($ptext) $text = file_get_contents("text/".$ptext.".txt");
    if(isset($text)) 
    {
        $markov_table = generate_markov_table($text, $order);
        $markov = generate_markov_text($length, $markov_table, $order);
        if (get_magic_quotes_gpc())
            $markov = stripslashes($markov);
    }
}
?>
<html>
<head>
    <title>Markov Chain Generator</title>
</head>
<body>
    <form method="post" action="" name="markov">
        Input
        <br>
        <textarea type="text" name="input" rows="20" cols="60"></textarea>
        <br>
        Order
        <input type="text" name="order">
        <br>
        Length
        <input type="text" name="length">
        <br>
        <input type="submit" name="submit" value="Submit"/>
    </form>
    <br>
    Output
    <br>
    <textarea rows="40" cols="60">
    <?php  
        if(isset($markov))
            echo $markov;
    ?>
    </textarea>
</body>
</html>