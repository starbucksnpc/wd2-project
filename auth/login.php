<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

//check for the submit 

//take the data from the input

//write our query

//execute and then fetch

//do our rowCount

//to do our password_verify + redirect to the index page

//  session_start();

// Redirect if user is already logged in
if(isset($_SESSION['username'])) {
    header("location: http://localhost:31337/project/index.php");
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Check if email and password are provided
    if ($_POST['email'] == '' or $_POST['password'] == '') {
        $errorMessage = "One or more inputs are empty.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $login = $conn->query("SELECT * FROM users WHERE email = '$email'");

        $login->execute();

        $row = $login->FETCH(PDO::FETCH_ASSOC);

        // Check if user exists
        if ($login->rowCount() > 0) {
            // Verify password
            if (password_verify($password, $row['mypassword'])) {
                // echo "logged in";

                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];


                header('location: ../index.php');
                exit; //Exit to prevent further execution
            } else {
                //Incorrect password
                $errorMessage = "Incorrect email or password. Please try again.";
            }
        } else{
            // User not found
            $errorMessage = "User not found.";
        }
    }
}

?>


<form method="POST" action="login.php">
    <!-- Email input -->

    <!-- Login failure message -->
    <?php if(isset($errorMessage)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

    <div class="form-outline mb-4">
        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />

    </div>


    <!-- Password input -->
    <div class="form-outline mb-4">
        <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />

    </div>

    

    <!-- Submit button -->
    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

    <!-- Register buttons -->
    <div class="text-center">
        <p>New member? Create an acount<a href="register.php"> Register</a></p>



    </div>
</form>

<?php require "../includes/footer.php"; ?>