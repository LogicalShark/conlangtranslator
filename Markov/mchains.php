<?php
require 'markov.php';

if (isset($_POST['submit'])) 
{
    $order  = $_REQUEST['order'];
    $length = $_REQUEST['length'];
    $input  = $_REQUEST['input'];
    $first = $_REQUEST['first'];
    $text = $input;
    if(isset($text)) 
    {
        $markov_table = createTable($text, $order);
        $markov = createText($first, $length, $markov_table, $order);
        if (get_magic_quotes_gpc())
            $markov = stripslashes($markov);
    }
}
?>
<html>
<head>
    <title>Markov Chains</title>
</head>
<body>
<h1>Markov Chains</h1><br>
<p>Instructions: Input some text, more is better. 
<br>Order -- How close it is to the original text. 2-: Gibberish, 3:Nonsensical, 4/5:Generally Optimal, 6+:Close to Original. 
<br>Length -- The number of characters outputted.
<br>Starting seed -- The first characters of the output, generation will procede from there.</p><br>
    <form method="post" action="" name="markov">
        Input:
        <br>
        <textarea type="text" name="input" rows="20" cols="60"></textarea>
        <br>
        Order:
        <input type="text" name="order">
        <br>
        Length:
        <input type="text" name="length">
        <br>
        Starting seed (Length must be less than order):
        <input type="text" name="first">
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