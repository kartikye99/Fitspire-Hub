@extends('layouts.app')

@section('title', 'Fitness Calculators')

@section('content')
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2.2rem; margin-bottom: 5px;">Interactive Fitness Calculators</h1>
        <p style="color: var(--text-muted);">Assisting you in setting up targets, tracking metrics, and maintaining optimal training conditions.</p>
    </div>

    <!-- Calculators Row Grid -->
    <div class="calculators-container" id="calculators-flex-grid">
        
        <!-- BMI Calculator -->
        <div class="calc-widget" id="bmi-calculator">
            <div class="calc-header">
                <h3>BMI Calculator</h3>
                <p>Calculate your Body Mass Index (BMI) to understand your weight classification.</p>
            </div>

            <div style="flex: 1;">
                <div class="form-group">
                    <label class="form-label" for="bmi-weight">Weight (kg)</label>
                    <input type="number" id="bmi-weight" class="form-control" placeholder="e.g., 70" min="10" max="300">
                </div>

                <div class="form-group">
                    <label class="form-label" for="bmi-height">Height (cm)</label>
                    <input type="number" id="bmi-height" class="form-control" placeholder="e.g., 175" min="50" max="250">
                </div>

                <button type="button" class="btn btn-primary btn-block" id="btn-calculate-bmi" onclick="computeBMI()">Calculate BMI</button>
            </div>

            <!-- Result Box -->
            <div class="calc-result-box" id="bmi-result-box">
                <div class="calc-result-num" id="bmi-value">22.5</div>
                <div class="calc-result-label" id="bmi-category">Normal Weight</div>
                
                <!-- Gauge representation -->
                <div class="gauge-track">
                    <div class="gauge-marker" id="bmi-gauge-marker" style="left: 50%;"></div>
                </div>
                <div class="gauge-labels">
                    <span>18.5 (Under)</span>
                    <span>25.0 (Normal)</span>
                    <span>30.0 (Over)</span>
                </div>
                
                <p class="calc-result-desc" id="bmi-advice" style="margin-top: 15px;">You have a healthy body weight. Maintain your physical activity!</p>
            </div>
        </div>

        <!-- Target Heart Rate Calculator -->
        <div class="calc-widget" id="heart-rate-calculator">
            <div class="calc-header">
                <h3>Training Heart Rate</h3>
                <p>Find your optimal heart rate training zones for fat burning, cardio, and peak performance.</p>
            </div>

            <div style="flex: 1;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="hr-age">Age (years)</label>
                        <input type="number" id="hr-age" class="form-control" placeholder="e.g., 25" min="1" max="120">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="hr-resting">Resting HR (bpm)</label>
                        <input type="number" id="hr-resting" class="form-control" placeholder="e.g., 65" min="30" max="150">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary btn-block" id="btn-calculate-hr" onclick="computeHeartRate()">Calculate Zones</button>
            </div>

            <!-- Result Box -->
            <div class="calc-result-box" id="hr-result-box">
                <div class="calc-result-num" id="hr-max-value" style="color: var(--color-secondary);">195 <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">bpm</span></div>
                <div class="calc-result-label">Estimated Max Heart Rate</div>
                
                <div class="hr-zones">
                    <div class="hr-zone-row zone-fat">
                        <span class="hr-zone-name">Fat Burn Zone (60-70%)</span>
                        <span class="hr-zone-val" id="hr-zone-fat-val">120 - 135 bpm</span>
                    </div>
                    <div class="hr-zone-row zone-cardio">
                        <span class="hr-zone-name">Aerobic Cardio (70-85%)</span>
                        <span class="hr-zone-val" id="hr-zone-cardio-val">135 - 160 bpm</span>
                    </div>
                    <div class="hr-zone-row zone-peak">
                        <span class="hr-zone-name">Peak Training (85%+)</span>
                        <span class="hr-zone-val" id="hr-zone-peak-val">160+ bpm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMR & Daily Calorie Calculator -->
        <div class="calc-widget" id="bmr-calculator" style="grid-column: 1 / -1;">
            <div class="calc-header">
                <h3>BMR & Daily Energy Calculator</h3>
                <p>Estimate your Basal Metabolic Rate (BMR) and total daily calorie requirements based on your training activity level.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Inputs Left -->
                <div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="bmr-age">Age (years)</label>
                            <input type="number" id="bmr-age" class="form-control" placeholder="e.g., 28">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bmr-gender">Gender</label>
                            <select id="bmr-gender" class="form-control" style="background-color: var(--bg-dark); color: white;">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="bmr-weight">Weight (kg)</label>
                            <input type="number" id="bmr-weight" class="form-control" placeholder="e.g., 72">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bmr-height">Height (cm)</label>
                            <input type="number" id="bmr-height" class="form-control" placeholder="e.g., 180">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="bmr-activity">Activity Level / Sport Routine</label>
                        <select id="bmr-activity" class="form-control" style="background-color: var(--bg-dark); color: white;">
                            <option value="1.2">Sedentary (Little or no exercise)</option>
                            <option value="1.375">Lightly Active (Light exercise/sports 1-3 days/week)</option>
                            <option value="1.55">Moderately Active (Moderate exercise/sports 3-5 days/week)</option>
                            <option value="1.725">Very Active (Hard exercise/sports 6-7 days/week)</option>
                            <option value="1.9">Extra Active (Very hard exercise, physical job or training twice a day)</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-accent btn-block" id="btn-calculate-bmr" onclick="computeBMR()">Calculate Calories</button>
                </div>

                <!-- Results Right -->
                <div style="display: flex; align-items: center; justify-content: center;">
                    <div class="calc-result-box" id="bmr-result-box" style="width: 100%; margin-top: 0; padding: 25px;">
                        <div style="margin-bottom: 20px;">
                            <div class="calc-result-num" id="bmr-value" style="color: var(--color-accent); font-size: 2.2rem;">1650 <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">kcal</span></div>
                            <div class="calc-result-label" style="font-size: 0.9rem; font-weight: normal;">Basal Metabolic Rate (BMR)</div>
                        </div>

                        <div style="border-top: 1px solid var(--border-color); padding-top: 20px;">
                            <h4 style="margin-bottom: 15px; font-size: 1rem; color: #ffffff;">Daily Calories Target</h4>
                            
                            <div class="hr-zones" style="margin-top: 0;">
                                <div class="hr-zone-row" style="background: rgba(139, 92, 246, 0.1); border-left: 3px solid var(--color-accent);">
                                    <span class="hr-zone-name">Maintenance (Stay same)</span>
                                    <span class="hr-zone-val" id="bmr-tdee-val" style="color: #ffffff;">2350 kcal</span>
                                </div>
                                <div class="hr-zone-row" style="background: rgba(16, 185, 129, 0.1); border-left: 3px solid var(--color-primary);">
                                    <span class="hr-zone-name">Weight Loss (-500 kcal)</span>
                                    <span class="hr-zone-val" id="bmr-loss-val" style="color: var(--color-primary);">1850 kcal</span>
                                </div>
                                <div class="hr-zone-row" style="background: rgba(6, 182, 212, 0.1); border-left: 3px solid var(--color-secondary);">
                                    <span class="hr-zone-name">Muscle Gain (+500 kcal)</span>
                                    <span class="hr-zone-val" id="bmr-gain-val" style="color: var(--color-secondary);">2850 kcal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bmr-placeholder" style="color: var(--text-muted); font-style: italic; text-align: center; width: 100%;">
                        <span style="font-size: 3rem; display: block; margin-bottom: 10px;">📊</span>
                        Fill in your physical attributes to generate metabolic analysis.
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // BMI Logic
        function computeBMI() {
            const weight = parseFloat(document.getElementById('bmi-weight').value);
            const height = parseFloat(document.getElementById('bmi-height').value);
            const resultBox = document.getElementById('bmi-result-box');
            
            if (isNaN(weight) || isNaN(height) || weight <= 0 || height <= 0) {
                alert('Please enter valid positive numbers for height and weight.');
                return;
            }

            const heightM = height / 100;
            const bmi = weight / (heightM * heightM);
            const bmiRounded = bmi.toFixed(1);

            document.getElementById('bmi-value').innerText = bmiRounded;

            let category = '';
            let advice = '';
            let markerPos = 0; // percentage from left
            
            // Set marker position and classification advice
            if (bmi < 18.5) {
                category = 'Underweight';
                advice = 'Your weight is below the normal range. Consider consulting a nutritionist or trainer to design a muscle gain plan.';
                markerPos = Math.max(5, (bmi / 18.5) * 20); // Scale up to 20%
            } else if (bmi >= 18.5 && bmi < 25) {
                category = 'Normal Weight';
                advice = 'Outstanding! You have a healthy weight. Keep up your active sports lifestyle and structured nutrition.';
                markerPos = 20 + ((bmi - 18.5) / 6.5) * 35; // Scale from 20% to 55%
            } else if (bmi >= 25 && bmi < 30) {
                category = 'Overweight';
                advice = 'You are slightly above the normal body mass index. Incorporate more active sports and cardio routines from the Ideas tab.';
                markerPos = 55 + ((bmi - 25) / 5) * 25; // Scale from 55% to 80%
            } else {
                category = 'Obese';
                advice = 'Your BMI is categorized as obese. Focus on regular low-impact exercises, steady hydration, and dietary changes to protect your joints.';
                markerPos = Math.min(95, 80 + ((bmi - 30) / 10) * 15); // Scale up to 95%
            }

            document.getElementById('bmi-category').innerText = category;
            document.getElementById('bmi-advice').innerText = advice;
            document.getElementById('bmi-gauge-marker').style.left = `${markerPos}%`;

            resultBox.classList.add('active');
        }

        // Heart Rate Logic
        function computeHeartRate() {
            const age = parseInt(document.getElementById('hr-age').value);
            const resting = parseInt(document.getElementById('hr-resting').value);
            const resultBox = document.getElementById('hr-result-box');

            if (isNaN(age) || isNaN(resting) || age <= 0 || resting <= 0) {
                alert('Please enter valid age and resting heart rate numbers.');
                return;
            }

            const maxHR = 220 - age;
            document.getElementById('hr-max-value').innerHTML = `${maxHR} <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">bpm</span>`;

            // Karvonen Formula: HRR = MaxHR - RestingHR
            const hrr = maxHR - resting;

            const fatMin = Math.round((hrr * 0.60) + resting);
            const fatMax = Math.round((hrr * 0.70) + resting);
            
            const cardioMin = Math.round((hrr * 0.70) + resting);
            const cardioMax = Math.round((hrr * 0.85) + resting);

            const peakMin = Math.round((hrr * 0.85) + resting);

            document.getElementById('hr-zone-fat-val').innerText = `${fatMin} - ${fatMax} bpm`;
            document.getElementById('hr-zone-cardio-val').innerText = `${cardioMin} - ${cardioMax} bpm`;
            document.getElementById('hr-zone-peak-val').innerText = `${peakMin}+ bpm`;

            resultBox.classList.add('active');
        }

        // BMR Mifflin-St Jeor Logic
        function computeBMR() {
            const age = parseInt(document.getElementById('bmr-age').value);
            const gender = document.getElementById('bmr-gender').value;
            const weight = parseFloat(document.getElementById('bmr-weight').value);
            const height = parseFloat(document.getElementById('bmr-height').value);
            const activity = parseFloat(document.getElementById('bmr-activity').value);
            
            const resultBox = document.getElementById('bmr-result-box');
            const placeholder = document.getElementById('bmr-placeholder');

            if (isNaN(age) || isNaN(weight) || isNaN(height) || age <= 0 || weight <= 0 || height <= 0) {
                alert('Please enter valid values for age, weight, and height.');
                return;
            }

            let bmr = 0;
            if (gender === 'male') {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
            } else {
                bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
            }

            const bmrRounded = Math.round(bmr);
            const tdee = Math.round(bmr * activity);
            const loss = tdee - 500;
            const gain = tdee + 500;

            document.querySelector('#bmr-calculator #bmr-value').innerHTML = `${bmrRounded} <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">kcal</span>`;
            document.getElementById('bmr-tdee-val').innerText = `${tdee} kcal`;
            document.getElementById('bmr-loss-val').innerText = `${loss} kcal`;
            document.getElementById('bmr-gain-val').innerText = `${gain} kcal`;

            placeholder.style.display = 'none';
            resultBox.classList.add('active');
        }
    </script>
@endsection
