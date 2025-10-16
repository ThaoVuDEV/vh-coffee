<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COFFEE GÓC ẢNH- Quản Lý Quán Nhà</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-rXcWZUv...etc" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}" type="image/png">

    <!-- Flowbite JS (nếu chưa có) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            50: '#faf7f2',
                            100: '#f4ede0',
                            200: '#e8d5be',
                            300: '#d6b895',
                            400: '#c59969',
                            500: '#b8804a',
                            600: '#aa6b3e',
                            700: '#8d5735',
                            800: '#724630',
                            900: '#5e3a29',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-coffee-50 to-coffee-100 min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed lg:relative w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-20 h-screen lg:h-auto">
            <!-- Logo -->
            <div class="bg-gradient-to-r from-coffee-600 to-coffee-700 p-4 text-white">
                <a href="{{ route('home') }}">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-xl">
                            <img src="{{ asset('storage/images/logo.jpg') }}" alt="" class="rounded-full">
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">COFFEE GÓC ẢNH</h2>
                            <p class="text-coffee-200 text-xs">Quản lý quán nhà</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            @include('admin.partials.admin-navbar')
        </div>



        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 ml-0">
            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        });
    </script>

</body>

</html>
