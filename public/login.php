<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_conn.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
$username = "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);



  if (empty($errors)) {
    // Attempt Login

		$username = $_POST["username"];
		$password = $_POST["password"];

    debug_to_console($_POST);
		
		$found_admin = attempt_login($username, $password);

    debug_to_console($found_admin);

    if ($found_admin) {
      // Success
			// Mark user as logged in
			$_SESSION["admin_id"] = $found_admin["id"];
			$_SESSION["username"] = $found_admin["user_name"];
      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Login</h2>
    <form action="login.php" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Submit" />
    </form>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
