<?php

//$_session['userid'] = 123456;
$user_id = 2;
$keyword = "%" . "e" . "%";

// Create connection
$con=mysqli_connect("localhost", "campusla", "Daisy@007", "campusla_fullcalendar");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user_result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user"));
$univ_id = $user_result['univ_id'];
$user_type = $user_result['user_type'];
//echo $univ_id . " | " . $user_type . " | ";

//$campus_result = mysqli_query($con, "SELECT * FROM connect WHERE (privacy = campus)");

$posts_result = mysqli_query($con, "SELECT * FROM posts WHERE (() OR (((privacy = 'student' AND '$user_type' = 's') OR privacy = 'campus') AND target_univ_id = '$univ_id')) AND (text_msg LIKE '$keyword' OR sub_text LIKE '$keyword')");

while($posts_row = mysqli_fetch_array($posts_result)) {
  echo $posts_row['text_msg'] . ' | ';
}

$result = mysqli_query($con, "SELECT * FROM connect WHERE to_user_id = '$user_id'");
while($posts_row = mysqli_fetch_array($posts_result)) {
  $posts_result = mysqli_query($con, "SELECT * FROM posts WHERE (user_id = '$from_user_id' AND (text_msg LIKE '$keyword' OR sub_text LIKE '$keyword'))");

  while($posts_row = mysqli_fetch_array($posts_result)) {
    echo $posts_row['text_msg'] . ' | ';
  }
}

mysqli_close($con);
?>