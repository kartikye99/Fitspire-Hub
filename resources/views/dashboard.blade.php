@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" id="dashboard-welcome">
        <div class="welcome-text">
            <h1>Hi, {{ Auth::user()->name }}!</h1>
            <p>Ready to boost your fitness levels today? Track your actions below.</p>
        </div>
        <div class="streak-badge" id="streak-badge-container">
            <span class="streak-icon">🔥</span>
            <div>
                <div class="streak-number" id="streak-value">{{ $streak }}</div>
                <div class="streak-label">Day Streak</div>
            </div>
        </div>
    </div>

    <!-- Stats summary cards -->
    <div class="stats-row" id="stats-summary-row">
        <!-- Calories -->
        <div class="stat-card calories" id="stat-calories">
            <div class="stat-header">Calories Burned Today</div>
            <div class="stat-value" id="val-calories">{{ $todayCalories }} <span>kcal</span></div>
        </div>

        <!-- Active Minutes -->
        <div class="stat-card minutes" id="stat-minutes">
            <div class="stat-header">Active Minutes Today</div>
            <div class="stat-value" id="val-minutes">{{ $todayMinutes }} <span>mins</span></div>
        </div>

        <!-- Water Hydration -->
        <div class="stat-card water" id="stat-water">
            <div class="stat-header">Water Intake Today</div>
            <div class="stat-value" id="val-water">{{ $todayWater / 1000 }} / 2.0 <span>Liters</span></div>
        </div>
    </div>

    <!-- Dashboard main grid -->
    <div class="dashboard-grid">
        <!-- Left: Quick log forms -->
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <!-- Hydration Widget -->
            <div class="panel" id="panel-hydration">
                <h3>Hydration Tracker</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 20px;">Target: 2.0 Liters (2000 ml) daily to stay hydrated during sports.</p>
                
                @php
                    $waterTarget = 2000;
                    $percent = min(100, ($todayWater / $waterTarget) * 100);
                @endphp

                <div class="water-widget">
                    <div class="water-bottle" id="water-bottle-visual">
                        <div class="water-fill" style="height: {{ $percent }}%;" id="water-fill-level"></div>
                    </div>

                    <div style="font-size: 1.1rem; font-weight: 700; margin-bottom: 5px;">
                        {{ $todayWater }} ml logged
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.85rem;">
                        {{ round($percent) }}% of daily target reached
                    </div>

                    <form action="{{ route('water-logs.store') }}" method="POST" class="water-options">
                        @csrf
                        <button type="submit" name="amount_ml" value="250" class="btn btn-outline btn-sm" id="btn-add-250">
                            +250 ml (Cup)
                        </button>
                        <button type="submit" name="amount_ml" value="500" class="btn btn-outline btn-sm" id="btn-add-500">
                            +500 ml (Bottle)
                        </button>
                        <button type="submit" name="amount_ml" value="750" class="btn btn-outline btn-sm" id="btn-add-750">
                            +750 ml (Large)
                        </button>
                        <button type="submit" name="amount_ml" value="1000" class="btn btn-outline btn-sm" id="btn-add-1000">
                            +1000 ml (Max)
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Workout Logger Form -->
            <div class="panel" id="panel-quick-workout">
                <div class="quick-log-form">
                    <h3>Quick Log Activity</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 20px;">Log a sport or workout to calculate calorie burn rates.</p>

                    <form action="{{ route('workouts.store') }}" method="POST" id="quick-workout-form">
                        @csrf

                        <div class="form-group">
                            <label for="activity_name" class="form-label">Activity / Sport Name</label>
                            <input type="text" name="activity_name" id="activity_name" class="form-control" placeholder="e.g., Running, Football, HIIT" required>
                            @error('activity_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" placeholder="e.g., 30" min="1" max="1440" required>
                                @error('duration_minutes')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="intensity" class="form-label">Intensity Level</label>
                                <select name="intensity" id="intensity" class="form-control" required style="background-color: var(--bg-dark); color: white;">
                                    <option value="Medium">Medium (8 kcal/min)</option>
                                    <option value="Low">Low (5 kcal/min)</option>
                                    <option value="High">High (12 kcal/min)</option>
                                </select>
                                @error('intensity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="logged_at" class="form-label">Date</label>
                            <input type="date" name="logged_at" id="logged_at" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                            @error('logged_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" id="btn-submit-quick-workout">
                            Log Workout
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right: Recent logs history and Saved ideas -->
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <!-- Recent Activities -->
            <div class="panel" id="panel-recent-activities">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin-bottom: 0;">Recent Activities</h3>
                    <a href="{{ route('workouts.index') }}" style="font-size: 0.85rem;" id="link-view-all-workouts">View All</a>
                </div>

                <div class="log-list" id="recent-workouts-list">
                    @forelse($recentWorkouts as $workout)
                        <div class="log-item" id="workout-item-{{ $workout->id }}">
                            <div class="log-info">
                                <h4>{{ $workout->activity_name }}</h4>
                                <p>{{ \Carbon\Carbon::parse($workout->logged_at)->format('M d, Y') }} &bull; <span style="color: {{ $workout->intensity == 'High' ? '#ef4444' : ($workout->intensity == 'Medium' ? '#3b82f6' : '#10b981') }}">{{ $workout->intensity }}</span></p>
                            </div>
                            <div class="log-stats">
                                <div class="log-stat">
                                    <div class="log-stat-num">{{ $workout->duration_minutes }} <span style="font-size: 0.75rem; font-weight: normal; color: var(--text-muted);">min</span></div>
                                    <div class="log-stat-label">Duration</div>
                                </div>
                                <div class="log-stat">
                                    <div class="log-stat-num" style="color: var(--color-primary);">{{ $workout->calories_burned }} <span style="font-size: 0.75rem; font-weight: normal; color: var(--text-muted);">kcal</span></div>
                                    <div class="log-stat-label">Burned</div>
                                </div>
                                <form action="{{ route('workouts.destroy', $workout) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-log" title="Delete log" onclick="return confirm('Are you sure you want to delete this workout?')">×</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 40px 0;" id="empty-workouts-placeholder">
                            <span style="font-size: 2rem; display: block; margin-bottom: 10px;">🏃‍♂️</span>
                            No activities logged yet.<br>Start by adding your first workout!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Saved Fitness Ideas -->
            <div class="panel" id="panel-saved-ideas">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin-bottom: 0;">My Saved Routines</h3>
                    <a href="{{ route('ideas.index') }}" style="font-size: 0.85rem;" id="link-view-all-ideas">Find More</a>
                </div>

                <div class="log-list" id="saved-ideas-list">
                    @forelse($savedIdeas as $idea)
                        <div class="log-item" id="saved-idea-item-{{ $idea->id }}" style="border-left: 3px solid var(--color-accent);">
                            <div class="log-info">
                                <h4 style="font-size: 0.95rem;">{{ $idea->title }}</h4>
                                <p>{{ $idea->category }} &bull; Est. {{ $idea->duration_est }} mins</p>
                            </div>
                            <div class="log-stats">
                                <a href="{{ route('ideas.index', ['category' => $idea->category]) }}" class="btn btn-outline btn-sm" style="padding: 6px 12px; font-size: 0.75rem;">View</a>
                                <form action="{{ route('ideas.unsave', $idea) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-delete-log" title="Remove" style="color: #ef4444;">×</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 30px 0;" id="empty-ideas-placeholder">
                            <span style="font-size: 1.8rem; display: block; margin-bottom: 10px;">💡</span>
                            No ideas saved yet.<br>Browse the ideas hub to find sports drills & activities.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
