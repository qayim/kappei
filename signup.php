<?php 
session_start();
require_once "pdo.php";

if( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['age'])){
    if (strlen($_POST['username']) < 1) {
        $_SESSION['error'] = "Username missing";
        header("Location: signup.php");
        return;
    } else if (strlen($_POST['password']) < 1) {
        $_SESSION['error'] = "Password missing";
        header("Location: signup.php");
        return;
    } else if (strlen($_POST['age']) < 1) {
        $_SESSION['error'] = "Age missing";
        header("Location: signup.php");
        return;
    } else if (!is_numeric($_POST['age'])) {
        $_SESSION['error'] = "Age must be numbers";
        header("Location: signup.php");
        return;
    } else{
        $stmt = $pdo->prepare('INSERT INTO users (username, password, age) VALUES (:username, :password, :age)');
        $stmt->execute(array(
            ':username' => htmlentities($_POST['username']),
            ':password' => htmlentities(md5($_POST['password'])),
            ':age' => htmlentities($_POST['age']),
        ));
        $_SESSION['success'] = "Signed up successful";
        header("Location: index.php");
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kappei Sign Up</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


</head>

<body>
    <div class="container-sm panel center-screen user-login my-5">
        
        <div class="row">
            <div class="col-sm">
                <img id="kappei-logo" class="img-fluid" src="img/kappei.svg" alt="Kappei Logo">
            </div>
        </div>

        <?php 
              if ( isset($_SESSION['error']) ) {
                 echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                 unset($_SESSION['error']);
              }
        ?>

        <form method="post">
        <section class="username"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Username:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="text" name="username" id="username" placeholder="Username">
                    </div>
                </div>
            </section>

            <section class="password"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Password:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="password" name="password" id="password" placeholder="Password">
                    </div>
                </div>
            </section>

            <section class="age"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Age:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="number" name="age" id="age" placeholder="Age">
                    </div>
                </div>
            </section>

            <section class="buttons">
                <div class="row">
                    <div class="col-sm">
                    <br>
                    <br>
                    <input class="button-theme" type="submit" value="Signup">
                    </div>
                </div>
            </section>
        </form>

    </div>
</body>

</html>