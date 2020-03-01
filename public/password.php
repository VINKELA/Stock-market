<?php


// configuration
require("../includes/config.php");


// if request is a GET request 
if ($_SERVER["REQUEST_METHOD"] == "GET")
{       
	// present form to user
    render("password.php", ["title" =>"change password"]);
}
// if a post request
else
{
	//if username is empty apologise
	if (empty($_POST["username"]))
	{
	apologize("You must provide your username.");
	}
	// if new password is empty apologize
	if (empty($_POST["npassword"]))
	{
	apologize("You must provide your username.");
	}
	// if comfirmation of password is empty, appologize
	if (empty($_POST["comfirmation"]))
	{
	apologize("You must provide your password comfirmation.");
	}
	if($_POST["comfirmation"] != $_POST["npassword"])
	{
		apologize("password and comfirmation do not match");
	}
	$rows = query("SELECT * FROM users WHERE username = ?",$_POST["username"]); 
	if($rows === false)
	{
	apologize("this shoudnt happen");
	}
	$row = $rows[0];

	if($_POST["npassword"] != $_POST["comfirmation"])
	{
	apologize("New password do not match its comfirmation");
	}
	$_SESSION["id"] = $row["id"];
	query("UPDATE users SET hash = ? WHERE id = ? ",crypt($_POST["npassword"]),$_SESSION["id"]);
	redirect("/");
	}

?>
