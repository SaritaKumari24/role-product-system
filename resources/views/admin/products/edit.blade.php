@extends('layouts.admin')

@section('title', 'Edit Product')
@section('header_title', 'Edit Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('admin.products.index') }}" class="hover:text-white transition">Products</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-200 truncate max-w-[200px]">Edit: {{ $product->name }}</span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">Edit Product: <span class="text-brand-400">{{ $product->name }}</span></h2>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs font-semibold text-brand-400 hover:text-brand-300 transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>View in Store</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs font-semibold text-slate-300 hover:text-white transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Inventory</span>
            </a>
        </div>
    </div>

    <!-- Product Edit Form -->
    <div class="admin-card rounded-3xl p-6 sm:p-8">
        <form id="productEditForm" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Hidden base64 cropped image payload from Cropper.js -->
            <input type="hidden" name="cropped_image" id="cropped_image">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">Product Title / Name <span class="text-rose-400">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm placeholder-slate-500 outline-none">
                </div>

                <!-- Category Selector -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-300 mb-1.5">Product Category <span class="text-rose-400">*</span></label>
                    <div class="relative">
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm outline-none appearance-none">
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <!-- Price Input -->
                <div>
                    <label for="price" class="block text-xs font-semibold text-slate-300 mb-1.5">Price ($ USD) <span class="text-rose-400">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold">$</span>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" required
                               class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm placeholder-slate-500 outline-none">
                    </div>
                </div>

                <!-- Status Selector -->
                <div class="md:col-span-2">
                    <label for="status" class="block text-xs font-semibold text-slate-300 mb-1.5">Publishing Status <span class="text-rose-400">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-xl bg-slate-900 border border-slate-700/80 cursor-pointer hover:border-brand-500 transition">
                            <input type="radio" name="status" value="active" {{ old('status', $product->status) === 'active' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                            <div>
                                <span class="block text-xs font-bold text-white">Active</span>
                                <span class="text-[11px] text-slate-400">Immediately visible to customers</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl bg-slate-900 border border-slate-700/80 cursor-pointer hover:border-brand-500 transition">
                            <input type="radio" name="status" value="inactive" {{ old('status', $product->status) === 'inactive' ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500">
                            <div>
                                <span class="block text-xs font-bold text-white">Draft / Inactive</span>
                                <span class="text-[11px] text-slate-400">Hidden from storefront</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-semibold text-slate-300 mb-1.5">Product Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 focus:border-brand-500 text-white text-sm placeholder-slate-500 outline-none resize-none">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Image Section with Cropper.js -->
                <div class="md:col-span-2 border-t border-slate-800 pt-6">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <label class="block text-xs font-semibold text-white flex items-center gap-1.5">
                                <i class="fa-solid fa-crop-simple text-brand-400"></i> Product Image & Cropper.js
                            </label>
                            <p class="text-[11px] text-slate-400">Change image and crop before saving.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                        <!-- Dropzone / Picker -->
                        <div class="border-2 border-dashed border-slate-700 hover:border-brand-500/80 rounded-2xl p-6 text-center transition cursor-pointer bg-slate-900/50" onclick="document.getElementById('imageFileInput').click()">
                            <input type="file" id="imageFileInput" accept="image/jpeg,image/png,image/webp,image/jpg" class="hidden">
                            <div class="w-12 h-12 rounded-2xl bg-brand-500/10 border border-brand-500/20 text-brand-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p class="text-xs font-bold text-white">Upload / Replace Image</p>
                            <p class="text-[10px] text-slate-400 mt-1">Click to select new image to crop</p>
                            <span class="inline-block mt-3 px-3 py-1 rounded-lg text-[10px] font-semibold bg-brand-500/10 text-brand-300 border border-brand-500/20">
                                <i class="fa-solid fa-scissors mr-1"></i> Interactive Cropper
                            </span>
                        </div>

                        <!-- Current Image / Cropped Preview Box -->
                        <div id="previewContainer" class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col items-center justify-center min-h-[160px] text-center">
                            <div id="currentImageWrapper" class="flex flex-col items-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Current Active Image</p>
                                <img id="activeProductImg" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 h-32 rounded-2xl object-cover border border-slate-700 shadow-md">
                            </div>

                            <div id="croppedResultWrapper" class="hidden w-full flex flex-col items-center">
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-2 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Newly Cropped Preview
                                </p>
                                <img id="croppedPreviewImg" src="" alt="Cropped Preview" class="w-32 h-32 rounded-2xl object-cover border-2 border-brand-500/50 shadow-lg shadow-brand-500/20">
                                <div class="mt-3 flex items-center gap-2">
                                    <button type="button" onclick="openCropperAgain()" class="px-3 py-1 rounded-lg text-[11px] font-semibold bg-brand-500/20 text-brand-300 hover:bg-brand-500/30 transition">
                                        <i class="fa-solid fa-crop-simple mr-1"></i> Re-crop
                                    </button>
                                    <button type="button" onclick="removeCroppedImage()" class="px-3 py-1 rounded-lg text-[11px] font-semibold bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 transition">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Discard
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="border-t border-slate-800 pt-6 flex items-center justify-between">
                <div>
                    @role('admin')
                        <button type="button" onclick="if(confirm('Delete this product permanently?')) document.getElementById('deleteProductForm').submit();" class="px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 border border-rose-500/30 text-xs font-semibold transition flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Delete Product</span>
                        </button>
                    @endrole
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-check"></i>
                        <span>Update Product</span>
                    </button>
                </div>
            </div>
        </form>

        @role('admin')
            <form id="deleteProductForm" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endrole
    </div>
</div>

<!-- ============================================================== -->
<!-- CROPPER.JS INTERACTIVE MODAL                                    -->
<!-- ============================================================== -->
<div id="cropperModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-400 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-scissors"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Crop Product Image</h3>
                    <p class="text-[11px] text-slate-400">Position and frame the image to your desired aspect ratio</p>
                </div>
            </div>
            <button type="button" onclick="closeCropperModal()" class="text-slate-400 hover:text-white transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Cropper Image Viewport -->
        <div class="p-6 overflow-hidden flex items-center justify-center bg-slate-950/60 max-h-[420px]">
            <div class="w-full max-h-[380px] flex items-center justify-center">
                <img id="cropperImageElement" src="" alt="To Crop" class="max-w-full max-h-[360px] block">
            </div>
        </div>

        <!-- Toolbar & Aspect Ratios -->
        <div class="px-6 py-3 bg-slate-900 border-t border-slate-800 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-1.5">
                <span class="text-[11px] font-bold text-slate-400 mr-1">Aspect:</span>
                <button type="button" onclick="setAspectRatio(1)" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-brand-600 text-white aspect-btn active" data-ratio="1">
                    1:1 Square
                </button>
                <button type="button" onclick="setAspectRatio(4/3)" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 aspect-btn" data-ratio="1.33">
                    4:3
                </button>
                <button type="button" onclick="setAspectRatio(16/9)" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 aspect-btn" data-ratio="1.77">
                    16:9
                </button>
                <button type="button" onclick="setAspectRatio(NaN)" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 aspect-btn" data-ratio="free">
                    Free
                </button>
            </div>

            <div class="flex items-center gap-1.5">
                <button type="button" onclick="zoomCropper(0.1)" title="Zoom In" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
                <button type="button" onclick="zoomCropper(-0.1)" title="Zoom Out" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                    <i class="fa-solid fa-magnifying-glass-minus"></i>
                </button>
                <button type="button" onclick="rotateCropper(-90)" title="Rotate Left" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button type="button" onclick="rotateCropper(90)" title="Rotate Right" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button type="button" onclick="resetCropper()" title="Reset" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="px-6 py-4 border-t border-slate-800 flex items-center justify-end gap-3 bg-slate-900/80">
            <button type="button" onclick="closeCropperModal()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition">
                Cancel
            </button>
            <button type="button" onclick="applyCrop()" class="px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold shadow-lg shadow-brand-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-check"></i>
                <span>Crop & Apply Image</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cropperInstance = null;
    let originalRawImage = null;

    const imageFileInput = document.getElementById('imageFileInput');
    const cropperModal = document.getElementById('cropperModal');
    const cropperImageElement = document.getElementById('cropperImageElement');
    const croppedImageInput = document.getElementById('cropped_image');
    const currentImageWrapper = document.getElementById('currentImageWrapper');
    const croppedResultWrapper = document.getElementById('croppedResultWrapper');
    const croppedPreviewImg = document.getElementById('croppedPreviewImg');

    imageFileInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function (event) {
                originalRawImage = event.target.result;
                openCropperWithImage(originalRawImage);
            };
            reader.readAsDataURL(file);
        }
    });

    function openCropperWithImage(src) {
        cropperImageElement.src = src;
        cropperModal.classList.remove('hidden');

        if (cropperInstance) {
            cropperInstance.destroy();
        }

        setTimeout(() => {
            cropperInstance = new Cropper(cropperImageElement, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        }, 150);
    }

    function openCropperAgain() {
        if (originalRawImage) {
            openCropperWithImage(originalRawImage);
        }
    }

    function closeCropperModal() {
        cropperModal.classList.add('hidden');
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    }

    function setAspectRatio(ratio) {
        if (cropperInstance) {
            cropperInstance.setAspectRatio(ratio);
            document.querySelectorAll('.aspect-btn').forEach(btn => {
                btn.classList.remove('bg-brand-600', 'text-white');
                btn.classList.add('bg-slate-800', 'text-slate-300');
            });
            event.target.classList.add('bg-brand-600', 'text-white');
            event.target.classList.remove('bg-slate-800', 'text-slate-300');
        }
    }

    function zoomCropper(delta) {
        if (cropperInstance) cropperInstance.zoom(delta);
    }

    function rotateCropper(degree) {
        if (cropperInstance) cropperInstance.rotate(degree);
    }

    function resetCropper() {
        if (cropperInstance) cropperInstance.reset();
    }

    function applyCrop() {
        if (!cropperInstance) return;

        const canvas = cropperInstance.getCroppedCanvas({
            width: 800,
            height: 800,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.92);

        croppedImageInput.value = croppedDataUrl;
        croppedPreviewImg.src = croppedDataUrl;

        currentImageWrapper.classList.add('hidden');
        croppedResultWrapper.classList.remove('hidden');

        closeCropperModal();
    }

    function removeCroppedImage() {
        croppedImageInput.value = '';
        imageFileInput.value = '';
        originalRawImage = null;
        croppedResultWrapper.classList.add('hidden');
        currentImageWrapper.classList.remove('hidden');
    }
</script>
@endpush
@endsection
