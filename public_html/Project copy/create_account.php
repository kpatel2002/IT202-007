<?php require_once(__DIR__ . "/partials/nav.php"); ?>

<form method="POST">
  <label> Account Number </label>
  <input type="number" name="account_number" disabled value="<?php $randNumber = rand(100000000000,1000000000000); echo $randNumber;?>" />
  <label>Account Type</label>
  <select name="account_type">
    <option value = "checking">checking</option>
    <option value =  "saving">saving</option>
    <option value = "loan">loan</option>
   
  </select>
  <label>Balance</label>
  <input type="number" min="10.00" name="balance" value="<?php echo $result["balance"];?>" />
	<input type="submit" name="save" value="Create"/>
</form>

<?php 

if(isset($_POST["save"])){
        $account_type = $_POST["account_type"]; 
    $user= get_user_id();
    $balance = $_POST["balance"];
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Accounts (account_number, account_type, user_id, balance) VALUES(:account_number, :account_type, :user, :balance)");
    $r = $stmt->execute([
        ":account_number" => $randNumber,
        ":account_type"=> $account_type,
        ":user" => $user,
        ":balance" => $balance
    ]);

    if($r){
      flash("Created successfully with id: " . $db->lastInsertId());
    }
    else{
      $e = $stmt->errorInfo();
      flash("Error creating: " . var_export($e, true));
    }

}   

?> 
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