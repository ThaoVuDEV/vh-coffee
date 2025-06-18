<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminProduct extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $categories;
    public $showModal = false;
    public $editMode = false;
    public $productId;

    // Form fields
    public $name;
    public $category_id;
    public $original_price;
    public $sale_price = 0;
    public $description;
    public $image;
    public $is_available = true;

    // Search and filter
    public $search = '';
    public $categoryFilter = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'original_price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'is_available' => 'boolean'
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        $products = $query->latest()->paginate(10);

        return view('livewire.admin.admin-product', [
            'products' => $products,
            'categories' => $this->categories
        ]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->category_id = '';
        $this->original_price = '';
        $this->sale_price = 0; 
        $this->description = '';
        $this->image = null;
        $this->is_available = true;
        $this->productId = null;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'original_price' => $this->original_price,
            'sale_price' => $this->sale_price ?: 0,
            'description' => $this->description,
            'is_available' => $this->is_available,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        if ($this->editMode) {
            Product::findOrFail($this->productId)->update($data);
            session()->flash('message', 'Sản phẩm đã được cập nhật thành công!');
        } else {
            Product::create($data);
            session()->flash('message', 'Sản phẩm đã được thêm thành công!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->original_price = $product->original_price;
        $this->sale_price = $product->sale_price ?: 0; // Đảm bảo không bao giờ là null
        $this->description = $product->description;
        $this->is_available = $product->is_available;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            Product::findOrFail($id)->delete();
            session()->flash('message', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function toggleAvailability($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_available' => !$product->is_available]);
        session()->flash('message', 'Trạng thái sản phẩm đã được cập nhật!');
    }
}