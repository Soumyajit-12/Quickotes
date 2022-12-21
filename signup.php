<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'connection.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $existSQL = "SELECT * FROM `usertable` WHERE email='$email'";
    $res = mysqli_query($con,$existSQL);
    $numExistRows = mysqli_num_rows($res);
    if($numExistRows > 0){
        $showError = 'Email already exists';
    }
    else{
        if(($password == $cpassword)){
            $sql = "INSERT INTO `usertable` (`username`, `email`, `password`, `dt`) 
            VALUES ('$username', '$email', '$password', current_timestamp());";
            $res = mysqli_query($con,$sql);
            if($res){
                $showAlert = true;
            }else{
                $showError = 'Error in adding data to Database';
            }
        }else{
            $showError = 'Passwords do not match';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>

    <!-- Header Section -->
    <?php include 'header.php'; ?>


    <!-- Container Section -->
    <section class="container">
        <div class="form signup-form">
            <form action="signup.php" method="POST" autocomplete="">
                <h1 class="form-heading">Signup Form</h1>
                <p class="form-description">It's simple, quick and easy</p>
                <?php
                if($showAlert){
                    echo '<p class="success">Account created successfully! You can login now</p>';
                }
                if($showError){
                    echo '<p class="error">'.$showError.'</p>';
                }
                ?>
                <div class="form-group">
                    <input class="input" type="text" name="username" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                    <input class="input" type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input class="input" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input class="input" type="password" name="cpassword" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input class="signup-button" type="submit" name="signup" value="Signup">
                </div>
                <div class="login-link text-center">Already a member? <a href="index.php">Login Here</a></div>
            </form>
        </div>
    </section>



    <!-- Footer Section -->
    <footer class="screen-end">
        <?php include 'footer.php'; ?>
    </footer>


    <!-- Internal Java Script -->
    <script>
        function github() {
            window.open("https://github.com/Soumyajit-12")
        }

        function linkedIn() {
            window.open("https://www.linkedin.com/in/soumyajit-mitra-038827244/")
        }

        function instagram() {
            window.open("https://www.instagram.com/soumyajit_2641/")
        }
    </script>

</body>

</html>