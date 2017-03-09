<?php
$servername = "localhost";
$username = "root";
$password = "";
$database="form_data";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";




    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $image=basename( $_FILES["imageUpload"]["name"],".jpg"); // used to store the filename in a variable




$name=$_POST['name'];

$address=$_POST['address'];

$number=$_POST['number'];

$email=$_POST['email'];

$roll_number=$_POST['roll_number'];

$undergraduate=$_POST['undergraduate'];
$undergraduate_from=$_POST['undergraduate_from'];
$undergraduate_to=$_POST['undergraduate_to'];

$intermideate_subjects=$_POST['intermideate_subjects'];
$college_name=$_POST['college_name'];

$major_project_year=$_POST['major_project_year'];
$major_projetc_name=$_POST['major_projetc_name'];
$major_project_discription=$_POST['major_project_discription'];

$major_project_year_2=$_POST['major_project_year_2'];
$major_projetc_name_2=$_POST['major_projetc_name_2'];
$major_project_discription_2=$_POST['major_project_discription_2'];

$skills_level=$_POST['skills_level'];
$skills_detail=$_POST['skills_detail'];

$work_year_1=$_POST['work_year_1'];
$organization_name_1=$_POST['organization_name_1'];
$work_discription_1=$_POST['work_discription_1'];

$work_year_2=$_POST['work_year_2'];
$organization_name_2=$_POST['organization_name_2'];
$work_discription_2=$_POST['work_discription_2'];

$award_year_1=$_POST['award_year_1'];
$award_1=$_POST['award_1'];


if (empty($name) || empty($roll_number) || empty($email) || empty($number)) {
                echo "<script>alert('PLEASE CHECK YOUR CREDENTIALS!');</script>";  
           echo '<script type="text/javascript"> window.open("Form.html","_self");</script>';  
    
}
else{
    
    


$sql = "INSERT INTO form(NAME,ADDRESS,MOBILE_NUMBER,EMAIL,ROLL_NUMBER,DEPARTMENT,B_FROM,B_TO,INTERMEDIATE,COLLEGE_NAME,PROJECT_YEAR,PROJECT_NAME,PROJECT_DISCRIPTION,PROJECT_YEAR_2,PROJECT_NAME_2,PROJECT_DISCRIPTION_2,SKILL_LEVEL,SKILL_NAME,WORK_YEAR_1,ORG_1,WORK_DISCRIPTION,WORK_YEAR_2,ORG_2,WORK_DISCRIPTION_2,AWARD_1_YEAR,AWARD_1_DISCRIPTION) VALUES('".$name."' , '".$address."' , '".$number."' , '".$email."' , '".$roll_number."' , '".$undergraduate."' , '".$undergraduate_from."' , '".$undergraduate_to."' , '".$intermideate_subjects."' , '".$college_name."' , '".$major_project_year."' , '".$major_projetc_name."' , '".$major_project_discription."' , '".$major_project_year_2."' , '".$major_projetc_name_2."' , '".$major_project_discription_2."' , '".$skills_level."' , '".$skills_detail."' , '".$work_year_1."' , '".$organization_name_1."' , '".$work_discription_1."' , '".$work_year_2."' , '".$organization_name_2."' , '".$work_discription_2."' , '".$award_year_1."' , '".$award_1."')";

if ($conn->query($sql) === TRUE) {
   
            echo "<script>alert('THANK YOU!');</script>";  
           echo '<script type="text/javascript"> window.open("Form.html","_self");</script>';            //  On Successfull Login redirects to home.php
            

    
    
    
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>