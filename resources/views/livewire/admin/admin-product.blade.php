<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Quản lý sản phẩm</h1>
        <p class="text-gray-600 dark:text-gray-400">Quản lý danh sách sản phẩm trong cửa hàng</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="sr-only">Tìm kiếm</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tìm kiếm sản phẩm...">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="md:w-48">
                <select wire:model.live="categoryFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Tất cả danh mục</option>
                    @if($categories && $categories->count() > 0)
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Add Button -->
            <button wire:click="openModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4 mr-2 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5.757v8.486M5.757 10h8.486M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                Thêm sản phẩm
            </button>
        </div>
    </div>

    <!-- Products Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Hình ảnh</th>
                    <th scope="col" class="px-6 py-3">Tên sản phẩm</th>
                    <th scope="col" class="px-6 py-3">Danh mục</th>
                    <th scope="col" class="px-6 py-3">Giá gốc</th>
                    <th scope="col" class="px-6 py-3">Giá khuyến mãi</th>
                    <th scope="col" class="px-6 py-3">Trạng thái</th>
                    <th scope="col" class="px-6 py-3">Ngày tạo</th>
                    <th scope="col" class="px-6 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if($products->count())
                @foreach($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->id }}
                        </td>
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img class="w-10 h-10 rounded object-cover" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($product->original_price, 0, ',', '.') }}đ
                        </td>
                        <td class="px-6 py-4">
                            @if($product->sale_price)
                                {{ number_format($product->sale_price, 0, ',', '.') }}đ
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleAvailability({{ $product->id }})" class="inline-flex items-center">
                                @if($product->is_available)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 bg-green-600 rounded-full mr-1 inline-block"></span>
                                        Có sẵn
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 bg-red-600 rounded-full mr-1 inline-block"></span>
                                        Hết hàng
                                    </span>
                                @endif
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button wire:click="edit({{ $product->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $product->id }})" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Không có sản phẩm nào được tìm thấy
                    </td>
                </tr>
            @endif
            
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $editMode ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' }}
                        </h3>
                        <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form wire:submit.prevent="store" class="p-6 space-y-6">
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Product Name -->
                            <div class="col-span-6">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên sản phẩm</label>
                                <input type="text" wire:model="name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập tên sản phẩm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Danh mục</label>
                                <select wire:model="category_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Chọn danh mục</option>
                                    @if($categories && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Original Price -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="original_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá gốc</label>
                                <input type="number" wire:model="original_price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                                @error('original_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Sale Price -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="sale_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giá bán</label>
                                <input type="number" wire:model="sale_price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                                @error('sale_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Hình ảnh</label>
                                <input wire:model="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" accept="image/*">
                                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-span-6">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả</label>
                                <textarea wire:model="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập mô tả sản phẩm..."></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Availability -->
                            <div class="col-span-6">
                                <div class="flex items-center">
                                    <input wire:model="is_available" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sản phẩm có sẵn</label>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                            </button>
                            <button wire:click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>