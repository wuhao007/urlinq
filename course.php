$courses = array('AE4613'=>"The course explores incompressible inviscid flow, rotational and irrotational flow, elementary flows and their superposition, airfoil and wing geometry, aerodynamic forces and moments, thin airfoil theory, camber effects, incompressible laminar and turbulent boundary layer, vortex system, incompressible flow about wings, wing/body configurations, compressible flows past airfoils and wings and high-lift devices.  Prerequisite: AE 4603.",
'AE4633' => "This course looks at operation, performance and design methods for flight-vehicle propulsion, air-breathing engines, ramjets, turbojets, turbofans and their components, elements of solid and liquid rocket-propulsion systems.  Prerequisite: AE 4603.",
'BE 997X'=>"The thesis for the master?s degree in biomedical engineering should report the results of an original investigation of problems in biomedical engineering or application of physical, chemical or other scientific principles to biomedical engineering. The thesis may involve experimental research, theoretical analyses or process designs, or combinations of them. Master?s degree candidates are required to submit four unbound copies to advisers before the seventh Wednesday before commencement.",
'BE6113' => "Part II of this sequence focuses on the muscular, skeletal, renal and endocrine systems and includes discussions on skin and basic oncology. This part is taught using a Ã¢ï¿½ï¿½systemsÃ¢ï¿½ï¿½ approach and link concepts from BE 6013. The material includes hands-on demonstration of technology to measure EMG.  Prerequisites: BE 6013.",
'BE6203' => "This course introduces the physics, instrumentation and signal-processing methods used in X-ray imaging (projection radiography), X-ray computed tomography, nuclear medicine (SPECT/PET), ultrasound imaging and magnetic resonance imaging. Co-listed as EL 5823.  Prerequisite: Multivariable calculus (MA 2112, MA 2122), physics (PH 2004), probability (MA 3012). Open to graduate students and upper-level UG students. Co-requisite: Signals and systems (EE 3054, preferred but not required).",
'BE6403'=>"Discrete and continuous-time linear systems. Z-transform. Fourier transforms. Sampling. Discrete Fourier transform (DFT). Fast Fourier transform (FFT). Digital filtering. Design of FIR and IIR filters. Windowing. Least squares in signal processing. Minimum-phase and all-pass systems. Digital filter realizations. Matlab programming exercises.",
'BE6453'=>"Continuous and discrete random variables and their joint probability distribution and density functions; Functions of one random variable and their distributions;  Independent random variables and conditional distributions;  One function of one and two random variables; Two functions of two random  variables and their joint density functions; Jointly distributed discrete random variables and their functions; Characteristic functions and higher order moments; Covariance, correlation, orthogonality.",
'BE6503'=>"This course reviews various methods of analysis for biomedical data. Contents: population and sample, confidence interval, hypothesis test, Bayesian logic, correlation, regression, design of studies, t test, chi-square test, analysis of variance, multiple regression, survival curves. Multivariable Calculus knowledge required; Probability Theory knowledge is preferred.");
$word_map = array();
$nouse = array();
foreach ($courses as $course=>$description) {
    $keywords = preg_split("/[^a-zA-Z0-9]+/", strtolower($description));

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
    print "<p>" .$c_name . ': ';
    foreach ($key_words as $key) {
        print $key . ' ';
    }
    print '</p>';
}

