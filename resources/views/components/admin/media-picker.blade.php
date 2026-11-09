<div x-data="{
        open: false,
        targetInput: null,
        targetPreview: null,
        mediaList: [],
        loading: false,
        uploading: false,
        searchQuery: '',
        loadMedia() {
            this.loading = true;
            fetch('{{ route('admin.media.api') }}?search=' + encodeURIComponent(this.searchQuery))
                .then(res => res.json())
                .then(data => {
                    this.mediaList = data.data || [];
                    this.loading = false;
                    setTimeout(() => window.renderIcons(), 50);
                })
                .catch(() => this.loading = false);
        },
        selectMedia(url) {
            if (this.targetInput) {
                const inputEl = document.getElementById(this.targetInput);
                if (inputEl) {
                    inputEl.value = url;
                    inputEl.dispatchEvent(new Event('input'));
                }
            }
            if (this.targetPreview) {
                const previewEl = document.getElementById(this.targetPreview);
                if (previewEl) {
                    previewEl.src = url;
                    previewEl.classList.remove('hidden');
                }
            }
            this.open = false;
        },
        uploadFile(e) {
            const files = e.target.files;
            if (!files.length) return;

            const formData = new FormData();
            formData.append('file', files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            this.uploading = true;
            fetch('{{ route('admin.media.upload.api') }}', {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(res => {
                this.uploading = false;
                if (res.url) {
                    this.selectMedia(res.url);
                }
                this.loadMedia();
            })
            .catch(() => {
                this.uploading = false;
                alert('Upload failed. Please check file format and size.');
            });
        }
     }"
     @open-media-picker.window="
        targetInput = $event.detail.targetInput;
        targetPreview = $event.detail.targetPreview;
        open = true;
        loadMedia();
     "
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
     style="display: none;">

    <div @click.away="open = false" class="bg-stone-900 border border-stone-800 rounded-3xl w-full max-w-4xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">

        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-stone-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i data-lucide="image" class="w-5 h-5 text-amber-400"></i>
                <h3 class="font-serif-heading text-lg font-bold text-white">Media Library & Picker</h3>
            </div>
            <button @click="open = false" class="text-stone-400 hover:text-white p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Controls: Search & Upload -->
        <div class="p-4 border-b border-stone-800 flex flex-col sm:flex-row items-center justify-between gap-4 bg-stone-950/60">
            <div class="relative w-full sm:w-72">
                <input type="text"
                       x-model="searchQuery"
                       @input.debounce.300ms="loadMedia()"
                       placeholder="Search media files..."
                       class="w-full bg-stone-900 border border-stone-700/80 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-stone-500 focus:outline-none focus:border-amber-400">
                <i data-lucide="search" class="w-4 h-4 text-stone-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
            </div>

            <div>
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider bg-amber-400 text-stone-950 hover:bg-amber-300 transition-colors">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span x-text="uploading ? 'Uploading...' : 'Upload New Image'"></span>
                    <input type="file" @change="uploadFile" accept="image/*" class="hidden" :disabled="uploading">
                </label>
            </div>
        </div>

        <!-- Media Grid -->
        <div class="p-6 overflow-y-auto flex-1">
            <template x-if="loading">
                <div class="py-16 text-center text-stone-400 text-xs">
                    <i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto mb-2 text-amber-400"></i>
                    <span>Loading assets...</span>
                </div>
            </template>

            <template x-if="!loading && mediaList.length === 0">
                <div class="py-16 text-center text-stone-500 text-xs">
                    <i data-lucide="image-off" class="w-8 h-8 mx-auto mb-2"></i>
                    <span>No media found. Upload your first photo above!</span>
                </div>
            </template>

            <div x-show="!loading && mediaList.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <template x-for="item in mediaList" :key="item.id">
                    <div @click="selectMedia(item.url)"
                         class="group relative rounded-xl overflow-hidden aspect-square bg-stone-950 border border-stone-800 hover:border-amber-400 cursor-pointer transition-all shadow-md">
                        <img :src="item.url" :alt="item.alt_text" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        <div class="absolute inset-0 bg-stone-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-2 text-[10px] text-white">
                            <span class="truncate font-semibold" x-text="item.original_name"></span>
                            <span class="text-stone-400" x-text="item.formatted_size"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-3 border-t border-stone-800 bg-stone-950/60 flex items-center justify-between text-xs text-stone-400">
            <span>Click any image to select it for your field.</span>
            <button @click="open = false" class="px-4 py-1.5 rounded-lg bg-stone-800 hover:bg-stone-700 text-white transition-colors">
                Cancel
            </button>
        </div>

    </div>
</div>
