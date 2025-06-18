<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Quản lý danh mục</h1>
        <p class="text-gray-600">Thêm mới và quản lý các danh mục sản phẩm</p>
    </div>

    <!-- Success Message -->
    <div id="success-message"
        class="hidden bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"></path>
        </svg>
        <span id="success-text"></span>
    </div>

    <!-- Add Category Button -->
    <div class="flex justify-between items-center">
        <button data-modal-target="add-category-modal" data-modal-toggle="add-category-modal"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Thêm danh mục mới
        </button>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                Danh sách danh mục
                <span class="ml-2 bg-white bg-opacity-20 text-white text-sm px-2 py-1 rounded-full">
                    {{ count($categories) }}
                </span>
            </h3>
        </div>

        <div class="p-6">
            @forelse ($categories as $index => $category)
                <div
                    class="flex items-center justify-between p-4 mb-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $category->name }}
                            </h4>
                            <p class="text-sm text-gray-500">Danh mục sản phẩm</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="editCategory({{ $category->id }})" data-modal-target="edit-category-modal"
                            data-modal-toggle="edit-category-modal"
                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </button>
                        <button wire:click="confirmDelete({{ $category->id }})"
                            data-modal-target="delete-category-modal" data-modal-toggle="delete-category-modal"
                            class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có danh mục nào</h3>
                    <p class="text-gray-500">Hãy thêm danh mục đầu tiên để bắt đầu quản lý sản phẩm</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="add-category-modal" aria-hidden="true" wire:ignore tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Thêm danh mục mới
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="add-category-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                @if (session()->has('success'))
                    <div class="fixed top-5 right-5 z-50">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow"
                            role="alert">
                            <strong class="font-bold">Thành công!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                <form wire:submit.prevent="createCategory" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <div class="col-span-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Tên danh
                                mục</label>
                            <input type="text" wire:model="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Nhập tên danh mục..." required="">
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Thêm danh mục
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="edit-category-modal" wire:ignore tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Chỉnh sửa danh mục
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-category-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                @if (session()->has('success'))
                    <div class="fixed top-5 right-5 z-50">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow"
                            role="alert">
                            <strong class="font-bold">Thành công!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                <form wire:submit.prevent="updateCategory" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <div class="col-span-1">
                            <label for="editName" class="block mb-2 text-sm font-medium text-gray-900">Tên danh
                                mục</label>
                            <input type="text" wire:model="editName" id="editName"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Nhập tên danh mục..." required="">
                            @error('editName')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="delete-category-modal" wire:ignore tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="delete-category-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Bạn có chắc chắn muốn xóa danh mục này?</h3>
                    @if ($deletingCategory)
                        <p class="mb-5 text-sm text-gray-600">Danh mục: <strong>{{ $deletingCategory->name }}</strong>
                        </p>
                    @endif
                    <button wire:click="deleteCategory" data-modal-hide="delete-category-modal" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        Có, tôi chắc chắn
                    </button>
                    <button data-modal-hide="delete-category-modal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Không,
                        hủy bỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {

            // Show success notification with SweetAlert2
            Livewire.on('show-success', (message) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });

            // Close modal handler
            Livewire.on('close-modal', (modalId) => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    modal.style.display = 'none';

                    // Xóa các backdrop cụ thể của Flowbite/Tailwind
                    document.querySelectorAll('[modal-backdrop]').forEach(el => el.remove());

                    // Xóa thêm các lớp backdrop chung
                    const backdrops = document.querySelectorAll(
                        '.fixed.inset-0.bg-gray-900\\/50, .bg-black.bg-opacity-50');
                    backdrops.forEach(el => el.remove());

                    // Reset body & html overflow
                    document.body.classList.remove('overflow-hidden', 'modal-open');
                    document.documentElement.classList.remove('overflow-hidden');
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';

                    // Flowbite modal instance (nếu có)
                    if (typeof FlowbiteInstances !== 'undefined') {
                        const modalInstance = FlowbiteInstances.getInstance('Modal', modalId);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                }
            });

        });
    </script>
@endscript
