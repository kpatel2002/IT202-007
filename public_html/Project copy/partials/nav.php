<?php
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/Project",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();
require_once(__DIR__ . "/../lib/functions.php");

?>
<!-- include css and js files -->
<link rel="stylesheet" href="<?php echo get_url('styles.css'); ?>">
<script src="<?php echo get_url('helpers.js'); ?>"></script>
<nav>
    <ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="create_account.php">Create Account</a></li>
            <li><a href="edit_account.php">Edit Account</a></li>
            <li><a href="list_account.php">List Account</a></li>
            <li><a href="create_transactions.php">Create Transactions</a></li>
            <li><a href="list_transactions.php">List Transactions</a></li>
            <li><a href="reset_password.php">Reset Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
        <?php if (!is_logged_in()) : ?>
            <li><a href="<?php echo get_url('login.php'); ?>">Login</a></li>
            <li><a href="<?php echo get_url('register.php'); ?>">Register</a></li>
        <?php endif; ?>
        <?php if (is_logged_in()) : ?>
            <li><a href="<?php echo get_url('logout.php'); ?>">Logout</a></li>
        <?php endif; ?>
        
        
    </ul>
</nav>