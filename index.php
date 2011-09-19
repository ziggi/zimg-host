<?
include "config.php";
include "functions.php";

global $errors;


if(!empty($_GET['image']))
{
	$file_names = explode(",",$_GET['image']);
	
	$img = array();
	$thumb_link = array();
	$img_links="";
	$thumb_bb="";
	$img_bb="";
	$thumb_html="";
	$img_html="";
	for($i=0;$i<count($file_names);$i++)
	{
		if(empty($file_names[$i])) continue;
		// уберём из имени все символы, кроме тех, которые являются результатом хеша md5
		$file_name = preg_replace("/[^a-zA-Z0-9]/u","",$file_names[$i]);
		$file_location = glob("files/".$file_name.".*");
		
		if(empty($file_location) || !file_exists($file_location[0])) continue;
		
		$file_type = substr(strrchr($file_location[0], '.'), 1);
		$img[$i] = get_info("siteurl")."files/".$file_name.".".$file_type;
		$thumb_link[$i] = get_info("siteurl")."files/".$file_name."t.".$file_type;
		
		$img_links .= $img[$i]."\n";
		$thumb_bb .= "[url=".$img[$i]."][img]".$thumb_link[$i]."[/img][/url]\n";
		$img_bb .= "[img]".$img[$i]."[/img]\n";
		$thumb_html .= "<a href=\"$img[$i]\" target=\"_blank\"><img src=\"$thumb_link[$i]\"></a>\n";
		$img_html .= "<img src=\"".$img[$i]."\">\n";
	}
	if(count($file_names) > 1)
	{
		$errors .= "
		
		<div class='image_load'>
			<span class='text_b'>Суммарная информация</span><br><br>
			<table class='g_table'>
				<tr>
					<td style='width:200px'>Ссылки</td>
					<td style='padding-right:5px;'><textarea onClick=select() readonly>$img_links</textarea></td>
				</tr>
				<tr>
					<td style='width:200px'>Превью с увеличением, BB код</td>
					<td style='padding-right:5px;'><textarea onClick=select() readonly>$thumb_bb</textarea></td>
				</tr>
				<tr>
					<td style='width:200px'>Картинка, BB код</td>
					<td style='padding-right:5px;'><textarea onClick=select() readonly>$img_bb</textarea></td>
				</tr>
				<tr>
					<td style='width:200px'>Превью с увеличением, HTML код</td>
					<td style='padding-right:5px;'><textarea onClick=select() readonly>$thumb_html</textarea></td>
				</tr>
				<tr>
					<td style='width:200px'>Картинка, HTML код</td>
					<td style='padding-right:5px;'><textarea onClick=select() readonly>$img_html</textarea></td>
				</tr>
			</table>
		</div>
		<br><br>
		<center><span class='text_b'>Информация по каждой картинке</span></center>
		<br>
		";
	}
	for($i=0;$i<count($file_names);$i++)
	{
		$file_location = glob("files/".$file_names[$i].".*");
		if(empty($file_names[$i]) || empty($file_location[0])|| !file_exists($file_location[0])) continue;
		$errors .= "
		<div class='image_load'>
			<a href=\"$img[$i]\" target=\"_blank\"><img src=\"$thumb_link[$i]\"></a><br>
			<table class='g_table'>
				".add_new_tr("Ссылка",$img[$i])."
				".add_new_tr("Превью с увеличением, BB код","[url=".$img[$i]."][img]".$thumb_link[$i]."[/img][/url]")."
				".add_new_tr("Картинка, BB код","[img]".$img[$i]."[/img]")."
				".add_new_tr("Превью с увеличением, HTML код","<a href=\"$img[$i]\" target=\"_blank\"><img src=\"$thumb_link[$i]\"></a>")."
				".add_new_tr("Картинка, HTML код","<img src=\"".$img[$i]."\">")."
			</table>
		</div>
		";
	}
	load_theme_module("index.php");
	exit;
}

if(isset($_GET['step']) && isset($_FILES["filename"]) && $_FILES["filename"]["error"] != 4)
{
	$url_result = "Location: image/";
	for($i=0;$i<count($_FILES["filename"]);$i++)
	{
		if(empty($_FILES["filename"]["name"][$i])) continue;
		// проверим размер
		if( $_FILES["filename"]["size"][$i] > get_info("max_file_size")*1024*1024 )
		{
			$errors .= "<li>Размер файла превышает ".get_info("max_file_size")." мегабайт</li>";
			load_theme_module("index.php");
			return;
		}
		// вытащим тип файла
		if( ($pos = strpos($_FILES["filename"]["type"][$i],"/")) == false )
		{
			$errors .= "<li>Неверный тип файла</li>";
			return;
		}
		// отсечём неподдерживаемые типы
		$file_type = substr($_FILES["filename"]["type"][$i],$pos+1);
		switch( $file_type )
		{
			case "jpeg": break;
			case "png": break;
			case "gif": break;
			case "bmp": break;
			default:
			{
				$errors .= "<li>Неверный тип файла</li>";
				load_theme_module("index.php");
				exit;
			}
		}
		if( is_uploaded_file($_FILES["filename"]["tmp_name"][$i]) )
		{
			// изменим имя файла, приделав к нему дату и захешировав в md5
			$file_name = md5($_FILES["filename"]["name"][$i].date("dmYHis"));
			move_uploaded_file($_FILES["filename"]["tmp_name"][$i], "files/".$file_name.".".$file_type);
			// print link on img
			$img = get_info("siteurl")."files/".$file_name.".".$file_type;
			// параметры уменьшенной картинки
			list($width, $height) = getimagesize($img);
			$newwidth = $newheight = 100;
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$thumb_link = get_info("siteurl")."files/".$file_name."t.".$file_type;
			// создаём уменьшенную версию картинки
			switch( $file_type )
			{
				case "jpeg":
				{
					$source = imagecreatefromjpeg($img);
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					// приделываем плюс
					$plus_source = imagecreatefrompng("plus.png");
					imagecopy($thumb, $plus_source, 90, 90, 0, 0, 10, 10);
					// сохраняем итог в файл
					imagejpeg($thumb,"files/".$file_name."t.".$file_type);
					break;
				}
				case "png":
				{
					$source = imagecreatefrompng($img);
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					// приделываем плюс
					$plus_source = imagecreatefrompng("plus.png");
					imagecopy($thumb, $plus_source, 90, 90, 0, 0, 10, 10);
					// сохраняем итог в файл
					imagepng($thumb,"files/".$file_name."t.".$file_type);
					break;
				}
				case "gif":
				{
					$source = imagecreatefromgif($img);
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					// приделываем плюс
					$plus_source = imagecreatefrompng("plus.png");
					imagecopy($thumb, $plus_source, 90, 90, 0, 0, 10, 10);
					// сохраняем итог в файл
					imagegif($thumb,"files/".$file_name."t.".$file_type);
					break;
				}
				case "bmp":
				{
					$source = imagecreatefromwbmp($img);
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					// приделываем плюс
					$plus_source = imagecreatefrompng("plus.png");
					imagecopy($thumb, $plus_source, 90, 90, 0, 0, 10, 10);
					// сохраняем итог в файл
					imagewbmp($thumb,"files/".$file_name."t.".$file_type);
					break;
				}
			}
			// перекидываем на страницу изображения
			$url_result .= "$file_name,";
		}
		else
		{
			$errors .= "<li>Ошибка загрузки файла</li>";
		}
	}
	header( substr($url_result, 0, -1) );
}

load_theme_module("index.php");

function add_new_tr($name,$value)
{
	return "<tr>
		<td style='width:200px'>$name:</td>
		<td style='padding-right:5px;'><input type='text' value='$value' onClick=select() readonly></td>
	</tr>";
}
?>
