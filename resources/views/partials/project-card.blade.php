<a class="card" href="{{ route('work.show', $project->slug) }}">
    <div class="shot" aria-hidden="true"></div>
    <div>
        <span @class(['tag', 'live' => $project->status === 'live', 'dev' => $project->status !== 'live'])>{{ $project->statusLabel() }}</span>
        <span class="tag">{{ $project->categoryLabel() }}</span>
    </div>
    <h3>{{ $project->title }}</h3>
    <p>{{ $project->summary }}</p>
    <span class="more">Read case study →</span>
</a>
