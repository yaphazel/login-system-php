<link rel="stylesheet" href="style-all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

<?php 
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
        $name = $_SESSION["name"];
        $button1 = "Welcome ".$name;
        $button2 = "<a href='logout.php' style='color:#4D6466;'>Log Out</a>";
        $sql = "SELECT id from users where username = '$username'";

        $result = mysqli_query($con, $sql);
        $rarray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $_SESSION["id"] = $rarray[0]["id"];
        $id = $_SESSION["id"];

        $sqltask = "SELECT * from datatasks where userid = '$id'";

        $resulttask = mysqli_query($con, $sqltask);
        $rarraytasks = mysqli_fetch_all($resulttask, MYSQLI_ASSOC);
        $_SESSION['loggedin'] = TRUE;

    }
    else{
        $button1 = "<a href='login.php'  style='color:#4D6466;'>Log In</a>";
        $button2 = "<a href='signup.php' style='color:#4D6466;'> Sign Up </a>";
        $_SESSION['loggedin'] = FALSE;
    }
    if(isset($_POST["tasksubmit"])){
        if(isset($_SESSION['username'])){
            $task = $_POST["addTask"];
            $sql = "INSERT INTO datatasks(userid, tasks, compstatus) VALUES ('$id', '$task', 'Uncompleted')";
            mysqli_query($con,$sql);
            header("Location:index.php");
        }
        else{
            echo '<p id="warning">Please login or signup</p>';
        }
    }
    if(isset($_POST["deleteWord"])){
        $id = $_POST["taskid"];
        $sql = "DELETE FROM datatasks WHERE id='$id'";
        mysqli_query($con,$sql);
        header("Location:index.php");
    }
    if(isset($_POST["doneWord"])){
        $status = $_POST["status"];
        $id = $_POST["taskid"];
        if($status == 'Uncompleted'){
           $sql = "UPDATE datatasks SET compstatus ='Completed' WHERE id='$id'";
           mysqli_query($con,$sql);
           header("Location:index.php");  
        }
        else{
            $sql = "UPDATE datatasks SET compstatus ='Uncompleted' WHERE id='$id'";
            mysqli_query($con,$sql);
            header("Location:index.php");
        }
        
    }


?>

<section id="content"> 
    <body onload="getWord()">
                <div id="mini-nav">
                    <p><?php echo $button1 ?></p>
                    <p>   |   </p>
                    <p><?php echo $button2 ?></p>
                </div>  

                <div>
                    <form id="addTaskContainer" method="POST">
                        <button type="button">
                            <i class="fas fa-list"></i>
                        </button>
                        <input type="text" name="addTask" id="addTask" value="" placeholder="Add Task..." autocomplete="off">
                        <button type="submit" name="tasksubmit" id="tasksubmit" >
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>
                </div>
                <div>
                    <ul id="list">
                        <?php if ($_SESSION['loggedin'] == TRUE){foreach($rarraytasks as $rarraytask){ ?>
                            <form method="POST">
                                <li>
                                    <?php
                                    if($rarraytask["compstatus"] == 'Uncompleted'){
                                        $style = "text-decoration:normal";
                                    }
                                    else{
                                        $style = "text-decoration:line-through";
                                    }?>
                                    <input type="hidden" name="status" value=<?php echo $rarraytask["compstatus"]?>>
                                    <input type="hidden" name="taskid" value=<?php echo $rarraytask["id"]?>>
                                    <button type="submit" id="doneWord" name="doneWord"><i class="far fa-check-circle"></i></button>
                                    <p id="word" style=<?php echo $style ?> ><?php echo htmlspecialchars($rarraytask["tasks"]);?></p>
                                    <button type="submit" id="deleteWord" name="deleteWord"  ><i class="fas fa-times"></i></button>
                                    
                                </li>
                            </form>
                        <?php }} ?>
                        <!-- <li> 
                            <button id="done1"><i></i></button>
                            <p></p>
                            <button><i></i></button>
                        </li> -->
                    </ul>
                </div>
    </body>
</section>
<style type="text/css">
    ul{
        list-style-type:none;
        display: inline-flex;
        flex-direction: column;
        justify-content:center;
        text-align: center;
        max-width: 700px;
        padding:0;
        margin:0;
        color: #789E9e;
    }
    ul i{
        font-size: 1.5rem;
        padding: 1rem;
        color: #789E9e;
    }
    ul p{
        font-size: 1.3rem;
        font-family: 'Rubik', sans-serif;
        min-width: 520px;
        max-width: 520px;
        text-align: left;
        padding: 1rem;
        word-break: break-all;
        white-space: normal;
    }
    li{
        display: inline-flex;
        flex-direction: row;
        justify-content:space-between;
        align-items: center;
        background-color: white;
        width: 700px;
    }
  
    input{
        border: none;
        background: none;
        overflow: hidden;
        padding: 1rem;
        font-size: 1.2rem;
        min-width: 520px;
        max-width: 520px;
        text-align: left;
        color: #F4EEED;
    }
    #addTaskContainer {
        font-size: 1.5rem;
        background: #789E9e;
        width: 700px;
        margin-bottom: 0.5rem;
        display: inline-flex;
        text-align: center;
        justify-content: space-between;
        }

    #addTaskContainer i{
        color: #F4EEED;
        font-size: 1.2rem;
        font-size: 1.5rem;
        padding: 1rem;
    }

    ::placeholder{
        color: #F4EEED;
        font-size: 1.2rem;
        font-style: italic;
        font-family: 'Rubik', sans-serif;
    }
    #addTask:focus, #addTask:active{
        background: transparent;
        border:none;
        outline: none;
        font-family: 'Rubik', sans-serif;
    } 

    #mini-nav p{
        display: inline-block;
        font-family: 'Domine', serif;
        color:#4D6466;
    }
    #mini-nav a{
        color:#4D6466;
    }
    #warning{
        background-color: #FFCDD2; 
        color:#ED4337;
        width: 700px;
        height:30px;
        border-radius:2px;
        align-items:center;
        justify-content:center;
        display: inline-flex;
    }
        /*#DDB7AB*/
</style>

