<?php

//$_session['userid'] = 123456;
$user_id = 1;
$keyword = "%" . "e" . "%";

// Create connection
$con=mysqli_connect("localhost", "campusla", "mArCh3!!1992X", "campusla_urlinq_beta");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user_result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user"));
$univ_id = $user_result['univ_id'];
$user_type = $user_result['user_type'];
$post_id = array();
//echo $univ_id . " | " . $user_type . " | ";
echo "followed";
echo "<br/>";
$connect_result = mysqli_query($con, "SELECT * FROM connect WHERE from_user_id = '$user_id'");
//while($connect_row = mysqli_fetch_array($connect_result)) {
  //$to_user_id = $connect_row['to_user_id'];
  //$posts_result = mysqli_query($con, "SELECT * FROM posts WHERE user_id = '$to_user_id' AND target_univ_id <> '$univ_id' AND (text_msg LIKE '$keyword' OR sub_text LIKE '$keyword')");
$posts_result = mysqli_query($con, "SELECT distinct post_id, text_msg FROM posts JOIN connect ON posts.user_id = connect.to_user_id AND (posts.text_msg LIKE '$keyword' OR posts.sub_text LIKE '$keyword')");
while($posts_row = mysqli_fetch_array($posts_result)) {
  array_push($post_id, $posts_row['post_id']);
  echo $posts_row['text_msg'] . ' | ';
}
//}
echo "<br/>";

//$campus_result = mysqli_query($con, "SELECT * FROM connect WHERE (privacy = campus)");

echo "campus";
echo "<br/>";
$posts_result = mysqli_query($con, "SELECT post_id, text_msg FROM posts WHERE ((privacy = 'student' AND '$user_type' = 's') OR privacy = 'campus') AND target_univ_id = '$univ_id' AND (text_msg LIKE '$keyword' OR sub_text LIKE '$keyword')");

while($posts_row = mysqli_fetch_array($posts_result)) {
  if (in_array($posts_row['post_id'], $post_id)) {
    echo "";
  } else {
    echo $posts_row['text_msg'] . ' | ';
  }
}

mysqli_close($con);
?>
