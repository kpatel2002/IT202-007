<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
//Note: we have this up here, so our update happens before our get/fetch
//that way we'll fetch the updated data and have it correctly reflect on the form below
//As an exercise swap these two and see how things change
if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You must be logged in to access this page");
    die(header("Location: login.php"));
}

$db = getDB();
//save data if we submitted the form
if (isset($_POST["saved"])) {
    $isValid = true;
    //check if our email changed
    $newEmail = get_email();
    if (get_email() != $_POST["email"]) {
        //TODO we'll need to check if the email is available
        $email = $_POST["email"];
        $stmt = $db->prepare("SELECT COUNT(1) as InUse from Users where email = :email");
        $stmt->execute([":email" => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $inUse = 1;//default it to a failure scenario
        if ($result && isset($result["InUse"])) {
            try {
                $inUse = intval($result["InUse"]);
            }
            catch (Exception $e) {

            }
        }
        if ($inUse > 0) {
            flash("Email already in use");
            //for now we can just stop the rest of the update
            $isValid = false;
        }
        else {
            $newEmail = $email;
        }
    }
    $newUsername = get_username();
    if (get_username() != $_POST["username"]) {
        $username = $_POST["username"];
        $stmt = $db->prepare("SELECT COUNT(1) as InUse from Users where username = :username");
        $stmt->execute([":username" => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $inUse = 1;//default it to a failure scenario
        if ($result && isset($result["InUse"])) {
            try {
                $inUse = intval($result["InUse"]);
            }
            catch (Exception $e) {

            }
        }
        if ($inUse > 0) {
            flash("Username already in use");
            //for now we can just stop the rest of the update
            $isValid = false;
        }
        else {
            $newUsername = $username;
        }
    }
    if ($isValid) {
        $stmt = $db->prepare("UPDATE Users set email = :email, username= :username where id = :id");
        $r = $stmt->execute([":email" => $newEmail, ":username" => $newUsername, ":id" => get_user_id()]);
        if ($r) {
            flash("Updated profile");
        }
        else {
            flash("Error updating profile");
        }
        //password is optional, so check if it's even set
        //if so, then check if it's a valid reset request
        if (!empty($_POST["password"]) && !empty($_POST["confirm"])) {
            if ($_POST["password"] == $_POST["confirm"]) {
                $password = $_POST["password"];
                $hash = password_hash($password, PASSWORD_BCRYPT);
                //this one we'll do separate
                $stmt = $db->prepare("UPDATE Users set password = :password where id = :id");
                $r = $stmt->execute([":id" => get_user_id(), ":password" => $hash]);
                if ($r) {
                    flash("Reset Password");
                }
                else {
                    flash("Error resetting password");
                }
            }
        }
//fetch/select fresh data in case anything changed
        $stmt = $db->prepare("SELECT email, username from Users WHERE id = :id LIMIT 1");
        $stmt->execute([":id" => get_user_id()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $email = $result["email"];
            $username = $result["username"];
            //let's update our session too
            $_SESSION["user"]["email"] = $email;
            $_SESSION["user"]["username"] = $username;
        }
    }
    else {
        //else for $isValid, though don't need to put anything here since the specific failure will output the message
    }
}


?>

    <form method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo(get_email()); ?>"/>
        <label for="username">Username</label>
        <input type="text" maxlength="60" name="username" value="<?php echo(get_username()); ?>"/>
        <!-- DO NOT PRELOAD PASSWORD-->
        <label for="pw">Password</label>
        <input type="password" name="password"/>
        <label for="cpw">Confirm Password</label>
        <input type="password" name="confirm"/>
        <input type="submit" name="saved" value="Save Profile"/>
    </form>
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