<?php
/**
 * Project: Learning Path for rtCamp
 * Purpose: Demonstrating PHP proficiency for Associate Engineer role.
 */

class EngineeringRoadmap {
    public $candidate_goal = 'Associate WordPress Engineer';
    public $university = 'Sathyabama Institute of Science and Technology';
    
    // Skills required as per job description
    public $skills = [
        'backend'  => ['PHP', 'MySQL'],
        'frontend' => ['JavaScript', 'HTML', 'CSS', 'React'],
        'tools'    => ['Git', 'Composer']
    ];

    public function show_commitment() {
        return "I am ready to learn, write clean code, and contribute to Open Source.";
    }
}

$me = new EngineeringRoadmap();
echo "Applying from: " . $me->university . "\n";
echo "Status: " . $me->show_commitment();
?>
