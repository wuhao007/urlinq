<?php

// Create connection
$con=mysqli_connect("localhost", "campusla", "mArCh3!!1992X", "campusla_urlinq_beta");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$subject = array();
$result = mysqli_query($con, "SELECT course_id, course_desc FROM courses_semester");
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
$query = "I want to be a electrical engineer in the future";
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
$k = 0;
$MAP_score = 0;
$MAP_word = "";
$words_score = array();
foreach($queries as $query_word) {
    $word_score = ($subject[$MAP_dept][$query_word] + $k) / ($dept_words[$MAP_dept] + $k * $x_words);
    if ($word_score > $MAP_score) {
        $MAP_score = $word_score;
        $MAP_word = $query_word;
    }
    echo "<br/>";
    echo $query_word . " " . $word_score;
    $words_score[$query_word] = $word_score;
}
echo "<br/>";
echo "MAX " . $MAP_word . " " . $MAP_score;
echo "<br/>";
arsort($words_score);
echo "<br/>";

$stopwords = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although","always","am","among", "amongst", "amoungst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around", "as",  "at", "back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the");

foreach($words_score as $word=>$score) {
    if (!in_array($word, $stopwords) and $word != "" and strlen($word) > 1) {
        echo "<br/>";
        echo $word . ":" . $score;
    }
}
#echo "<br/>";
#$sentence = preg_split("/(?<=\w)\b\s*/", "I'm a sentence.");
#echo $sentence[0];
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
