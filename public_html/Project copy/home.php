<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
//we use this to safely get the email to display
$email = "";
if (isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])) {
    $email = $_SESSION["user"]["email"];
}
?>
    <p>Welcome, <?php echo $email; ?></p>

    <style>
        body {
    margin: 0px;
    }
    
    nav {
    font-family: Arial, sans-serif;
    font-weight: 10;
    }
    
    ul {
    height: 3em;
        display: flex;
        justify-content: space-around;
        list-style: none;
        align-items: center;
    background: black;
    }
    
    ul a {
    color: white;
    text-decoration: none;
    }
    
    .container {
    	width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
    }
    .card {
		width: 30em;
		padding: 2em;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		border-radius: 10px;
    }
	.inp_fld {
        border: solid 1px gray;
		border-radius: 5px;
		margin: 1em;
		height: 35px;
		width: 285px;
		padding-left: 25px;
    }
	
	.inp_btn {
		border: none;
		background-color: black;
		border-radius: 5px;
		margin: 1em;
		height: 35px;
		width: 285px;
		color: white;
		font-weight: bold;
	}
	
	h2 {
		font-family: Arial, sans-serif;
	}
    </style>
<?php require(__DIR__ . "/partials/flash.php");