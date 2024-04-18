<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>


<?php 

    if(isset($_POST['search'])) {

        if($_POST['search'] == '') {
            echo "<div class='alert alert-danger bg-danger text-white text-center'>
            Enter search keyword first</div>";
        } else{
            $search = $_POST['search'];

            $data = $conn->prepare("SELECT * FROM posts WHERE title LIKE '%$search%'");
        }
    }

?>

<?php require "includes/footer.php"; ?>
