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
	var input_count=1;
	function addNewInput()
	{
		if(input_count >= <?=get_info("max_new_inputs")?>) return;
		input = document.createElement("input");
		input.setAttribute("type", "file");
		input.setAttribute("name", "filename[]");
		input.setAttribute("size", "40");
		if(input_count == 0)
		{
			document.getElementById("inputs").innerHTML = "";
			input.setAttribute("multiple","multiple");
		}
		document.getElementById("inputs").appendChild(input);
		input_count++;
	}
	function addTextArea()
	{
		input_count=0;
		document.getElementById("inputs").innerHTML = "<textarea name='file_urls' style='height:100px;width:97%'></textarea>";
	}
	</script>
</head>

<body>
	<div style='width:700px;margin:0 auto;padding:150px 0 150px 0;'>
		<div id='content'>
			<? global $errors; if(!empty($errors)) echo $errors."<br>"; ?>
			<input type="submit" value="Добавить поле" style='width:120px' onClick='addNewInput()'>
			<input type="submit" value="Загрузить с URL" style='width:120px;float:right;' onClick='addTextArea()'>
			<br>
			<form action="<? print_info("siteurl") ?>?step" method="post" enctype="multipart/form-data">
				<br>
				<div id='inputs'>
					<input type="file" name="filename[]" size="40" multiple>
				</div>
				<br><br>
				<input type="submit" value="Загрузить">
			</form>
		</div>
		<div id='footer'>
			<div class='text_a' style='text-align:left;float:left;'><a href='http://ziggi.su/category/developments/zimage-host-developments/' target='_blank'>v<? print_info("engine_version"); ?></a></div>
			<div class='text_a' style='text-align:right;float:right;'><a href='http://ziggi.su/' target='_blank'>ZiGGi</a></div>
		</div>
	</div>
</body>

</html>
