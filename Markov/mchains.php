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