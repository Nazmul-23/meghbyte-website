<section class="block">
    <div class="wrap">
        <div class="cta-band">
            <div>
                <h2>{{ $title ?? 'Have a project in mind?' }}</h2>
                <p>{{ $text ?? 'Tell us what your business needs. We reply with honest advice and a clear, written quote.' }}</p>
            </div>
            <div class="cta-row">
                <a class="btn btn-o" href="{{ route('contact') }}">Get a free quote</a>
                <a class="btn btn-line" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp us</a>
            </div>
        </div>
    </div>
</section>
