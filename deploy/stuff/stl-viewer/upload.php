<?php
   if(isset($_FILES['stl'])){
      $errors= array();
      $file_name = $_FILES['stl']['name'];
      $file_size =$_FILES['stl']['size'];
      $file_tmp =$_FILES['stl']['tmp_name'];
      $file_type=$_FILES['stl']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['stl']['name'])));
      
      if($file_ext != "stl"){
         $errors[]="Sorry, only STL files are allowed.";
      }
      
      if($file_size > 10485760){
         $errors[]='File size must be smaller than 10 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"/var/www/models/".$file_name);
         echo "Success. Redirecting...";
      }else{
         print_r($errors);
      }
      header('Location: http://localhost/');
   }
?>