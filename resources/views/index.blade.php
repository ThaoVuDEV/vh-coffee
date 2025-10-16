<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Góc Ảnh </title>
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

<body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-amber-800 to-orange-700 text-white shadow-2xl">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">
                        <img src="{{ asset('storage/images/logo.jpg') }}" alt="" class="rounded-full">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">COFFEE GÓC ẢNH</h1>
                        <p class="text-amber-100 text-sm">Hệ thống quản lý bán hàng</p>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="text-right">
                        <div class="font-semibold">Thu ngân: {{ Auth::User()->name }}</div>
                        <div class="text-amber-100 text-sm" id="currentTime"></div>
                    </div>
                    @if (Auth::Check() && Auth::User()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-all duration-300">
                            Quản lý</a>
                    @endif

                    <a href="{{ route('logout') }}"
                        class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-all duration-300">
                        Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>

    <livewire:order-checkout />

</body>

</html>
