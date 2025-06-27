<div x-show="showDetail"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
     x-transition:enter-end="opacity-50 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-50 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
     @click.self="showDetail = false" x-cloak>

    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col md:flex-row gap-6">

            <!-- Gambar -->
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800 mb-4" x-text="selectedProduct?.name"></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <template x-if="selectedProduct?.images?.length">
                        <template x-for="img in selectedProduct.images" :key="img.id">
                            <img :src="'/storage/' + img.image_path"
                                class="w-full h-64 sm:h-80 object-cover rounded-xl shadow-md transition-transform duration-300 hover:scale-105"
                                alt="Gambar">
                        </template>
                    </template>
                    <p x-show="!selectedProduct?.images?.length" class="text-gray-500 italic col-span-full text-center">Tidak ada gambar.</p>
                </div>
            </div>

            <!-- Detail -->
            <div class="flex-1 space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Deskripsi Produk</h3>
                <p class="text-gray-600 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                <div class="space-y-2 pt-4 border-t">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Kategori</span>
                        <span class="text-gray-700 font-medium" x-text="selectedProduct?.category?.category_name ?? '-'"></span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Harga</span>
                        <span class="text-gray-700 font-medium">Rp <span x-text="Number(selectedProduct?.price).toLocaleString()"></span></span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Status</span>
                        <span class="text-gray-700 font-medium capitalize" x-text="selectedProduct?.status"></span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>No. Telepon</span>
                        <span class="text-gray-700 font-medium" x-text="selectedProduct?.phone ?? '-'"></span>
                    </div>
                </div>

                <div class="pt-6 text-right border-t">
                    <button class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg transition"
                        @click="showDetail = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
