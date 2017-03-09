<!DOCTYPE HTML>
<html>
    
         <head>
    
    <link rel="stylesheet" type="text/css" href="form.css">
    
</head>

    <?php
$name = $_POST['name'];
file_put_contents("tickerMaster.txt",$name); // Will put the text to file
?>
    
    <button onClick="window.location='stockDownloader.php'">DOWNLOAD DATA</button>
    
</body>
</html>