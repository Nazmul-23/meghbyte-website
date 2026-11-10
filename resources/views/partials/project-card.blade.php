@php
    $tech = array_slice((array) ($project->tech_stack ?? []), 0, 2);
@endphp
<a class="case" href="{{ route('work.show', $project->slug) }}">
    <div class="info">
        <span class="tag">{{ $project->categoryLabel() }}</span>
        <h3>{{ $project->title }}</h3>
        <p>{{ $project->summary }}</p>
        <div class="meta">
            <div>Scope<b>{{ $project->categoryLabel() }}</b></div>
            <div>Status<b class="status-dot {{ $project->status === 'live' ? '' : 'dev' }}">{{ $project->statusLabel() }}</b></div>
            @if($tech)<div>Stack<b>{{ implode(' · ', $tech) }}</b></div>@endif
        </div>
    </div>
    <div class="visual" aria-hidden="true">
        @php $shot = 'images/work/'.$project->slug.'.webp'; @endphp
        @if(file_exists(public_path($shot)))
            <figure class="browser"><div class="bar"><i></i><i></i><i></i><span>{{ \Illuminate\Support\Str::slug($project->title) }}.app</span></div><img src="{{ asset($shot) }}?v=1" alt="" loading="lazy" width="1600" height="900"></figure>
        @elseif($project->category === 'app')
            <div class="mock-phone"><div class="ln"></div><i class="g"></i><i></i><i></i><b>Create quotation</b></div>
        @else
            <div class="mock-win"><div class="dots"><i></i><i></i><i></i></div><div class="ln" style="width:40%"></div><div class="row"><i class="g"></i><i></i><i></i></div><div class="row"><i></i><i></i></div><div class="ln"></div><div class="ln" style="width:70%"></div></div>
        @endif
    </div>
</a>
