<?php
require_once "pdo.php";
session_start();

$uid = $_GET['uid'];
	
	if ( ! isset($_GET['uid']) ) {
		  $_SESSION['error'] = "Missing user id";
		  session_destroy();
		  header('Location: index.php');
		  return;
	}

//to check there's input or not

if(isset($_POST['insert'])){
	
	if (strlen($_POST['coffeename']) < 1) {
            $_SESSION['error'] = "Name missing";
            header("Location: add.php?uid=".$_GET['uid']);
            return;
    } else if (strlen($_POST['coffeename']) > 50) {
        $_SESSION['error'] = "Name exceeds character limit";
        header("Location: add.php?uid=".$_GET['uid']);
        return;
    } else if (strlen($_POST['available']) < 1) {
        $_SESSION['error'] = "Availability missing";
        header("Location: add.php?uid=".$_GET['uid']);
        return;
    } else if (strlen($_POST['available']) > 50) {
        $_SESSION['error'] = "Availability exceeds character limit";
        header("Location: add.php?uid=".$_GET['uid']);
        return;
    } else if (strlen($_POST['price']) < 1) {
            $_SESSION['error'] = "Price missing";
            header("Location: add.php?uid=".$_GET['uid']);
            return;
    } else if (strlen($_POST['price']) > 50) {
        $_SESSION['error'] = "Price exceeds character limit";
        header("Location: add.php?uid=".$_GET['uid']);
        return;
    } else if (strlen($_POST['type']) < 1) {
            $_SESSION['error'] = "Type missing";
            header("Location: add.php?uid=".$_GET['uid']);
            return;
	} else if (strlen($_POST['method']) < 1) {
            $_SESSION['error'] = "How to order missing";
            header("Location: add.php?uid=".$_GET['uid']);
            return;
	} else if (strlen($_POST['method']) > 200) {
        $_SESSION['error'] = "How to order exceeds character limit";
        header("Location: add.php?uid=".$_GET['uid']);
        return;
    } else {
		
		$stmt = $pdo->prepare('INSERT INTO coffee (coffeename, available, price, type, method) 
		VALUES (:coffeename, :available, :price, :type, :method)');
				
		$stmt->execute(array(
                ':coffeename' => htmlentities($_POST['coffeename']),
				':available' => htmlentities($_POST['available']),
				':price' => htmlentities($_POST['price']),
				':type' => htmlentities($_POST['type']),
				':method' => htmlentities($_POST['method']),
		));
		
		$_SESSION['success'] = "Coffee added";
            header("Location: main.php?uid=".$_GET['uid']);
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
    <title>Kappei Add Coffee</title>

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
                <h1>Add Coffee</h1>
            </div>
        </div>

        <?php
					if ( isset($_SESSION['error']) ) {
							echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
							unset($_SESSION['error']);
					}
			?>

        <form method="post">
            <section class="coffeename"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Coffee name:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="text" name="coffeename" id="coffeename" placeholder="Coffee name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <h5>*Must be under 50 characters</h5>
                    </div>
                </div>
            </section>

            <section class="available"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Available at:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="text" name="available" id="available" placeholder="Place">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <h5>*Must be under 50 characters</h5>
                    </div>
                </div>
            </section>

            <section class="price"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Average price:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="number" name="price" id="price" placeholder="Average price">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <h5>*Must be under 50 characters</h5>
                    </div>
                </div>
            </section>

            <section class="type"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Type of drink:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input type="radio" id="hot" name="type" value="Hot" checked="checked" style="height:35px; width:35px; vertical-align: middle;">
							  <label for="hot">Hot</label>
						<input type="radio" id="gcold" name="type" value="Cold" style="height:35px; width:35px; vertical-align: middle;">
							  <label for="cold">Cold</label>
                    </div>
                </div>

            </section>

            <section class="order"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>How to order:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textarea-theme" type="text" name="method" id="method" placeholder="Ways to order. Eg: What to say to the barista." cols="40" rows="5">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <h5>*Must be under 200 characters</h5>
                    </div>
                </div>
            </section>

            <section class="buttons">
                <div class="row">
                    <div class="col-sm">
                    <br>
                    <br>
                    <input class="button-theme" type="submit" name="insert" value="Add Coffee">
                    </div>
                </div>
            </section>
        </form>

    </div>
</body>

</html>