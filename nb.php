<?php

// Create connection
$con=mysqli_connect("localhost", "campusla", "Daisy@007", "campusla_fullcalendar");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$subject = array();
$result = mysqli_query($con, "SELECT * FROM courses");
$global_set = array();
$course_count = array();
$course_number = 0;
$dept_words = array();

while($row = mysqli_fetch_array($result)) {
    $course = $row['course_id'];
    $description = strtolower($row['course_desc']);
    preg_match('/^[A-Z]+/', $course, $matches);
    $dept = $matches[0];
    //echo $keyword;
    //$keywords = preg_split("/[^a-zA-Z\-]+/", $description);
    $keywords = preg_split("/[^a-z\-]+/", $description);
    //echo $course . $description;
    if (array_key_exists($dept, $subject)) {
        $course_count[$dept] = $course_count[$dept] + 1; 
    } else {
        $course_count[$dept] = 1;
        $subject[$dept] = array();
        $dept_words[$dept] = 0;
    }
    $course_number = $course_number + 1;
    foreach($keywords as $word) {
        $dept_words[$dept] = $dept_words[$dept] + 1;
        if (array_key_exists($word, $subject[$dept])) {
            $subject[$dept][$word] = $subject[$dept][$word] + 1; 
        } else {
            $subject[$dept][$word] = 1; 
        }
        if (array_key_exists($word, $global_set)) {
            $global_set[$word] = $global_set[$word] + 1; 
        } else {
            $global_set[$word] = 1; 
        }
        //echo $word . " " . $global_set[$word] . " " . $subject[$dept][$word] . " ";
    }
}
$query = "machine learing is good, I like programming";
$k = 1;
$queries = preg_split("/[^a-z\-]+/", strtolower($query));
$denominator = 0;
$MAP_dept = "";
$MAP_value = 0;
$x_dept = sizeof($course_count);
echo "<br/>";
echo $x_dept;
echo "<br/>";
$x_words = sizeof($global_set);
echo "size of vocabulary " . $x_words;
foreach ($course_count as $dept=>$dept_course_num) {
    //echo "size of vocabulary " . sizeof($global_set);
    //echo $dept . " number " . $dept_course_num;
    //echo "total course number " . $course_number;
    $P_CS  = ($dept_course_num + $k)/($course_number + $k * $x_dept); 
    //echo "P(" . $dept . ") " . $P_CS;
    //echo $query . " number" . $subject[$dept][$query];
    //echo $dept . " words number" . $dept_words[$dept];
    $P_BFS_CS = 1;
    foreach($queries as $query_word) {
        $P_BFS_CS = $P_BFS_CS * ($subject[$dept][$query_word] + $k) / ($dept_words[$dept] + $k * $x_words);
    }
    echo "<br/>";
    echo "P(" . $query . "|" . $dept . ")=" . $P_BFS_CS;
    $P_BFS_CS_P_CS = $P_BFS_CS * $P_CS;
    if ($P_BFS_CS_P_CS > $MAP_value) {
        $MAP_dept = $dept;
        $MAP_value = $P_BFS_CS_P_CS;
    }
    $denominator = $denominator + $P_BFS_CS_P_CS;
    echo " P(" . $query . "|" . $dept . ")*P(" . $dept . ")=" . $P_BFS_CS_P_CS;
    echo "<br/>";
}
echo $denominator;
echo "<br/>";
echo $MAP_dept;
echo "<br/>";
echo $MAP_value/$denominator;
echo "<br/>";

//$word_map = array();
//$nouse = array();
//foreach ($subject as $course=>$description) {
//    //$keywords = preg_split("/[^a-zA-Z0-9]+/", strtolower($description));
//    $keywords = preg_split("/[^a-zA-Z\-]+/", $description);
//
//    foreach($keywords as $word) {
//        if (array_key_exists($word, $word_map)) {
//            if ($course != $word_map[$word]) {
//                array_push($nouse, $word);
//            }
//        } else {
//            $word_map[$word] = $course;
//        }
//    }
//}
//
//foreach ($nouse as $word) {
////print "<p>" . $word . '</p>';
//    unset($word_map[$word]);
//}
//
//$course_key = array();
//foreach ($word_map as $common_word=>$course_name)
//{
//    if (in_array($common_word, $nouse)) {
//        echo "";
//    } else {
//    // print "<p>" . $common_word . "=>" . $course_name . '</p>';
//        if (array_key_exists($course_name, $course_key)) {
//            array_push($course_key[$course_name], $common_word);
//        } else {
//            $course_key[$course_name] = array($common_word);
//        }
//    }
//}
//
//foreach ($course_key as $c_name => $key_words) {
//    //print "<p>" .$c_name . ': ';
//    echo $c_name . ":";
//    foreach ($key_words as $key) {
//        //print $key . ' ';
//        echo $key . " ";
//    }
//    //print '</p>';
//    echo "<br/>";
//}

?>
