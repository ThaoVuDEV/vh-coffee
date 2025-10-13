<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VH-Coffee - Hệ thống POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-occupied {
            background: linear-gradient(135deg, #fef3c7, #f59e0b);
            border-color: #d97706;
        }

        .table-available {
            background: linear-gradient(135deg, #dcfce7, #22c55e);
            border-color: #16a34a;
        }

        .table-reserved {
            background: linear-gradient(135deg, #ddd6fe, #8b5cf6);
            border-color: #7c3aed;
        }
    </style>
</head>

<body class="bg-amber-50 ">
    <!-- Header -->
    <header class="bg-gradient-to-r from-amber-800 to-orange-700 text-white shadow-2xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">
                        ☕
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="text-xl font-bold tracking-wider">VH-COFFEE</a>
                    </div>
                </div>

                <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    <a href="#menu" class="hover:text-amber-200 transition-colors">Thực đơn</a>
                    <a href="#gallery" class="hover:text-amber-200 transition-colors">Góc ảnh</a>
                    <a href="#contact" class="hover:text-amber-200 transition-colors">Liên hệ</a>
                </nav>

                <a href="#"
                    class="hidden md:inline-block bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-5 rounded-full transition-all duration-300">
                    Đặt Món
                </a>
            </div>
        </div>
    </header>

    <livewire:home-page />
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} VH-Coffee. All Rights Reserved.</p>
            <p class="text-sm text-gray-400 mt-2">Thiết kế và phát triển bởi ThaoDev.</p>
        </div>
    </footer>
</body>


</html>
