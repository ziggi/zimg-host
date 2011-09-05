<?
include "config.php";
include "functions.php";

global $errors;

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
		// изменим имя файла по дате и времени
		$file_md5salt = md5($_FILES["filename"]["name"].date("dmYHis"));
		$file_name = substr($file_md5salt,strlen($file_md5salt)/2);
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
		// выводим
		$errors .= "
		<div class='image_load'>
			<img src='$thumb_link' width='100' height='100'><br>
			<table class='g_table'>
				".add_new_tr("Ссылка",$img)."
				".add_new_tr("Превью с увеличением, BB код","[url=".$img."][img]".$thumb_link."[/img][/url]")."
				".add_new_tr("Картинка, BB код","[img]".$img."[/img]")."
				".add_new_tr("Превью с увеличением, HTML код","<a href=\"$img\" target=\"_blank\"><img src=\"$thumb_link\"></a>")."
				".add_new_tr("Картинка, HTML код","<img src=\"".$img."\">")."
			</table>
		</div>
		";
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