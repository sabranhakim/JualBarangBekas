<div x-show="showDetail" x-transition @click.self="showDetail = false"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4" x-cloak>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col md:flex-row gap-6" x-data="{ slideIndex: 0 }" x-init="slideIndex = 0">

            <!-- Gambar -->
            <div class="flex-1">
                <h2 class="text-xl font-bold mb-4" x-text="selectedProduct?.name"></h2>

                <template x-if="selectedProduct?.images?.length">
                    <div class="relative">
                        <!-- Gambar Utama -->
                        <div class="h-96 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                            <template x-for="(img, index) in selectedProduct.images" :key="img.id">
                                <img
                                    x-show="index === slideIndex"
                                    :src="'/storage/' + img.image_path"
                                    class="object-contain h-full mx-auto transition-all duration-300" alt="">
                            </template>
                        </div>

                        <!-- Tombol Sebelumnya -->
                        <button @click="slideIndex = (slideIndex - 1 + selectedProduct.images.length) % selectedProduct.images.length"
                            class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow">
                            ‹
                        </button>
                        <!-- Tombol Berikutnya -->
                        <button @click="slideIndex = (slideIndex + 1) % selectedProduct.images.length"
                            class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow">
                            ›
                        </button>
                    </div>
                </template>

                <p x-show="!selectedProduct?.images?.length" class="text-gray-500 italic mt-4 text-center">Tidak ada gambar.</p>
            </div>

            <!-- Detail -->
            <div class="flex-1 bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-200">Deskripsi Produk</h3>

                <p class="text-gray-700 mb-6 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                <div class="space-y-2">
                    <p>
                        <span class="font-semibold text-indigo-600">Kategori:</span>
                        <span x-text="selectedProduct?.category?.category_name ?? '-'"></span>
                    </p>
                    <p>
                        <span class="font-semibold text-indigo-600">Harga:</span>
                        Rp <span x-text="Number(selectedProduct?.price).toLocaleString()"></span>
                    </p>
                    <p>
                        <span class="font-semibold text-indigo-600">Status:</span>
                        <span x-text="selectedProduct?.status"></span>
                    </p>
                    <p>
                        <span class="font-semibold text-indigo-600">Kontak:</span>
                        <span x-text="selectedProduct?.phone ?? '-'"></span>
                    </p>
                </div>

                <div class="mt-8 text-right">
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition duration-200"
                        @click="showDetail = false">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
