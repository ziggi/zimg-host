<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title><? print_info("title") ?></title>
	<meta http-equiv='Content-Type' content='text/html; charset=<? print_info("charset") ?>'>
	<meta name='description' content='<? print_info("description") ?>'> 
	<meta name='keywords' content='<? print_info("keywords") ?>'>
	<link rel='stylesheet' type='text/css' href='<? print_info("siteurl") ?>themes/<? print_info("themename") ?>/style.css'>
	<link rel='shortcut icon' type='image/x-icon' href='<? print_info("siteurl") ?>themes/<? print_info("themename") ?>/images/favicon.ico'>
</head>

<body>
	<div style='width:600px;margin:0 auto;padding-top:150px;'>
		<div id='content'>
			<? global $errors; echo $errors; ?>
			<br>
			<form action="<? print_info("siteurl") ?>?step" method="post" enctype="multipart/form-data">
				<input type="file" name="filename" size='40'>
				<br><br>
				<input type="submit" value="Загрузить">
			</form>
		</div>
		<div id='footer'>
			<div class='text_a' style='text-align:left;float:left;'>v<? print_info("engine_version"); ?></div>
			<div class='text_a' style='text-align:right;float:right;'><a href='http://ziggi.su/' target='_blank'>ZiGGi</a></div>
		</div>
	</div>
</body>

</html>
