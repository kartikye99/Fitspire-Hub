# ⚡ FitSpire Hub

FitSpire Hub is a premium, high-energy, fully functional fitness and sports web application. Built with **PHP Laravel 12**, **SQLite**, and crafted with **custom vanilla CSS and JavaScript** for maximum visual quality, responsiveness, and performance.

---

## ✨ Features

### 1. 🎬 Cinematic Entrance Animation
- **Apple/Nike Inspired Pacing**: Full-screen typographic flash transitions ("FOCUS.", "PERFORM.", "EXCEL.") using hardware-accelerated scaling and canvas motion-blur filtering.
- **Vector Runner Silhouette**: A mathematically animated athletic runner silhouette with neon cyan highlights and organic studio backlights.
- **sessionStorage Guard**: Plays the cinematic intro only once per browser session to ensure fast subsequent navigations.

### 2. ⚡ Custom Interactive Physics Cursor
- **Energy Sphere Design**: A solid center point and a lagging outer neon cyan glow sphere.
- **Velocity Stretching (Motion Blur)**: Outer glow morphs and stretches into an oval along the direction of travel based on mouse acceleration.
- **Contextual Icon Morphing**: Transforms into relevant emoji actions when hovering over interactive elements:
  - **Workouts**: Dumbbell (`🏋️`)
  - **Buttons**: Lightning (`⚡`)
  - **Delete actions**: Blast (`💥`)
  - **Calculators**: Target (`🎯`)
  - **Inputs**: Notepad (`📝`)
  - **Links**: Sparkles (`✨`)

### 3. 🌗 Anti-Flash Light/Dark Mode
- **Instant Toggle**: Toggle between high-contrast dark mode and premium sleek light mode.
- **Anti-Flash Implementation**: Script executes immediately in the layout `<head>` before body rendering, reading from `localStorage` to completely prevent page load flashing.

### 4. 📊 Personal Dashboard
- **Overview Stat Cards**: Total workouts logged, total calories burned, target hydration progress, and active routine overview.
- **Recent Workouts**: Chronological table of your latest workout logs with delete functionality.

### 5. 🏋️ Workout & Routine Tracker
- **Routine Logger**: Title workouts, log exercises, sets, reps, and weights.
- **Workout Checklists**: Mark workouts as completed directly from the tracker.
- **Live Logs**: Delete outdated logs or view historical workout data.

### 6. 💧 Interactive Hydration Tracker
- **Progress Gauge**: Animated filling water container.
- **Custom Intake Logger**: Add customized logs or quickly add using convenient presets (+250ml, +500ml, +750ml).
- **Target Setting**: Set and update daily hydration goals dynamically.

### 7. 🧮 Fitness Calculators
- **BMI Calculator**: Enter height and weight to calculate Body Mass Index, health categories, and custom training suggestions.
- **Body Fat Calculator**: Uses the **U.S. Navy Circumference Method** (calculating waist, neck, hip, and height) to estimate body fat percentage and fitness category.

### 8. 💡 Thematic Knowledge Directory
- **Curated Cards**: Interactive cards for **Cardio**, **Strength**, **Sports Drills**, and **Flexibility** categories.
- **Image Hover Scale**: Premium custom generated illustration panels with zoom micro-interactions.

---

## 🛠️ Technology Stack
- **Backend**: PHP Laravel 12 (MVC Architecture, SQLite database, Eloquent ORM)
- **Frontend**: Blade Templating, Vanilla CSS, Vanilla JavaScript
- **Styling**: Tailored custom CSS custom variables (no Tailwind CSS, fully modular layout)

---

## 🚀 How to Run the Project Locally

### 1. Prerequisites
- **PHP** (>= 8.2)
- **Composer**
- **Node.js & NPM**

### 2. Installation Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/kartikye99/Fitspire-Hub.git
   cd Fitspire-Hub
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install and compile frontend assets:
   ```bash
   npm install
   npm run build
   ```
4. Create your Environment file:
   ```bash
   copy .env.example .env
   ```
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Set up the SQLite database:
   - Create an empty database file:
     - On Windows PowerShell: `New-Item -ItemType File -Path database/database.sqlite`
     - On Linux/macOS: `touch database/database.sqlite`
   - Run migrations and seeders:
     ```bash
     php artisan migrate --seed
     ```

### 3. Start the Server
Start the Laravel development server:
```bash
php artisan serve
```
Open your browser and navigate to **[http://127.0.0.1:8000](http://127.0.0.1:8000)**. Register a new account and begin your fitness journey!

---

## 🔒 Security Notes
- `.env` and `database.sqlite` are explicitly added to `.gitignore` to protect environment secrets and database records.

---

## 📄 License
The FitSpire Hub project is open-sourced software licensed under the [MIT license](LICENSE).
