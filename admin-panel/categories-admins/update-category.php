<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if (isset($_GET['up_id'])) {
  $id = filter_input(INPUT_GET, 'up_id', FILTER_VALIDATE_INT);


  if (!isset($_SESSION['adminname'])) {
    header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
  }
  
  // First query to fetch the existing post details
  
  $select = $conn->prepare("SELECT * FROM categories WHERE id = '$id'");
  $select->execute();
  $rows = $select->fetch(PDO::FETCH_OBJ);



  //categories
  $categories = $conn->query("SELECT * FROM categories");
  $categories->execute();
  $category = $categories->fetchAll(PDO::FETCH_OBJ);



  // Second query
  if (isset($_POST['submit'])) {
    if ($_POST['name'] == '' ) {
      echo "<div class='alert alert-danger text-center role='alert'> Enter data into the inputs. </div>";
    } else {

      $name = $_POST['name'];
 
      $update = $conn->prepare("UPDATE categories SET name = :name WHERE id = '$id'");

      $update->execute([
        ':name' => $name,
        ':id' => $id
      ]);

      //header('location: http://localhost:31337/project/admin-panel/categories-admins/show-categories.php');
    }
  }
} else {
  header('location: http://localhost:31337/project/404.php');
}

?>



<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Update Categories</h5>
        <form method="POST" >
        <?php if ($rows) : ?>
          <!-- Email input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" value="<?php echo $rows->name; ?>" name="name" id="form2Example1" class="form-control" placeholder="name" />

          </div>


          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
          <?php else : ?>
            <div class='alert alert-danger text-center' role='alert'> Category not found. </div>
          <?php endif; ?>

        </form>

      </div>
    </div>
  </div>
</div>
<?php require "../layouts/footer.php"; ?>