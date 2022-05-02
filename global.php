<?php


function paging($page, $pages, $sum, $url) {
    if ($pages == 0) {
        return;
    }

    
    
    if ($page ==0) {
        $disable = "disabled";
    }
    if ($page == $pages) {
        $dis = "disabled";
    }


    $start = 0 ;
    $end = $pages;

    $startpoint = false;
    $endpoint = false;
    
    


    $result = "<ul class='pagination center-align'>";
    $result .= "<li class='$disable'><a href='?sum=$sum&page=0'><i class='material-icons'>skip_previous</i></a></li>";
    $result .= "<li class='$disable'><a href='?sum=$sum&page=".($page-1).$url."'><i class='material-icons'>chevron_left</i></a></li>";
    if($startpoint){
        $result .= "<li> . . .  </li>";
    }


    for ($i= $start;  $i <= $pages ; $i++) {

        if( $page >= 2 ){
            $startpoint = true;
        }else{$endpoint = false;}
    
        if( $page <= $pages-2){
            $endpoint = true; 
        }else{$endpoint = false;}

        $ac = "";
        if($page == $i){
            $ac = "active";
        }

        $result .= "<li class='$ac'> <a href='?sum=$sum&page=$i$url'>". ($i+1)."</a> </li>" ;
        
        
    }
    if($endpoint){
        $result .= "<li> . . .  </li>";
    }
    $result .= "<li class='$dis'><a href='?sum=$sum&page=".($page+1).$url."'><i class='material-icons'>chevron_right</i></a></li>";
    $result .= "<li class='$dis'><a href='?sum=$sum&page=$pages'><i class='material-icons'>skip_next</i></a></li>";
    $result .= "</ul>";

    return $result;
}