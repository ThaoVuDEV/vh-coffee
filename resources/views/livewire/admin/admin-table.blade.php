<div class="container mx-auto px-4 py-8">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <span class="mr-2">✅</span>
                    <span>{{ session('message') }}</span>
                    <button onclick="this.parentElement.parentElement.parentElement.style.display='none'" class="ml-4 text-green-700 hover:text-green-900">×</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🪑 Quản lý Bàn</h1>
                <p class="text-gray-600 mt-2">Quản lý thông tin bàn trong nhà hàng</p>
            </div>
            <button wire:click="openModal" class="bg-coffee-600 hover:bg-coffee-700 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg">
                <span class="mr-2">➕</span>
                Thêm Bàn Mới
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" wire:model.live="search" placeholder="Tìm theo tên bàn hoặc vị trí..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="available">Trống</option>
                    <option value="occupied">Đang sử dụng</option>
                    <option value="reserved">Đã đặt</option>
                    <option value="maintenance">Bảo trì</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="$refresh" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    🔄 Làm mới
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <span class="text-2xl">✅</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bàn Trống</p>
                    <p class="text-2xl font-bold text-green-600">{{ $tables->where('status', 'available')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <span class="text-2xl">🔴</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Đang Sử Dụng</p>
                    <p class="text-2xl font-bold text-red-600">{{ $tables->where('status', 'occupied')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <span class="text-2xl">📋</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Đã Đặt</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $tables->where('status', 'reserved')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-coffee-100 rounded-full">
                    <span class="text-2xl">🪑</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng Bàn</p>
                    <p class="text-2xl font-bold text-coffee-600">{{ $tables->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Danh Sách Bàn</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Bàn</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sức Chứa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vị Trí</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng Thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hoạt Động</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tables as $table)
                        <tr class="hover:bg-gray-50" wire:key="table-{{ $table->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">🪑</span>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $table->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $table->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $table->capacity }} người</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $table->location ?: 'Chưa xác định' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $table->status_color }}">
                                    {{ $table->status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $table->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $table->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="edit({{ $table->id }})" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors" title="Sửa">
                                        ✏️
                                    </button>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-50 transition-colors" title="Thay đổi trạng thái">
                                            🔄
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                            <div class="py-1">
                                                <button wire:click="changeStatus({{ $table->id }}, 'available')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                                    Trống
                                                </button>
                                                <button wire:click="changeStatus({{ $table->id }}, 'occupied')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                                    Đang sử dụng
                                                </button>
                                                <button wire:click="changeStatus({{ $table->id }}, 'reserved')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                                    Đã đặt
                                                </button>
                                                <button wire:click="changeStatus({{ $table->id }}, 'maintenance')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                                                    Bảo trì
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="delete({{ $table->id }})" wire:confirm="Bạn có chắc chắn muốn xóa bàn '{{ $table->name }}'?" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors" title="Xóa">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <span class="text-6xl mb-4">🪑</span>
                                    <p class="text-lg font-medium">Chưa có bàn nào</p>
                                    <p class="text-sm">Hãy thêm bàn đầu tiên cho nhà hàng của bạn</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-3 border-t border-gray-200">
            {{ $tables->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="{{ $editMode ? 'update' : 'store' }}">
                        <div class="bg-white px-6 py-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $editMode ? 'Chỉnh Sửa Bàn' : 'Thêm Bàn Mới' }}
                                </h3>
                                <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <span class="text-2xl">×</span>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <!-- Tên bàn -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên bàn *</label>
                                    <input type="text" wire:model="name" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500 @error('name') border-red-500 @enderror"
                                           placeholder="VD: Bàn 01, Bàn A1">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Số chỗ ngồi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Số chỗ ngồi *</label>
                                    <input type="number" wire:model="capacity" min="1" max="20"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500 @error('capacity') border-red-500 @enderror"
                                           placeholder="VD: 4">
                                    @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Vị trí -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vị trí</label>
                                    <input type="text" wire:model="location" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500 @error('location') border-red-500 @enderror"
                                           placeholder="VD: Tầng 1 - Gần cửa sổ, Khu vực VIP">
                                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Trạng thái -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái *</label>
                                    <select wire:model="status" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500 @error('status') border-red-500 @enderror">
                                        <option value="available">Trống</option>
                                        <option value="occupied">Đang sử dụng</option>
                                        <option value="reserved">Đã đặt</option>
                                        <option value="maintenance">Bảo trì</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Mô tả -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                                    <textarea wire:model="description" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-coffee-500 focus:border-coffee-500 @error('description') border-red-500 @enderror"
                                              placeholder="Mô tả thêm về bàn (tùy chọn)"></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Trạng thái hoạt động -->
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_active" 
                                           class="h-4 w-4 text-coffee-600 focus:ring-coffee-500 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-700">
                                        Bàn đang hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                            <p class="text-xs text-gray-500">* Trường bắt buộc</p>
                            <div class="flex space-x-3">
                                <button type="button" wire:click="closeModal" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Hủy
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-coffee-600 border border-transparent rounded-lg hover:bg-coffee-700 transition-colors">
                                    {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const flashMessage = document.querySelector('.fixed.top-4.right-4');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    });
</script>