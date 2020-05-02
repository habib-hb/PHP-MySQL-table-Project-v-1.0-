
<?php
$db="mysql:host=localhost;dbname=fm_db";
$db_user="root";
$db_password="";
try{
$conn=new PDO($db,$db_user,$db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);



}
catch(PDOException $e){
   echo "Failed..." . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form</title>
</head>
<body>
<style>
body{
  background-color: beige;
}
#editButton{
  background-color:rgb(166, 190, 241);
  border-color: rgb(224, 155, 155);
}
#editButton:hover{
  background-color:rgb(219, 230, 197);
  border-color: rgb(38, 148, 11);
}
#deleteButton{
  background-color:rgb(226, 211, 128);
  border-color: rgb(226, 17, 17);
}
#deleteButton:hover{
  background-color:rgb(219, 230, 197);
  border-color: rgb(38, 148, 11);
}
#add{
  background-color: rgb(111, 221, 47);
}
#add:hover{
  background-color:rgb(219, 230, 197);
  border-color: rgb(38, 148, 11);
  width:60px;
}
#div{
  margin: 0 auto;
  background-color: rgb(243, 243, 183);
  width:693px;
}
</style>
  <div id='div'>



<?php


if(isset($_REQUEST['delete'])){

  $sql="DELETE FROM group1 WHERE id=:id";

$result=$conn->prepare($sql);
$deleteid=$_REQUEST['id'];
$result->execute(array('id'=>$deleteid));

unset($result);



}
if(isset($_REQUEST['newAdd'])){
  
  
  if(($_REQUEST['addName']=="")||($_REQUEST['addHeight']=="")||($_REQUEST['addAge']=="")){
    echo "<p>Fill All Fields</p>";

  }
  else{
          $sql="INSERT INTO group1 (name,height,age) VALUE(:name,:height,:age)";
    $result=$conn->prepare($sql);
    $addName=$_REQUEST['addName'];
    $addHeight=$_REQUEST['addHeight'];
    $addAge=$_REQUEST['addAge'];
  
    $result->execute(array('name'=>$addName,'height'=>$addHeight,'age'=>$addAge));  
    unset($result);
    
    
  }

  
}
if(isset($_REQUEST['edit'])){
  echo "<fieldset style='width:150px'>";
  echo "<form>";
  echo "<i>Name</i><br><input id='editName' name='editName' value=".$_REQUEST['name']."><br>";
  echo "<i>HEIGHT</i><br><input name='editHeight' value=".$_REQUEST['height']."><br>";
  echo "<i>AGE</i><br><input name='editAge' value=".$_REQUEST['age']."><br>";

  echo "<br><input type='hidden' name='editId' value=".$_REQUEST['id']."><button type='submit' name='update'>Update</button></form>";
  echo "</fieldset>";



  
}
if(isset($_REQUEST['update'])){
  //checking
if(($_REQUEST['editName']=="")||($_REQUEST['editHeight']=="")||($_REQUEST['editAge']=="")){
   
}else{

  
$sql="UPDATE group1 SET name=:name,height=:height,age=:age WHERE id=:id";
  
$result = $conn->prepare($sql);
$editId=$_REQUEST['editId'];
$editName=$_REQUEST['editName'];
$editHeight=$_REQUEST['editHeight'];
$editAge=$_REQUEST['editAge'];
$result->execute(array('id'=>$editId,'name'=>$editName,'height'=>$editHeight,'age'=>$editAge));


}

  }
  
?>
 <?php
   $sql="SELECT * FROM group1";
   $result=$conn->prepare($sql);
   $result->execute();
   $rowCheck=$result->rowCount();
   if($rowCheck>0){
   ?>

   <table border='2' style='text-align:center;background-color: rgb(191, 238, 170);'>
   <caption>DATABASE</caption>
   <thead style="background-color:rgb(245, 243, 151);">
   <th style='width:100px'>ID</th>
   <th style='width:300px'>NAME</th>
   <th>HEIGHT</th>
   <th style='width:70px'>AGE</th>
   <th>ACTION</th>
   </thead>
    <tbody>
   
   <?php
   while($row=$result->fetch(PDO::FETCH_ASSOC)){
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['height'] . "</td>";
echo "<td>" . $row['age'] . "</td>";
echo '<td>' . '<form action="" method="POST"><input type="hidden" name="id" value='.$row['id'].'><input type="hidden" name="name" value='.$row['name'].'><input type="hidden" name="height" value='.$row['height'].'><input type="hidden" name="age" value='.$row['age'].'><button type="submit" name="delete"  id="deleteButton">DELETE</button> | <button type="submit" name="edit" id="editButton">EDIT</button></form>'.  '</td>'; 
echo "</tr>";
   }

  }else{
    echo "0 results.";
  } 

unset($result);
    ?>


    </tbody>



   </table>
 
<br>
<form action="" method="POST">
<button type='submit' name='add' id='add'>ADD+</button>
</form>

<?php
if(isset($_REQUEST['add'])){

?>
<div>
<fieldset style='width:150px'>
<form action="" method="post">
<i>Name:</i><br>
<input type="text" name="addName"><br>
<i>Height:</i><br>
<input type="text" name="addHeight"><br>
<i>Age:</i><br>
<input type="text" name="addAge"><br><br>
<button type='submit' name='newAdd'>ADD</button>
</form>
</fieldset>

</div>
<?php
}

$conn=null;
?>

  </div>
</body>
</html>



<?php
/*
$db="mysql:host=localhost; dbname=fm_db";
$db_user="root";
$db_password="";

try{
$conn=new PDO($db,$db_user,$db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
echo "Connected <br><hr>";
}
catch(PDOException $e){
echo "Connected Failed " . $e->getMessage();
}

if(isset($_REQUEST['submit'])){
  if(($_REQUEST['name']=="") || ($_REQUEST['height']=="") || ($_REQUEST['age']=="")){
     echo "<i> Fill All Fields</i><br><hr>";
  }
  else{
        $sql="INSERT INTO group1 (name,height,age) VALUES(:name, :height , :age) ";
          
$result=$conn->prepare($sql);
$name=$_REQUEST['name'];
$height=$_REQUEST['height'];
$age=$_REQUEST['age'];


$result->execute(array('name'=>$name,'height'=>$height,'age'=> $age));
    
echo $result->rowCount() . "Row Inserted <br>";

unset($result);


  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <div>
    <form action="" method="POST">
<label for="name">Name;</label><br>
<input type="text" name="name"><br><br>
<label for="height">Height;</label><br>
<input type="text" name="height"><br><br>
<label for="age">Age;</label><br>
<input type="text" name="age"><br><br>
<button type='submit' name='submit'>Submit</button>
</form>
  </div><br>
  <div>
<?php
$sql="SELECT * FROM group1";

$result=$conn->prepare($sql);

$result->execute();

if($result->rowCount()>0){
echo <<<TKN
<table border='1' align='center' style='text-align:center'>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Height</th>
<th>Age</th>
</tr>
</thead>
<tbody>
TKN;
while($row=$result->fetch(PDO::FETCH_ASSOC)){
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['height'] . "</td>";
echo "<td>" . $row['age'] . "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";


}
else{
echo "0 results.";
}


?>




  </div>
</body>

<?php
unset($result);

$conn=null;


?>
</html>

*/?><?php//delete this row;;;?>










<?php
/*
$db="mysql:host=localhost;dbname=fm_db";
$db_user="root";
$db_password="";

try{
$conn=new PDO($db,$db_user,$db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connected <br><hr>";


}
catch(PDOException $e){
           echo "Connection Failed" . $e->getMessage();
}

if(isset($_REQUEST['submit'])){
if(($_REQUEST['name']=="") || ($_REQUEST['height']=="") || ($_REQUEST['age']=="")){
echo "<i>Fill All Fields</i>";
}
else{
 $sql= "INSERT INTO group1 (name, height , age) VALUE(:name,:height,:age)";
$result=$conn->prepare($sql);

$name=$_REQUEST['name'];
$height=$_REQUEST['height'];
$age=$_REQUEST['age'];

$result->execute(array('name'=>$name,'height'=>$height, 'age' =>$age));

echo $result->rowCount() . "Row Inserted.<br>";

unset($result);
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<div>
<form action="" method="POST">
<label>Name</label><br>
<input type='text' name='name'><br>
<label>height</label><br>
<input type='text' name='height'><br>
<label>age</label><br>
<input type='text' name='age'><br><br>
<button type='submit' name='submit'>Submit</button>

</form>

</div>




</body>
</html>

*/
?>

<?php
/*
//connection;
$db="mysql:host=localhost; dbname=fm_db";
$db_user="root";
$db_password = "";

try{
$conn = new PDO($db,$db_user,$db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connected<br><hr>";
}
catch(PDOException $e){
  echo "Connection Failed ." . $e->getMessage();
}

try{
$sql="INSERT INTO memb (name,identity,age) VALUES (:name ,:iden ,:age)";
$result = $conn->prepare($sql);

$name= "memb8";
$iden= "none";
$age= 00;

$result->execute(array('name'=>$name,'iden'=>$iden, 'age'=>$age));

echo $result->rowCount() . "Row inserted <br>";

}
catch(PDOException $e){
echo $e->getMessage();
}


unset($result);
$conn=null;














*/


?>



<?php
/*

<?php
$db="mysql:host=localhost;dbname=fm_db";
$db_user="root";
$db_password="";

try{
  $conn=new PDO($db,$db_user,$db_password);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "Connected Successfully<br><hr>";
}
catch(PDOException $e){
  echo "faied" . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
 <div>
<?php
//select All data;
$sql="SELECT * FROM memb";

$result=$conn->prepare($sql);

$result->execute();


if($result->rowCount() > 0){
  echo <<<TKN
  <table border='3' style="background-color:yellow;text-align:center" align="center">
  <thead>
   <tr style="background-color:orange">
   <th>ID</th>
  <th>Name</th>
  <th>Identity</th>
  <th>Age</th>
  </tr>
  </thead>
  <tbody>
  TKN;  
  
  while($row=$result->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['identity'] . "</td>";
    echo "<td>" . $row['age'] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
}
else{
  echo "0 results";
}

?>


 </div>
</body>
<?php
 unset($result);

 $conn=null;



?>
</html>

*/
?>




















































