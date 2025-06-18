<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Table;
use Livewire\WithFileUploads;
use Livewire\WithPagination;



class AdminTable extends Component
{
    use WithFileUploads, WithPagination;
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showModal = false;
    public $editMode = false;
    
    // Form fields
    public $tableId;
    public $name = '';
    public $capacity = '';
    public $status = 'available';
    public $location = '';
    public $description = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1|max:20',
        'status' => 'required|in:available,occupied,reserved,maintenance',
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:500',
        'is_active' => 'boolean'
    ];

    protected $messages = [
        'name.required' => 'Tên bàn là bắt buộc',
        'name.max' => 'Tên bàn không được vượt quá 255 ký tự',
        'capacity.required' => 'Số chỗ ngồi là bắt buộc',
        'capacity.integer' => 'Số chỗ ngồi phải là số nguyên',
        'capacity.min' => 'Số chỗ ngồi phải lớn hơn 0',
        'capacity.max' => 'Số chỗ ngồi không được vượt quá 20',
        'status.required' => 'Trạng thái là bắt buộc',
        'location.max' => 'Vị trí không được vượt quá 255 ký tự',
        'description.max' => 'Mô tả không được vượt quá 500 ký tự'
    ];

    public function render()
    {
        $tables = Table::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.admin-table', compact('tables'));
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editMode = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['tableId', 'name', 'capacity', 'status', 'location', 'description', 'is_active']);
        $this->status = 'available';
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        Table::create([
            'name' => $this->name,
            'capacity' => $this->capacity,
            'status' => $this->status,
            'location' => $this->location,
            'description' => $this->description,
            'is_active' => $this->is_active
        ]);

        session()->flash('message', 'Thêm bàn thành công!');
        $this->closeModal();
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);
        
        $this->tableId = $table->id;
        $this->name = $table->name;
        $this->capacity = $table->capacity;
        $this->status = $table->status;
        $this->location = $table->location;
        $this->description = $table->description;
        $this->is_active = $table->is_active;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $table = Table::findOrFail($this->tableId);
        $table->update([
            'name' => $this->name,
            'capacity' => $this->capacity,
            'status' => $this->status,
            'location' => $this->location,
            'description' => $this->description,
            'is_active' => $this->is_active
        ]);

        session()->flash('message', 'Cập nhật bàn thành công!');
        $this->closeModal();
    }

    public function delete($id)
    {
        Table::findOrFail($id)->delete();
        session()->flash('message', 'Xóa bàn thành công!');
    }

    public function changeStatus($id, $status)
    {
        $table = Table::findOrFail($id);
        $table->update(['status' => $status]);
        
        session()->flash('message', 'Cập nhật trạng thái thành công!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
}
