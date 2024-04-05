<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>



<?php
// Redirect if user is already logged in
if(isset($_SESSION['adminname'])) {
  header("location: http://localhost:31337/project/admin-panel/index.php");
}

// Check if form is submitted
if (isset($_POST['submit'])) {
  // Check if email and password are provided
  if ($_POST['email'] == '' or $_POST['password'] == '') {
    $errorMessage = "One or more inputs are empty.";
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $conn->query("SELECT * FROM admins WHERE email = '$email'");

    $login->execute();

    $row = $login->FETCH(PDO::FETCH_ASSOC);

    // Check if user exists
    if ($login->rowCount() > 0) {
      // Verify password
      if (password_verify($password, $row['mypassword'])) {
        // echo "logged in";

        $_SESSION['adminname'] = $row['adminname'];
        $_SESSION['admin_id'] = $row['id'];


        header('location: http://localhost:31337/project/admin-panel/index.php');
        //exit; //Exit to prevent further execution
      } else {
        //Incorrect password
        $errorMessage = "Incorrect email or password. Please try again.";
      }
    } else {
      // User not found
      $errorMessage = "You do not have access permissions.";
    }
  }
}




?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mt-5">Login</h5>
        <form method="POST" class="p-auto" action="login-admins.php">

          <!-- Login failure message -->
          <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo $errorMessage; ?>
            </div>
          <?php endif; ?>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />

          </div>


          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />

          </div>



          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>


        </form>

      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>