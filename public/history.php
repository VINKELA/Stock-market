<?php


// configuration
require("../includes/config.php");


// if user reached page via GET (as by clicking a link or via redirect)
if (empty($_SESSION["id"]))
{

    // else render form
    redirect("/");

}
// else if user reached page via POST (as by submitting a form via POST)
else
{
         $rows = query("SELECT * FROM history WHERE id = ?",$_SESSION["id"] );
     
         render("history.php",["title" => "History","rows" => $rows]); 

}

?>
