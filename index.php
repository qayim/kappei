<?php 
session_start();
require_once "pdo.php";
	
    if (isset($_POST['username']) && isset($_POST['password'])) {
	
	$stmt0 = $pdo->prepare("SELECT * from loginlogs WHERE username = :username");
            $stmt0->execute(array(
                ':username' => htmlentities($_POST['username']),
            ));
	$rows0 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
			$count0 = $stmt0->rowCount(); 
		if($count0 <= 2){
				if (strlen($_POST['username']) < 1) {
					$_SESSION["error"] = "Username missing";
					header("Location: index.php");
					return;
				} else if (strlen($_POST['password']) < 1) {
					$_SESSION["error"] = "Password missing";
					header("Location: index.php");
					return;
				} else {
					$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
					$stmt->execute(array(
						':username' => htmlentities($_POST['username']),
						':password' => htmlentities(md5($_POST['password'])),
					));
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$count = $stmt->rowCount(); 
					
					foreach($rows as $row){
						if($count > 0){  
							$stmt2 = $pdo->prepare('DELETE FROM loginlogs where username = :username');
							$stmt2->execute(array(
								':username' => htmlentities($_POST['username']),
							));
							$_SESSION["username"] = $_POST["username"];  
							$_SESSION["password"] = md5($_POST["password"]);
							header("location: main.php");  
							return;
						}  
						else{  
							 $_SESSION["error"] = "Wrong data"; 
							 header("Location: index.php"); 
							 return;
						}  
					$_SESSION['success'] = "Logged in";
					header("Location: main.php");
					return;
					}

					if($count == 0){
						$_SESSION["error"] = "Wrong data";
						$stmt1 = $pdo->prepare('INSERT INTO loginlogs (username, time) VALUE (:username, :time)');
						$stmt1->execute(array(
							':username' => htmlentities($_POST['username']),
							':time' => date_default_timezone_get() . " " . date("H:i:s"),
						));
						header("Location: index.php"); 
						return;
					}
				}
		} else{
			$_SESSION["error"] = "Log in attempt more than 3 times"; 
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
    <title>Kappei Login</title>

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

                <p> </p>
                <br>
                <p> </p>
            </section>

            <section class="buttons"> 
                <div class="row">
                    <div class="col-sm">
                        <input class=" button-theme" type="submit" value="Login">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                    <a href="signup.php" class="btn button-theme" role="button">Sign Up</a>
                    </div>
                </div>
            </section>

        </form>
    </div>
</body>

</html>