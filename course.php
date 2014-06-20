<?php

// Create connection
$con=mysqli_connect("localhost", "campusla", "mArCh3!!1992X", "campusla_urlinq_beta");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$subject = array();
$result = mysqli_query($con, "SELECT * FROM courses");

while($row = mysqli_fetch_array($result)) {
    $course = $row['course_id'];
    $description = $row['course_desc'];
    preg_match('/^[A-Z]+/', $course, $matches);
    $keyword = $matches[0];
    //echo $keyword;
    //echo $course . $description;
    if (array_key_exists($keyword, $subject)) {
        $subject[$keyword] = $subject[$keyword] . " " . $description;
    } else {
        $subject[$keyword] = $description;
    }
}

$word_map = array();
$nouse = array();
foreach ($subject as $course=>$description) {
    //$keywords = preg_split("/[^a-zA-Z0-9]+/", strtolower($description));
    $keywords = preg_split("/[^a-zA-Z]+/", $description);

    foreach($keywords as $word) {
        if (array_key_exists($word, $word_map)) {
            if ($course != $word_map[$word]) {
                array_push($nouse, $word);
            }
        } else {
            $word_map[$word] = $course;
        }
    }
}

foreach ($nouse as $word) {
//print "<p>" . $word . '</p>';
    unset($word_map[$word]);
}

$course_key = array();
foreach ($word_map as $common_word=>$course_name)
{
    if (in_array($common_word, $nouse)) {
        echo "";
    } else {
    // print "<p>" . $common_word . "=>" . $course_name . '</p>';
        if (array_key_exists($course_name, $course_key)) {
            array_push($course_key[$course_name], $common_word);
        } else {
            $course_key[$course_name] = array($common_word);
        }
    }
}

foreach ($course_key as $c_name => $key_words) {
    //print "<p>" .$c_name . ': ';
    echo $c_name . ":";
    foreach ($key_words as $key) {
        //print $key . ' ';
        echo $key . " ";
    }
    //print '</p>';
    echo "<br/>";
}

?>
