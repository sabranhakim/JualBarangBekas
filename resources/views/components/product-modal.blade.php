<div x-show="showDetail"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    x-transition @click.self="showDetail = false" x-cloak>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Gambar -->
            <div class="flex-1">
                <h2 class="text-xl font-bold mb-2" x-text="selectedProduct?.name"></h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <template x-if="selectedProduct?.images?.length">
                        <template x-for="img in selectedProduct.images" :key="img.id">
                            <img :src="'/storage/' + img.image_path"
                                class="w-full h-40 object-cover rounded shadow" alt="Gambar">
                        </template>
                    </template>
                    <p x-show="!selectedProduct?.images?.length"
                        class="text-gray-500 italic col-span-full">Tidak ada gambar.</p>
                </div>
            </div>

            <!-- Detail -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Deskripsi Produk</h3>
                <p class="text-gray-700 mb-4 whitespace-pre-line" x-text="selectedProduct?.description"></p>

                <p><span class="font-semibold">Kategori:</span> <span
                        x-text="selectedProduct?.category?.category_name ?? '-'"></span></p>
                <p><span class="font-semibold">Harga:</span> Rp <span
                        x-text="Number(selectedProduct?.price).toLocaleString()"></span></p>
                <p><span class="font-semibold">Status:</span> <span
                        x-text="selectedProduct?.status"></span></p>
                <p><span class="font-semibold">Kontak:</span> <span 
                    x-text="selectedProduct?.phone ?? '-'"></span></p>


                <div class="mt-6 text-right">
                    <button class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded"
                        @click="showDetail = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
