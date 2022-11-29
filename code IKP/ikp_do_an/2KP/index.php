<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Thông tin bên mua </title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="../style.css">
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Rubik+Dirt&family=Space+Grotesk&display=swap" rel="stylesheet">
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
		<div class="container">
			<div class="hv_img">
				<img src="../images/pic1.png" alt="">
			</div>
			<div class="row ">
				<div class="col-md-6 col-md-offset-4 buyer">
					<form action="./2KP/merchant.php" class="form-group" method="post">
					<h1 class="hv_td">Thông điệp gửi đi</h1>
					<input type="text" name="messages_buyer" value="" placeholder="" class="form-control form-group hv_box_mess">
					<button type="submit" name="submit" value="Gửi thông điệp Merchant" class="form-group hv_btn_sent"><span>Gửi Thông Điệp</span></button>
				</form>
				</div>
				
			</div>
		</div>
	</body>
</html>