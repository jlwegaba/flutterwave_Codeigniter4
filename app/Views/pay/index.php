<!DOCType html>
<html>
<head> 
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name=”robots” content=”noindex,nofollow”>
    <title>Flutterwave Payment</title>

    <!-- Favicons -->
    <link href="<?= base_url();?>/assets/images/favicon.png" rel="icon">
	
	

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="<?= base_url();?>/assets/css/main.css" rel="stylesheet">

    <!-- Toastr alert notification -->
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
	
</head>
</head>
<body>
    <div class="container mt-5 h-75 pt-md-5" style="max-width: 500px;">
        <div class="bg-light text-center mt-5 p-4" role="alert">
		 <p class="mb-3"> <img src="<?=base_url()?>/assets/images/boraLogo2.png" width="150px"></p>
		 <h2> Forgot password?</h2>
		<p>Reset Password to enjoy the best of <strong>BORA<i>pos</i></strong></p>
			
			<?php if(session()->getTempdata('success')): ?>
				<div class="alert alert-success" role="alert"><?= session()->getTempdata('success');?></div>
			<?php endif;?>
			<?php if(isset($validation)): ?>
			<div class="alert alert-danger">
			<?= $validation->listErrors()?>
			</div>
			<?php endif;?>
			<?php if(session()->getTempdata('error')):?>
			<div class="alert alert-danger">  <?= session()->getTempdata('error');?></div>
			<?php endif;?>
			<form method="POST" action="processPayment.php" id="paymentForm">
				<input type="hidden" name="amount" value="200"/> <!-- Replace the value with your transaction amount -->
				<input type="hidden" name="payment_options" value=""/>
				<!-- Can be card, account, ussd, qr, mpesa, mobilemoneyghana  (optional) -->
				<input type="hidden" name="description" value="I Phone X, 100GB, 32GB RAM"/>
				<!-- Replace the value with your transaction description -->
				<input type="hidden" name="logo" value="http://brandmark.io/logo-rank/random/apple.png"/>
				<!-- Replace the value with your logo url (optional) -->
				<input type="hidden" name="title" value="Victor Store"/>
				<!-- Replace the value with your transaction title (optional) -->
				<input type="hidden" name="country" value="NG"/> <!-- Replace the value with your transaction country -->
				<input type="hidden" name="currency" value="NGN"/> <!-- Replace the value with your transaction currency -->
				<input type="hidden" name="email" value="busa@yahoo.com"/> <!-- Replace the value with your customer email -->
				<input type="hidden" name="firstname" value="Olaobaju"/>
				<!-- Replace the value with your customer firstname (optional) -->
				<input type="hidden" name="lastname" value="Abraham"/>
				<!-- Replace the value with your customer lastname (optional) -->
				<input type="hidden" name="phonenumber" value="08098787676"/>
				<!-- Replace the value with your customer phonenumber (optional if email is passes) -->
				<!-- Put your failure url here -->
				<center><input id="btn-of-destiny" class="btn btn-warning" type="submit" value="Pay Now"/></center>
			</form>
        </div>
    </div>

	<div class="mt-md-3 py-3 px-2 float-end d-flex align-items-baseline" ><small>&copy;<?= date('Y');?>  All Rights Reserved.</small></div>
	<script src="<?= base_url();?>/assets/js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>
	
	