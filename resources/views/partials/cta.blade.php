<section class="sec" style="padding-top:40px">
    <div class="wrap">
        <div class="ctaband">
            <span class="eyebrow">Free 30-minute consultation</span>
            <h2 style="margin-top:18px">{{ $title ?? 'Have a project in mind?' }}</h2>
            <p>{{ $text ?? 'Tell us what you want to build. We reply within 24 hours with honest advice and a clear proposal.' }}</p>
            <div class="ctas">
                <a class="btn btn-light" href="{{ route('contact') }}">Book a free call <span class="arr">→</span></a>
                <a class="btn btn-ghost" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">Chat on WhatsApp</a>
            </div>
        </div>
    </div>
</section>
