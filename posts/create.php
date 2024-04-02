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
  $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];

  $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
  $actual_mime_type        = getimagesize($temporary_path)['mime'];

  $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
  $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

  return $file_extension_is_valid && $mime_type_is_valid;
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
  
  // Only create a post if the image is valid
  if(isset($_POST['submit'])) {
      if($_POST['title'] == '' OR $_POST['subtitle'] == '' OR $_POST['body'] == '' ) {
          echo "one or more inputs are empty";
      } else {
          $title = $_POST['title'];
          $subtitle = $_POST['subtitle'];
          $body = $_POST['body'];
          $img = $_FILES['img']['name']; 
          $user_id = $_SESSION['user_id'];
          $user_name = $_SESSION['username'];

          // Execute the post creation query
          $insert = $conn->prepare("INSERT INTO posts (title, subtitle, body, img, user_id, user_name) VALUES (:title, :subtitle, :body, :img, :user_id, :user_name)");
          $insert->execute([
              ':title' => $title,
              ':subtitle' => $subtitle,
              ':body' => $body,
              ':img' => $img,
              ':user_id' => $user_id,
              ':user_name' => $user_name
          ]);
          
          // Redirect after post creation
          header('location: http://localhost:31337/project/index.php');
          exit(); 
      }
  }


?>


<form method="POST" action="create.php" enctype="multipart/form-data">
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="text" name="title" id="form2Example1" class="form-control" placeholder="title" />

  </div>

  <div class="form-outline mb-4">
    <input type="text" name="subtitle" id="form2Example1" class="form-control" placeholder="subtitle" />
  </div>

  <div class="form-outline mb-4">
    <textarea type="text" name="body" id="form2Example1" class="form-control" placeholder="body" rows="8"></textarea>
  </div>


  <div class="form-outline mb-4">
    <input type="file" name="img" id="form2Example1" class="form-control" placeholder="image" />
  </div>


  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


</form>



<?php require "../includes/footer.php"; ?>