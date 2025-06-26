<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-[calc(100vh-140px)]">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-amber-800">🪑 CHỌN BÀN</h2>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-green-400 rounded-full"></div>
                        <span class="text-sm text-gray-600 font-medium">Trống</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-red-400 rounded-full"></div>
                        <span class="text-sm text-gray-600 font-medium">Có khách</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                @foreach ($tables as $table)
                    <div class="relative border-2 rounded-xl p-6 cursor-pointer hover:shadow-xl transition-all duration-300 text-center
                    {{ $selectedTable == $table->id ? 'border-amber-600 bg-amber-100 ring-4 ring-amber-200' : '' }}
                    {{ $table->status == 'available' ? 'border-green-300 bg-green-50' : '' }}
                    {{ $table->status == 'occupied' ? 'border-red-300 bg-red-50' : '' }}
                    {{ $table->status == 'reserved' ? 'border-yellow-300 bg-yellow-50' : '' }}"
                        wire:click="selectTable({{ $table->id }})">

                        <!-- Icon bàn lớn hơn -->
                        <div class="text-4xl mb-3">
                            {{ $table->status == 'available' ? '🪑' : ($table->status == 'occupied' ? '🍽️' : '📅') }}
                        </div>

                        <!-- Tên bàn to hơn -->
                        <div class="font-bold text-lg mb-2">{{ $table->name }}</div>

                        <!-- Sức chứa -->
                        <div class="text-sm text-gray-600 mb-3">{{ $table->capacity }} chỗ</div>

                        <!-- Status badge -->
                        <div class="text-xs">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold
                        {{ $table->status == 'available' ? 'bg-green-500' : '' }}
                        {{ $table->status == 'occupied' ? 'bg-red-500' : '' }}
                        {{ $table->status == 'reserved' ? 'bg-yellow-500' : '' }}">
                                {{ $table->status_text }}
                            </span>
                        </div>

                        <!-- THÊM: Nút thanh toán cho bàn có khách -->
                        @if ($table->status == 'occupied' && isset($tableOrders[$table->id]) && !empty($tableOrders[$table->id]))
                            <div class="mt-3">
                                <button wire:click.stop="checkout({{ $table->id }})"
                                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-3 rounded-lg text-xs font-semibold transition-colors">
                                    💳 Thanh toán
                                </button>
                            </div>
                        @endif

                        <!-- Badge hiển thị nếu bàn được chọn -->
                        @if ($selectedTable == $table->id)
                            <div
                                class="absolute -top-2 -right-2 bg-amber-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                                ✓
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>


        </div>

        <!-- Phần menu - THAY ĐỔI: lg:col-span-1 (thu nhỏ lại) -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl p-4 overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-amber-800">📋 MENU</h2>
                <!-- Ẩn thông tin bàn ở đây vì đã hiển thị ở phần chọn bàn -->
            </div>

            <!-- Category tabs - thu nhỏ -->
            <div class="flex flex-wrap gap-1 mb-4">
                <button
                    class="category-tab {{ $selectedCategory === 0 ? 'active bg-amber-600 text-white' : 'bg-gray-200 text-gray-700' }} px-2 py-1 rounded text-xs hover:bg-amber-700 transition-colors"
                    wire:click="filterCategory(0)">
                    All
                </button>

                @foreach ($categories as $category)
                    <button
                        class="category-tab {{ $selectedCategory === $category['id'] ? 'active bg-amber-600 text-white' : 'bg-gray-200 text-gray-700' }} px-2 py-1 rounded text-xs hover:bg-amber-700 transition-colors"
                        wire:click="filterCategory({{ $category['id'] }})">
                        {{ ucfirst($category['name']) }}
                    </button>
                @endforeach
            </div>

            <!-- Menu grid - thu nhỏ -->
            <div class="grid grid-cols-2 gap-3" id="menuGrid">
                @foreach ($menuItems as $item)
                    <div class="border rounded-lg p-3 cursor-pointer hover:shadow-lg transition-all duration-300 bg-white"
                        wire:click="addToOrder({{ $item['id'] }})">

                        {{-- Ảnh món ăn - nhỏ hơn --}}
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                            class="mb-2 w-full h-24 object-cover rounded-lg" />

                        {{-- Tên và giá - thu nhỏ --}}
                        <div class="text-center">
                            <div class="font-semibold text-sm text-gray-800 mb-1">{{ $item['name'] }}</div>
                            <div class="text-amber-700 font-bold text-xs">{{ number_format($item['sale_price']) }} ₫
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Phần đơn hàng - giữ nguyên -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl p-6 flex flex-col">
            <!-- Nội dung đơn hàng giữ nguyên như cũ -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-amber-800">ĐƠN HÀNG</h3>
                <span class="bg-amber-600 text-white px-3 py-1 rounded-lg font-semibold" id="orderNumber">
                    {{ $orderNumber ?? '#Chưa có đơn' }}
                </span>
            </div>

            <div class="flex-1 overflow-y-auto mb-4" id="orderItems">
                @if (empty($orderItems))
                    <div class="text-center py-12 text-gray-400">
                        <div class="text-4xl mb-4">🛒</div>
                        <p>Chưa có món nào được chọn</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($productsInOrder as $product)
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                <!-- Nội dung giữ nguyên như cũ -->
                                <div class="flex justify-between items-center mb-2">
                                    <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                    <div class="text-amber-700 font-semibold text-sm">
                                        {{ number_format($product->sale_price) }} ₫
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="decreaseQuantity({{ $product->id }})"
                                            class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center text-lg font-bold transition-colors">
                                            −
                                        </button>

                                        <span
                                            class="w-8 text-center font-semibold text-lg">{{ $orderItems[$product->id] }}</span>

                                        <button wire:click="increaseQuantity({{ $product->id }})"
                                            class="w-8 h-8 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center text-lg font-bold transition-colors">
                                            +
                                        </button>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <span class="font-bold text-amber-700">
                                            {{ number_format($product->sale_price * $orderItems[$product->id]) }} ₫
                                        </span>

                                        <button wire:click="removeFromOrder({{ $product->id }})"
                                            class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center text-sm font-bold transition-colors">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Order summary -->
            @if (!empty($orderItems))
                <div class="border-t pt-4" id="orderSummary">
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }} ₫</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-amber-800 border-t pt-2">
                            <span>TỔNG CỘNG:</span>
                            <span>{{ number_format($total) }} ₫</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action buttons - Chỉ hiển thị thanh toán khi có món và đã chọn bàn -->
            <div class="space-y-3">
                @if (!empty($orderItems) && $selectedTable)
                    <button wire:click="checkout"
                        class="w-full rounded-lg bg-amber-600 hover:bg-amber-700 text-white py-3 font-semibold transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        THANH TOÁN
                    </button>
                @endif

                @if (!empty($orderItems))
                    <button wire:click="clearOrder"
                        class="w-full rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 font-semibold transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        XÓA MÓN
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Menu Modal -->
    <div x-data="{ open: false }" @wire('showMenuModal') open=true @endwire x-show="open"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white p-6 rounded-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Chọn món - Bàn <span x-text="$wire.selectedTable"></span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($menuItems as $item)
                    <div class="border rounded-lg p-4 cursor-pointer hover:shadow-lg transition-all duration-300"
                        wire:click="addToOrder({{ $item['id'] }})">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                            class="mb-3 w-full h-40 object-cover rounded-lg" />
                        <div class="font-semibold text-lg">{{ $item['name'] }}</div>
                        <div class="text-amber-800 font-bold">{{ number_format($item['sale_price']) }} ₫</div>
                    </div>
                @endforeach
            </div>
            <button @click="open = false" class="mt-4 bg-amber-600 text-white px-4 py-2 rounded-lg">Đóng</button>
        </div>
    </div>


    <div x-data="{
        open: false,
        orderItems: {},
        orderDetails: [],
        table: null,
        tableName: '',
        subtotal: 0,
        tax: 0,
        total: 0,
        paymentMethod: 'cash',
        cashReceived: 0,
        change: 0,
        exactPayment: false,
        selectedDenomination: '', // Mệnh giá được chọn
        showManualInput: false, // Hiển thị input nhập tay
        showNumpad: false, // Hiển thị bàn phím số
    
        init() {
            // Lắng nghe event từ Livewire
            $wire.on('showPaymentModal', (data) => {
                console.log('Payment modal received data:', data);
    
                this.open = true;
                this.orderItems = data.orderItems || {};
                this.orderDetails = data.orderDetails || [];
                this.table = data.table;
                this.tableName = data.tableName || 'Không xác định';
                this.subtotal = data.subtotal || 0;
                this.tax = data.tax || 0;
                this.total = data.total || 0;
                this.cashReceived = 0;
                this.change = 0;
                this.paymentMethod = 'cash';
                this.exactPayment = false;
                this.selectedDenomination = '';
                this.showManualInput = false;
                this.showNumpad = false;
    
                console.log('Modal data set:', {
                    table: this.table,
                    tableName: this.tableName,
                    subtotal: this.subtotal,
                    tax: this.tax,
                    total: this.total,
                    orderDetails: this.orderDetails
                });
            });
    
            $wire.on('closePaymentModal', () => {
                this.open = false;
            });
    
            $wire.on('notify', (data) => {
                if (data.type === 'error') {
                    alert('❌ ' + data.message);
                } else if (data.type === 'success') {
                    alert('✅ ' + data.message);
                } else {
                    alert(data.message);
                }
            });
        },
    
        // Danh sách mệnh giá tiền Việt Nam
        getDenominations() {
            const baseAmounts = [
                10000, 20000, 50000, 100000, 200000, 500000
            ];
    
            // Tìm mệnh giá gần nhất >= tổng tiền
            const denominations = [];
    
            // Thêm các mệnh giá >= total
            baseAmounts.forEach(amount => {
                if (amount >= this.total) {
                    denominations.push(amount);
                }
            });
    
            // Nếu không có mệnh giá nào >= total, thêm mệnh giá cao nhất
            if (denominations.length === 0) {
                denominations.push(500000);
            }
    
            // Thêm một số mệnh giá cao hơn để khách có thể trả
            const maxDenomination = Math.max(...baseAmounts);
            if (this.total > maxDenomination) {
                // Làm tròn lên đến triệu gần nhất
                const roundedMillion = Math.ceil(this.total / 1000000) * 1000000;
                denominations.push(roundedMillion);
                if (roundedMillion < this.total * 2) {
                    denominations.push(roundedMillion * 2);
                }
            }
    
            return [...new Set(denominations)].sort((a, b) => a - b);
        },
    
        handleExactPayment() {
            if (this.exactPayment) {
                this.cashReceived = this.total;
                this.selectedDenomination = '';
                this.showManualInput = false;
                this.showNumpad = false;
                // Đồng bộ với Livewire ngay lập tức
                $wire.set('cashReceived', this.total);
            } else {
                this.cashReceived = 0;
                $wire.set('cashReceived', 0);
            }
            this.calculateChange();
        },
    
        handleDenominationChange() {
            if (this.selectedDenomination === 'manual') {
                this.showManualInput = true;
                this.showNumpad = true;
                this.cashReceived = 0;
                this.exactPayment = false;
                // Tự động focus vào input sau khi DOM cập nhật
                this.$nextTick(() => {
                    const input = this.$refs.cashInput;
                    if (input) {
                        input.focus();
                    }
                });
            } else if (this.selectedDenomination) {
                this.showManualInput = false;
                this.showNumpad = false;
                this.cashReceived = parseInt(this.selectedDenomination);
                this.exactPayment = (this.cashReceived === this.total);
                $wire.set('cashReceived', this.cashReceived);
            } else {
                this.showManualInput = false;
                this.showNumpad = false;
                this.cashReceived = 0;
                this.exactPayment = false;
                $wire.set('cashReceived', 0);
            }
            this.calculateChange();
        },
    
        // Thêm số từ bàn phím
        addNumber(num) {
            const currentValue = this.cashReceived.toString();
            const newValue = currentValue === '0' ? num.toString() : currentValue + num.toString();
            this.cashReceived = parseInt(newValue) || 0;
            this.updateCashReceived();
        },
    
        // Xóa một số
        deleteNumber() {
            const currentValue = this.cashReceived.toString();
            if (currentValue.length > 1) {
                this.cashReceived = parseInt(currentValue.slice(0, -1)) || 0;
            } else {
                this.cashReceived = 0;
            }
            this.updateCashReceived();
        },
    
        // Xóa tất cả
        clearAll() {
            this.cashReceived = 0;
            this.updateCashReceived();
        },
    
        calculateChange() {
            if (this.paymentMethod === 'cash') {
                this.change = Math.max(0, this.cashReceived - this.total);
            } else {
                this.change = 0;
            }
        },
    
        updateCashReceived() {
            // Đồng bộ với Livewire khi nhập tay
            $wire.set('cashReceived', this.cashReceived);
            this.calculateChange();
            // Cập nhật trạng thái exactPayment
            this.exactPayment = (this.cashReceived === this.total);
            // Reset denomination khi nhập tay
            if (this.showManualInput) {
                this.selectedDenomination = 'manual';
            }
        },
    
        resetPaymentInputs() {
            this.selectedDenomination = '';
            this.showManualInput = false;
            this.showNumpad = false;
            this.cashReceived = 0;
            this.exactPayment = false;
            $wire.set('cashReceived', 0);
            this.calculateChange();
        },
    
        formatNumber(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }
    }" x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

        <!-- Main Modal -->
        <div class="bg-white p-6 rounded-lg max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto shadow-2xl relative">
            <h2 class="text-xl font-bold mb-4 text-amber-800">
                💳 Thanh toán - Bàn <span x-text="tableName" class="text-amber-600"></span>
            </h2>

            <!-- Order items -->
            <div class="mb-4 max-h-40 overflow-y-auto">
                <h3 class="font-semibold mb-2 text-gray-700">📋 Chi tiết đơn hàng:</h3>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <template x-for="item in orderDetails" :key="item.id">
                        <div class="flex justify-between mb-2 text-sm">
                            <div class="flex-1">
                                <span x-text="item.name" class="font-medium"></span>
                                <span class="text-gray-500">x<span x-text="item.quantity"></span></span>
                            </div>
                            <div class="text-right">
                                <span x-text="formatNumber(item.total) + ' ₫'"
                                    class="font-medium text-amber-700"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Order summary -->
            <div class="border-t pt-4 mb-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Tạm tính:</span>
                        <span x-text="formatNumber(subtotal) + ' ₫'"></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-amber-800 border-t pt-2">
                        <span>💰 TỔNG CỘNG:</span>
                        <span x-text="formatNumber(total) + ' ₫'" class="text-xl"></span>
                    </div>
                </div>
            </div>

            <!-- Payment method -->
            <div class="mb-4">
                <label class="block mb-2 font-semibold text-gray-700">🏦 Phương thức thanh toán</label>
                <select x-model="paymentMethod" wire:model="paymentMethod"
                    @change="calculateChange(); resetPaymentInputs();"
                    class="w-full border rounded-lg p-2 focus:border-amber-500 focus:outline-none">
                    <option value="cash">💵 Tiền mặt</option>
                    <option value="transfer">🏧 Chuyển khoản</option>
                </select>
            </div>

            <!-- Cash input -->
            <div x-show="paymentMethod === 'cash'" class="mb-4">
                <!-- Checkbox trả đủ -->
                <div class="mb-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" x-model="exactPayment" @change="handleExactPayment()"
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500 focus:ring-2">
                        <span class="ml-2 text-sm font-medium text-gray-700">
                            Khách trả đúng <span x-text="formatNumber(total) + ' ₫'"
                                class="font-bold text-amber-600"></span>
                        </span>
                    </label>
                </div>

                <!-- Chọn mệnh giá tiền -->
                <div class="mb-4" x-show="!exactPayment">
                    <label class="block mb-2 font-semibold text-gray-700">💴 Chọn mệnh giá</label>
                    <select x-model="selectedDenomination" @change="handleDenominationChange()"
                        class="w-full border rounded-lg p-2 focus:border-amber-500 focus:outline-none">
                        <option value="">-- Chọn mệnh giá tiền --</option>
                        <template x-for="amount in getDenominations()" :key="amount">
                            <option :value="amount" x-text="formatNumber(amount) + ' ₫'"></option>
                        </template>
                        <option value="manual">✏️ Nhập số khác</option>
                    </select>
                </div>

                <!-- Input nhập tay -->
                <div x-show="showManualInput || exactPayment" class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700">💸 Tiền khách đưa</label>
                    <div class="flex space-x-2">
                        <input type="number" x-model.number="cashReceived" x-ref="cashInput"
                            @input="updateCashReceived()" :disabled="exactPayment"
                            :class="exactPayment ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'"
                            class="flex-1 border rounded-lg p-2 focus:border-amber-500 focus:outline-none"
                            placeholder="Nhập số tiền khách đưa" :min="total" />

                        <!-- Nút hiện/ẩn bàn phím số -->
                        <button type="button" x-show="showManualInput && !exactPayment"
                            @click="showNumpad = !showNumpad"
                            :class="showNumpad ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-3 py-2 rounded-lg transition-colors hover:bg-amber-700">
                            🔢
                        </button>
                    </div>
                </div>

                <!-- Hiển thị tiền thối -->
                <div class="mt-2 p-2 rounded-lg"
                    :class="cashReceived >= total ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
                    <span class="font-medium">💰 Tiền thối: </span>
                    <span x-text="formatNumber(change) + ' ₫'" class="font-bold"></span>
                    <div x-show="cashReceived < total && cashReceived > 0" class="text-sm mt-1">
                        ⚠️ Thiếu: <span x-text="formatNumber(total - cashReceived) + ' ₫'"></span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col space-y-3">
                <!-- Nút xác nhận thanh toán - ưu tiên cao nhất -->
                <button wire:click="processPayment" :disabled="paymentMethod === 'cash' && cashReceived < total"
                    :class="paymentMethod === 'cash' && cashReceived < total ?
                        'bg-gray-300 cursor-not-allowed text-gray-500' :
                        'bg-green-600 hover:bg-green-700 text-white'"
                    class="w-full px-6 py-4 rounded-lg transition-colors font-semibold text-lg shadow-lg">
                    <span class="flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        XÁC NHẬN THANH TOÁN
                    </span>
                </button>

                <!-- Hàng nút phụ -->
                <div class="flex space-x-3">
                    <!-- Nút in hóa đơn -->
                    <button wire:click="printReceipt"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors font-semibold shadow-md">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V9a4 4 0 10-8 0v2.5">
                                </path>
                            </svg>
                            IN HÓA ĐƠN
                        </span>
                    </button>

                    <!-- Nút hủy -->
                    <button @click="open = false"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition-colors font-semibold shadow-md">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            HỦY
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Numpad Modal -->
        <div x-show="showNumpad" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-x-4"
            x-transition:enter-end="opacity-100 scale-100 translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100 translate-x-0"
            x-transition:leave-end="opacity-0 scale-95 translate-x-4"
            class="  bg-white border-2 border-amber-300 rounded-lg shadow-xl p-3 z-10" style="width: 200px;">

            <!-- Header bàn phím -->
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-semibold text-gray-700">🔢 Bàn phím số</span>
                <button @click="showNumpad = false" class="text-gray-400 hover:text-gray-600 text-lg">
                    ✕
                </button>
            </div>

            <!-- Hiển thị số hiện tại -->
            <div class="bg-gray-100 p-2 rounded text-center mb-3">
                <span x-text="formatNumber(cashReceived) + ' ₫'" class="font-bold text-amber-700"></span>
            </div>

            <!-- Grid bàn phím -->
            <div class="grid grid-cols-3 gap-2">
                <!-- Hàng 1: 1,2,3 -->
                <template x-for="i in 3" :key="i">
                    <button @click="addNumber(i)"
                        class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded p-2 font-semibold text-blue-700 transition-colors">
                        <span x-text="i"></span>
                    </button>
                </template>

                <!-- Hàng 2: 4,5,6 -->
                <template x-for="i in 3" :key="i + 3">
                    <button @click="addNumber(i + 3)"
                        class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded p-2 font-semibold text-blue-700 transition-colors">
                        <span x-text="i + 3"></span>
                    </button>
                </template>

                <!-- Hàng 3: 7,8,9 -->
                <template x-for="i in 3" :key="i + 6">
                    <button @click="addNumber(i + 6)"
                        class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded p-2 font-semibold text-blue-700 transition-colors">
                        <span x-text="i + 6"></span>
                    </button>
                </template>

                <!-- Hàng 4: Clear, 0, Delete -->
                <button @click="clearAll()"
                    class="bg-red-50 hover:bg-red-100 border border-red-200 rounded p-2 font-semibold text-red-700 transition-colors text-xs">
                    CLR
                </button>

                <button @click="addNumber(0)"
                    class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded p-2 font-semibold text-blue-700 transition-colors">
                    0
                </button>

                <button @click="deleteNumber()"
                    class="bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded p-2 font-semibold text-orange-700 transition-colors text-xs">
                    ⌫
                </button>
            </div>

            <!-- Nút thêm số 0 -->
            <div class="grid grid-cols-2 gap-2 mt-2">
                <button @click="addNumber('00')"
                    class="bg-green-50 hover:bg-green-100 border border-green-200 rounded p-2 font-semibold text-green-700 transition-colors">
                    00
                </button>
                <button @click="addNumber('000')"
                    class="bg-green-50 hover:bg-green-100 border border-green-200 rounded p-2 font-semibold text-green-700 transition-colors">
                    000
                </button>
            </div>
        </div>
    </div>


</div>


<script>
    window.printReceipt = function(eventData = null) {
        let orderItems, selectedTable, tables, subtotal, tax, total, orderNumber, productsInOrder, tableName;

        // XỬ LÝ NHIỀU DẠNG DỮ LIỆU KHÁC NHAU
        let data = null;
        if (eventData) {
            // Trường hợp 1: eventData là array
            if (Array.isArray(eventData) && eventData.length > 0) {
                data = eventData[0];
            }
            // Trường hợp 2: eventData là object trực tiếp
            else if (typeof eventData === 'object' && !Array.isArray(eventData)) {
                data = eventData;
            }
            // Trường hợp 3: eventData có property data
            else if (eventData.data) {
                data = eventData.data;
            }
        }

        if (data) {
            orderItems = data.orderItems || data.order_items || {};
            selectedTable = data.selectedTable || data.selected_table || data.table || null;
            tables = data.tables || [];
            subtotal = data.subtotal || data.sub_total || 0;
            tax = data.tax || data.vat || 0;
            total = data.total || data.grand_total || 0;
            orderNumber = data.orderNumber || data.order_number || data.invoice_number || '#001';
            productsInOrder = data.productsInOrder || data.products_in_order || data.products || data.items || [];
            tableName = data.tableName || data.table_name || (selectedTable ? selectedTable.name : 'Chưa chọn bàn');
        } else {
            console.error('❌ No valid data found in eventData');
            alert('⚠️ Lỗi khi lấy dữ liệu đơn hàng!');
            return;
        }

        // Kiểm tra có đơn hàng không
        if (!orderItems || Object.keys(orderItems).length === 0) {
            alert('⚠️ Không có món nào để in!');
            return;
        }
        if (!selectedTable) {
            alert('⚠️ Vui lòng chọn bàn trước!');
            return;
        }


        let receiptHtml = `
                <div id="receipt-print-content" style="display: none;">
                    <div style="
                        font-family: 'Courier New', monospace; 
                        font-size: 10px; 
                        line-height: 1.2; 
                        width: 100%; 
                        max-width: 72mm;
                        margin: 0; 
                        padding: 2mm;
                        font-weight: bold;
                        text-align: left;
                        box-sizing: border-box;
                    ">
                        <!-- HEADER - COMPACT CHO 8CM -->
                         <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 6px;">
                    <!-- Logo placeholder - có thể thay bằng base64 image -->
                    <img src="/storage/logo/logo1.jpg" style="
                        width: 40px; 
                        height: 40px; 
                        margin: 0 auto 4px auto; 
                        display: block;
                        object-fit: contain;
                        border-radius: 4px;
                    " alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    
                    
                    <div style="font-size: 16px; font-weight: bold; margin-bottom: 2px;">VH-Coffee</div>
                    <div style="font-size: 12px; margin-bottom: 1px;">TTTM Hòn Đất</div>
                    <div style="font-size: 12px; margin-bottom: 1px;">TT. Hòn Đất, An Giang</div>
                    <div style="font-size: 12px;">DT: 096815252-0938431415</div>
                </div>
                        
                        <!-- THÔNG TIN ĐỢN HÀNG - COMPACT -->
                        <div style="margin-bottom: 4px; font-size: 19px;">
                            <div style="margin-bottom: 1px;">HD: ${orderNumber}</div>
                            <div style="margin-bottom: 1px;">Bàn: ${tableName}</div>
                            <div style="margin-bottom: 1px;">${new Date().toLocaleString('vi-VN')}</div>
                        </div>
                        
                        <!-- ĐƯỜNG PHÂN CÁCH -->
                        <div style="border-top: 1px dashed #000; margin: 4px 0;"></div>
                        
                        <!-- DANH SÁCH SẢN PHẨM -->
                        <div style="margin-bottom: 8px;">
            `;


        let hasProducts = false;

        if (productsInOrder && productsInOrder.length > 0) {
            console.log('📋 Found', productsInOrder.length, 'products in order');
            productsInOrder.forEach((product, index) => {
                console.log(`🔍 Product ${index + 1}:`, product);

                const quantity = orderItems[product.id] ||
                    orderItems[product.product_id] ||
                    product.quantity ||
                    product.qty ||
                    product.pivot?.quantity ||
                    product.pivot?.qty || 1;

                console.log(`📊 Product "${product.name}" - Quantity: ${quantity}`);

                if (quantity && quantity > 0) {
                    const price = product.sale_price ||
                        product.price ||
                        product.unit_price ||
                        product.pivot?.price ||
                        0;

                    const itemTotal = price * quantity;

                    hasProducts = true;
                    receiptHtml += `
                            <div style="margin-bottom: 3px; font-size: 19px;">
                                <div style="font-weight: bold; word-wrap: break-word;">${product.name || 'Sản phẩm'}</div>
                                <div style="display: flex; justify-content: space-between; margin-top: 2px;">
                                    <span style="font-size: 15px;">${number_format(price)}đ</span>
                                     <span style="font-size: 15px;">          x${quantity}</span>
                                    <span style="font-weight: bold; font-size: 19px;">${number_format(itemTotal)}đ</span>
                                </div>
                            </div>
                        `;
                } else {}
            });
        } else {
            if (orderItems && Object.keys(orderItems).length > 0) {
                console.log('🔄 Trying to get products from orderItems keys...');
                Object.keys(orderItems).forEach(productId => {
                    const quantity = orderItems[productId];
                    if (quantity > 0) {
                        hasProducts = true;
                        receiptHtml += `
                                <div style="margin-bottom: 3px; font-size: 19px;">
                                    <div style="font-weight: bold;">SP ID: ${productId}</div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 1px;">
                                        <span style="font-size: 18px;">SL: ${quantity}</span>
                                        <span style="font-weight: bold;">-</span>
                                    </div>
                                </div>
                            `;
                    }
                });
            }
        }
        receiptHtml += `
                        </div>
                        
                        <!-- ĐƯỜNG PHÂN CÁCH -->
                        <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>
                        
                        <!-- TỔNG TIỀN - CHỮ TO HỚN -->
                        <div style="font-size: 23px; margin-bottom: 6px;">
                            <!--
                            <div style="display: flex; justify-content: space-between; margin-bottom: 2px;">
                                <span>Thuế:</span>
                                <span>${number_format(tax || 0)}đ</span>
                            </div>
                            -->
                            <div style="border-top: 1px dashed #000; padding-top: 3px; margin-top: 3px;">
                                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 25px;">
                                    <span>TỔNG:</span>
                                    <span>${number_format(total || 0)}đ</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- FOOTER - CHỮ TO HỚN -->
                        <div style="text-align: center; border-top: 1px dashed #000; padding-top: 5px; font-size: 15px;">
                            <div style="margin-bottom: 2px;">Cảm ơn quý khách!</div>
                            <div>Hẹn gặp lại!</div>
                        </div>
                    </div>
                </div>
            `;


        // Xóa content cũ nếu có
        const existingContent = document.getElementById('receipt-print-content');
        if (existingContent) {
            existingContent.remove();
        }

        // Thêm content mới vào body
        document.body.insertAdjacentHTML('beforeend', receiptHtml);

        // CSS CHO GIẤY NHIỆT 80MM - FIX SINGLE PAGE ISSUE
        const printStyle = document.createElement('style');
        printStyle.id = 'receipt-print-style';
        printStyle.innerHTML = `
            @media print {
                @page {
                    size: 80mm 297mm !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                * {
                    visibility: hidden !important;
                    box-sizing: border-box !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                body {
                    margin:  0 !important;
                    padding: 0 !important;
                    width: 80mm !important;
                    height: auto !important;
                    overflow: visible !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                
                #receipt-print-content, 
                #receipt-print-content * {
                    visibility: visible !important;
                }
                
                #receipt-print-content {
                    position: static !important;
                    display: block !important;
                    width: 80mm !important;
                    max-width: 80mm !important;
                    min-width: 80mm !important;
                    margin: 0 !important;
                    padding: 2mm !important;
                    box-sizing: border-box !important;
                    height: auto !important;
                    overflow: visible !important;
                    
                    /* ĐẢM BẢO KHÔNG CHIA TRANG */
                    page-break-before: avoid !important;
                    page-break-after: avoid !important;
                    page-break-inside: avoid !important;
                    break-before: avoid !important;
                    break-after: avoid !important;
                    break-inside: avoid !important;
                    orphans: 999 !important;
                    widows: 999 !important;
                }
                
                #receipt-print-content > div {
                    page-break-inside: avoid !important;
                    break-inside: avoid !important;
                    display: block !important;
                    padding: 1mm !important;
                    font-size: 9px !important;
                    line-height: 1.1 !important;
                }
                
                /* NGĂN TẤT CẢ PHẦN TỬ CHIA TRANG */
                #receipt-print-content * {
                    page-break-before: avoid !important;
                    page-break-after: avoid !important;
                    page-break-inside: avoid !important;
                    break-before: avoid !important;
                    break-after: avoid !important;
                    break-inside: avoid !important;
                    orphans: 999 !important;
                    widows: 999 !important;
                }
                
                /* ẨN TẤT CẢ PHẦN TỬ KHÁC */
                body > *:not(#receipt-print-content) {
                    display: none !important;
                    visibility: hidden !important;
                }
            }
            
            /* Ẩn hóa đơn khi không in */
            #receipt-print-content {
                display: none;
            }
        `;

        // Xóa style cũ nếu có
        const existingStyle = document.getElementById('receipt-print-style');
        if (existingStyle) {
            existingStyle.remove();
        }
        document.head.appendChild(printStyle);

        // In ngay lập tức
        setTimeout(() => {
            console.log('Starting print process for 80mm thermal paper - SINGLE PAGE...');
            window.print();

            // Dọn dẹp sau khi in
            setTimeout(() => {
                const contentToRemove = document.getElementById('receipt-print-content');
                const styleToRemove = document.getElementById('receipt-print-style');
                if (contentToRemove) contentToRemove.remove();
                if (styleToRemove) styleToRemove.remove();
                console.log('Print cleanup completed');
            }, 1000);
        }, 500);
    };



    // Hàm format số tiền
    window.number_format = function(number) {
        return new Intl.NumberFormat('vi-VN').format(number || 0);
    };

    // Lắng nghe event từ Livewire với DEBUG
    document.addEventListener('livewire:initialized', () => {
        console.log('Livewire initialized, setting up print-receipt listener for 80mm thermal printer');
        Livewire.on('print-receipt', (eventData) => {
            // Gọi hàm in
            printReceipt(eventData);
            console.log('🎯 ===== PRINT EVENT PROCESSED =====');
        });
    });
    window.addLogoToReceipt = function(logoBase64 = null, logoUrl = null) {
        // Ví dụ sử dụng:
        // addLogoToReceipt('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...');
        // hoặc addLogoToReceipt(null, '/path/to/logo.png');

        if (logoBase64) {
            return `<img src="${logoBase64}" style="width: 40px; height: 40px; margin: 0 auto 4px auto; display: block;">`;
        } else if (logoUrl) {
            return `<img src="${logoUrl}" style="width: 40px; height: 40px; margin: 0 auto 4px auto; display: block;">`;
        } else {
            // Default placeholder logo
            return `<div style="
            width: 40px; 
            height: 40px; 
            border: 2px solid #000; 
            margin: 0 auto 4px auto; 
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            background: #f0f0f0;
        ">VH</div>`;
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, 80mm thermal receipt printer ready - SINGLE PAGE MODE');
    });
</script>
