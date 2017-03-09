<!DOCTYPE html>
<html>
    
             <head>
    
    <link rel="stylesheet" type="text/css" href="form.css">
    
</head>
    
    
<body>

 <?php

include("includes/connect.php");


    

function createURL($ticker){
    
    $currentMonth=date("n");
    $currentMonth=$currentMonth-1;
    
    $currentDay=date("j");
    
    $currentYear=date("Y");
    
    return "http://real-chart.finance.yahoo.com/table.csv?s=$ticker&d=$currentMonth&e=$currentDay&f=$currentYear&g=d&a=11&b=31&c=2013&ignore=.csv";
 //         http://real-chart.finance.yahoo.com/table.csv?s=YHOO   &d=4            &e=7          &f=2016        &g=d&a=3&b=12&c=1996&ignore=.csv
//          http://real-chart.finance.yahoo.com/table.csv?s=YHOO   &d=4            &e=7          &f=2016        &g=d&a=4&b=19&c=2016&ignore=.csv
//          http://real-chart.finance.yahoo.com/table.csv?s=YHOO&amp;d=4&amp;e=7&amp;f=2016&amp;g=d&amp;a=4&amp;b=19&amp;c=2016&amp;ignore=.csv
}

    
    
   // http://real-chart.finance.yahoo.com/table.csv?s=YHOO&d=4&e=7&f=2016&g=d&a=3&b=12&c=1996&ignore=.csv
//    http://real-chart.finance.yahoo.com/table.csv?s=YHOO&amp;d=4&amp;e=7&amp;f=2016&amp;g=d&amp;a=4&amp;b=19&amp;c=2016&amp;ignore=.csv



function getCSVFile($url,$outputFile){
    //$content=file_get_contents($url.urlencode('limit=4&offset=0&s_date=2012-02-05&e_date=2012-03-13&order=release_date&dir=desc&cid=12'));
    $content = file_get_contents($url);
    $content=str_replace("Date,Open,High,Low,Close,Volume,Adj Close","",$content);
    
    $content=trim($content); //remove whitespace
    
    file_put_contents("$outputFile",$content);
    
    
}


function fileToDatabase($txtFile,$tableName){
    
    $file=fopen($txtFile,"r");
    
    while(!feof($file)){
        
        $line=fgets($file); // returns line as string
        $pieces=explode(",",$line); //breaking string of text in array seperated based on ","
            
        $date=$pieces[0];
        $open=$pieces[1];
        $high=$pieces[2];
        $low=$pieces[3];
        $close=$pieces[4];
        $volume=$pieces[5];
        
        $amountChanged=$close-$open;
        $amountChangedPercent=($amountChanged/$open)*100;  // how well stock did
        

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database="database";

        // Create connection
        $conn = new mysqli($servername, $username, $password,$database);

// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        
        
        $sql="select * from '".$tableName."' ";
       

        if (!$conn->query($sql) === TRUE) {
   

     $sql2="create table $tableName (date DATE, PRIMARY KEY(date) , open FLOAT ,high FLOAT ,low FLOAT ,close FLOAT ,volume INT, amountChanged FLOAT , amountChangedPercent FLOAT )";
            
        if ($conn->query($sql2) === TRUE) {}
    
        }
  

    //insert values
        
       


     
        
//        
//        $date=$pieces[0];
//        $open=$pieces[1];
//        $high=$pieces[2];
//        $low=$pieces[3];
//        $close=$pieces[4];
//        $volume=$pieces[5];
//        
//        $amountChanged=$close-$open;
//        $amountChangedPercent=($amountChanged/$open)*100;
        
        
     $sql3= "insert into $tableName (date , open , high, low ,close ,volume, amountChanged , amountChangedPercent ) VALUES ('".$date."' , '".$open."' , '".$high."' , '".$low."' , '".$close."' , '".$volume."' , '".$amountChanged."' , '".$amountChangedPercent."')  ";
            
        if ($conn->query($sql3) === TRUE) {
            //yaay
        }
            
            else{
                
              //  die(" failed :p " . $conn->connect_error);
            }
    
    
        
    }
    
    fclose($file);
}


function main(){
    $mainTickerFile=fopen("tickerMaster.txt","r");
    
    while(!feof($mainTickerFile)){
        
        $companyTicker=fgets($mainTickerFile);
        $companyTicker=trim($companyTicker);
        $fileURL=createURL($companyTicker);               //creating url
        $companyTxtFile= "txtFiles/".$companyTicker.".txt"; //naming
        getCSVFile($fileURL,$companyTxtFile);   // save csv info as text 
        fileToDatabase($companyTxtFile,$companyTicker); //save txt to db
         
  }

    
   
}




main();  
    
        


    ?>
    
    <button onClick="window.location='anylasis/anylsis_a.php'">ANALYSE DATA</button>

</body>
</html>