@extends('layouts.app')

@section('title', 'Sports & Fitness Ideas')

@section('content')
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2.2rem; margin-bottom: 5px;">Sports & Fitness Ideas Directory</h1>
        <p style="color: var(--text-muted);">Discover and save routines designed to boost fitness activities and assist you in keeping fit.</p>
    </div>

    <!-- Search and Category Filters Panel -->
    <div class="panel" style="margin-bottom: 30px;" id="panel-search-filters">
        <form action="{{ route('ideas.index') }}" method="GET" class="search-filter-bar" id="ideas-filter-form">
            
            <!-- Search bar -->
            <input type="text" name="q" id="search-query" class="form-control" placeholder="Search by activity, equipment, or description..." value="{{ request('q') }}">

            <!-- Category Filter dropdown -->
            <select name="category" id="category-filter" class="form-control" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="Cardio" {{ request('category') == 'Cardio' ? 'selected' : '' }}>Cardio / Endurance</option>
                <option value="Strength" {{ request('category') == 'Strength' ? 'selected' : '' }}>Strength & Conditioning</option>
                <option value="Sports Drills" {{ request('category') == 'Sports Drills' ? 'selected' : '' }}>Sports-Specific Drills</option>
                <option value="Flexibility" {{ request('category') == 'Flexibility' ? 'selected' : '' }}>Flexibility & Yoga</option>
            </select>

            <button type="submit" class="btn btn-primary" id="btn-search-ideas">Search</button>

            @if(request('q') || request('category'))
                <a href="{{ route('ideas.index') }}" class="btn btn-outline" style="line-height: 24px;" id="btn-reset-ideas">Reset</a>
            @endif
        </form>

        <!-- Category Shortcuts (Tabs) -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap;" id="category-tabs">
            <a href="{{ route('ideas.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline' }}">All</a>
            <a href="{{ route('ideas.index', ['category' => 'Cardio', 'q' => request('q')]) }}" class="btn btn-sm {{ request('category') == 'Cardio' ? 'btn-primary' : 'btn-outline' }}">Cardio</a>
            <a href="{{ route('ideas.index', ['category' => 'Strength', 'q' => request('q')]) }}" class="btn btn-sm {{ request('category') == 'Strength' ? 'btn-primary' : 'btn-outline' }}">Strength</a>
            <a href="{{ route('ideas.index', ['category' => 'Sports Drills', 'q' => request('q')]) }}" class="btn btn-sm {{ request('category') == 'Sports Drills' ? 'btn-primary' : 'btn-outline' }}">Sports Drills</a>
            <a href="{{ route('ideas.index', ['category' => 'Flexibility', 'q' => request('q')]) }}" class="btn btn-sm {{ request('category') == 'Flexibility' ? 'btn-primary' : 'btn-outline' }}">Flexibility</a>
        </div>
    </div>

    <!-- Ideas Grid -->
    <div class="ideas-grid" id="ideas-cards-grid">
        @forelse($ideas as $idea)
            <div class="panel idea-card" id="idea-card-{{ $idea->id }}">
                <div class="idea-card-image">
                    @if($idea->category == 'Cardio')
                        <img src="{{ asset('images/cardio_theme.png') }}" alt="Cardio Training">
                    @elseif($idea->category == 'Strength')
                        <img src="{{ asset('images/strength_theme.png') }}" alt="Strength Training">
                    @elseif($idea->category == 'Sports Drills')
                        <img src="{{ asset('images/sports_drills_theme.png') }}" alt="Sports Drills">
                    @elseif($idea->category == 'Flexibility')
                        <img src="{{ asset('images/flexibility_theme.png') }}" alt="Flexibility Flow">
                    @endif
                </div>

                <div class="idea-tag-row">
                    <span class="idea-category">{{ $idea->category }}</span>
                    <span class="idea-intensity">{{ $idea->intensity_level }}</span>
                </div>

                <h3 class="idea-title">{{ $idea->title }}</h3>
                <p class="idea-description">{{ $idea->description }}</p>

                <div class="idea-meta">
                    <div class="idea-meta-item">
                        <span>Equipment:</span>
                        <strong>{{ $idea->equipment_needed }}</strong>
                    </div>
                    <div class="idea-meta-item">
                        <span>Est. Duration:</span>
                        <strong>{{ $idea->duration_est }} mins</strong>
                    </div>
                    <div class="idea-meta-item">
                        <span>Calorie Burn:</span>
                        <strong>~{{ $idea->calories_burned_est }} kcal</strong>
                    </div>
                    <div class="idea-meta-item">
                        <span>Est. Rate:</span>
                        <strong>{{ round($idea->calories_burned_est / ($idea->duration_est ?: 1), 1) }} kcal/m</strong>
                    </div>
                </div>

                <div class="idea-actions">
                    <!-- Toggle Instructions JS Button -->
                    <button class="btn btn-outline btn-sm toggle-instructions-btn" data-id="{{ $idea->id }}" id="btn-toggle-instructions-{{ $idea->id }}">
                        View Routine
                    </button>

                    <!-- Save/Unsave Action -->
                    @if(in_array($idea->id, $savedIdeaIds))
                        <form action="{{ route('ideas.unsave', $idea) }}" method="POST" style="flex: 1; display: flex;">
                            @csrf
                            <button type="submit" class="btn btn-accent btn-sm btn-block" style="background: linear-gradient(135deg, var(--color-accent), #6b21a8);" id="btn-unsave-idea-{{ $idea->id }}">
                                Saved
                            </button>
                        </form>
                    @else
                        <form action="{{ route('ideas.save', $idea) }}" method="POST" style="flex: 1; display: flex;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm btn-block" id="btn-save-idea-{{ $idea->id }}">
                                Save Routine
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Hidden instructions drawer -->
                <div class="idea-instructions" id="instructions-{{ $idea->id }}">
                    <h4 style="font-size: 0.95rem; margin-bottom: 8px; color: #ffffff;">Step-by-Step Instructions:</h4>
                    <ol class="instruction-steps">
                        @if($idea->instructions)
                            @foreach(explode("\n", $idea->instructions) as $step)
                                <li>{{ $step }}</li>
                            @endforeach
                        @else
                            <li>Perform the activity at a steady pace focusing on proper form.</li>
                        @endif
                    </ol>
                </div>

            </div>
        @empty
            <div class="panel" style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 60px 20px;" id="empty-ideas-placeholder">
                <span style="font-size: 2.5rem; display: block; margin-bottom: 15px;">🔍</span>
                No sports or fitness ideas match your filters.<br>Try adjusting your search keywords or resetting categories.
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.toggle-instructions-btn');
            
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const ideaId = button.getAttribute('data-id');
                    const drawer = document.getElementById(`instructions-${ideaId}`);
                    
                    if (drawer.classList.contains('active')) {
                        drawer.classList.remove('active');
                        button.innerText = 'View Routine';
                    } else {
                        drawer.classList.add('active');
                        button.innerText = 'Hide Routine';
                    }
                });
            });
        });
    </script>
@endsection
