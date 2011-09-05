<?

function get_info( $info )
{
	switch( $info )
	{
		case "engine_version":
		{
			$output = "1.0.0";
			break;
		}
		case "max_file_size":
		{
			$output = 0.5;
			break;
		}
		case "title":
		{
			$output = "ZiGGi Image Host";
			break;
		}
		case "charset":
		{
			$output = "UTF-8";
			break;
		}
		case "description":
		{
			$output = "ZiGGi Image hosting";
			break;
		}
		case "keywords":
		{
			$output = "image host";
			break;
		}
		case "themename":
		{
			$output = "standart";
			break;
		}
		case "siteurl":
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