<!DOCTYPE HTML>
<html>

<head>
	<title>
		<?= $title ?>
	</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta name="subject" content="Web Development">
	<meta name="url" content="https://hellolittlered.org/">
	<meta name="rating" content="General">
	<meta name="format-detection" content="telephone=no">

	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:description" content="A web application to monitor products' prices in Lazada" />
	<meta property="og:image" content="<?=base_url('assets/img/logo.jpg'); ?>">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@iarifiany">
	<meta name="twitter:creator" content="@iarifiany">
	<meta name="twitter:title" content="<?= $title ?>">
	<meta name="twitter:image" content="<?=base_url('assets/img/logo.jpg');?>">
	<meta name="twitter:description" content="A web application to monitor products' prices in Lazada">
	<meta name="theme-color" content="#6d0000">
	<meta name="google-site-verification" content="R1AJmpriHPv9KnGMvbKBGg0lKXx7HRBbcNDeC9QUSZs" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/labjs/2.0.3/LAB.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/css/uikit.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.18/datatables.min.css" />
	<link rel="icon" href="http://i.imgur.com/I6Udqo8.png" sizes="any" type="image/png">
	<meta name="author" content="Ilma Arifiany">
    <meta name="keywords" content="Lazada">
    <meta name="description" content="A web application to monitor products' prices in Lazada">
</head>
<script>
	const base_url = "<?= base_url() ?>"
	$LAB.script("https://code.jquery.com/jquery-3.1.1.min.js")
		.script("https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.18/datatables.min.js")
		.script("https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/js/uikit.min.js")
		.script("https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.20/js/uikit-icons.min.js")
		.script("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js").wait()
		.script("<?= base_url('application/views/module/'.$file.'.js') ?>").wait();

</script>
<style>
    #content {
        margin-top: 100px;
        min-height: calc(100vh - 300px);
        background: url('http://hellolittlered.org/assets/img/birds.jpg') no-repeat #ffffff;
        background-size: 100% auto;
        }
</style>
<body>
	<div uk-sticky="media: 960" class="uk-navbar-container uk-background-primary">
		<div class="uk-container uk-container-expand">
			<nav class="uk-navbar">
				<div class="uk-navbar-left"><a href="<?= base_url() ?>" class="uk-navbar-item uk-logo"> Lazada Price Monitor
					</a></div>
				<div class="uk-navbar-right">
					<ul class="uk-navbar-nav uk-visible@m">
						<li><a href="<?= base_url('product') ?>">Monitored Products List</a></li>
					</ul>
                </div>
			</nav>
		</div>
	</div>

	<div id="loader" class="uk-modal-full" uk-modal esc-close="false" bg-close="false">
		<div class="uk-modal-dialog uk-height-1-1">
			<div class="uk-position-center">
				<span uk-spinner="ratio: 3" class="uk-margin-right"></span>
				Please wait, your link is being processed...
			</div>
		</div>
	</div>

    <div id="content">