@extends('layouts.main')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Create New Product</h2>
            <p class="text-amber-700/80 mt-2 font-medium">Add a new item to your storefront catalog.</p>
        </div>
        <a href="{{ route('products.index') }}" class="bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="p-5 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm mb-8 flex items-start">
            <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="font-bold mb-1">Please fix the following errors:</h3>
                <ul class="list-disc list-inside text-sm font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 xl:grid-cols-3 gap-8" x-data="productForm()">
        @csrf

        <!-- Left Column: Product Details -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- Basic Info Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-full -z-10 opacity-50"></div>
                <h3 class="text-xl font-black text-amber-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    General Information
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-amber-900 mb-2">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-amber-900 p-3" required placeholder="e.g. Premium Chocolate Cake">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-amber-900 mb-2">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="6" class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-amber-900 p-3" required placeholder="Detailed description of the product...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                <h3 class="text-xl font-black text-amber-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pricing & Inventory
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-amber-900 mb-2">Price (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-amber-500 font-bold">Rp</span>
                            </div>
                            <input type="hidden" name="price" :value="rawPrice">
                            <input type="text" x-model="formattedPrice" @input="updatePrice" class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-amber-900 pl-12 p-3 font-bold text-lg" required placeholder="1.000.000">
                        </div>
                        <p class="text-xs text-amber-600 mt-2">Format is applied automatically.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-amber-900 mb-2">Stock <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="stock" value="{{ old('stock') }}" min="1" class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm text-amber-900 p-3 font-bold text-lg" required placeholder="50">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Media & Actions -->
        <div class="space-y-8 xl:sticky xl:top-8 h-fit">
            <!-- Media Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 flex flex-col">
            <h3 class="text-xl font-black text-amber-900 mb-4 border-b border-amber-100 pb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Product Media
            </h3>
            
            <div class="bg-amber-50 rounded-2xl p-5 mb-6 border border-amber-100">
                <p class="text-sm text-amber-800 font-medium">
                    Upload up to 5 images. The first image will be the <strong class="text-amber-900">Cover</strong>. You can upload them one by one or select multiple at once!
                </p>
            </div>
            
            <!-- Real hidden file input -->
            <input type="file" name="images[]" multiple id="image-upload" x-ref="fileInput" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="handleFileSelect">

            
            <!-- Upload Box -->
            <div class="w-full border-2 border-dashed border-amber-300 rounded-2xl p-8 text-center hover:bg-amber-50 transition-colors cursor-pointer group mb-6" @click="$refs.fileInput.click()">
                <div class="text-amber-500 group-hover:text-amber-700 transition-colors transform group-hover:scale-105 duration-200">
                    <svg class="mx-auto h-16 w-16 mb-4 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="font-black text-lg mb-1">Click to add photos</p>
                    <p class="text-sm opacity-75 font-medium">PNG, JPG, JPEG up to 2MB</p>
                </div>
            </div>

            <!-- Preview Grid -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-amber-900" x-text="`Selected Photos (${files.length}/5)`"></h4>
                    <span class="text-xs font-bold text-red-500" x-show="files.length === 0">Required</span>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="relative aspect-square rounded-xl overflow-hidden border-2 border-amber-200 shadow-sm group">
                            <img :src="file.preview" class="w-full h-full object-cover">
                            
                            <template x-if="index === 0">
                                <span class="absolute top-2 left-2 bg-amber-600 text-white text-xs font-black px-2.5 py-1 rounded shadow-md z-10">Cover</span>
                            </template>
                            
                            <!-- Remove Button -->
                            <button type="button" @click.stop="removeFile(index)" class="absolute inset-0 bg-red-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm">
                                <span class="bg-red-600 text-white rounded-full p-2 transform hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </span>
                            </button>
                        </div>
                    </template>
                    
                    <!-- Empty state placeholder -->
                    <template x-if="files.length === 0">
                        <div class="col-span-2 py-8 text-center text-amber-700/50 italic text-sm border border-dashed border-amber-200 rounded-xl bg-amber-50/50">
                            No photos added yet
                        </div>
                    </template>
                </div>
                </div>
            </div>

            <!-- Publish Action Card -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                <h3 class="text-xl font-black text-amber-900 mb-4 border-b border-amber-100 pb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Publish
                </h3>
                <p class="text-sm text-amber-700/80 font-medium mb-6">
                    Double-check your product details before publishing it to your storefront.
                </p>
                <button type="submit" class="bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-black text-lg w-full py-4 rounded-xl shadow-md transform transition hover:-translate-y-1 flex justify-center items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Publish Product
                </button>
            </div>
        </div>
    </form>

    <script>
        function productForm() {
            return {
                rawPrice: '{{ old("price", "") }}',
                formattedPrice: '{{ old("price") ? number_format(old("price"), 0, "", ".") : "" }}',
                files: [],

                updatePrice(e) {
                    // Remove non-digit characters
                    let val = e.target.value.replace(/\D/g, '');
                    this.rawPrice = val;
                    
                    // Format with dots every 3 digits
                    if (val) {
                        this.formattedPrice = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    } else {
                        this.formattedPrice = '';
                    }
                },
                
                handleFileSelect(e) {
                    let selectedFiles = Array.from(e.target.files);
                    if (this.files.length + selectedFiles.length > 5) {
                        alert('You can only upload a maximum of 5 images in total.');
                        return;
                    }
                    
                    selectedFiles.forEach(file => {
                        // Validate file type
                        if (!file.type.match('image.*')) return;
                        
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.files.push({
                                file: file,
                                preview: e.target.result
                            });
                            this.updateFileInput();
                        };
                        reader.readAsDataURL(file);
                    });
                    
                    // Reset the actual input so selecting the same file again works
                    e.target.value = '';
                },
                
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateFileInput();
                },
                
                updateFileInput() {
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(f => {
                        dataTransfer.items.add(f.file);
                    });
                    this.$refs.fileInput.files = dataTransfer.files;
                }
            }
        }
    </script>
@endsection