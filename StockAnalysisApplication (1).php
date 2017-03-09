<!DOCTYPE HTML>
<html>
    
         <head>
    
    <link rel="stylesheet" type="text/css" href="form.css">
    
</head>
    <?php




function masterLoop(){
 
    $mainTickerFile=fopen("../tickerMaster.txt","r");
    
    while(!feof($mainTickerFile)){ //pointer checking for eof
    
        $companyTicker=fgets($mainTickerFile); //return line of tt as string
                                               //moves pointer to eol
        $companyTicker=trim($companyTicker); //no whitespace
        
        $nextDayIncrease=1;
        $nextDayDecrease=1;
        $nextDayNoChange=1;
        
        $Total=1;
        
        $sumOfIncreases=1;
        $sumOfDecreases=1;
        
        
        
        
        
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
        
        

        //all days where stock price went down
        $sql="select date, amountChangedPercent from $companyTicker where amountChangedPercent < '0' order by date ASC" ;
       
        $result    =    $conn->query($sql);
        
        
        if ($result) {
            
            while($row=mysqli_fetch_array($result)){
                  
                  //date when stock price went down
                
                  $date=$row['date'];
                  $amountChangedPercent=$row['amountChangedPercent'];
                  
        
                
                
                
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
                
                  //for next date
                  $sql2="select date,amountChangedPercent from $companyTicker where date > '$date' ORDER BY date ASC LIMIT 1";
                
                  $result2    =    $conn->query($sql2);

                //if no tomorrow
                  
                  $numberOfRows=mysqli_num_rows($result2);
                  
                  if($numberOfRows==1)
                  {
                      
                      //tomorrow exist
                      
                      $row2=mysqli_fetch_row($result2);
                      
                      $tomorrow_date=$row2[0];
                      $tomorrow_percent_change=$row2[1];
                      
                      if($tomorrow_percent_change>0){
                          $nextDayIncrease++;
                          $sumOfIncreases+=$tomorrow_percent_change;
                          $Total++;
                            
                      }
                      
                      else{
                          if($tomorrow_percent_change<0){
                          $nextDayDecrease++;
                          $sumOfDecreases+=$tomorrow_percent_change;
                          $Total++;
                          }
                          
                      
                      else {
                          $nextDayNoChange++;
                          $Total++;
                      }
                      }
                      
                  
                      }
                      
                      else if($numberOfRows==0){
                          //no data for today
                      }
                      

                      
                  }       

          }
       
        $nextDayIncreasePercent=($nextDayIncrease/$Total)*100;
        $nextDayDecreasePercent=($nextDayDecrease/$Total)*100;
        
        $avgIncreasePercentage=($sumOfIncreases/$nextDayIncrease);
        $avgDecreasePercentage=-1*($sumOfDecreases/$nextDayDecrease);
        
        insertIntoResultTable($companyTicker,$nextDayIncrease,$nextDayIncreasePercent,$avgIncreasePercentage,$nextDayDecrease,$nextDayDecreasePercent,$avgDecreasePercentage);

    }
    fclose($mainTickerFile);

}

function insertIntoResultTable($companyTicker,$nextDayIncrease,$nextDayIncreasePercent,$avgIncreasePercentage,$nextDayDecrease,$nextDayDecreasePercent,$avgDecreasePercentage)

  {
        $buyValue=$nextDayIncreasePercent*$avgIncreasePercentage;
        $sellValue=$nextDayDecreasePercent*$avgDecreasePercentage;
    
    
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
    
    

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database="database";

        // Create connection
        $conn = new mysqli($servername, $username, $password,$database);
    
    $sql="select * from analysis where ticker='$companyTicker' ";
    $val = mysqli_query($conn,'".$sql."');
    //$result    =    $conn->query($sql);
    
    
  //  if(!$result){
    
    
    if($val !== FALSE)
{
  $sql="update analysis set ticker='".$companyTicker."',daysInc='".$nextDayIncrease."' pctOfDaysInc='".$nextDayIncreasePercent."' ,avgIncPct='".$avgIncreasePercentage."' , daysDec='".$nextDayDecrease."' , pctOfDaysDec='".$nextDayDecreasePercent."',avgDecPec='".$avgDecreasePercentage."' , buyValue='".$buyValue."' , sellValue='".$sellValue."' where ticker='".$companyTicker."' ";
      $conn->query($sql);
        
      //  echo " in update";
     if(!$conn->query($sql)==1){
       //  echo "update";
     }
}
else
{
         $sql2="insert into analysis (ticker,daysInc,pctOfDaysInc ,avgIncPct, daysDec , pctOfDaysDec,avgDecPec , buyValue , sellValue) VALUES ( '".$companyTicker."' , '".$nextDayIncrease."' , '".$nextDayIncreasePercent."' , '".$avgIncreasePercentage."' , '".$nextDayDecrease."' , '".$nextDayDecreasePercent."' , '".$avgDecreasePercentage."' , '".$buyValue."', '".$sellValue."' ) " ;
        
         $result2    =    $conn->query($sql2);
                // echo "in insert";

        
    if(!$result2){
       // echo " and failed";
   
               }
        
        
         }
}
        
masterLoop();             
        




?>
    <button onClick="window.location='GenerateXML.php'">GENERATE XML</button>
    </body>
</html>