<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

<?php
include "connect.php";
$errors = array("fn" => '', "ln" => '', "un" => '', "em"=> '', "pw"=> '', "pw2"=> '');
$constants = array("fnameval" => '', "lnameval" => '', "unameval" => '', "emailval"=> '');
if(isset($_POST["fname"])){
    $constants["fnameval"] = htmlspecialchars($_POST["fname"]);
}
if(isset($_POST["lname"])){
    $constants["lnameval"] = htmlspecialchars($_POST["lname"]);
}
if(isset($_POST["uname"])){
    $constants["unameval"] = htmlspecialchars($_POST["uname"]);
}
if(isset($_POST["email"])){
    $constants["emailval"] = htmlspecialchars($_POST["email"]);
}
if (isset($_POST["submit"])){
    if(empty($_POST["fname"])){
        $errors["fn"] = 'Please enter first name.';   
    }
    else{
        $fname=$_POST["fname"];
        echo $errors["fn"];
        if(!preg_match('/^[a-zA-Z\s]+$/',$fname)){
            $errors["fn"] = 'Only letters allowed';
        }
    }
    if(empty($_POST["lname"])){
        $errors["ln"] = 'Please enter last name.';   
    }
    else{
        $lname=$_POST["lname"];
        if(!preg_match('/^[a-zA-Z\s]+$/',$lname)){
            $errors["ln"] = 'Only letters allowed.';
        };
    }

    if(empty($_POST["uname"])){
        $errors["un"] = 'Please enter username.';   
    }
    else{
        $uname=$_POST["uname"];
        if(!preg_match('/^[a-zA-Z\s]+$/',$uname)){
            $errors["un"] = 'Only letters allowed.';
        };
    }

    if(empty($_POST["email"])){
        $errors["em"] = 'Please enter email.';   
    }
    else{
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["em"]  = "Invalid email format.";
        }
    }

    if(empty($_POST["password"])){
        $errors["pw"] = 'Please enter password.';   
        
    }
    else{
        $password = $_POST["password"];
        $hash = password_hash($password, PASSWORD_BCRYPT);
        if(!preg_match('/^[a-zA-Z\s0-9]+$/',$password)){
            $errors["pw"]  = 'Only letters and numbers allowed.';
        };
    }

    if($_POST["password"] != $_POST["password2"]){
        $errors["pw2"] = 'Passwords do not match.';
    }
    if(!array_filter($errors)){   
        session_start();
        $_SESSION["username"] = $uname; 
        $_SESSION["name"] = ucwords($fname." ".$lname);   
        $sql = "INSERT INTO users (firstname, lastname, username, email, pass) VALUES ('$fname','$lname', '$uname', '$email', '$hash')";
        mysqli_query($con,$sql);
        header("Location: signupcomp.php"); 
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    
    <?php include 'header.php' ?>
    <div>
        <form id="SignInContainer" method="POST">
            <label for="fname">First Name</label><br>
            <input type="text" name="fname" id="fname" placeholder="John" value=<?php echo $constants["fnameval"] ?>><br>
            <span><?php echo $errors["fn"] ?></span><br>

            <label for="lname">Last Name</label><br>
            <input type="text" name="lname" id="lname" placeholder="Doe " value= <?php echo $constants["lnameval"] ?> ><br>
            <span><?php echo $errors["ln"] ?></span><br>

            <label for="username">Username</label><br>
            <input type="text" name="uname" id="uname" placeholder="johndoe" value=<?php echo $constants["unameval"]?> ><br>
            <span><?php echo $errors["un"] ?></span><br>

            <label for="email">Email Address</label><br>
            <input type="email" name="email" id="email" placeholder="johndoe@example.com " value=<?php echo $constants["emailval"] ?>><br>
            <span><?php echo $errors["em"] ?></span><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="abc123"><br>
            <span><?php echo $errors["pw"] ?></span><br>

            <label for="password2">Re-enter Password</label><br>
            <input type="password" name="password2" id="password2" placeholder="abc123"><br>
            <span><?php echo $errors["pw2"] ?></span><br>

            <p>Already have an account? <a href="login.php">Log in</a></p>
            <button type="submit" name="submit" id="submit">Sign Up</button>
        </form>
    </div>
    
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400;500;600;700&display=swap');
        div{
            display:inline-block;
            background: #789E9e;
            padding:60px 80px 40px 80px;
            margin-top:30px;
        }
        #SignInContainer{
            font-family: 'Rubik', sans-serif;
            background: #789E9e;
            color: #F4EEED;
            text-align:left;
            letter-spacing:0.5px;
        }
        #submit{  
            color: #789E9e;
            border: #F4EEED 2px solid;
            display:block;
            width:100%;
            background: #F4EEED;
            margin-top:30px;
            font-size:15px;
            padding:8px 12px 8px 12px;
            font-family: 'Rubik', sans-serif;
        }
        #submit:hover{
            color: #F4EEED;
            border: #F4EEED 2px solid;
            background: #789E9e;
            transition:250ms;
        }
        label{
            letter-spacing:1px;
            font-size:16px;
            font-weight:500;
        }
        p {
            font-size:14px;
            font-family: 'Rubik', sans-serif;
        }
        span{
            display:block;
            font-size:10px;
            padding:2px 0px 5px 0px;
            color:red;
            height:10px;
        }
        input{
            border:none;
            background: #789E9e;
            margin-top:7px;
            height:40px;
            border-bottom:rgb(244, 238, 237, 0.6) solid 2px;
            min-width:250px;
            max-width:300px;
        }
        input:active,input:focus{
            outline: none;
            background:rgb(244, 238, 237, 0.4);
            border-radius:2px;
            border-bottom:none;
            font-family: 'Rubik', sans-serif;
        }
        a{
          text-decoration: underline;
          
        }
        a:active,a:visited{
            color:#E3DCD2;
        }
        ::placeholder,  input:focus::placeholder{
            font-family: 'Rubik', sans-serif;
            padding: left 2px;px;
            color:rgb(244, 238, 237, 0.6);
            font-size:17px;
            font-style:italic;
        }
    </style>
</html>

