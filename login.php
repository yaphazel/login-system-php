<?php
    session_start();
    include "header.php";
    include "connect.php";
    $errors = array("unlgn"=>" ","pwlgn"=>" ");
    $unameval = $passval = "";
    $user_valid = FALSE;
    if(isset($_POST["unamelgn"])){
        $unameval = $_POST["unamelgn"];
    }
    if(isset($_POST["passwordlgn"])){
        $passval = $_POST["passwordlgn"];
    }
    if (isset($_POST["submit-lgn"])){
        if(empty($_POST["unamelgn"])){  #empty username
            $errors["unlgn"] = "Please enter valid username.";
        }
        else{ #crosscheck username
            $username = $_POST["unamelgn"];
            $sql = "SELECT firstname, lastname, pass from users where username = '$username'";
            $result = mysqli_query($con,$sql);
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $user_valid = FALSE;
            if(empty($array)){  
                $errors["unlgn"] = "The username you entered does not belong to any account.";
                $errors["pwlgn"] = '';
            }
            else{
                $user_valid = TRUE;
                $hash = $array[0]["pass"];
                if(!password_verify($_POST["passwordlgn"], $hash) && $user_valid == TRUE){
                    $errors["pwlgn"] = 'Password is invalid. ';
                }
                else{
                    $fname = $array[0]["firstname"];
                    $lname = $array[0]["lastname"];
                    $_SESSION["name"] = ucwords($fname." ".$lname);
                    $_SESSION["username"] = $_POST["unamelgn"];
                    header("Location: index.php"); 
                    exit();
                }
            }
        }
        if(empty($_POST["passwordlgn"])){
            $errors["pwlgn"] = "Please enter valid password.";
        }

        
    }
?>
<DOCTYPE html>
<html>
    <body>
    <div>
        <form id="LogInContainer" method="POST">
            <label for="uname">Username</label><br>
            <input type="text" name="unamelgn" id="unamelgn" placeholder="johndoe " value=<?php echo $unameval?>><br>
            <span><?php echo $errors["unlgn"]?></span><br>
            <label for="password">Password</label><br>
            <input type="password" name="passwordlgn" id="passwordlgn" placeholder="abc123" value=<?php echo $passval?>><br>
            <span><?php echo $errors["pwlgn"] ?></span><br>
            <p >Don't have an account? <a href="signup.php"> Sign up now.</a></p>
            <button type="submit" name="submit-lgn" id="submit-lgn">Login<i class="fas fa-arrow-right"></i></button>
        </form>
    </body>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400;500;600;700&display=swap');

        div{
            display:inline-block;
            background: #789E9e;
            padding:60px 80px 40px 80px;
            margin-top:30px;
        }
        #LogInContainer{
            font-family: 'Rubik', sans-serif;
            background: #789E9e;
            color: #F4EEED;
            text-align:left;
            letter-spacing:0.5px;
        }
        #submit-lgn{  
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
        #submit-lgn:hover{
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