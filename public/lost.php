<?php
// configuration
require("../includes/config.php");
require("libphp-phpmailer/class.phpmailer.php");
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    render("lost_form.php", ["title" => "Send password"]);
}
// else if user reached page via POST (as by submitting a form via POST)
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{

if(empty($_POST["email"]))
{
    apologize("Email is empty");
}

if(empty($_POST["comfirmation"]))
{
    apologize("confirm Email");
}

if($_POST["comfirmation"] != $_POST["email"])
{
    apologize("Email and Comfirmation do not match");
}
    
    $row = query("SELECT hash FROM users WHERE email = ?",$_POST["email"]);
    if($row === false)
    {
        apologize("email doesnot exist");
    }
    $rows = $row[0];
    $password = crypt($rows["hash"]);
    
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com"; // change to your email host
    $mail->Port = 587; // change to your email port
    $mail->Username = "orjikalukelvin@gmail.com"; // change to your username
    $mail->Password = "venuse123"; // change to your email password
    $mail->setFrom("orjikalukelvin@gmail.com"); // change to your email password
    $mail->AddAddress($_POST["email"]); // change to user's email address
    $mail->Subject = "CHANGE PASSWORD"; // change to email's subject
    $mail->Body = "Follow the link http://pset7/password.php  to change your password "; // change to email's body, add the needed link here

    if ($mail->Send() == false)
    {
        die($mail->ErrInfo);
    }
    
    redirect("index.php");
}


?>
