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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="row border rounded-5  p-3 bg-white shadow box-area"> 

    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: rgb(12, 87, 2);">
           <div class="featured-image mb-3">
            <img src="img/logo.png" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Olivarez College</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Educate the Mind, Body, And Soul.</small>
       </div> 

       <div class="col-md-6 right-box"> 
          <div  class="row align-items-center">

                <div class="header-text mb-4">
                     <h2>The Olivarez Hub </h2>
                     <p>Sign up to the community</p>
                </div>
        <form action="registration.php"method="post">
            <div class="input-group mb-3">
                <input type="text" class= "form-control-lg bg-light w-100 fs-6" name="fullname" placeholder="Fullname:">
            </div>
            <div class="input-group mb-3">
                <input type="email" class= "form-control-lg bg-light w-100 fs-6" name="email" placeholder="Email:">
            </div>
            <div class="input-group mb-3">
                <input type="password" class= "form-control-lg bg-light w-100 fs-6" name="password" placeholder="Password:">
            </div>
            <div class="input-group mb-3">
                <input type="password" class= "form-control-lg bg-light w-100 fs-6  " name="confirm_password" placeholder="Confirm Password:">
            </div>
            <div class="form-btn" > </div>
            <input type="submit" class="btn btn-lg btn-success w-100 fs-6 mb-3" value="Signup" name="submit">
        </form>
        <div class="row mb-3 ">
                    <small>Already have an account? <a href="login.php">Sign In</a></small>
                </div>
        </div>
        <?php
            if(isset($_POST["submit"])) {
                $fullname=$_POST["fullname"];
                $email=$_POST["email"];
                $password=$_POST["password"];
                $confirm_password=$_POST["confirm_password"];

                $passwordhash = password_hash($password, PASSWORD_DEFAULT);

                $errors = array ();
                if(empty($fullname) OR empty($email) OR empty($password) OR empty($confirm_password)){
                    array_push($errors, "Please Fill out Requested informations");
                }
                else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Email is not valid");
                }       
                else if (strlen($password)<8){
                    array_push($errors, "Password must be 8 characters long");
                } 
                if ($password!==$confirm_password){
                    array_push($errors,"password does not match");
                }
                require_once "database.php";
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowcount = mysqli_num_rows($result);
                if ($rowcount>0){
                    array_push($errors, "email already exists!");
                }

                if (count($errors)>0){
                    foreach($errors as $error){
                        echo "<div class='alert alert-danger'> $error </div>";
                    }
                }else{
                    $sql = "INSERT INTO users (Full_Name,Email,Password) VALUES (?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                    if ($prepareStmt){
                        mysqli_stmt_bind_param($stmt,"sss", $fullname,$email,$passwordhash);
                        mysqli_stmt_execute($stmt);
                        echo"<div class = 'alert alert-success'>Account Registered. </div>";
                    }else{
                        die("something went wrong");
                    }
                }
            }   
        ?>
        </div>
        </div>  
    </div>
</body>
</html> 