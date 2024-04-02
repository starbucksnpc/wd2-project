<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

// Function to safely construct the file upload path
function file_upload_path($original_filename, $upload_subfolder_name = 'images')
{
  $current_folder = dirname(__FILE__);
  $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
  return join(DIRECTORY_SEPARATOR, $path_segments);
}

// Function to check if the file is an image
function file_is_an_image($temporary_path, $new_path) {
  $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
  
  $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);

  $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);

  return $file_extension_is_valid;
}

// Check if an image is uploaded
$image_upload_detected = isset($_FILES['img']) && ($_FILES['img']['error'] === 0);
$upload_error_detected = isset($_FILES['img']) && ($_FILES['img']['error'] > 0);

// If an image is uploaded
if ($image_upload_detected) {
  // Obtain image information
  $image_filename       = $_FILES['img']['name'];
  $temporary_image_path = $_FILES['img']['tmp_name'];
  $new_image_path       = file_upload_path($image_filename);
  
  // Check if the image is valid, and if so, upload it
  if (file_is_an_image($temporary_image_path, $new_image_path)) {
    move_uploaded_file($temporary_image_path, $new_image_path);
  } else {
    // Handle invalid image error
    echo "The uploaded file is not a valid image. Try again.";
    exit(); // Exit script as there is no uploaded image
  }
}

if (isset($_GET['upd_id'])) {
  $id = $_GET['upd_id'];

  // First query to fetch the existing post details
  $select = $conn->query("SELECT * FROM posts WHERE id = '$id'");
  $select->execute();
  $rows = $select->fetch(PDO::FETCH_OBJ);

  if ($_SESSION['user_id'] !== $rows->user_id) {
    header('location: http://localhost:31337/project/index.php');
  }

  // Second query
  if (isset($_POST['submit'])) {
    if ($_POST['title'] == '' or $_POST['subtitle'] == '' or $_POST['body'] == '') {
      echo 'one or more inputs are empty';
    } else {

      if (empty($rows->img)) {
        $img = $rows->img;
      } else {
        unlink("images/" . $rows->img . "");
      }

      $title = $_POST['title'];
      $subtitle = $_POST['subtitle'];
      $body = $_POST['body'];
      $img = $_FILES['img']['name'];

      $dir = 'images/' . basename($img);

      $update = $conn->prepare("UPDATE posts SET title = :title, subtitle = :subtitle, body = :body, img = :img WHERE id = '$id'");

      $update->execute([
        ':title' => $title,
        ':subtitle' => $subtitle,
        ':body' => $body,
        ':img' => $img

      ]);

      if (move_uploaded_file($_FILES['img']['tmp_name'], $dir)) {
        header('location: http://localhost:31337/project/index.php');
      }

      header('location: http://localhost:31337/project/index.php');
    }
  }
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

  <?php echo "<img src='images/" . $rows->img . "' width=300px height=300px> "; ?>

  <div class="form-outline mb-4">
    <input type="file" name="img" id="form2Example1" class="form-control" placeholder="image" />
  </div>

  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
</form>

<?php require "../includes/footer.php"; ?>
