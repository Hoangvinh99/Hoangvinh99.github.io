<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Thông báo từ Merchant về buyer</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../fontawesome-free-6.2.0-web/css/all.min.css">
	</head>
	</head>
	<body>
		<main class="bg-gray-dark d-flex flex-auto flex-column overflow-hidden position-relative">
			<div class="space">
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
				<div class="stars"></div>
			</div>
		</main>
		<div class="container hv_end">
			
			<div class="hv_img">
				<img src="../images/pic1.png" alt="">
			</div>
			<div class="row">
				<?php 
					if(isset($_POST['messages_merchant'])) {
				 ?>
				 <div class="col-md-6 col-md-offset-4 merchant">
				 <form action="acquirer.php" method="post">
				 	<h1 class="hv_td">Thông điệp Merchant phản hồi</h1>
				 	<input type="text" name="messages_merchant" value="<?php echo $_POST['messages_merchant']; ?>" class="form-control form-group hv_box_mess">
					<form action="ikp/index.php" method="POST" role="form" class="form-group">
					 	<button type="submit" name="submit"  class="form-group hv_btn_sent"><span><a href="http://localhost:3000/">Trang chủ</a></span></button>
					</form>
					
				 </form>
				</div>
				 <?php } ?>
			</div>
		</div>
	</body>
</html>