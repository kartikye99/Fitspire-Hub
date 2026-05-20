<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FitnessIdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FitnessIdea::create([
            'title' => 'HIIT Cardio Blaster',
            'description' => 'High Intensity Interval Training to boost VO2 max and burn calories fast.',
            'category' => 'Cardio',
            'intensity_level' => 'Advanced',
            'equipment_needed' => 'None',
            'duration_est' => 20,
            'calories_burned_est' => 280,
            'instructions' => "Warm up for 3 mins.\nPerform 30s High Knees followed by 30s rest.\nPerform 30s Burpees followed by 30s rest.\nPerform 30s Mountain Climbers followed by 30s rest.\nPerform 30s Jump Squats followed by 30s rest.\nRepeat the circuit 4 times.\nCool down for 2 mins."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Soccer Agility & Footwork',
            'description' => 'Enhance coordination, quick turns, and foot speed for football/soccer players.',
            'category' => 'Sports Drills',
            'intensity_level' => 'Intermediate',
            'equipment_needed' => 'Agility Cones & Soccer Ball',
            'duration_est' => 30,
            'calories_burned_est' => 240,
            'instructions' => "Set up 5 cones in a straight line, 1 meter apart.\nWeave through cones with quick lateral steps (3 sets).\nWeave while dribbling a soccer ball using inside/outside of feet (5 sets).\nPerform shuttle runs between cones: sprint forward, backpedal backward (4 sets).\nPractice wall passes: pass against a wall, control the rebound, and repeat (5 minutes)."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Basketball Shooting & Rhythm',
            'description' => 'Develop muscle memory and shooting accuracy from different spots on the court.',
            'category' => 'Sports Drills',
            'intensity_level' => 'Intermediate',
            'equipment_needed' => 'Basketball & Hoop',
            'duration_est' => 45,
            'calories_burned_est' => 320,
            'instructions' => "Form Shooting: Stand 2 feet from the hoop, shoot with one hand to focus on release (10 makes).\nMid-Range Pull-ups: Dribble twice to the left/right, pull up and shoot (15 shots each side).\nFree Throw Practice: Shoot sets of 5 free throws between active drills to simulate game exhaustion.\nThree-Point Spot Shooting: Catch and shoot from 5 spots around the arc (10 attempts per spot)."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Home Bodyweight Strength Circuit',
            'description' => 'Build functional strength and endurance using your own bodyweight. No gym required.',
            'category' => 'Strength',
            'intensity_level' => 'Beginner',
            'equipment_needed' => 'Yoga Mat',
            'duration_est' => 25,
            'calories_burned_est' => 180,
            'instructions' => "Perform 12 Bodyweight Squats.\nPerform 10 Push-ups (on knees if needed).\nPerform 15 Reverse Lunges (alternating legs).\nPerform 30-second Plank hold.\nRest for 60 seconds.\nRepeat this sequence for 4 full rounds."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Full Body Mobility & Yoga Flow',
            'description' => 'Increase active range of motion, improve flexibility, and reduce muscle tension.',
            'category' => 'Flexibility',
            'intensity_level' => 'Beginner',
            'equipment_needed' => 'Yoga Mat',
            'duration_est' => 30,
            'calories_burned_est' => 100,
            'instructions' => "Start in Child's Pose and hold for 1 minute.\nMove to Cat-Cow stretches to warm up the spine (10 reps).\nPerform Downward Facing Dog, pedaling feet to stretch calves (2 minutes).\nStep into a Low Lunge to open hips (hold 1 minute each side).\nPerform a Sphinx pose for a gentle backbend.\nEnd with Seated Forward Fold, stretching hamstrings."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => '5K Run Progression Plan',
            'description' => 'Structured running interval training designed to build cardiovascular endurance.',
            'category' => 'Cardio',
            'intensity_level' => 'Intermediate',
            'equipment_needed' => 'Running Shoes',
            'duration_est' => 35,
            'calories_burned_est' => 380,
            'instructions' => "Warm up with a brisk walk for 5 minutes.\nRun at a moderate pace for 4 minutes, walk for 1 minute.\nRepeat the run/walk interval 5 times.\nCool down with a slow walk for 5 minutes.\nFocus on upright posture and landing on your mid-foot."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Tennis Wall Volley Drill',
            'description' => 'Build hand-eye coordination, quick reaction time, and wrist strength.',
            'category' => 'Sports Drills',
            'intensity_level' => 'Beginner',
            'equipment_needed' => 'Tennis Racket & Ball',
            'duration_est' => 20,
            'calories_burned_est' => 150,
            'instructions' => "Stand 6-8 feet away from a flat brick/concrete wall.\nPractice forehand volleys consecutively against the wall (try to get to 20 without dropping).\nPractice backhand volleys consecutively (target 20 in a row).\nAlternate forehand and backhand volleys (focus on split-step footwork).\nKeep your knees bent and racket face slightly open."
        ]);

        \App\Models\FitnessIdea::create([
            'title' => 'Dumbbell Hypertrophy Upper Body',
            'description' => 'Target chest, back, and shoulders for muscle definition and upper body strength.',
            'category' => 'Strength',
            'intensity_level' => 'Advanced',
            'equipment_needed' => 'Dumbbells & Bench',
            'duration_est' => 40,
            'calories_burned_est' => 310,
            'instructions' => "Dumbbell Bench Press: 4 sets of 10 reps.\nOne-Arm Dumbbell Row: 4 sets of 12 reps per arm.\nDumbbell Shoulder Press (Seated): 3 sets of 10 reps.\nDumbbell Bicep Curls super-setted with Overhead Tricep Extensions: 3 sets of 12 reps.\nRest 90 seconds between sets."
        ]);
    }
}
