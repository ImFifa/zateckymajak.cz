<?php

header('HTTP/1.1 503 Service Unavailable');
header('Retry-After: 300'); // 5 minutes in seconds

?>
	<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="robots" content="noindex">

		<meta name="generator" content="K2D.CZ CMS">
		<meta name="author" content="K2D.CZ">

		<title>Aktualizace</title>

		<link rel="stylesheet" href="/dist/front.bundle.css" type="text/css">

		<style>
			html,
			body {
				height: 100%;
			}

			body {
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.content {
				text-align: center;
				padding: 3rem;
			}

			.content img {
				height: 50px;
			}
		</style>
	</head>
	<body>
	<div class="background">
		<div class="overlay"></div>

		<?php if (strpos($_SERVER['HTTP_HOST'], 'box') === false) { ?>
			<div class="img" style="background-image: url('/dist/img/bg.jpg'); background-size: cover;"></div>
		<?php } else { ?>
			<div class="img" style="background-image: url('/upload/show/2/bg.jpg'); background-size: cover;"></div>
		<?php } ?>

	</div>

	<div class="content">

		<?php if (strpos($_SERVER['HTTP_HOST'], 'box') === false) { ?>
			<img src="/dist/img/logo_white.svg" alt="Livesignal.tv - Logo">
		<?php } else { ?>
			<img src="/upload/show/2/logo_nobrand.png" alt="BOXING LUCERNA - Logo">
		<?php } ?>

		<h1 class="my-5">Omlouváme se</h1>
		<p>
			Právě aktualizujeme webovou aplikaci a proto není dostupná.<br />
			Zkuste to znovu za několik minut.<br />
			Děkujeme za pochopení.
		</p>
	</div>
	</body>
<?php

exit;
