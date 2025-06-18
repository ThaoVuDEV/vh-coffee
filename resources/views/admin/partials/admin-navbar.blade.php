<nav class="mt-4">
    <div class="px-3 space-y-1">
        <!-- Tổng quan -->
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link active flex items-center space-x-3 px-3 py-2 text-coffee-700 bg-coffee-50 rounded-lg border-l-4 border-coffee-600 font-medium text-sm">
            <span>📊</span>
            <span>Tổng quan</span>
        </a>

        <!-- Đơn hàng -->
        <a href="#"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>📋</span>
            <span>Đơn hàng hôm nay</span>
        </a>

        <!-- Quản lý sản phẩm -->
        <a href="{{ route('admin.product') }}"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>🍽️</span>
            <span>Sản phẩm</span>
        </a>

        <!-- Danh mục -->
        <a href="{{ route('admin.categories') }}"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>🗂️</span>
            <span>Danh mục</span>
        </a>
        <!-- Bàn -->
        <a href="{{ route('admin.tables') }}"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>🪑</span>
            <span>Bàn</span>
        </a>
        <!-- Quản lý nhà cung cấp -->
        <a href="{{ route('admin.suppliers') }}"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>🛒</span>
            <span>Nhà cung cấp</span>
        </a>
        <!-- Quản lý nhân viên -->
        <a href="#"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>👥</span>
            <span>Nhân viên & ca làm</span>
        </a>

        <!-- Nguyên liệu -->
        <a href="{{route('admin.ingredients')}}"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>📦</span>
            <span>Quản lý nguyên liệu</span>
        </a>

        <!-- Thống kê -->
        <a href="#"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>📈</span>
            <span>Thống kê</span>
        </a>

        <!-- Cài đặt -->
        <a href="#"
            class="nav-link flex items-center space-x-3 px-3 py-2 text-gray-600 hover:text-coffee-700 hover:bg-coffee-50 rounded-lg transition-colors text-sm">
            <span>⚙️</span>
            <span>Cài đặt hệ thống</span>
        </a>

    </div>
</nav>
