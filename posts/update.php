<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php



if (isset($_GET['upd_id'])) {
  $id = filter_input(INPUT_GET, 'upd_id', FILTER_VALIDATE_INT);

  // sanitize
  if (!is_numeric($id)) {
    header("Location: http://localhost:31337/project/404.php");
    exit;
  }

  // First query to fetch the existing post details
  $select = $conn->prepare("SELECT * FROM posts WHERE id = :id");
  $select->bindParam(':id', $id);
  $select->execute();
  $rows = $select->fetch(PDO::FETCH_OBJ);

  // rows not found
  // if (!$rows) {
  //   header("Location: http://localhost:31337/project/404.php");
  //   exit;
  // }

  //categories
  $categories = $conn->query("SELECT * FROM categories");
  $categories->execute();
  $category = $categories->fetchAll(PDO::FETCH_OBJ);


  // update data
  if ($_SESSION['user_id'] !== $rows->user_id) {
    header('location: http://localhost:31337/project/404.php');
  }

  // Second query
  if (isset($_POST['submit'])) {
    if ($_POST['title'] == '' or $_POST['subtitle'] == '' or $_POST['body'] == '') {
      echo "<div class='alert alert-danger text-center role='alert'> One or more inputs are empty </div>";
    } elseif (!isset($_POST['category_id']) || $_POST['category_id'] == '') {
      echo "<div class='alert alert-danger text-center' role='alert'> Category is required </div>";
    } else {

      if (!empty($rows->img)) {
        $img = $rows->img;
      } else {
        // unlink("images/" . $rows->img . "");
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
          $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
          if (!in_array($_FILES["img"]["type"], $allowed_types)) {
            echo "<div class='alert alert-danger text-center role='alert'> The uploaded file is not a valid image. Try again. </div>";
            exit;
          }
        }
      }


      // Function to safely construct the file upload path
      function file_upload_path($original_filename, $upload_subfolder_name = 'images')
      {
        $current_folder = dirname(__FILE__);
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
      }

      // Function to check if the file is an image
      function file_is_an_image($temporary_path, $new_path)
      {
        $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

        $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type = mime_content_type($temporary_path);

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
      }



      $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
      $img = $_FILES['img']['name'];

      $dir = 'images/' . basename($img);

      // Check if an image is uploaded
      $image_upload_detected = isset($_FILES['img']) && ($_FILES['img']['error'] === 0);
      $upload_error_detected = isset($_FILES['img']) && ($_FILES['img']['error'] > 0);


      $update = $conn->prepare("UPDATE posts SET title = :title, subtitle = :subtitle, body = :body, category_id = :category_id, img = :img WHERE id = '$id'");

      // If an image is uploaded
      if ($image_upload_detected) {
        // Obtain image information
        $image_filename       = $_FILES['img']['name'];
        $temporary_image_path = $_FILES['img']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);
        unlink("images/" . $rows->img . "");


        // Check if the image is valid, and if so, upload it
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
          move_uploaded_file($temporary_image_path, $new_image_path);
        } else {
          $img = $rows->img;
        }
      }

      $update->execute([
        ':title' => $title,
        ':subtitle' => $subtitle,
        ':body' => $body,
        ':category_id' => $category_id,
        ':img' => $img

      ]);

      // if (move_uploaded_file($_FILES['img']['tmp_name'], $dir)) {
      //   header('location: http://localhost:31337/project/index.php');
      // }

      header('location: http://localhost:31337/project/index.php');
      exit;
    }
  }
} else {
  header('location: http://localhost:31337/project/404.php');
  exit;
}

?>

<form method="POST" action="update.php?upd_id=<?php echo $id; ?>" enctype="multipart/form-data">
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="text" name="title" value="<?php echo $rows->title; ?>" id="form2Example1" class="form-control" placeholder="title" />

  </div>

  <div class="form-outline mb-4">
    <input type="text" name="subtitle" value="<?php echo $rows->subtitle; ?>" id="form2Example1" class="form-control" placeholder="subtitle" />
  </div>

  <div class="form-outline mb-4">
    <textarea type="text" name="body" id="form2Example1" class="form-control" placeholder="body" rows="8"><?php echo $rows->body; ?></textarea>
  </div>

  <div class="form-outline mb-4">
    <select name="category_id" class="form-select" aria-label="Default select example">
      <option selected disabled>Open this select menu</option>
      <?php foreach ($category as $cat) : ?>
        <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <?php echo "<img src='images/" . $rows->img . "' width=300px height=300px> "; ?>

  <div class="form-outline mb-4">
    <input type="file" name="img" id="form2Example1" class="form-control" placeholder="image" />
  </div>

  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
</form>

<?php require "../includes/footer.php"; ?>