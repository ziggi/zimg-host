<?

date_default_timezone_set('Europe/Moscow');

function get_info( $info )
{
	switch( $info )
	{
		case "engine_version": // версия скрипта
		{
			$output = "1.3.0";
			break;
		}
		case "max_file_size": // максимальный размер одного файла, в мегабайтах
		{
			$output = 0.5;
			break;
		}
		case "max_upload_files": // максимальное количество загружаемых файлов
		{
			$output = 10;
			break;
		}
		case "max_new_inputs": // максимальное количество создаваемых input type=file
		{
			$output = 10;
			break;
		}
		case "title": // текст между <title> и </title>
		{
			$output = "ZImage Host";
			break;
		}
		case "charset":
		{
			$output = "UTF-8";
			break;
		}
		case "description": // описание ресурса
		{
			$output = "ZImage hosting";
			break;
		}
		case "keywords": // теги
		{
			$output = "image host,zimage host";
			break;
		}
		case "themename": // название темы, тема должна быть в папке themes/
		{
			$output = "standart";
			break;
		}
		case "siteurl": // url вашего сайта
		{
			$output = "http://127.0.0.1/img.ziggi.su/";
			break;
		}
		case "themedir":
		{
			$output = get_info("siteurl")."themes/".get_info("themename");
			break;
		}
	}
	return $output;
}

?>
