<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Quản lý Nguyên liệu</h2>
        <button wire:click="create" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Thêm nguyên liệu
        </button>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" 
                       wire:model.debounce.300ms="search" 
                       placeholder="Tên hoặc mã nguyên liệu..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nhà cung cấp</label>
                <select wire:model="selectedSupplier" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả nhà cung cấp</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tình trạng tồn kho</label>
                <select wire:model="stockFilter" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tất cả</option>
                    <option value="low">Sắp hết hàng</option>
                    <option value="normal">Bình thường</option>
                    <option value="high">Tồn kho cao</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nguyên liệu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Mã
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nhà cung cấp
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tồn kho
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tình trạng
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Giá
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Thao tác
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ingredients as $ingredient)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $ingredient->name }}</div>
                                <div class="text-sm text-gray-500">{{ $ingredient->unit }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $ingredient->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $ingredient->supplier->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($ingredient->current_stock) }} {{ $ingredient->unit }}
                            <div class="text-xs text-gray-500">
                                Min: {{ number_format($ingredient->min_stock) }} | 
                                Max: {{ number_format($ingredient->max_stock) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $stockStatus = $ingredient->stock_status;
                                $statusClass = $stockStatus === 'low' ? 'bg-red-100 text-red-800' : 
                                              ($stockStatus === 'high' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $ingredient->stock_status_text }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($ingredient->unit_price, 0) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="openTransactionModal({{ $ingredient->id }}, 'import')" 
                                        class="text-green-600 hover:text-green-900" title="Nhập hàng">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <button wire:click="openTransactionModal({{ $ingredient->id }}, 'export')" 
                                        class="text-orange-600 hover:text-orange-900" title="Xuất hàng">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                                <button wire:click="edit({{ $ingredient->id }})" 
                                        class="text-blue-600 hover:text-blue-900" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $ingredient->id }})" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                        class="text-red-600 hover:text-red-900" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            Không có dữ liệu
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4">
            {{ $ingredients->links() }}
        </div>
    </div>

    {{-- Main Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                        {{ $editMode ? 'Cập nhật nguyên liệu' : 'Thêm nguyên liệu mới' }}
                    </h3>
                    
                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sản phẩm liên kết (nếu có)</label>
                            <select wire:model="product_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Không liên kết sản phẩm --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên nguyên liệu *</label>
                                <input type="text" wire:model="name" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Đơn vị *</label>
                                <input type="text" wire:model="unit" placeholder="kg, lít, gram..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nhà cung cấp *</label>
                                <select wire:model="supplier_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Chọn nhà cung cấp</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            @if(!$editMode)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng hiện tại</label>
                                <input type="number" step="0.01" wire:model="current_stock" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tồn kho tối thiểu *</label>
                                <input type="number" step="0.01" wire:model="min_stock" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('min_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tồn kho tối đa *</label>
                                <input type="number" step="0.01" wire:model="max_stock" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('max_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Giá đơn vị *</label>
                                <input type="number" step="0.01" wire:model="unit_price" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('unit_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                                <select wire:model="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Ngừng hoạt động</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                            <textarea wire:model="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Hủy
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Transaction Modal --}}
    @if($showTransactionModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                        {{ $transactionType === 'import' ? 'Nhập hàng' : 'Xuất hàng' }}
                    </h3>
                    
                    <form wire:submit.prevent="saveTransaction">
                        <div class="space-y-4">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng *</label>
                                <input type="number" step="0.01" wire:model="transactionQuantity" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('transactionQuantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Đơn giá</label>
                                <input type="number" step="0.01" wire:model="transactionUnitPrice" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số chứng từ</label>
                                <input type="text" wire:model="transactionReferenceNumber" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ghi chú</label>
                                <textarea wire:model="transactionNote" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Hủy
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 {{ $transactionType === 'import' ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white rounded-md">
                                {{ $transactionType === 'import' ? 'Nhập hàng' : 'Xuất hàng' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>  