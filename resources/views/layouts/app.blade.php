<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Track your fitness activities, sports routines, hydration levels, and calculate key fitness indices in one premium dashboard.">
    <title>@yield('title', 'Fit & Sports Hub') - Keep Active & Fit</title>
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        // Immediately load preferred theme before rendering to prevent flashing
        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.add('light-theme');
            } else if (savedTheme === 'dark') {
                document.documentElement.classList.remove('light-theme');
            } else if (window.matchMedia('(prefers-color-scheme: light)').matches) {
                document.documentElement.classList.add('light-theme');
            }
        })();
    </script>
    @yield('styles')
</head>
<body>

    <!-- Cinematic Opening Intro -->
    <div id="cinematic-intro">
        <canvas id="intro-canvas"></canvas>
    </div>

    <!-- Running Man Preloader -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="running-man">🏃‍♂️</div>
            <div class="preloader-text">Loading FitSpire...</div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header>
        <div class="container nav-wrapper">
            <a href="{{ route('dashboard') }}" class="logo" id="logo-link">
                ⚡ FitSpire <span>Hub</span>
            </a>
            
            <nav>
                <ul class="nav-links">
                    <li><a href="{{ route('dashboard') }}" class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" id="nav-dashboard">Dashboard</a></li>
                    <li><a href="{{ route('workouts.index') }}" class="{{ Route::currentRouteName() == 'workouts.index' ? 'active' : '' }}" id="nav-workouts">Workouts</a></li>
                    <li><a href="{{ route('ideas.index') }}" class="{{ Route::currentRouteName() == 'ideas.index' ? 'active' : '' }}" id="nav-ideas">Sports Ideas</a></li>
                    <li><a href="{{ route('calculators') }}" class="{{ Route::currentRouteName() == 'calculators' ? 'active' : '' }}" id="nav-calculators">Calculators</a></li>
                </ul>
            </nav>

            <div class="nav-user">
                <span>{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout" id="logout-button">Logout</button>
                </form>
                <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle Theme" title="Toggle Light/Dark Mode">🌓</button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Success/Error Alerts -->
            @if(session('success'))
                <div class="alert alert-success" id="success-alert">
                    <span>✔</span> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" id="error-alert">
                    <span>✖</span> Please fix the validation errors below.
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} FitSpire Hub. Ideas that boost fitness activities and assist in keeping fit.</p>
        </div>
    </footer>

    <!-- Custom Energy Cursor -->
    <div class="custom-cursor" id="custom-cursor">
        <div class="cursor-dot"></div>
        <div class="cursor-glow"></div>
        <div class="cursor-icon-container">
            <span id="cursor-icon">⚡</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('theme-toggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const isLight = document.documentElement.classList.toggle('light-theme');
                    localStorage.setItem('theme', isLight ? 'light' : 'dark');
                });
            }
        });

        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('fade-out');
            }
        });

        // Custom interactive physics cursor
        (function() {
            if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

            const cursor = document.getElementById('custom-cursor');
            const dot = cursor.querySelector('.cursor-dot');
            const glow = cursor.querySelector('.cursor-glow');
            const iconContainer = cursor.querySelector('.cursor-icon-container');
            const iconSpan = document.getElementById('cursor-icon');

            let mouseX = window.innerWidth / 2, mouseY = window.innerHeight / 2;
            let dotX = mouseX, dotY = mouseY;
            let glowX = mouseX, glowY = mouseY;

            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });

            function updatePhysics() {
                dotX += (mouseX - dotX) * 0.22;
                dotY += (mouseY - dotY) * 0.22;

                glowX += (mouseX - glowX) * 0.12;
                glowY += (mouseY - glowY) * 0.12;

                let dx = mouseX - glowX;
                let dy = mouseY - glowY;
                let speed = Math.sqrt(dx * dx + dy * dy);

                let scale = 1 + Math.min(speed / 120, 0.55);
                let angle = Math.atan2(dy, dx) * 180 / Math.PI;

                dot.style.transform = `translate3d(${dotX}px, ${dotY}px, 0)`;
                glow.style.transform = `translate3d(${glowX}px, ${glowY}px, 0) rotate(${angle}deg) scaleX(${scale})`;
                iconContainer.style.transform = `translate3d(${dotX}px, ${dotY}px, 0)`;

                requestAnimationFrame(updatePhysics);
            }
            requestAnimationFrame(updatePhysics);

            document.addEventListener('mouseover', (e) => {
                const target = e.target.closest('a, button, select, input, [role="button"], .interactive-hover, .btn-logout, .btn-delete-log, .theme-toggle-btn');
                if (target) {
                    cursor.classList.add('hovering');
                    
                    if (target.tagName === 'BUTTON' || target.classList.contains('btn') || target.classList.contains('btn-logout') || target.classList.contains('btn-delete-log') || target.classList.contains('theme-toggle-btn')) {
                        if (target.id.includes('workout') || target.innerText.toLowerCase().includes('workout') || target.innerText.toLowerCase().includes('routine') || target.innerText.toLowerCase().includes('activity')) {
                            iconSpan.innerText = '🏋️';
                        } else if (target.id.includes('delete') || target.classList.contains('btn-delete-log')) {
                            iconSpan.innerText = '💥';
                        } else {
                            iconSpan.innerText = '⚡';
                        }
                    } else if (target.tagName === 'A' || target.tagName === 'SELECT') {
                        if (target.href && target.href.includes('calculator')) {
                            iconSpan.innerText = '🎯';
                        } else {
                            iconSpan.innerText = '✨';
                        }
                    } else if (target.tagName === 'INPUT') {
                        iconSpan.innerText = '📝';
                    } else {
                        iconSpan.innerText = '⚡';
                    }
                }
            });

            document.addEventListener('mouseout', (e) => {
                const target = e.target.closest('a, button, select, input, [role="button"], .interactive-hover, .btn-logout, .btn-delete-log, .theme-toggle-btn');
                if (target) {
                    cursor.classList.remove('hovering');
                }
            });
        })();

        // Cinematic Apple/Nike Inspired Intro Manager
        (function() {
            if (sessionStorage.getItem('intro-played') === 'true') {
                const intro = document.getElementById('cinematic-intro');
                if (intro) intro.style.display = 'none';
                return;
            }

            const intro = document.getElementById('cinematic-intro');
            const canvas = document.getElementById('intro-canvas');
            if (!intro || !canvas) return;

            const ctx = canvas.getContext('2d');
            let width = canvas.width = window.innerWidth;
            let height = canvas.height = window.innerHeight;

            window.addEventListener('resize', () => {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            });

            // Particles system (lightweight dust)
            const particles = [];
            for (let i = 0; i < 30; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: -(Math.random() * 4 + 2),
                    vy: Math.random() * 1 - 0.5,
                    radius: Math.random() * 2 + 0.5,
                    color: ['#10b981', '#06b6d4', '#8b5cf6'][Math.floor(Math.random() * 3)]
                });
            }

            // Speed lines
            const speedLines = [];
            for (let i = 0; i < 8; i++) {
                speedLines.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    length: Math.random() * 100 + 40,
                    speed: Math.random() * 12 + 8,
                    color: 'rgba(6, 182, 212, 0.12)'
                });
            }

            let startTime = null;

            function render(time) {
                if (!startTime) startTime = time;
                let elapsed = (time - startTime) / 1000; // in seconds

                // 1. Dynamic background lighting sweep
                if (elapsed >= 1.5) {
                    let lightProgress = (elapsed - 1.5) / 1.7; // 0 to 1
                    let lightX = width / 2 + Math.sin(lightProgress * Math.PI - Math.PI / 2) * (width * 0.25);
                    let lightY = height / 2 - 30;
                    
                    let bgGrad = ctx.createRadialGradient(lightX, lightY, 10, width / 2, height / 2, Math.max(width, height) * 0.55);
                    bgGrad.addColorStop(0, '#0f172a'); // deep slate blue highlight
                    bgGrad.addColorStop(0.6, '#030712'); // pitch dark core
                    bgGrad.addColorStop(1, '#020617');
                    ctx.fillStyle = bgGrad;
                } else {
                    ctx.fillStyle = '#030712'; // start with solid pitch dark
                }
                ctx.fillRect(0, 0, width, height);

                // Draw background speed lines and dust particles
                speedLines.forEach(line => {
                    line.x -= line.speed;
                    if (line.x + line.length < 0) {
                        line.x = width;
                        line.y = Math.random() * height;
                    }
                    ctx.strokeStyle = line.color;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(line.x, line.y);
                    ctx.lineTo(line.x + line.length, line.y);
                    ctx.stroke();
                });

                particles.forEach(p => {
                    p.x += p.vx;
                    p.y += p.vy;
                    if (p.x < 0) {
                        p.x = width;
                        p.y = Math.random() * height;
                    }
                    ctx.fillStyle = p.color;
                    ctx.shadowColor = p.color;
                    ctx.shadowBlur = 6;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fill();
                });
                ctx.shadowBlur = 0; // Reset shadows

                // 2. Typographic flashing builds (Apple/Nike style)
                let text = "";
                let textScale = 1.0;
                let textAlpha = 1.0;
                let textBlur = 0;

                if (elapsed < 0.5) {
                    text = "FOCUS.";
                    let progress = elapsed / 0.5;
                    textScale = 0.94 + progress * 0.08;
                    textAlpha = progress < 0.25 ? progress / 0.25 : (progress > 0.75 ? (1 - progress) / 0.25 : 1);
                    textBlur = progress > 0.75 ? (progress - 0.75) * 45 : 0;
                } else if (elapsed < 1.0) {
                    text = "PERFORM.";
                    let progress = (elapsed - 0.5) / 0.5;
                    textScale = 0.94 + progress * 0.08;
                    textAlpha = progress < 0.25 ? progress / 0.25 : (progress > 0.75 ? (1 - progress) / 0.25 : 1);
                    textBlur = progress > 0.75 ? (progress - 0.75) * 45 : 0;
                } else if (elapsed < 1.5) {
                    text = "EXCEL.";
                    let progress = (elapsed - 1.0) / 0.5;
                    textScale = 0.94 + progress * 0.08;
                    textAlpha = progress < 0.25 ? progress / 0.25 : (progress > 0.75 ? (1 - progress) / 0.25 : 1);
                    textBlur = progress > 0.75 ? (progress - 0.75) * 45 : 0;
                }

                // Render typographic flashing text
                if (text) {
                    ctx.save();
                    ctx.translate(width / 2, height / 2);
                    ctx.scale(textScale, textScale);
                    ctx.font = '900 78px "Outfit", "Inter", sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = `rgba(255, 255, 255, ${textAlpha})`;
                    
                    if (textBlur > 0) {
                        ctx.filter = `blur(${textBlur}px)`;
                    }
                    
                    ctx.shadowColor = 'rgba(6, 182, 212, 0.35)';
                    ctx.shadowBlur = 20;
                    ctx.fillText(text, 0, 0);
                    ctx.restore();
                    ctx.filter = 'none'; // reset filter
                }

                // 3. Final Build: Glowing Vector Runner silhouette & logo (1.5s - 3.2s)
                if (elapsed >= 1.5) {
                    let buildProgress = Math.min((elapsed - 1.5) / 0.6, 1);
                    
                    // Render Vector runner in the center
                    let centerX = width / 2;
                    let centerY = height / 2 - 35;
                    
                    let phase = elapsed * 8.5;
                    let bodyAngle = 0.22;
                    
                    let hipX = centerX - 10;
                    let hipY = centerY + 15;
                    let chestX = hipX + Math.sin(bodyAngle) * 45;
                    let chestY = hipY - Math.cos(bodyAngle) * 45;
                    
                    let headX = chestX + Math.sin(bodyAngle) * 20;
                    let headY = chestY - Math.cos(bodyAngle) * 20;
                    
                    let leftThigh = Math.sin(phase) * 0.75 + bodyAngle + 0.2;
                    let rightThigh = -Math.sin(phase) * 0.75 + bodyAngle + 0.2;
                    
                    let leftShin = leftThigh + Math.sin(phase + 1) * 0.6 + 0.55;
                    let rightShin = rightThigh + Math.sin(phase + 1 + Math.PI) * 0.6 + 0.55;
                    
                    let leftUpperArm = Math.sin(phase + Math.PI) * 0.75 - 0.2;
                    let rightUpperArm = Math.sin(phase) * 0.75 - 0.2;

                    let leftForearm = leftUpperArm + 1.25;
                    let rightForearm = rightUpperArm - 1.25;

                    let leftElbowX = chestX + Math.sin(leftUpperArm) * 24;
                    let leftElbowY = chestY + Math.cos(leftUpperArm) * 24;
                    let leftHandX = leftElbowX + Math.sin(leftForearm) * 20;
                    let leftHandY = leftElbowY + Math.cos(leftForearm) * 20;

                    let rightElbowX = chestX + Math.sin(rightUpperArm) * 24;
                    let rightElbowY = chestY + Math.cos(rightUpperArm) * 24;
                    let rightHandX = rightElbowX + Math.sin(rightForearm) * 20;
                    let rightHandY = rightElbowY + Math.cos(rightForearm) * 20;

                    let leftKneeX = hipX + Math.sin(leftThigh) * 32;
                    let leftKneeY = hipY + Math.cos(leftThigh) * 32;
                    let leftFootX = leftKneeX + Math.sin(leftShin) * 30;
                    let leftFootY = leftKneeY + Math.cos(leftShin) * 30;

                    let rightKneeX = hipX + Math.sin(rightThigh) * 32;
                    let rightKneeY = hipY + Math.cos(rightThigh) * 32;
                    let rightFootX = rightKneeX + Math.sin(rightShin) * 30;
                    let rightFootY = rightKneeY + Math.cos(rightShin) * 30;

                    // Neon shadow outline
                    ctx.strokeStyle = `rgba(6, 182, 212, ${buildProgress})`;
                    ctx.lineWidth = 18;
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';
                    ctx.shadowColor = '#06b6d4';
                    ctx.shadowBlur = 25;

                    function drawRunner() {
                        ctx.beginPath();
                        ctx.moveTo(chestX, chestY);
                        ctx.lineTo(leftElbowX, leftElbowY);
                        ctx.lineTo(leftHandX, leftHandY);
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.moveTo(hipX, hipY);
                        ctx.lineTo(leftKneeX, leftKneeY);
                        ctx.lineTo(leftFootX, leftFootY);
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.moveTo(hipX, hipY);
                        ctx.lineTo(chestX, chestY);
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.arc(headX, headY, 11, 0, Math.PI * 2);
                        ctx.stroke();
                        ctx.fill();

                        ctx.beginPath();
                        ctx.moveTo(hipX, hipY);
                        ctx.lineTo(rightKneeX, rightKneeY);
                        ctx.lineTo(rightFootX, rightFootY);
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.moveTo(chestX, chestY);
                        ctx.lineTo(rightElbowX, rightElbowY);
                        ctx.lineTo(rightHandX, rightHandY);
                        ctx.stroke();
                    }

                    drawRunner();

                    // Inner solid silhouette
                    ctx.strokeStyle = `rgba(0, 0, 0, ${buildProgress})`;
                    ctx.fillStyle = `rgba(0, 0, 0, ${buildProgress})`;
                    ctx.lineWidth = 14;
                    ctx.shadowBlur = 0; // disable shadow for black core
                    drawRunner();

                    // Render FitSpire Logo below runner
                    ctx.save();
                    ctx.translate(width / 2, height / 2 + 115);
                    ctx.font = '800 44px "Outfit", sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillStyle = `rgba(255, 255, 255, ${buildProgress})`;
                    ctx.shadowColor = 'rgba(6, 182, 212, 0.3)';
                    ctx.shadowBlur = 20;
                    ctx.fillText("⚡ FITSPIRE HUB", 0, 0);
                    ctx.restore();

                    // Render subtext slogan
                    ctx.save();
                    ctx.translate(width / 2, height / 2 + 155);
                    ctx.font = '600 13px "Inter", sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillStyle = `rgba(255, 255, 255, ${buildProgress * 0.55})`;
                    ctx.fillText("U N L E A S H   Y O U R   P O T E N T I A L", 0, 0);
                    ctx.restore();
                }

                // 4. End animation after 3.2 seconds
                if (elapsed < 3.2) {
                    requestAnimationFrame(render);
                } else {
                    intro.classList.add('hide');
                    sessionStorage.setItem('intro-played', 'true');
                }
            }

            requestAnimationFrame(render);
        })();
    </script>
    @yield('scripts')
</body>
</html>
