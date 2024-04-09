<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php

    $posts = $conn->query("SELECT posts.id AS id, posts.title AS title, posts.user_name AS user_name, posts.created_at AS created_at, categories.name AS name FROM categories 
    JOIN posts ON categories.id = posts.category_id");
    $posts->execute();
    $rows = $posts->fetchAll(PDO::FETCH_OBJ);


?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Posts</h5>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Category</th>
              <th scope="col">User</th>
              <th scope="col">Created at</th>
              <th scope="col">Delete</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach($rows as $row) : ?>
            <tr>
              <th scope="row"><?php echo $row->id; ?></th>
              <td><?php echo $row->title; ?></td>
              <td><?php echo $row->name; ?></td>
              <td><?php echo $row->user_name; ?></td>
              <td><?php echo $row->created_at; ?></td>
              <td><a href="delete-posts.php?po_id=<?php echo $row->id; ?>" class="btn btn-danger  text-center ">Delete</a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php require "../layouts/footer.php"; ?>