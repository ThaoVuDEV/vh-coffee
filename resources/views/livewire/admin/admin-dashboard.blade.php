<div class="p-4 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Dashboard Thống Kê</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded">
            <h3 class="font-semibold">Tổng doanh thu</h3>
            <p class="text-lg font-bold">{{ number_format($totalRevenue) }} ₫</p>
        </div>

        <div class="bg-green-100 p-4 rounded">
            <h3 class="font-semibold">Doanh thu hôm nay</h3>
            <p class="text-lg font-bold">{{ number_format($dailyRevenue) }} ₫</p>
        </div>

        <div class="bg-yellow-100 p-4 rounded">
            <h3 class="font-semibold">Doanh thu tháng</h3>
            <p class="text-lg font-bold">{{ number_format($monthlyRevenue) }} ₫</p>
        </div>

        <div class="bg-red-100 p-4 rounded">
            <h3 class="font-semibold">Số lượng bán hôm nay</h3>
            <p class="text-lg font-bold">{{ $dailySalesCount }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-3">Top 10 món bán chạy hôm nay</h3>
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-2 py-1 text-left">Tên món</th>
                    <th class="border border-gray-300 px-2 py-1 text-right">Số lượng</th>
                    <th class="border border-gray-300 px-2 py-1 text-right">Doanh thu (₫)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topSellingProducts as $product)
                    <tr>
                        <td class="border border-gray-300 px-2 py-1">{{ $product['product_name'] }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-right">{{ $product['quantity'] }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-right">{{ number_format($product['revenue']) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-2 py-1 text-center">Chưa có dữ liệu bán hàng hôm nay</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
