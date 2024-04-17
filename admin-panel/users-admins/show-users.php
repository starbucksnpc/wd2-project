<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php

if (!isset($_SESSION['adminname'])) {
  header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php");
}


    $posts = $conn->prepare("SELECT users.id AS id, users.email AS email, users.username AS username, users.mypassword AS mypassword, users.created_at AS created_at FROM users");
    $posts->execute();
    $rows = $posts->fetchAll(PDO::FETCH_OBJ);


?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title mb-4 d-inline">Users</h5>
        <a href="create-users.php" class="btn btn-primary mb-4 text-center float-right">Create Users</a>

        <table class="table">
          <thead>
            <tr>
              <!-- <th scope="col">#</th> -->
              <th scope="col">Email</th>
              <th scope="col">User Name</th>
              <th scope="col">Password</th>
              <th scope="col">Created at</th>
              <th scope="col">Update</th>
              <th scope="col">Delete</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach($rows as $row) : ?>
            <tr>
              <!-- <th scope="row"><?php echo $row->id; ?></th> -->
              <td><?php echo $row->email; ?></td>
              <td><?php echo $row->username; ?></td>
              <td><?php echo $row->mypassword; ?></td>
              <td><?php echo $row->created_at; ?></td>
              <td><a href="update-users.php?up_id=<?php echo $row->id; ?>" class="btn btn-warning text-white text-center ">Update</a></td>
              <td><a href="delete-users.php?de_id=<?php echo $row->id; ?>" class="btn btn-danger  text-center ">Delete</a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php require "../layouts/footer.php"; ?>