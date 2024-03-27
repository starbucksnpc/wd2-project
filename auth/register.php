<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

// Redirect if user is already logged in
if (isset($_SESSION['username'])) {
  header("location: http://localhost:31337/project/index.php");
}

if (isset($_POST['submit'])) {

  if ($_POST['email'] == '' or $_POST['username'] == '' or $_POST['password'] == '') {
    echo "type something in the inputs.";
  } else {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
      $errorMessage = "Passwords do not match. Please try again.";
    } else {
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      $insert = $conn->prepare("INSERT INTO users (email, username, mypassword) VALUES(:email, :username, :mypassword)");

      $insert->execute([
        ':email' => $email,
        ':username' => $username,
        ':mypassword' => $passwordHash
      ]);

      // Redirect to login page after successful registration
      header("location: ../auth/login.php");
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">
  
<form method="POST" action="register.php">
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />

  </div>

  <div class="form-outline mb-4">
    <input type="text" name="username" id="form2Example1" class="form-control" placeholder="Username" />

  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />

  </div>

  <!-- Confirm Password input -->
  <div class="form-outline mb-4">
    <input type="password" name="confirm_password" id="form2Example3" placeholder="Confirm Password" class="form-control" />
  </div>

  <!-- Error message -->
  <?php if (isset($errorMessage)) : ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $errorMessage; ?>
    </div>
  <?php endif; ?>

  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Register</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Already a member? <a href="login.php">Login</a></p>



  </div>
</form>



<?php require "../includes/footer.php"; ?>