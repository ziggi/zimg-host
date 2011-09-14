<?
include "config.php";
include "functions.php";

global $errors;


if(!empty($_GET['image']))
{
	// уберём из имени все символы, кроме тех, которые являются результатом хеша md5
	$file_name = preg_replace("/[^a-zA-Z0-9]/u","",$_GET['image']);
	$file_location = glob("files/".$file_name.".*");
	
	if(empty($file_location) || !file_exists($file_location[0]))
	{
		load_theme_module("index.php");
		exit;
	}
	
	$file_type = substr(strrchr($file_location[0], '.'), 1);
	$img = get_info("siteurl")."files/".$file_name.".".$file_type;
	$thumb_link = get_info("siteurl")."files/".$file_name."t.".$file_type;
	
	$errors .= "
	<div class='image_load'>
		<a href=\"$img\" target=\"_blank\"><img src=\"$thumb_link\"></a><br>
		<table class='g_table'>
			".add_new_tr("Ссылка",$img)."
			".add_new_tr("Превью с увеличением, BB код","[url=".$img."][img]".$thumb_link."[/img][/url]")."
			".add_new_tr("Картинка, BB код","[img]".$img."[/img]")."
			".add_new_tr("Превью с увеличением, HTML код","<a href=\"$img\" target=\"_blank\"><img src=\"$thumb_link\"></a>")."
			".add_new_tr("Картинка, HTML код","<img src=\"".$img."\">")."
		</table>
	</div>
	";
	
	load_theme_module("index.php");
	exit;
}
if(isset($_GET['step']) && isset($_FILES["filename"]) && $_FILES["filename"]["error"] != 4)
{
	// проверим размер
	if( $_FILES["filename"]["size"] > get_info("max_file_size")*1024*1024 )
	{
		$errors .= "<li>Размер файла превышает ".get_info("max_file_size")." мегабайт</li>";
		load_theme_module("index.php");
		return;
	}
	// вытащим тип файла
	if( ($pos = strpos($_FILES["filename"]["type"],"/")) == false )
	{
		$errors .= "<li>Неверный тип файла</li>";
		return;
	}
	// отсечём неподдерживаемые типы
	$file_type = substr($_FILES["filename"]["type"],$pos+1);
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
	if( is_uploaded_file($_FILES["filename"]["tmp_name"]) )
	{
		// изменим имя файла, приделав к нему дату и захешировав в md5
		$file_name = md5($_FILES["filename"]["name"].date("dmYHis"));
		move_uploaded_file($_FILES["filename"]["tmp_name"], "files/".$file_name.".".$file_type);
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
		header("Location: image/$file_name");
	}
	else
	{
		$errors .= "<li>Ошибка загрузки файла</li>";
	}
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
