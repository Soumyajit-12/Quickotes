<?php
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'connection.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "Select * from usertable where email='$email' AND 
    password='$password'";
    $res = mysqli_query($con,$sql);
    $num = mysqli_num_rows($res);
    if($num == 1){
        $login = true;
        $followingdata = $res->fetch_array(MYSQLI_ASSOC);
        $username = $followingdata['username'];
        $date = $followingdata['dt'];
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['date'] = $date;
        header('location: home.php');
    }
    else{
        $showError = 'Invalid Credentials';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>
    <!-- Header Section -->
    <?php include 'header.php'; ?>



    <!-- Container Section -->
    <section class="container">
        <div class="form login-form">
            <form action="index.php" method="POST" autocomplete="">
                <h1 class="form-heading">Login Form</h1>
                <p class="form-description">Login with your email and password</p>
                <?php
                if($login){
                    echo '<p class="success"><strong>Success!</strong> You are logged in</p>';
                }
                if($showError){
                    echo '<p class="error">'.$showError.'</p>';
                }
                ?>
                <div class="form-group">
                    <input class="input" type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input class="input" type="password" name="password" placeholder="Password" required >
                </div>
                <div class="form-group">
                    <input class="login-button" type="submit" name="login" value="Login">
                </div>
                <div class="login-link text-center">Not yet a member? <a href="signup.php">Signup now</a></div>
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