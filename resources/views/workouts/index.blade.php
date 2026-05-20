@extends('layouts.app')

@section('title', 'Workouts Log')

@section('content')
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2.2rem; margin-bottom: 5px;">Workout Tracker</h1>
        <p style="color: var(--text-muted);">View your detailed physical history and log new sports activities.</p>
    </div>

    <!-- Aggregate Stats Grid -->
    <div class="stats-row" style="margin-bottom: 30px;" id="workouts-aggregate-stats">
        <div class="stat-card calories" id="workouts-total-calories">
            <div class="stat-header">Total Calories Burned</div>
            <div class="stat-value">{{ $totalCalories }} <span>kcal</span></div>
        </div>

        <div class="stat-card minutes" id="workouts-total-minutes">
            <div class="stat-header">Total Active Minutes</div>
            <div class="stat-value">{{ $totalDuration }} <span>mins</span></div>
        </div>

        <div class="stat-card water" id="workouts-total-count" style="border-bottom: 3px solid var(--color-secondary);">
            <div class="stat-header">Total Activities Logged</div>
            <div class="stat-value">{{ $workoutCount }} <span>workouts</span></div>
        </div>
    </div>

    <!-- Workouts Main Grid -->
    <div class="dashboard-grid">
        <!-- Left: Logging Form -->
        <div class="panel" id="panel-add-workout" style="height: fit-content;">
            <h3>Log New Activity</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 25px;">Provide the duration and intensity of your training session.</p>

            <form action="{{ route('workouts.store') }}" method="POST" id="workouts-page-log-form">
                @csrf

                <div class="form-group">
                    <label for="activity_name" class="form-label">Activity / Sport Name</label>
                    <input type="text" name="activity_name" id="activity_name" class="form-control" placeholder="e.g., Football, Jogging, Swimming" required>
                    @error('activity_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" placeholder="e.g., 45" min="1" max="1440" required>
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

                <div class="form-group">
                    <label for="logged_at" class="form-label">Date of Training</label>
                    <input type="date" name="logged_at" id="logged_at" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                    @error('logged_at')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes / Details (Optional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="How did you feel? Sets, reps, or distance covered..."></textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="workouts-page-submit">
                    Log Workout
                </button>
            </form>
        </div>

        <!-- Right: Log History Table -->
        <div class="panel" id="panel-workout-history">
            <h3>Training History</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 15px;">List of all logged fitness and sports events.</p>

            <div class="table-responsive">
                <table class="premium-table" id="workouts-history-table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Duration</th>
                            <th>Intensity</th>
                            <th>Calories</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workouts as $workout)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #ffffff;">{{ $workout->activity_name }}</div>
                                    @if($workout->notes)
                                        <div style="font-size: 0.78rem; color: var(--text-muted); font-style: italic; margin-top: 4px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $workout->notes }}">
                                            {{ $workout->notes }}
                                        </div>
                                    @endif
                                </td>
                                <td style="color: var(--text-muted);">
                                    {{ \Carbon\Carbon::parse($workout->logged_at)->format('M d, Y') }}
                                </td>
                                <td>{{ $workout->duration_minutes }} mins</td>
                                <td>
                                    <span style="font-size: 0.8rem; font-weight: 600; padding: 3px 8px; border-radius: 20px; 
                                        @if($workout->intensity == 'High') background: rgba(239, 68, 68, 0.15); color: #f87171;
                                        @elseif($workout->intensity == 'Medium') background: rgba(59, 130, 246, 0.15); color: #60a5fa;
                                        @else background: rgba(16, 185, 129, 0.15); color: #34d399; @endif">
                                        {{ $workout->intensity }}
                                    </span>
                                </td>
                                <td style="color: var(--color-primary); font-weight: 700; font-family: var(--font-heading);">
                                    {{ $workout->calories_burned }} kcal
                                </td>
                                <td>
                                    <form action="{{ route('workouts.destroy', $workout) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-log" title="Delete entry" onclick="return confirm('Are you sure you want to delete this workout?')">×</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 50px 0;">
                                    <span style="font-size: 2rem; display: block; margin-bottom: 10px;">📉</span>
                                    No logged history found. Use the form to submit your first session!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom pagination links -->
            <div style="margin-top: 20px;" id="workouts-pagination">
                {{ $workouts->links() }}
            </div>
        </div>
    </div>
@endsection
