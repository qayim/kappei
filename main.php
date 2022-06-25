<?php
	session_start();
    require_once "pdo.php";
	
    $stmt = $pdo->query("SELECT * FROM coffee;");
	 
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kappei Main</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container-fluid"><img src="img/kappei.svg" style="width: 100px;">
            <h1>Main page</h1>
			<a href="add.php" class="btn add" role="button" style="margin: 1px;">
                <i class="material-icons" >add_circle</i>
            </a>
        </div>
    </nav>
    <?php
								  if ( isset($_SESSION['error']) ) {
									 echo('<p style="color: red; text-align: center;">'.htmlentities($_SESSION['error'])."</p>\n");
									 unset($_SESSION['error']);
								  }
			?>
    <?php
					//this is to get the logo/pic from database
					//<?php echo(htmlentities($_SESSION["dlogo"])) 
					
					//to get all of the images in database
						echo('<div class="row">');
						foreach ($rows as $row) {
								
									echo('<div class="col-sm-3">');
											echo('<a href="edit.php?cid='.$row['cid'].'">');
												echo('<div class="container p-3 my-3 bg-light">');
													echo('<img src="img/');
													echo($row['type']);
													echo('.png" class="picture" height="200px">');
													echo('<h4>Name: ');
													echo($row['coffeename']);
													echo('</h4>');
                                                    echo('<p>Available at: ');
													echo($row['available']);
													echo('</p>');
                                                    echo('<p>Average price: ');
													echo($row['price']);
													echo('</p>');
												echo('</div>');
											echo('</a>');
									echo('</div>');
						
						}
						echo('</div>');
					
					
				echo('</div>');
				
				?>

</body>

</html>