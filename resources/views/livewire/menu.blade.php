<div class="bg-amber-50">
    <section id="full-menu" class="py-16 md:py-24">
        <div class="container mx-auto px-6">
            <!-- Tiêu đề -->
            <div class="text-center mb-12 animate-fade-in">
                <h2 class="text-4xl md:text-5xl font-bold text-amber-800 mb-4"
                    style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    Đồ uống Của Chúng Tôi
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                    Khám phá hương vị đa dạng từ những hạt cà phê tuyển chọn đến các loại trà và nước giải khát đặc biệt,
                    được pha chế với tất cả tâm huyết.
                </p>
            </div>

            <div class="flex justify-center flex-wrap gap-3 md:gap-4 mb-12 animate-fade-in" style="animation-delay: 0.2s;">
                <button
                    class="px-5 py-2 text-sm font-semibold rounded-full transition-all duration-300 bg-amber-600 text-white shadow-md">
                    Tất Cả
                </button>
                <button
                    class="px-5 py-2 text-sm font-semibold rounded-full transition-all duration-300 bg-white hover:bg-amber-100 text-gray-700 shadow-sm">
                    Cà Phê
                </button>
                <button
                    class="px-5 py-2 text-sm font-semibold rounded-full transition-all duration-300 bg-white hover:bg-amber-100 text-gray-700 shadow-sm">
                    Trà & Trà Sữa
                </button>
                <button
                    class="px-5 py-2 text-sm font-semibold rounded-full transition-all duration-300 bg-white hover:bg-amber-100 text-gray-700 shadow-sm">
                    Đá Xay
                </button>
                <button
                    class="px-5 py-2 text-sm font-semibold rounded-full transition-all duration-300 bg-white hover:bg-amber-100 text-gray-700 shadow-sm">
                    Nước Ép
                </button>
            </div>

            <!-- Lưới hiển thị các món -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                {{-- Lấy ví dụ từ trang chủ --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 animate-fade-in"
                    style="animation-delay: 0.3s;">
                    <img src="https://images.unsplash.com/photo-1517487881594-2787fef5ebf7?q=80&w=2035&auto=format&fit=crop"
                        alt="Bạc Xỉu" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Bạc Xỉu</h4>
                        <p class="text-gray-600 mt-2 h-12">Ngọt ngào, nhẹ nhàng, phù hợp cho một buổi chiều thư giãn.</p>
                        <p class="text-amber-600 font-bold text-lg mt-3">32.000đ</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 animate-fade-in"
                    style="animation-delay: 0.4s;">
                    <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=2087&auto=format&fit=crop"
                        alt="Cà Phê Đen" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Cà Phê Đen</h4>
                        <p class="text-gray-600 mt-2 h-12">Đắng đậm đà, cho người sành điệu yêu cà phê thuần khiết.</p>
                        <p class="text-amber-600 font-bold text-lg mt-3">30.000đ</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 animate-fade-in"
                    style="animation-delay: 0.5s;">
                    <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?q=80&w=2062&auto=format&fit=crop"
                        alt="Cappuccino" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Cappuccino</h4>
                        <p class="text-gray-600 mt-2 h-12">Sự kết hợp hoàn hảo giữa espresso và sữa tươi mịn màng.</p>
                        <p class="text-amber-600 font-bold text-lg mt-3">45.000đ</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 animate-fade-in"
                    style="animation-delay: 0.6s;">
                    <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=2064&auto=format&fit=crop"
                        alt="Trà Vải Cam Sả" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Trà Vải Cam Sả</h4>
                        <p class="text-gray-600 mt-2 h-12">Sự kết hợp thanh mát, giải nhiệt cho ngày hè oi ả.</p>
                        <p class="text-amber-600 font-bold text-lg mt-3">40.000đ</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 animate-fade-in"
                    style="animation-delay: 0.7s;">
                    <img src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=2141&auto=format&fit=crop"
                        alt="Trà Đào" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Trà Đào</h4>
                        <p class="text-gray-600 mt-2 h-12">Vị đào ngọt thanh kết hợp cùng trà xanh mát lạnh.</p>
                        <p class="text-amber-600 font-bold text-lg mt-3">42.000đ</p>
                    </div>
                </div>

                {{-- Bạn có thể thêm nhiều món ăn khác vào đây bằng cách lặp lại cấu trúc trên --}}

            </div>
        </div>
    </section>
</div>