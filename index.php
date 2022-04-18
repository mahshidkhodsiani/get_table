<?php
define("DIR", __DIR__);

require_once DIR . "/connection/connect.php";


$disable = "";

switch($_REQUEST['fn']){
    case "add":
        $firstName = $_GET["firstName"];
        $lastName = $_GET["lastName"];
        $Email = $_GET["Email"];
        
        $valid = true ;
    
        if (empty($firstName) || 
            empty($lastName) || 
            empty($Email)) 
            {
            $message = "<p class='error'> please Enter completely.</p>";
            $msgColor = "red";
            $valid = false;
        }
    
        if(!filter_var($Email, FILTER_VALIDATE_EMAIL) && $valid ){
            $message = "<p class='error'> please enter a valid Email. </p>";
            $msgColor = "red";
            $valid = false;
        }
    
    
    
        if($valid !== false){
            $sql = "INSERT INTO student (firstName , lastName , Email) 
                    VALUES ('$firstName' , '$lastName' , '$Email')";
    
            if($conn->query($sql) == true){
                $message = "<p class='success'> your data successfully added </p>";
                $msgColor = "green";
            }else{
                $message = "<p class='error'> sorry a problem happend </p>";
                $msgColor = "red";
            }
        }else{
            $fname = $firstName;
            $lname = $lastName;
            $email = $Email;
        }
    break;

    case "del":
        $sql = "DELETE FROM student WHERE id={$_GET['Id']}";
   
    
        if($conn->query($sql) == true){
            $message = "<p class='success'> your data successfully deleted </p> ";
            $msgColor = "green";
        }else{
            $message = "<p class='error'> sorry a problem happend </p> ";
            $msgColor = "red";
        }
    break;

    case "edt":
        $sql = "SELECT * FROM student WHERE id ={$_GET['Id']}";
        $result = $conn->query($sql);
        
        $class_id = $_GET['Id'];
        $edit = true ;
        $disable = "disabled";
    
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $id    = $row['id'];
                $fname = $row['firstName'];
                $lname = $row['lastName'];
                $email = $row['Email'];
            }
        }
    break;

    case "sve":
        $idedit    = $_GET['eId'];
        $fnameedit = $_GET['firstName'];
        $lnameedit = $_GET['lastName'];
        $emailedit = $_GET['Email'];
    
        $valid = true ;
    
        if (empty($fnameedit) || 
            empty($lnameedit) || 
            empty($emailedit)) 
            {
            $message = "<p class='error'> please Enter completely.</p> ";
            $msgColor = "red";
            $valid = false;
        }
    
        if(!filter_var($emailedit, FILTER_VALIDATE_EMAIL) && $valid ){
            $message = "<p class='error'> please enter a valid Email.</p>";
            $msgColor = "red";
            $valid = false;
        }
    
        if($valid !== false){
        
            $sql = "UPDATE student SET firstName='$fnameedit', lastName='$lnameedit',Email='$emailedit' WHERE id={$idedit}";
    
            if($conn->query($sql) == true){
                $message = "<p class='success'> your data successfully updated </p>";
                $msgColor = "green";
            }else{
                $message = "<p class='error'> sorry a problem happend.</p>";
                $msgColor = "red";
            }
        }else{
            //hame chi kharab shode dobare emtehan konim
            $class_id = $idedit ;
            $edit = true ;
            $disable = "disabled";
            $id    = $idedit;
            $fname = $fnameedit;
            $lname = $lnameedit;
            $email = $emailedit;
        }
    break;

}




//search
$where = "1";
$url = "";
if(isset($_REQUEST['ser']) && $_REQUEST['ser']=="search"){
    
    $url .= "&ser=search";
    if(isset($_REQUEST['nsearch']) && !empty($_REQUEST['nsearch'])){
        $name = $_REQUEST['nsearch'];
        $where .= " AND firstName LIKE '%$name%' ";
        $url .= "&nsearch=$name";
    }

    if(isset($_REQUEST['lsearch']) && !empty($_REQUEST['lsearch'])){
        $last = $_REQUEST['lsearch'];
        $where .= " AND lastName LIKE '%$last%' ";
        $url .= "&lsearch=$last";
    }
}



// hamishe bayad anjam beshe
$count = 10 ;
$page = $_REQUEST['page'];

if(empty($page)){
    $page = 0;
}

$start = $page * $count ; 

$sql = "SELECT count(id) as stid FROM student WHERE $where ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sum = $row['stid']; 
    }
}

$pages = floor( $sum / $count );
if($sum % $count == 0){
    $pages = $pages -1 ;
}

// select asli
$sql = "SELECT * FROM student 
    WHERE $where
    ORDER BY reg_date DESC
    LIMIT $start , $count";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./materialaize/materialaize1.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>get</title>
    
</head>
<body>
<div class="container ">
    <div class="row ">
        <div class="col s12 ">
            <div class="card ">
                <div class="card-content ">
                <span class="card-title">Personal Information</span>
                    <form method="GET">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="text" name="firstName" id="first" value="<?php echo @$fname; ?>" placeholder="Enter your Name:">
                            </div>
                        
                            <div class="input-field col s12 m6">
                                <input type="text" name="lastName" id="last" value="<?php echo @$lname; ?>" placeholder="Enter your Family:">
                            </div>
                        
                            <div class="input-field col s12 m6">   
                                <input type="text" name="Email" id="email" value="<?php echo @$email; ?>" placeholder="Enter your Email:">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12"> 
                                <input type="submit" value="submit" id="add_id" class="black-text waves-light btn" <?php echo @$disable; ?> >     
                                
                                
                                <?php
                                if($edit == true){ // faze edit hastim
                                    echo "<input type='submit' value='save' class='black-text waves-light btn'>";
                                    echo "<input type='hidden' value='sve' name='fn'>";
                                    echo "<input type='hidden' value='{$id}' name='eId'>";
                                    echo "<a href='index.php?page=$page$url' style='color:black;margin-left: 5px;' id='aId' class='black-text waves-light btn'>cancel</a> ";
                                }else{
                                    echo "<input type='hidden' value='add' name='fn'>";
                                }
            
                                ?>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    
        <?php
        if(isset($message)){
            echo "<div class='row '>
                    <div class='col s12 m6'>
                        <div class='card $msgColor'>
                            <div class='card-content'>
                                 $message 
                            </div>
                        </div>
                    </div>
                </div> " ;
        }
           
        ?>
                
    
    <br>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Search</span>
                    <form method="GET">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="text" name="nsearch" value="<?php echo $_REQUEST['nsearch']; ?>" placeholder="search your name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="text" name="lsearch" value="<?php echo $_REQUEST['lsearch']; ?>" placeholder="search your last name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input type="submit" value="search" name="ser" class="black-text waves-light btn" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col s12 ">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Checking Information</span>
                    <table>
                        <tr >
                            <th>id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Reg Date</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                        <?php  
                            
                            $a =$start + 1;
                            foreach ($data as $d) {

                                
                                if( $d['id'] == $class_id) {
                                    $class = "pink lighten-3";
                                }else{
                                    $class = "";
                                }

                                echo "<tr class='$class'>  

                                <td>   $a  </td>
                                <td>  {$d["firstName"]} </td>
                                <td>  {$d["lastName"] } </td>
                                <td>  {$d["Email"] } </td>
                                <td>  {$d["reg_date"] } </td>
                                <td> 
                                    <a  href='index.php?fn=del&Id={$d['id']}&page=$page$url'><i class='material-icons red-text'>delete_forever</i></a>
                                </td>
                                <td>
                                    <a href='index.php?fn=edt&Id={$d['id']}&page=$page$url'><i class='material-icons green-text'>edit</i></a> 
                                </td>
                                </tr>";

                                $a++;
                            }
                            
                        ?>
                    </table>

                    
                    <?php


                    if($page ==0){
                        $disable = "disabled";
                    }
                    if($page == $pages){
                        $dis = "disabled";
                    }

                    echo "<ul class='pagination center-align'>";
                    echo "<li class='$disable'><a href='?page=".($page-1).$url."'><i class='material-icons'>chevron_left</i></a></li>";
                    for($i= 0 ; $i <= $pages ; $i++){

                        if($page == $i){
                            $ac = "active";
                        }else{
                            $ac = "";
                        }


                        echo "<li class='$ac'> <a href='?page=$i$url'>". ($i+1) ."</a> </li>" ;
                    }
                    echo "<li class='$dis'><a href='?page=".($page+1).$url."'><i class='material-icons'>chevron_right</i></a></li>";
                    echo "</ul>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="./materialaize/materialize2.js"></script>
</body>
</html>

 
  
