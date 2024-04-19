<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php

$categories = $conn->query("SELECT * FROM categories");
$categories->execute();
$category = $categories->fetchAll(PDO::FETCH_OBJ);




// Only create a post if the image is valid
if (isset($_POST['submit'])) {
  if ($_POST['title'] == '' or $_POST['subtitle'] == '' or $_POST['body'] == '' ) {
    echo "<div class='alert alert-danger text-center role='alert'> One or more inputs are empty </div>";
  } elseif (!isset($_POST['category_id']) || $_POST['category_id'] == '') {
    echo "<div class='alert alert-danger text-center' role='alert'> Category is required </div>";
  } else {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

    $img = $_FILES['img']['name'];
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];

    

    // Execute the post creation query
    $insert = $conn->prepare("INSERT INTO posts (title, subtitle, body, category_id, img, user_id, user_name) VALUES (:title, :subtitle, :body, :category_id, :img, :user_id, :user_name)");
    $insert->execute([
      ':title' => $title,
      ':subtitle' => $subtitle,
      ':body' => $body,
      ':category_id' => $category_id,
      ':img' => $img,
      ':user_id' => $user_id,
      ':user_name' => $user_name
    ]);


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
        echo "<div class='alert alert-danger text-center role='alert'> The uploaded file is not a valid image. Try again. </div>";
        exit(); // Exit script as there is no uploaded image
      }
    }


    // Redirect after post creation
    //header('location: http://localhost:31337/project/index.php');
    //exit();
    echo "<div class='alert alert-danger text-center role='alert'> Post created successfully. </div>";
  }
}


?>

<link href="../project/css/styles.css" rel="stylesheet" />

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
    <select name="category_id" class="form-select" aria-label="Default select example">
      <option selected disabled>Select a category</option>
      <?php foreach ($category as $cat) : ?>
        <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-outline mb-4">
    <input type="file" name="img" id="form2Example1" class="form-control" placeholder="image" />
  </div>


  <!-- Submit button -->
  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


</form>



<?php require "../includes/footer.php"; ?>