<?php

    session_start();

    $error = "";    

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        session_destroy();

    }
     else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) 
     {
        
        header("Location: loggedInPage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        require 'connection.php';
        
        
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {

                    $query = "INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {

                        //$query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                       // mysqli_query($link, $query);

                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

                        } 

                        header("Location: loggedInPage.php");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        //$hashedPassword = md5(md5($row['id']).$_POST['password']);
                        //echo $_POST['password']."<br>";
                        //echo $hashedPassword."<br>";
                        //echo $row['id']."<br>";
                        //echo $row['password'];
                        if ($_POST['password'] == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedInPage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }


?>

<?php require 'header.php'; ?>
  <h1 class="head"><span class="glyphicon glyphicon-edit"></span> Embed Your thoughts and data Securely here!</h1>
<div class="container" id="homePageContainer">
    <h1>Secret Diary</h1>
    

    <div id="error">
            <?php if($error != ""){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            } ?>
    </div>

    <form method="post" id="signUpForm">
        <h5>Interested In? Sign Up Now ! </h5>
        <fieldset class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Your Email">
        </fieldset>
        
        <fieldset class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
        </fieldset>
        
        <div class="checkbox">
            <label>
                <input type="checkbox" name="stayLoggedIn" value=1> Stay Logged In
            </label>
        </div>
        
        
        <input type="hidden" name="signUp" value="1">
           
         <fieldset class="form-group">
             <input type="submit" class="btn btn-success" name="submit" value="Sign Up!">
         </fieldset>   
         <p><a class="toggleForm" href="#">LogIn</a></p>
        
    </form>

    <form method="post" id="logInForm">
        <h5>LogIn with your username and password!</h5>
        <fieldset class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Your Email To LogIn">
        </fieldset>
        
        <fieldset class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password for LogIn">
        </fieldset>
        
        <div class="checkbox">
            <label>
                <input type="checkbox" name="stayLoggedIn" value=1> Stay Logged In
            </label>
        </div>
        
        
        <input type="hidden" name="signUp" value="0">
           
         <fieldset class="form-group">
             <input type="submit" class="btn btn-success" name="submit" value="Log In!">
         </fieldset>   

         <p><a class="toggleForm" href="#">SignUp</a></p>

    </form>
</div>

   <?php require 'footer.php'; ?>


