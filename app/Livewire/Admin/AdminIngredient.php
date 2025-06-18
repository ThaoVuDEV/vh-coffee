<?php
namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ingredient;
use App\Models\Supplier;
use App\Models\IngredientTransaction;
use App\Models\Product;

class AdminIngredient extends Component
{
    use WithPagination;
    public $product_id;

    public $search = '';
    public $selectedSupplier = '';
    public $stockFilter = 'all'; 
    
    public $showModal = false;
    public $editMode = false;
    public $ingredientId;
    
    public $name;
    public $code;
    public $description;
    public $unit;
    public $current_stock = 0;
    public $min_stock = 0;
    public $max_stock = 0;
    public $unit_price = 0;
    public $supplier_id;
    public $status = 'active';

    public $showTransactionModal = false;
    public $transactionType = 'import';
    public $transactionQuantity;
    public $transactionUnitPrice;
    public $transactionNote;
    public $transactionReferenceNumber;

    protected $rules = [
        'name' => 'required|string|max:255',
        'unit' => 'required|string|max:50',
        'min_stock' => 'required|numeric|min:0',
        'max_stock' => 'required|numeric|min:0',
        'unit_price' => 'required|numeric|min:0',
        'supplier_id' => 'required|exists:suppliers,id',
        'status' => 'required|in:active,inactive'
    ];

    public function render()
    {
        $query = Ingredient::with('supplier')
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedSupplier, function($q) {
                $q->where('supplier_id', $this->selectedSupplier);
            });

        // Lọc theo tình trạng tồn kho
        if ($this->stockFilter !== 'all') {
            $query->where(function($q) {
                switch ($this->stockFilter) {
                    case 'low':
                        $q->whereRaw('current_stock <= min_stock');
                        break;
                    case 'high':
                        $q->whereRaw('current_stock >= max_stock');
                        break;
                    case 'normal':
                        $q->whereRaw('current_stock > min_stock AND current_stock < max_stock');
                        break;
                }
            });
        }

        $ingredients = $query->orderBy('created_at', 'desc')->paginate(10);
        $suppliers = Supplier::where('status', 'active')->get();

        return view('livewire.admin.admin-ingredient', [
            'ingredients' => $ingredients,
            'suppliers' => $suppliers,
            'products' => Product::all(),
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editMode = false;
    }

    public function edit($id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $this->ingredientId = $ingredient->id;
        $this->name = $ingredient->name;
        $this->description = $ingredient->description;
        $this->unit = $ingredient->unit;
        $this->current_stock = $ingredient->current_stock;
        $this->min_stock = $ingredient->min_stock;
        $this->max_stock = $ingredient->max_stock;
        $this->unit_price = $ingredient->unit_price;
        $this->supplier_id = $ingredient->supplier_id;
        $this->status = $ingredient->status;
          $this->product_id = $ingredient->product_id;
        $this->showModal = true;
        $this->editMode = true;
    }

    public function save()
    {
    
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'unit' => $this->unit,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
            'unit_price' => $this->unit_price,
            'supplier_id' => $this->supplier_id,
            'status' => $this->status,
            'product_id' => $this->product_id ?: null,
        ];

        if ($this->editMode) {
            Ingredient::findOrFail($this->ingredientId)->update($data);
            session()->flash('message', 'Cập nhật nguyên liệu thành công!');
        } else {
            $data['current_stock'] = $this->current_stock;
            Ingredient::create($data);
            session()->flash('message', 'Thêm nguyên liệu thành công!');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        Ingredient::findOrFail($id)->delete();
        session()->flash('message', 'Xóa nguyên liệu thành công!');
    }

    public function openTransactionModal($ingredientId, $type = 'import')
    {
        $this->ingredientId = $ingredientId;
        $this->transactionType = $type;
        $this->resetTransactionForm();
        $this->showTransactionModal = true;
    }

    public function saveTransaction()
    {
        $this->validate([
            'transactionQuantity' => 'required|numeric|min:0.01',
            'transactionUnitPrice' => 'nullable|numeric|min:0',
            'transactionNote' => 'nullable|string|max:500'
        ]);

        $ingredient = Ingredient::findOrFail($this->ingredientId);
        
        $totalAmount = $this->transactionUnitPrice ? 
            $this->transactionQuantity * $this->transactionUnitPrice : null;

        IngredientTransaction::create([
            'ingredient_id' => $this->ingredientId,
            'type' => $this->transactionType,
            'quantity' => $this->transactionQuantity,
            'unit_price' => $this->transactionUnitPrice,
            'total_amount' => $totalAmount,
            'note' => $this->transactionNote,
            'reference_number' => $this->transactionReferenceNumber,
            'transaction_date' => now()
        ]);

        session()->flash('message', 'Giao dịch được thêm thành công!');
        $this->resetTransactionForm();
        $this->showTransactionModal = false;
    }

    private function resetForm()
    {
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->unit = '';
        $this->current_stock = 0;
        $this->min_stock = 0;
        $this->max_stock = 0;
        $this->unit_price = 0;
        $this->supplier_id = '';
        $this->status = 'active';
        $this->ingredientId = null;
    }

    private function resetTransactionForm()
    {
        $this->transactionQuantity = '';
        $this->transactionUnitPrice = '';
        $this->transactionNote = '';
        $this->transactionReferenceNumber = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showTransactionModal = false;
        $this->resetForm();
        $this->resetTransactionForm();
    }
}