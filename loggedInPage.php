<?php  
	
	session_start();

	$diaryContent = "";

	if(array_key_exists("id", $_COOKIE)){

		$_SESSION['id'] = $_COOKIE['id'];

	}

	if(array_key_exists("id", $_SESSION)){


		require 'connection.php';

		$query = "SELECT diary FROM users WHERE id='".mysqli_real_escape_string($link, $_SESSION['id'])."'";

		$row = mysqli_fetch_array(mysqli_query($link, $query));

		$diaryContent = $row['diary'];

	} else {

		header("Location: index.php");

	}

?>
<?php require 'header.php';  ?>

<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  <a class="navbar-brand" href="#">Secret Diary</a>
    <div class="pull-xs-right">
      <a href='index.php?logout=1'><button class="btn btn-success">Log-Out</button></a>
    </div>
</nav>

<div class="container-fluid" id="containerLoggedInPage">
	<textarea id="diary" class="form-control">
		<?php echo $diaryContent; ?>
	</textarea>
</div>

<?php require 'footer.php' ?>