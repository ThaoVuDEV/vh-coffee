<div class="bg-amber-50">
    <!-- Hero Section -->

    <section id="home" class="relative h-[60vh] md:h-[80vh] overflow-hidden">
        <!-- Slideshow Container -->
        <div class="slideshow-container absolute inset-0">


            <!-- Slide 2 -->
            <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000"
                style="background-image: url('https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=2078&auto=format&fit=crop');">
            </div>

            <!-- Slide 3 -->
            <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000"
                style="background-image: url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2047&auto=format&fit=crop');">
            </div>

            <!-- Slide 4 -->
            <div class="slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000"
                style="background-image: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=2070&auto=format&fit=crop');">
            </div>
        </div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50 z-10"></div>

        <!-- Content -->
        <div class="relative z-20 flex flex-col items-center justify-center h-full text-white text-center px-4">
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight animate-fade-in"
                style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                Không Gian Cà Phê Đậm Chất Riêng
            </h2>
            <p class="mt-4 text-lg md:text-2xl max-w-2xl animate-fade-in"
                style="animation-delay: 0.3s; text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                Nơi mỗi tách cà phê là một câu chuyện và mỗi góc quán là một kỷ niệm.
            </p>
            <a href="menu"
                class="mt-8 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 animate-fade-in"
                style="animation-delay: 0.6s;">
                Đặt Món Ngay
            </a>
        </div>

        <!-- Navigation Arrows -->
        <button onclick="changeSlide(-1)"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-black/50 hover:bg-amber-600/80 text-white p-3 rounded-full transition-all duration-300 border-2 border-white/50 hover:border-amber-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button onclick="changeSlide(1)"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-black/50 hover:bg-amber-600/80 text-white p-3 rounded-full transition-all duration-300 border-2 border-white/50 hover:border-amber-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Slide Indicators -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            <div onclick="goToSlide(0)"
                class="indicator w-3 h-3 rounded-full bg-amber-600 cursor-pointer transition-all duration-300 hover:scale-110">
            </div>
            <div onclick="goToSlide(1)"
                class="indicator w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-all duration-300 hover:scale-110">
            </div>
            <div onclick="goToSlide(2)"
                class="indicator w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-all duration-300 hover:scale-110">
            </div>
        </div>
    </section>

    <section id="menu" class="py-16 md:py-24 bg-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <h3 class="text-3xl font-bold text-amber-800 mb-2">Thực Đơn Nổi Bật</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">Những món được yêu thích nhất tại Coffee Góc Ảnh,
                    được pha chế từ tâm huyết của chúng tôi.</p>
            </div>

            <!-- Carousel Container -->
            <div class="relative" data-aos="fade-up" data-aos-delay="200">
                <!-- Navigation Buttons -->
                <button onclick="scrollMenu(-1)"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-amber-600 text-amber-600 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 -ml-4 hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <button onclick="scrollMenu(1)"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white hover:bg-amber-600 text-amber-600 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 -mr-4 hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Menu Carousel -->
                <div id="menuCarousel" class="flex overflow-x-auto gap-6 pb-4 scroll-smooth snap-x snap-mandatory"
                    style="scrollbar-width: none; -ms-overflow-style: none;">


                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1517487881594-2787fef5ebf7?q=80&w=2035&auto=format&fit=crop"
                            alt="Bạc Xỉu" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Bạc Xỉu</h4>
                            <p class="text-gray-600 mt-2">Ngọt ngào, nhẹ nhàng, phù hợp cho một buổi chiều thư giãn.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">32.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=2087&auto=format&fit=crop"
                            alt="Cà Phê Đen" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Cà Phê Đen</h4>
                            <p class="text-gray-600 mt-2">Đắng đậm đà, cho người sành điệu yêu cà phê thuần khiết.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">30.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?q=80&w=2062&auto=format&fit=crop"
                            alt="Cappuccino" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Cappuccino</h4>
                            <p class="text-gray-600 mt-2">Sự kết hợp hoàn hảo giữa espresso và sữa tươi mịn màng.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">45.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1561882468-9110e03e0f78?q=80&w=2074&auto=format&fit=crop"
                            alt="Latte" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Latte</h4>
                            <p class="text-gray-600 mt-2">Hương vị cà phê nhẹ nhàng hòa quyện cùng sữa tươi béo ngậy.
                            </p>
                            <p class="text-amber-600 font-bold text-lg mt-3">48.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=2064&auto=format&fit=crop"
                            alt="Trà Vải Cam Sả" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Trà Vải Cam Sả</h4>
                            <p class="text-gray-600 mt-2">Sự kết hợp thanh mát, giải nhiệt cho ngày hè oi ả.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">40.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=2141&auto=format&fit=crop"
                            alt="Trà Đào" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Trà Đào</h4>
                            <p class="text-gray-600 mt-2">Vị đào ngọt thanh kết hợp cùng trà xanh mát lạnh.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">42.000đ</p>
                        </div>
                    </div>

                    <div
                        class="flex-none w-80 snap-center bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1515823064-d6e0c04616a7?q=80&w=2071&auto=format&fit=crop"
                            alt="Matcha Latte" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800">Matcha Latte</h4>
                            <p class="text-gray-600 mt-2">Trà xanh Nhật Bản thơm ngon, pha cùng sữa tươi béo ngậy.</p>
                            <p class="text-amber-600 font-bold text-lg mt-3">50.000đ</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center" data-aos="fade-up">
                <a href="/menu"
                    class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-10 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span>Xem Tất Cả Món</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- About Us Section -->
    <section id="about" class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <h3 class="text-3xl font-bold text-amber-800 mb-4">Về Coffee Góc Ảnh</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Tại Coffee Góc Ảnh, chúng tôi tin rằng cà phê không chỉ là một thức uống, mà là một nghệ
                        thuật, một trải nghiệm. Chúng tôi tự hào mang đến những hạt cà phê chất lượng nhất, được
                        rang xay tỉ mỉ để giữ trọn hương vị nguyên bản.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Không gian của Coffee Góc Ảnh được thiết kế ấm cúng và đầy cảm hứng, là nơi lý tưởng để bạn
                        gặp gỡ bạn bè, làm việc, hay đơn giản là tìm một góc yên tĩnh cho riêng mình.
                    </p>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1559496417-e7f25cb247f3?q=80&w=1974&auto=format&fit=crop"
                        alt="Không gian quán Coffee Góc Ảnh" class="rounded-2xl shadow-xl w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>
    <section id="gallery" class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <div data-aos="fade-up">
                <h3 class="text-3xl font-bold text-amber-800 mb-2">Góc Ảnh Quán</h3>
                <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Lưu giữ những khoảnh khắc đẹp tại
                    Coffee Góc Ảnh. Mỗi góc nhỏ đều có thể trở thành background "sống ảo" của bạn.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Cột 1 -->
                <div class="grid gap-4" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?q=80&w=2071&auto=format&fit=crop"
                            alt="Góc quán vintage">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=2078&auto=format&fit=crop"
                            alt="Không gian quán cafe ấm cúng">
                    </div>
                </div>

                <!-- Cột 2 -->
                <div class="grid gap-4" data-aos="fade-up" data-aos-delay="200">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1521017432531-fbd92d768814?q=80&w=2070&auto=format&fit=crop"
                            alt="Góc cafe view đẹp">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1521017432531-fbd92d768814?q=80&w=2070&auto=format&fit=crop"
                            alt="Góc cafe view đẹp">
                    </div>
                </div>

                <!-- Cột 3 -->
                <div class="grid gap-4" data-aos="fade-up" data-aos-delay="300">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=2047&auto=format&fit=crop"
                            alt="Không gian cafe hiện đại">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1453614512568-c4024d13c247?q=80&w=2232&auto=format&fit=crop"
                            alt="Góc ngồi sân vườn">
                    </div>
                </div>

                <!-- Cột 4 -->
                <div class="grid gap-4" data-aos="fade-up" data-aos-delay="400">
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1493857671505-72967e2e2760?q=80&w=2070&auto=format&fit=crop"
                            alt="Bàn ghế cafe phong cách">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg shadow-md transition-transform hover:scale-105"
                            src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?q=80&w=2070&auto=format&fit=crop"
                            alt="Góc thư giãn cafe">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kyniem" class="py-16 md:py-24 bg-amber-50 overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <div data-aos="fade-up">
                <h3 class="text-3xl font-bold text-amber-800 mb-2">Khoảnh Khắc Kỷ Niệm</h3>
                <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Những tấm ảnh kỷ niệm được khách hàng ghi lại tại Coffee Góc Ảnh, giống như được ghim trên tường.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Customer Photo 1 -->
                <div class="bg-white p-3 pb-4 rounded-lg shadow-lg transform -rotate-3 transition-transform hover:scale-105 hover:rotate-0" data-aos="fade-up" data-aos-delay="100">
                    <img class="h-auto max-w-full rounded-md" src="https://images.unsplash.com/photo-1528740561666-dc2479703592?q=80&w=1974&auto=format&fit=crop" alt="Ảnh kỷ niệm của khách hàng">
                    <p class="text-sm text-gray-500 mt-3 italic">"Cà phê ngon, view đẹp!" - An</p>
                </div>

                <!-- Customer Photo 2 -->
                <div class="bg-white p-3 pb-4 rounded-lg shadow-lg transform rotate-2 transition-transform hover:scale-105 hover:rotate-0" data-aos="fade-up" data-aos-delay="200">
                    <img class="h-auto max-w-full rounded-md" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=1974&auto=format&fit=crop" alt="Ảnh kỷ niệm của khách hàng">
                    <p class="text-sm text-gray-500 mt-3 italic">"Quán ruột của mình." - Bình</p>
                </div>

                <!-- Customer Photo 3 -->
                <div class="bg-white p-3 pb-4 rounded-lg shadow-lg transform rotate-1 transition-transform hover:scale-105 hover:rotate-0 sm:hidden md:block" data-aos="fade-up" data-aos-delay="300">
                    <img class="h-auto max-w-full rounded-md" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1964&auto=format&fit=crop" alt="Ảnh kỷ niệm của khách hàng">
                    <p class="text-sm text-gray-500 mt-3 italic">"Sẽ quay lại nhiều lần nữa." - Châu</p>
                </div>

                <!-- Customer Photo 4 -->
                <div class="bg-white p-3 pb-4 rounded-lg shadow-lg transform -rotate-2 transition-transform hover:scale-105 hover:rotate-0 sm:hidden lg:block" data-aos="fade-up" data-aos-delay="400">
                    <img class="h-auto max-w-full rounded-md" src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=1964&auto=format&fit=crop" alt="Ảnh kỷ niệm của khách hàng">
                    <p class="text-sm text-gray-500 mt-3 italic">"Nhân viên thân thiện." - Dũng</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-16 md:py-24 bg-amber-800 text-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <h3 class="text-3xl font-bold mb-4">Ghé Thăm Chúng Tôi</h3>
                    <p class="text-amber-200 mb-2"><strong class="font-semibold text-white">Địa
                            chỉ:</strong> TTTM Hòn Đất, TT. Hòn Đất, An Giang</p>
                    <p class="text-amber-200 mb-2"><strong class="font-semibold text-white">Điện
                            thoại:</strong> <a href="tel:0796815252" class="hover:underline">0796 815 252</a> - <a href="tel:0938431415" class="hover:underline">0938 431 415</a></p>
                    <p class="text-amber-200"><strong class="font-semibold text-white">Giờ mở
                            cửa:</strong> 7:00 - 22:00 mỗi ngày</p>
                    <!-- Facebook Fanpage -->
                    <div class="mt-6">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
                            nonce="XYZ123"></script>
                        <div class="fb-page " data-href="https://www.facebook.com/profile.php?id=61577963981041"
                            data-tabs="timeline" data-width="500" data-height="450" data-small-header="false"
                            data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/profile.php?id=61577963981041"
                                class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/profile.php?id=61577963981041">Fanpage</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d347.0947760980335!2d104.92268006447745!3d10.186411799154156!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a757002c845de1%3A0xfcf65e08d6090d2!2zQ29mZmVlIEfDs2Mg4bqjbmg!5e0!3m2!1svi!2s!4v1760452886638!5m2!1svi!2s"
                        height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="w-full rounded-lg shadow-xl"></iframe>
                </div>
            </div>
        </div>
    </section>

</div>
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    let autoSlideInterval;

    function showSlide(index) {
        // Reset all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
        });

        // Reset all indicators
        indicators.forEach(indicator => {
            indicator.classList.remove('bg-amber-600');
            indicator.classList.add('bg-white/50');
        });

        // Show current slide
        slides[index].classList.add('active');
        slides[index].style.opacity = '1';

        // Highlight current indicator
        indicators[index].classList.remove('bg-white/50');
        indicators[index].classList.add('bg-amber-600');
    }

    function changeSlide(direction) {
        currentSlide += direction;

        if (currentSlide < 0) {
            currentSlide = slides.length - 1;
        } else if (currentSlide >= slides.length) {
            currentSlide = 0;
        }

        showSlide(currentSlide);
        resetAutoSlide();
    }

    function goToSlide(index) {
        currentSlide = index;
        showSlide(currentSlide);
        resetAutoSlide();
    }

    function autoSlide() {
        currentSlide++;
        if (currentSlide >= slides.length) {
            currentSlide = 0;
        }
        showSlide(currentSlide);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(autoSlide, 5000);
    }

    // Start auto slide
    autoSlideInterval = setInterval(autoSlide, 5000);

    // Initialize first slide
    showSlide(0);

    function scrollMenu(direction) {
        const carousel = document.getElementById('menuCarousel');
        const scrollAmount = 336; // width of card (320px) + gap (16px)
        carousel.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
</script>
