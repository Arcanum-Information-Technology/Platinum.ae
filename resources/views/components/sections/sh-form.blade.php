@props(['data'])

@php
    $showTerritory = (string) ($data['show_territory'] ?? '0') === '1';
    $title = $data['title'] ?? "Let's connect!";
    $submitLabel = $data['submit_label'] ?? 'Enquire Now';
@endphp

<section class="sh-form-band">
    <div class="sh-wrap max-w-4xl mx-auto px-4 sm:px-6">
        <div class="sh-form-card">
            <div class="sh-form-header">
                @if(!empty(trim($title)))
                    <h2 class="sh-form-title">{{ $title }}</h2>
                @endif
                <p class="sh-form-subtitle">
                    @if($showTerritory)
                        Begin your journey with Shakespeare Middle East. Share your details below and our development director will be in touch.
                    @else
                        We welcome your thoughts and reservations. Please submit your inquiry below.
                    @endif
                </p>
                <div class="sh-form-flourish" aria-hidden="true">❦</div>
            </div>

            <form action="{{ route('contact.submit') }}" method="POST" class="sh-form-grid">
                @csrf
                <input type="text" name="website_hp" tabindex="-1" autocomplete="off" class="sh-hp" aria-hidden="true">
                <input type="hidden" name="subject" value="{{ $data['subject'] ?? ($showTerritory ? 'Franchise enquiry' : 'Website enquiry') }}">

                @if($errors->any())
                    <div class="sh-form-error-box col-span-full">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="sh-field-group">
                    <label for="fld_name" class="sh-field-label">Full Name <span class="sh-req">*</span></label>
                    <input id="fld_name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required class="sh-field-input">
                </div>

                <div class="sh-field-group">
                    <label for="fld_phone" class="sh-field-label">Mobile Number</label>
                    <input id="fld_phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Mobile Number" class="sh-field-input">
                </div>

                <div class="sh-field-group {{ $showTerritory ? '' : 'col-span-full' }}">
                    <label for="fld_email" class="sh-field-label">Email Address <span class="sh-req">*</span></label>
                    <input id="fld_email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required class="sh-field-input">
                </div>

                @if($showTerritory)
                    <div class="sh-field-group">
                        <label for="fld_territory" class="sh-field-label">Territory Interest</label>
                        <input id="fld_territory" type="text" name="territory" value="{{ old('territory') }}" placeholder="Territory Interest" class="sh-field-input">
                    </div>
                @endif

                <div class="sh-field-group col-span-full">
                    <label for="fld_message" class="sh-field-label">Message <span class="sh-req">*</span></label>
                    <textarea id="fld_message" name="message" rows="5" placeholder="Message" required class="sh-field-input sh-field-textarea">{{ old('message') }}</textarea>
                </div>

                <div class="col-span-full text-center pt-2">
                    <button type="submit" class="sh-form-submit-btn">
                        <span>{{ $submitLabel }}</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <p class="sh-form-disclaimer">
                        Strict confidentiality guaranteed. We typically respond within 24–48 hours.
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
