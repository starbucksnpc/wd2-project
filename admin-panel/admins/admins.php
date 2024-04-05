<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>


<?php

  $admins = $conn->query("SELECT * FROM admins LIMIT 7");
  $admins->execute();
  $rows = $admins->fetchAll(PDO::FETCH_OBJ);

?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Admins</h5>
             <a  href="create-admins.html" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">admin name</th>
                    <th scope="col">email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($rows as $row) : ?>
                  <tr>
                    <th scope="row"><?php echo $row->id; ?></th>
                    <td><?php echo $row->adminname; ?></td>
                    <td><?php echo $row->email; ?></td>
                   
                  </tr>
                  <?php endforeach; ?>
                   
                  </tr>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



  </div>
  <?php require "../layouts/footer.php"; ?>