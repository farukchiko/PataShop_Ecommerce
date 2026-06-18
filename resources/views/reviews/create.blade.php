<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-800 leading-tight tracking-wide">
            {{ __('Tulis Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                <div class="bg-amber-50 px-8 py-6 border-b border-amber-100">
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white border border-amber-200 shadow-sm flex-shrink-0">
                            @php $imgSrc = is_array($product->image) ? ($product->image[0] ?? 'default.jpg') : $product->image; @endphp
                            <img src="{{ asset('images/'.$imgSrc) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-amber-900 mb-1">{{ $product->name }}</h3>
                            <p class="text-sm font-semibold text-amber-700 mb-2">Order #{{ substr($order->id, 0, 8) }}</p>
                            <p class="text-xs text-amber-600/80">Bagaimana pengalaman Anda dengan produk ini?</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('reviews.store', [$order->id, $product->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-bold text-amber-900 mb-2">Penilaian Anda <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-2" x-data="{ rating: {{ old('rating', 5) }}, hoverRating: 0 }">
                                <template x-for="i in 5">
                                    <label class="cursor-pointer transition-transform hover:scale-110">
                                        <input type="radio" name="rating" :value="i" x-model="rating" class="sr-only" required>
                                        <svg class="w-10 h-10 transition-colors duration-200" 
                                             :class="(hoverRating >= i || (hoverRating === 0 && rating >= i)) ? 'text-amber-400' : 'text-amber-100'"
                                             @mouseenter="hoverRating = i" 
                                             @mouseleave="hoverRating = 0"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                </template>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('rating')" />
                        </div>

                        <!-- Comment -->
                        <div>
                            <label for="comment" class="block text-sm font-bold text-amber-900 mb-2">Tulis Ulasan <span class="text-red-500">*</span></label>
                            <textarea id="comment" name="comment" rows="4" 
                                      class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm bg-[#FDFBF7] text-amber-900 p-4" 
                                      placeholder="Ceritakan pengalaman Anda menggunakan produk ini..." required>{{ old('comment') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('comment')" />
                        </div>

                        <!-- Media Upload -->
                        <div x-data="{ 
                            files: [],
                            previews: [],
                            handleFiles(e) {
                                const selected = Array.from(e.target.files);
                                if (this.files.length + selected.length > 10) {
                                    alert('Maksimal 10 file yang dapat diunggah.');
                                    e.target.value = '';
                                    return;
                                }
                                
                                selected.forEach(file => {
                                    this.files.push(file);
                                    
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.previews.push({
                                            url: e.target.result,
                                            type: file.type,
                                            name: file.name
                                        });
                                    };
                                    reader.readAsDataURL(file);
                                });
                                
                                const dt = new DataTransfer();
                                this.files.forEach(f => dt.items.add(f));
                                this.$refs.mediaInput.files = dt.files;
                            },
                            removeFile(index) {
                                this.files.splice(index, 1);
                                this.previews.splice(index, 1);
                                
                                // Reset input file to allow re-selection if needed
                                const dt = new DataTransfer();
                                this.files.forEach(f => dt.items.add(f));
                                this.$refs.mediaInput.files = dt.files;
                            }
                        }">
                            <label class="block text-sm font-bold text-amber-900 mb-2">Tambahkan Foto/Video <span class="text-amber-600/70 font-normal">(Maks 10, Opsional)</span></label>
                            
                            <input type="file" name="media[]" id="media" multiple accept="image/jpeg,image/png,image/jpg,video/mp4,video/quicktime,video/x-msvideo" class="hidden" x-ref="mediaInput"
                                   @change="handleFiles" />
                                   
                            <div class="mt-2 space-y-4">
                                <div class="flex items-center gap-4">
                                    <button type="button" @click.prevent="$refs.mediaInput.click()" 
                                            class="inline-flex items-center px-4 py-2 bg-white border border-amber-300 rounded-xl font-bold text-xs text-amber-700 uppercase tracking-widest shadow-sm hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Pilih File
                                    </button>
                                    <p class="text-xs text-amber-600/60">Maks 10MB/file (JPEG, PNG, JPG, MP4, MOV, AVI)</p>
                                </div>
                                
                                <!-- Previews Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" x-show="previews.length > 0">
                                    <template x-for="(preview, index) in previews" :key="index">
                                        <div class="relative w-full aspect-square rounded-xl border border-amber-200 overflow-hidden shadow-sm group">
                                            <!-- Remove Button -->
                                            <button type="button" @click.prevent="removeFile(index)" 
                                                    class="absolute top-1 right-1 bg-red-500/90 text-white rounded-full p-1 z-10 hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            
                                            <!-- Preview Content -->
                                            <template x-if="preview.type.startsWith('image/')">
                                                <img :src="preview.url" class="w-full h-full object-cover">
                                            </template>
                                            
                                            <template x-if="preview.type.startsWith('video/')">
                                                <div class="w-full h-full bg-amber-900 flex flex-col items-center justify-center relative">
                                                    <svg class="w-8 h-8 text-white/70 absolute z-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                                    <video :src="preview.url" class="w-full h-full object-cover opacity-60"></video>
                                                </div>
                                            </template>
                                            
                                            <!-- File Name Overlay (for very long names) -->
                                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                                <p class="text-[10px] text-white truncate" x-text="preview.name"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('media')" />
                            <x-input-error class="mt-2" :messages="$errors->get('media.*')" />
                        </div>

                        <div class="pt-6 border-t border-amber-100 flex items-center justify-end gap-4">
                            <a href="{{ route('orders.index') }}" class="font-bold text-amber-700 hover:text-amber-900 transition-colors">Batal</a>
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
