<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php

if (!isset($_SESSION['adminname'])) {
  header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
}

if (isset($_POST['submit'])) {

  if ($_POST['email'] == '' or $_POST['username'] == '' or $_POST['password'] == '') {
    $errorMessage =  "Enter data into the inputs.";
  } else {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $insert = $conn->prepare("INSERT INTO users (email, username, mypassword) VALUES(:email, :username, :mypassword)");

    $insert->execute([
      ':email' => $email,
      ':username' => $username,
      ':mypassword' => $password
    ]);

    // Redirect to login page after successful creating admin
    //header("location: http://localhost:31337/project/admin-panel/index.php");
  }
}

?>


<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title mb-5 d-inline">Create Users</h5>
        <form method="POST" action="create-users.php">
          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />

          </div>

          <div class="form-outline mb-4">
            <input type="text" name="username" id="form2Example1" class="form-control" placeholder="username" />
          </div>
          <div class="form-outline mb-4">
            <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
          </div>

          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Create</button>


        </form>

      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>