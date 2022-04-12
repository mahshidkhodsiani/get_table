<?php

// selet from database
$result = array(
    0 => array('id' => 1, 'name' => 'mahshid', 'family' => 'khodsinai'),
    1 => array('id' => 2, 'name' => 'aria'   , 'family' => 'mazloom'  ),
    2 => array('id' => 3, 'name' => 'mina'   , 'family' => 'sadeghi'  ),
    3 => array('id' => 4, 'name' => 'parisa' , 'family' => 'jalaly'   ),
    4 => array('id' => 5, 'name' => 'negin'  , 'family' => 'yazdani'  ),
    5 => array('id' => 6, 'name' => 'behrooz', 'family' => 'khanjari' )
);

// tooye jadval neshun bedin va har kas id == 4 rang rt an ghermez shavad
$whichId = 1 ;


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table ,tr , th , td{
            border: black solid;
            border-collapse: collapse;
        }

        .rowColor1{
            background-color: green;
        }

        .rowColor2{
            background-color: red;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
        </tr>
        <?php
        // echo '<pre>';
        // var_dump($result);
        // die;
        
        

        foreach($result as $member){
            
            $color = "";
            $color1 = "";
            if($member['name'] == "behrooz"){
                $color= "rowColor1";
                
            }
            
            if($member['id'] == $whichId){
                $color = "rowColor2";
            }

            if($member['family']== 'mazloom'){
                $color1 = "rowColor1";
            }

           echo "<tr class='$color'>
                    <td> {$member['id']} </td>
                    <td> {$member['name']} </td>
                    <td class='$color1'> {$member['family']} </td>
           ";
        }
        
        ?>
    </table>
    
</body>
</html>