@php
    $values = $values ?? [];
    $prefix = $prefix ?? 'data';
@endphp

@foreach($fields as $field)
    @php
        $key = $field['key'];
        $name = $prefix.'['.$key.']';
        $id = 'fld_'.str_replace(['[', ']'], '_', $name);
        $value = data_get($values, $key);
        $type = $field['type'] ?? 'text';
    @endphp

    <div class="space-y-1.5">
        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-300" for="{{ $id }}">
            {{ $field['label'] ?? $key }}
        </label>

        @if($type === 'textarea')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="5" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">{{ $value }}</textarea>
        @elseif($type === 'media')
            <div class="flex gap-2">
                <input id="{{ $id }}" type="text" name="{{ $name }}" value="{{ $value }}" placeholder="Image or video path" class="flex-1 bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                <button type="button"
                        @click="$dispatch('open-media-picker', { targetInput: '{{ $id }}', targetPreview: '{{ $id }}_preview' })"
                        class="px-3 rounded-xl bg-stone-800 text-amber-300 text-xs font-semibold">
                    Library
                </button>
            </div>
            @if($prefix === 'data')
                <input type="file" name="upload[{{ $key }}]" accept="image/*,video/mp4,video/webm" class="text-xs text-stone-400">
            @endif
            <img id="{{ $id }}_preview" src="{{ \App\Support\AssetUrl::make(is_string($value) ? $value : '') }}" alt="" class="mt-2 max-h-20 {{ $value ? '' : 'hidden' }}">
        @elseif($type === 'repeater')
            @php
                $rows = is_array($value) && count($value) ? array_values($value) : [[]];
            @endphp
            <div class="repeater space-y-3">
                <div class="repeater-rows space-y-3">
                    @foreach($rows as $index => $row)
                        <div class="repeater-row bg-stone-950 border border-stone-800 rounded-2xl p-4 space-y-3">
                            @include('admin.pages.partials.section-fields', [
                                'fields' => $field['fields'],
                                'values' => $row,
                                'prefix' => $name.'['.$index.']',
                            ])
                            <button type="button" class="remove-row text-xs text-rose-300">Remove</button>
                        </div>
                    @endforeach
                </div>
                <template>
                    <div class="repeater-row bg-stone-950 border border-stone-800 rounded-2xl p-4 space-y-3">
                        @include('admin.pages.partials.section-fields', [
                            'fields' => $field['fields'],
                            'values' => [],
                            'prefix' => $name.'[__INDEX__]',
                        ])
                        <button type="button" class="remove-row text-xs text-rose-300">Remove</button>
                    </div>
                </template>
                <button type="button" class="add-row px-3 py-2 rounded-xl bg-stone-800 text-xs font-semibold text-amber-300">Add another</button>
            </div>
        @else
            <input id="{{ $id }}" type="text" name="{{ $name }}" value="{{ $value }}" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
        @endif
    </div>
@endforeach

@once
    @push('scripts')
        <script>
            document.addEventListener('click', (event) => {
                const add = event.target.closest('.add-row');
                if (add) {
                    const wrap = add.closest('.repeater');
                    const rows = wrap.querySelector('.repeater-rows');
                    const html = wrap.querySelector('template').innerHTML.replaceAll('__INDEX__', rows.children.length);
                    rows.insertAdjacentHTML('beforeend', html);
                    return;
                }
                const remove = event.target.closest('.remove-row');
                if (remove) {
                    const row = remove.closest('.repeater-row');
                    const rows = row.parentElement;
                    if (rows.children.length > 1) {
                        row.remove();
                    }
                }
            });
        </script>
    @endpush
@endonce
