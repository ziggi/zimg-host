<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title><? print_info("title") ?></title>
	<meta http-equiv='Content-Type' content='text/html; charset=<? print_info("charset") ?>'>
	<meta name='description' content='<? print_info("description") ?>'> 
	<meta name='keywords' content='<? print_info("keywords") ?>'>
	<link rel='stylesheet' type='text/css' href='<? print_info("siteurl") ?>themes/<? print_info("themename") ?>/style.css'>
	<link rel='shortcut icon' type='image/x-icon' href='<? print_info("siteurl") ?>themes/<? print_info("themename") ?>/images/favicon.ico'>
	<script>
	var input_count=0;
	function addNewInput() {
		if(input_count >= <?=get_info("max_new_inputs")?>) return;
		input = document.createElement("input");
		input.setAttribute("type", "file");
		input.setAttribute("name", "filename[]");
		input.setAttribute("size", "40");
		document.getElementById("new_inputs").appendChild(input);
		input_count++;
	}
	</script>
</head>

<body>
	<div style='width:700px;margin:0 auto;padding:150px 0 150px 0;'>
		<div id='content'>
			<? global $errors; if(!empty($errors)) echo $errors."<br>"; ?>
			<input type="submit" value="Добавить поле" style='width:100px' onClick='addNewInput()'>
			<br>
			<form action="<? print_info("siteurl") ?>?step" method="post" enctype="multipart/form-data">
				<input type="file" name="filename[]" size="40" multiple>
				<div id='new_inputs'></div>
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
