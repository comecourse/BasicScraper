<!DOCTYPE html>
<html>
<head>
	<title>ASIN Scraper</title>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<form method="get">
	<label>ASIN: <input name="asin"></label>
</form>
<?php
	$asin=filter_input(INPUT_GET, asin);

	if(!empty($asin))
	{
		$baseURL="https://www.amazon.com/gp/product/";

		$html=file_get_contents($baseURL . $asin);
		
		$isMatched=preg_match('!"priceblock_ourprice".*\$(.*)<!', $html,$match);
		// echo "<pre>";
		// print_r($match);
		// echo "</pre>";

		if($isMatched && isset($match[1]))
		{
			$price=$match[1];	
		}
		else
		{
			$isMatched=preg_match('|"priceblock_saleprice".*\$(.*)<|', $html,$match);
					if($isMatched && isset($match[1]))
					{
						$price=$match[1];	
					}
					else
						$price=0;

		}

	
		
		echo "$" .$price;

		$isMatched=preg_match_all('|"hiRes":null,"thumb":"(https://images-na.ssl-images-amazon.com/images/I/*.[^"]+.jpg)"|', $html, $matches);

	

			if($isMatched && isset($matches[0]))
			{
				// foreach ($matches[1] as $img ) 
				// {
				// 	# code...
				// 	echo "<img src='$img'><br />";
				// }

				$img=$matches[1];
				echo "<img src='$img[0]' style='width='200px'; height='200px;'><br />";
			}
			else
			{
				$isMatched=preg_match_all('|"hiRes":"(https://images-na.ssl-images-amazon.com/images/I/*.[^"]+.jpg)"|', $html, $matches);
				if($isMatched && isset($matches[0]))
				{
					$img=$matches[1];
					echo "<img src='$img[0]' style='width='200px'; height='200px;'><br />";
				}

			}

		// echo "<pre>";
		// print_r($matches);
		// echo "</pre>";
	}
	
?>
</body>
</html>
