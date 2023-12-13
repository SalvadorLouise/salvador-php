<?php
    session_start();
    if (isset($_SESSION["user"])){
        header("location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
            <!----------------------- yung main box -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <!----------------------- Log in area -------------------------->

        <div class="row  border rounded-5 p-3  bg-white shadow box-area "> 
            <!--------------------------- left na box ----------------------------->
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: rgb(12, 87, 2);">
           <div class="featured-image mb-3">
            <img src="img/logo.png" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Olivarez College</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Educate the Mind, Body, And Soul.</small>
       </div> 


            <!-------------------- ------ right side box ---------------------------->
           <div class="col-md-6 right-box"> 
          <div  class="row align-items-center">
          <?php
            if (isset($_POST["login"])){
                $email = $_POST["email"];
                $password = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    if (password_verify($password, $user["Password"])) {
                        session_start();
                        $_SESSION["user"] = "YES";
                        header("location: index.php");
                        die();

                    }else{
                        echo "<div class='alert alert-danger'>Incorrect Password</div>";
                    }
                }else{
                    echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Warning:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>
                      Please Enter A Valid Email Address
                    </div>
                  </div>";
                }
                
            }
            ?>
            <form action= "login.php" method="post">
                <div class="header-text mb-4">
                     <h2>The Olivarez Repository</h2>
                     <p>Welcome back to the Inventory</p>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control-lg bg-light w-100 fs-6" name="email" placeholder="Email address">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control-lg bg-light w-100 fs-6" name="password" placeholder="Password">
                </div>
                <div class="input-group mb-3">
                    <input type= "submit" class ="btn btn-lg btn-success w-100 fs-6" value="login" name = "login">
                </div>
                
                <div class="row">
                    <small>Don't have account? <a href="registration.php">Sign Up</a></small>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>