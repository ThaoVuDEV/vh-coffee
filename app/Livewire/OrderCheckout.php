<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class OrderCheckout extends Component
{
    public $categories = [];
    public $menuItems = [];
    public $tables = [];
    public $selectedCategory = 0;
    public $selectedTable = null;
    public $orderItems = [];
    public $paymentMethod = 'cash';
    public $cashReceived = 0;
    public $orderNumber = null;
    public $showReceipt = false;
    public $receiptContent = '';
    public $subtotal;
    public $tax;
    public $total;
    public function mount()
    {
        $this->loadCategories();
        $this->loadMenuItems();
        $this->loadTables();
        $this->loadSessionOrder();
        $this->generateNextOrderNumber();
        $this->updateTableStatuses();
    }

    public function generateNextOrderNumber()
    {
        // Lấy id đơn hàng lớn nhất hiện tại
        $lastOrder = \App\Models\Order::orderBy('id', 'desc')->first();

        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;

        $this->orderNumber = 'ORD-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    public function loadCategories()
    {
        $this->categories = \App\Models\Category::select('id', 'name')->get()->toArray();
    }

    public function loadTables()
    {
        $this->tables = \App\Models\Table::active()->get();
    }

    public function loadMenuItems()
    {
        $query = Product::query();

        if ($this->selectedCategory != 0) {
            $query->where('category_id', $this->selectedCategory);
        }

        $this->menuItems = $query->get()->toArray();
    }

    public function filterCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->loadMenuItems();
    }

    public function selectTable($tableId)
    {
        $this->selectedTable = $tableId;
        $this->loadSessionOrder();
        $this->generateNextOrderNumber();

        $this->dispatch('showMenuModal');
    }

    protected function loadSessionOrder()
    {
        if ($this->selectedTable) {
            $sessionKey = 'order_table_' . $this->selectedTable;
            $this->orderItems = Session::get($sessionKey, []);
        } else {
            $this->orderItems = [];
        }
    }
    private function updateTableStatuses()
    {
        foreach ($this->tables as $table) {
            $sessionKey = 'order_table_' . $table->id;
            $sessionOrder = Session::get($sessionKey, []);

            if (!empty($sessionOrder)) {
                if ($table->status !== 'occupied') {
                    $table->update(['status' => 'occupied']);
                }
            } else {
                if ($table->status === 'occupied') {
                    $table->update(['status' => 'available']);
                }
            }
        }

        $this->loadTables();
    }
    private function updateSingleTableStatus($tableId)
    {
        $table = \App\Models\Table::find($tableId);
        if (!$table) return;

        $sessionKey = 'order_table_' . $tableId;
        $sessionOrder = Session::get($sessionKey, []);

        if (!empty($sessionOrder)) {
            if ($table->status !== 'occupied') {
                $table->update(['status' => 'occupied']);
            }
        } else {
            if ($table->status === 'occupied') {
                $table->update(['status' => 'available']);
            }
        }

        $this->loadTables();
    }
    public function addToOrder($productId)
    {
        if (!$this->selectedTable) {
            $this->dispatch('notify', type: 'error', message: 'Vui lòng chọn bàn trước!');
            return;
        }

        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]++;
        } else {
            $this->orderItems[$productId] = 1;
        }

        $this->saveSessionOrder();
        $this->updateSingleTableStatus($this->selectedTable);
    }

    public function removeFromOrder($productId)
    {
        unset($this->orderItems[$productId]);
        $this->saveSessionOrder();
        $this->updateSingleTableStatus($this->selectedTable);
    }

    protected function saveSessionOrder()
    {
        if ($this->selectedTable) {
            $sessionKey = 'order_table_' . $this->selectedTable;
            Session::put($sessionKey, $this->orderItems);
        }
    }

    public function clearOrder()
    {
        $this->orderItems = [];
        $this->saveSessionOrder();
        if ($this->selectedTable) {
            $this->updateSingleTableStatus($this->selectedTable);
        }
    }

    public function checkout()
    {
        if (!$this->selectedTable) {
            $this->dispatch('notify', type: 'error', message: 'Vui lòng chọn bàn trước khi thanh toán!');
            return;
        }

        if (empty($this->orderItems)) {
            $this->dispatch('notify', type: 'error', message: 'Đơn hàng trống!');
            return;
        }

        $productsInOrder = Product::whereIn('id', array_keys($this->orderItems))->get();
        $subtotal = 0;
        $orderDetails = [];

        foreach ($productsInOrder as $product) {
            $subtotal += $product->sale_price * $this->orderItems[$product->id];
            $orderDetails[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => $this->orderItems[$product->id],
                'total' => $product->sale_price * $this->orderItems[$product->id]
            ];
        }

        // $tax = $subtotal * 0.1;
        $tax = 0;
        $total = $subtotal + $tax;

        // Lấy tên bàn
        $tableName = $this->tables->find($this->selectedTable)->name ?? 'Unknown';

        // Dispatch event với data đầy đủ
        $this->dispatch(
            'showPaymentModal',
            orderItems: $this->orderItems,
            orderDetails: $orderDetails,
            table: $this->selectedTable,
            tableName: $tableName,
            subtotal: $subtotal,
            tax: $tax,
            total: $total
        );
    }

    public function getProductsInOrderProperty()
    {
        if (empty($this->orderItems)) {
            return collect();
        }

        $productIds = array_keys($this->orderItems);
        return Product::whereIn('id', $productIds)->get();
    }


    public function processPayment()
    {
        $productsInOrder = Product::whereIn('id', array_keys($this->orderItems))->get();
        $subtotal = 0;

        // Tính subtotal
        foreach ($productsInOrder as $product) {
            $subtotal += $product->sale_price * $this->orderItems[$product->id];
        }

        // $tax = $subtotal * 0.1;
        $tax = 0;
        $total = $subtotal + $tax;

        if ($this->paymentMethod === 'cash' && $this->cashReceived < $total) {
            $this->dispatch('notify', type: 'error', message: 'Số tiền nhận không đủ!');
            return;
        }

        // Sử dụng Database Transaction để đảm bảo tính nhất quán
        DB::beginTransaction();

        try {
            $order = \App\Models\Order::create([
                'order_number' => 'ORD-' . time(),
                'table_id' => $this->selectedTable,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'cash_received' => $this->paymentMethod === 'cash' ? $this->cashReceived : $total,
                'change_amount' => $this->paymentMethod === 'cash' ? $this->cashReceived - $total : 0,
                'status' => 'completed',
                'payment_status' => 'paid',
                'completed_at' => now(),
            ]);

            $orderNumber = 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            $order->order_number = $orderNumber;
            $order->save();

            $this->orderNumber = $orderNumber;

            foreach ($productsInOrder as $product) {
                $quantityOrdered = $this->orderItems[$product->id];

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantityOrdered,
                    'unit_price' => $product->sale_price,
                    'total_price' => $product->sale_price * $quantityOrdered,
                ]);

                $ingredient = \App\Models\Ingredient::where('product_id', $product->id)->first();

                if ($ingredient && $ingredient->current_stock >= $quantityOrdered) {
                    $ingredient->current_stock -= $quantityOrdered;
                    $ingredient->save();
                }
            }

            DB::commit();

            $sessionKey = 'order_table_' . $this->selectedTable;
            Session::forget($sessionKey);
            $this->clearOrder();
            $this->selectedTable = null;

            $this->dispatch('notify', type: 'success', message: 'Thanh toán thành công!');
            $this->dispatch('closePaymentModal');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', type: 'error', message: 'Có lỗi xảy ra khi xử lý thanh toán!');
        }
    }

    public function closeReceipt()
    {
        $this->showReceipt = false;
        $this->receiptContent = '';
    }

    public function getProductName($productId)
    {
        $product = Product::find($productId);
        return $product ? $product->name : 'Unknown Product';
    }

    public function getProductPrice($productId)
    {
        $product = Product::find($productId);
        return $product ? $product->sale_price : 0;
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]++;
        } else {
            $this->orderItems[$productId] = 1;
        }

        $this->saveSessionOrder();
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->orderItems[$productId]) && $this->orderItems[$productId] > 1) {
            $this->orderItems[$productId]--;
        } else {
            unset($this->orderItems[$productId]);
        }

        $this->saveSessionOrder();
    }

    public function render()
    {
        $productsInOrder = Product::whereIn('id', array_keys($this->orderItems))->get();

        $subtotal = 0;
        foreach ($productsInOrder as $product) {
            $subtotal += $product->sale_price * $this->orderItems[$product->id];
        }

        // $tax = $subtotal * 0.1;
        $tax = 0;
        $total = $subtotal + $tax;

        return view('livewire.order-checkout', [
            'productsInOrder' => $productsInOrder,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }
    public function printReceipt()
    {
        if (empty($this->orderItems)) {
            $this->dispatch('notify', type: 'error', message: 'Không có món nào để in!');
            return;
        }

        if (!$this->selectedTable) {
            $this->dispatch('notify', type: 'error', message: 'Vui lòng chọn bàn!');
            return;
        }

        // Lấy thông tin sản phẩm trong đơn hàng
        $productsInOrder = Product::whereIn('id', array_keys($this->orderItems))->get();

        // Debug: Log dữ liệu products
        Log::info('Products in order:', $productsInOrder->toArray());
        Log::info('Order items:', $this->orderItems);

        // Tính toán tổng tiền
        $subtotal = 0;
        $productsData = [];

        foreach ($productsInOrder as $product) {
            $quantity = $this->orderItems[$product->id];
            $subtotal += $product->sale_price * $quantity;

            // Tạo array dữ liệu sản phẩm để truyền cho JavaScript
            $productsData[] = [
                'id' => $product->id,
                'name' => $product->name,
                'sale_price' => $product->sale_price,
                'quantity' => $quantity
            ];
        }

        // $tax = $subtotal * 0.1;
        $tax = 0;
        $total = $subtotal + $tax;

        // Lấy tên bàn
        $tableName = $this->tables->find($this->selectedTable)->name ?? 'Không xác định';

        // Debug: Log dữ liệu sẽ gửi
        Log::info('Data to send to JS:', [
            'productsData' => $productsData,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        // Cập nhật dữ liệu render để JavaScript có thể truy cập
        $this->subtotal = $subtotal;
        $this->tax = $tax;
        $this->total = $total;

        // Dispatch event với dữ liệu đầy đủ cho JavaScript
        $this->dispatch('print-receipt', [
            'orderItems' => $this->orderItems,
            'selectedTable' => $this->selectedTable,
            'tables' => $this->tables->toArray(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'orderNumber' => $this->orderNumber,
            'productsInOrder' => $productsData, // Dữ liệu sản phẩm đã format
            'tableName' => $tableName
        ]);
    }
}
