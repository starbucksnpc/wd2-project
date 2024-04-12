<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php


// if (isset($_SESSION['username'])) {
//   header("location: http://localhost:31337/project/index.php");
// }

if (!isset($_SESSION['adminname'])) {
  header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
}


if (isset($_POST['submit'])) {

  if ($_POST['name'] == '') {
    $errorMessage =  "Enter data into the inputs.";
  } else {
    $name = $_POST['name'];


    $insert = $conn->prepare("INSERT INTO categories (name) VALUES(:name)");

    $insert->execute([
      ':name' => $name,
    ]);

    // Redirect to login page after successful creating category
    //header("location: http://localhost:31337/project/admin-panel/categories-admins/create-category.php");
  }
}

?>


<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Create Categories</h5>
        <form method="POST" action="create-category.php">

          <!-- If you do not input -->
          <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo $errorMessage; ?>
            </div>
          <?php endif; ?>

          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
          </div>
          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Create</button>


        </form>

      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>