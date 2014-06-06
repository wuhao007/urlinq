$courses = array('AE4613'=>"The course explores incompressible inviscid flow, rotational and irrotational flow, elementary flows and their superposition, airfoil and wing geometry, aerodynamic forces and moments, thin airfoil theory, camber effects, incompressible laminar and turbulent boundary layer, vortex system, incompressible flow about wings, wing/body configurations, compressible flows past airfoils and wings and high-lift devices.  Prerequisite: AE 4603.",
'AE4633' => "This course looks at operation, performance and design methods for flight-vehicle propulsion, air-breathing engines, ramjets, turbojets, turbofans and their components, elements of solid and liquid rocket-propulsion systems.  Prerequisite: AE 4603.",
'BE 997X'=>"The thesis for the master?s degree in biomedical engineering should report the results of an original investigation of problems in biomedical engineering or application of physical, chemical or other scientific principles to biomedical engineering. The thesis may involve experimental research, theoretical analyses or process designs, or combinations of them. Master?s degree candidates are required to submit four unbound copies to advisers before the seventh Wednesday before commencement.");
$word_map = array();
foreach ($courses as $course=>$description) {
$keywords = preg_split("/[^a-zA-Z0-9]+/", strtolower($description));
$nouse = array();
foreach($keywords as $word)
{
   if (array_key_exists($word, $word_map))
   {
     if ($course != $word_map[$word]) {
       array_push($nouse, $word);
	 }
   } else {
     $word_map[$word] = $course;
   }
}

}
foreach ($nouse as $word)
{
//print "<p>" . $word . '</p>';
  unset($word_map[$word]);
}
$course_key = array();

foreach ($word_map as $common_word=>$course_name)
{
	if (array_key_exists($common_word, $nouse)) {
      echo "try";
	} else {
	// print "<p>" . $common_word . "=>" . $course_name . '</p>';
	 
	
	if (array_key_exists($course_name, $course_key)) {
	  array_push($course_key[$course_name], $common_word);
	} else {
	  $course_key[$course_name] = array($common_word);
	}
	}
}
foreach ($course_key as $c_name => $key_words){
print "<p>" .$c_name . ': ';
foreach ($key_words as $key)
{
print $key . ' ';
}
print '</p>';
}
