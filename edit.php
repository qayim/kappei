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

$_SESSION['cid'] = $_GET['cid'];
$coffeeid = $_GET['cid'];

	// make sure id is there or not
	if ( ! isset($coffeeid) ) {
	  $_SESSION['error'] = "Missing coffee id";
	  header('Location: main.php');
	  return;
	}

	$stmt = $pdo->prepare("SELECT * FROM coffee where cid = :cid");
	$stmt->execute(array(":cid" => $coffeeid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$coffeename= htmlentities($row['coffeename']);
	$available = htmlentities($row['available']);
	$price = htmlentities($row['price']);
	$type = htmlentities($row['type']);
	$method = htmlentities($row['method']);
	$cid = $coffeeid;

	if ( $row === false ) {
		$_SESSION['error'] = 'Bad value for cid';
		header( 'Location: edit.php' ) ;
		return;
	}
    // check data legit or not
    if ( isset($_POST['coffeename']) && isset($_POST['available']) && isset($_POST['price']) && isset($_POST['type']) && isset($_POST['method'])) {
            if (strlen($_POST['coffeename']) < 1) {
                $_SESSION['error'] = "Name missing";
                header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
                return;
        } else if (strlen($_POST['coffeename']) > 50) {
            $_SESSION['error'] = "Name exceeds character limit";
            header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
            return;
        } else if (strlen($_POST['available']) < 1) {
            $_SESSION['error'] = "Availability missing";
            header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
            return;
        } else if (strlen($_POST['available']) > 50) {
            $_SESSION['error'] = "Availability exceeds character limit";
            header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
            return;
        } else if (strlen($_POST['price']) < 1) {
                $_SESSION['error'] = "Price missing";
                header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
                return;
        } else if (strlen($_POST['price']) > 50) {
            $_SESSION['error'] = "Price exceeds character limit";
            header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
            return;
        } else if (strlen($_POST['type']) < 1) {
                $_SESSION['error'] = "Type missing";
                header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
                return;
        } else if (strlen($_POST['method']) < 1) {
                $_SESSION['error'] = "How to order missing";
                header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
                return;
        } else if (strlen($_POST['method']) > 200) {
            $_SESSION['error'] = "How to order exceeds character limit";
            header("Location: edit.php?uid=".$_GET['uid']."&&cid=?".$_GET['cid'].);
            return;
        } else {

            $sql = "UPDATE coffee SET coffeename = :coffeename, available = :available, price = :price, 
            type = :type, method = :method WHERE cid = :cid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':coffeename' => htmlentities($_POST['coffeename']),
				':available' => htmlentities($_POST['available']),
				':price' => htmlentities($_POST['price']),
				':type' => htmlentities($_POST['type']),
				':method' => htmlentities($_POST['method']),
				':cid' => $coffeeid,
            ));
        $_SESSION['error'] = 'Record edited';
        header( 'Location: main.php' ) ;
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
    <title>Kappei Edit Coffee</title>

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
                <h1>Edit Coffee</h1>
            </div>
            <?php
					if ( isset($_SESSION['error']) ) {
							echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
							unset($_SESSION['error']);
					}
			?>
        </div>

        <form method="post" enctype="multipart/form-data">
            <section class="coffeename"> 
                <div class="row">
                    <div class="col-sm">
                        <h2>Coffee name:</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <input class="textfield-theme" type="text" name="coffeename" id="coffeename" value="<?= $coffeename ?>">
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
                        <input class="textfield-theme" type="text" name="available" id="available" value="<?= $available ?>">
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
                        <input class="textfield-theme" type="number" name="price" id="price" value="<?= $price ?>">
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
                        <input type="radio" id="hot" name="type" <?=$type=="Hot" ? "checked" : ""?> value="Hot" style="height:35px; width:35px; vertical-align: middle;">
							  <label for="hot">Hot</label>
						<input type="radio" id="gcold" name="type" <?=$type=="Cold" ? "checked" : ""?> value="Cold" style="height:35px; width:35px; vertical-align: middle;">
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
                        <input class="textarea-theme" type="text" name="method" id="method" value="<?= $method ?>" cols="40" rows="5">
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
                    <input class="button-theme" type="submit" value="Edit Coffee">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">

                    <?php
                        echo('<a href="delete.php?cid='.$_GET['cid'].'&&uid='.$_GET['uid'].'" class="btn btn-danger" role="button">Delete</a>');
                    ?>
                    </div>
                </div>
            </section>
        </form>

    </div>
</body>

</html>