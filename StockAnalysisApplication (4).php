<!DOCTYPE HTML>
<html>
    
         <head>
    
    <link rel="stylesheet" type="text/css" href="form.css">
    
</head>

<?php
    

    
	$conni = mysqli_connect('localhost' , 'root','' );
	$selected = mysqli_select_db($conni, 'database');
    

    
    
    
	$query = "select * from analysis";
	$result = mysqli_query($conni, $query);
	
	$xml=new XMLWRITER();
	$xml->openURI('test.xml');
	$xml->startDocument('1.0','UTF-8');
	$xml->setIndent(true);
	$xml->startElement('company');

		while($row = mysqli_fetch_assoc($result))
		{	
				$xml->startElement('company');
					
					$xml->startElement('name');
						$xml->writeRaw($row['ticker']);
					$xml->endElement();
					
					$xml->startElement('days_increased');
						$xml->writeRaw($row['daysInc']);
					$xml->endElement();	
					
					$xml->startElement('percentage_of_days_increased');
						$xml->writeRaw($row['pctOfDaysInc']);
					$xml->endElement();
					
					$xml->startElement('average_increase_percentage');
						$xml->writeRaw($row['avgIncPct']);
					$xml->endElement();
					
					$xml->startElement('days_decreased');
						$xml->writeRaw($row['daysDec']);
					$xml->endElement();
					
					$xml->startElement('percentage_of_days_decreased');
						$xml->writeRaw($row['pctOfDaysDec']);
					$xml->endElement();
					
					$xml->startElement('average_decrease_percentage');
						$xml->writeRaw($row['avgDecPec']);
					$xml->endElement();
					
					$xml->startElement('buy_value');
						$xml->writeRaw($row['buyValue']);
					$xml->endElement();
					
					$xml->startElement('sell_value');
						$xml->writeRaw($row['sellValue']);
					$xml->endElement();
					
					
					
				$xml->endElement();
			
		}
	$xml->endElement();
	$xml->flush();
	
	echo "XML generated sucessfully";
        
//	echo "
//			<form action=\"GenerateXML.php\" method=\"post\">
//			<input type=\"submit\" value=\"Show XML\" name='showXML'>
//			</form>
//		";
//	if(isset($_POST['showXML']))
//	{
	header('location: test2.xml');
//	}
    

    

?>
    
    
        
</body>
</html>