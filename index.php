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
if(isset($_GET['step']) && !empty($_POST['file_urls']))
{
	$file_urls = preg_replace("/[^a-zA-Zа-яА-Я0-9\n:\.\-_\/]/u","",$_POST['file_urls']);
	$array["name"] = split("\n",$file_urls);
	// очистим массив от пустых элементов
	$array["name"] = array_unset_empty($array["name"]);
	// обрежем массив до get_info("max_upload_files") элементов
	if(($count = count($array["name"])) > get_info("max_upload_files")-1)
	{
		$tmp = array_chunk($array["name"],get_info("max_upload_files"));
		$array["name"] = $tmp[0];
	}
	for($i=0;$i<$count;$i++)
	{
		$array["tmp_name"][$i] = tempnam("/tmp","php");
		
		$content = file_get_contents($array["name"][$i]);
		if($content == false) continue;
		$file = fopen($array["tmp_name"][$i], "w");
		fwrite($file, $content);
		fclose($file);
		
		$array["size"][$i] = filesize($array["tmp_name"][$i]);
	}
	load_files($array);
	exit;
}
if(isset($_GET['step']) && isset($_FILES["filename"]) && $_FILES["filename"]["error"][0] != 4 && empty($_POST['file_urls']))
{
	load_files($_FILES["filename"]);
	exit;
}

load_theme_module("index.php");

function add_new_tr($name,$value)
{
	return "<tr>
		<td style='width:200px'>$name:</td>
		<td style='padding-right:5px;'><input type='text' value='$value' onClick=select() readonly></td>
	</tr>";
}

function load_files($files_array)
{
	global $errors;
	$url_result = "Location: image/";
	// очистим массив от пустых элементов
	$files_array["name"] = array_unset_empty($files_array["name"]);
	// обрежем массив до get_info("max_upload_files") элементов
	if(($count = count($files_array["name"])) > get_info("max_upload_files")-1)
	{
		$tmp = array_chunk($array["name"],get_info("max_upload_files"));
		$files_array["name"] = $tmp[0];
	}
	for($i=0;$i<$count;$i++)
	{
		// проверим размер
		if( $files_array["size"][$i] > get_info("max_file_size")*1024*1024 )
		{
			$errors .= "<li>Размер файла `".$files_array["name"][$i]."` превышает ".get_info("max_file_size")." мегабайт</li>";
			continue;
		}
		// извлекём тип файла
		$file_type = strtolower(array_pop(explode('.',$files_array["name"][$i])));
		// отсечём неподдерживаемые типы
		switch( $file_type )
		{
			case "jpeg": break;
			case "jpg": break;
			case "png": break;
			case "gif": break;
			case "bmp": break;
			default:
			{
				$errors .= "<li>Неверный тип файла</li>";
				return;
			}
		}
		if( file_exists($files_array["tmp_name"][$i]) )
		{
			// изменим имя файла, приделав к нему дату и захешировав в md5
			$file_name = md5($files_array["name"][$i].date("dmYHis"));
			rename($files_array["tmp_name"][$i], "files/".$file_name.".".$file_type);
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
				case "jpg":
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
			return;
		}
	}
	header( substr($url_result, 0, strrpos($url_result,",")) );
}

function array_unset_empty($array)
{
	$ret_arr = array();
	foreach($array as $val)
	{
		if(empty($val)) continue;
		$ret_arr[] = $val;
	}
	return $ret_arr;
}

?>
