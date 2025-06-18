<div class="p-6 bg-white rounded shadow">

    {{-- Tiêu đề và nút thêm mới --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Quản lý Nhà Cung Cấp</h2>
        <button wire:click="create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Thêm mới</button>
    </div>

    {{-- Thanh tìm kiếm và filter --}}
    <div class="flex mb-4 space-x-4">
        <input 
            type="text" 
            wire:model.debounce.300ms="search" 
            placeholder="Tìm kiếm nhà cung cấp..." 
            class="border rounded px-3 py-2 w-full max-w-md"
        >

        <select wire:model="statusFilter" class="border rounded px-3 py-2">
            <option value="all">Tất cả trạng thái</option>
            <option value="active">Hoạt động</option>
            <option value="inactive">Không hoạt động</option>
        </select>
    </div>

    {{-- Thông báo --}}
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Bảng danh sách --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-3 py-2 text-left">Tên nhà cung cấp</th>
                <th class="border border-gray-300 px-3 py-2 text-left">Người liên hệ</th>
                <th class="border border-gray-300 px-3 py-2 text-left">SĐT</th>
                <th class="border border-gray-300 px-3 py-2 text-left">Email</th>
                <th class="border border-gray-300 px-3 py-2 text-left">Trạng thái</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Nguyên liệu</th>
                <th class="border border-gray-300 px-3 py-2 text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($suppliers) > 0)
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td class="border border-gray-300 px-3 py-2">{{ $supplier->name }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $supplier->contact_person ?? '-' }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $supplier->phone ?? '-' }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $supplier->email ?? '-' }}</td>
                        <td class="border border-gray-300 px-3 py-2 capitalize">{{ $supplier->status }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-center">{{ $supplier->ingredients_count }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-center">
                            <button wire:click="edit({{ $supplier->id }})" class="text-blue-600 hover:underline mr-2">Sửa</button>
                            <button 
                                wire:click="delete({{ $supplier->id }})" 
                                onclick="confirm('Bạn có chắc muốn xóa?') || event.stopImmediatePropagation()" 
                                class="text-red-600 hover:underline"
                            >Xóa</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center py-4">Không có nhà cung cấp nào.</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>

    {{-- Modal thêm/sửa nhà cung cấp --}}
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded p-6 w-full max-w-lg relative">
                <h3 class="text-lg font-semibold mb-4">{{ $editMode ? 'Chỉnh sửa Nhà cung cấp' : 'Thêm Nhà cung cấp' }}</h3>

                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label class="block font-medium mb-1">Tên nhà cung cấp <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block font-medium mb-1">Người liên hệ</label>
                        <input type="text" wire:model.defer="contact_person" class="w-full border rounded px-3 py-2" />
                        @error('contact_person') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block font-medium mb-1">Số điện thoại</label>
                        <input type="text" wire:model.defer="phone" class="w-full border rounded px-3 py-2" />
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block font-medium mb-1">Địa chỉ</label>
                        <textarea wire:model.defer="address" class="w-full border rounded px-3 py-2"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block font-medium mb-1">Trạng thái <span class="text-red-500">*</span></label>
                        <select wire:model.defer="status" class="w-full border rounded px-3 py-2">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                        </button>
                    </div>
                </form>

                {{-- Nút đóng modal --}}
                <button 
                    wire:click="closeModal" 
                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold"
                    aria-label="Close"
                >&times;</button>
            </div>
        </div>
    @endif
</div>
