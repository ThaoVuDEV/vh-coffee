<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier;

class AdminSupplier extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    
    public $showModal = false;
    public $editMode = false;
    public $supplierId;
    
    public $name;
    public $contact_person;
    public $phone;
    public $email;
    public $address;
    public $status = 'active';

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string',
        'status' => 'required|in:active,inactive'
    ];

    public function render()
    {
        
        $suppliers = Supplier::when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function($query) {
                $query->where('status', $this->statusFilter);
            })
            ->withCount('ingredients')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.admin-supplier', [
            'suppliers' => $suppliers
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
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->contact_person = $supplier->contact_person;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->status = $supplier->status;
        
        $this->showModal = true;
        $this->editMode = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'status' => $this->status
        ];

        if ($this->editMode) {
            Supplier::findOrFail($this->supplierId)->update($data);
            session()->flash('message', 'Cập nhật nhà cung cấp thành công!');
        } else {
            Supplier::create($data);
            session()->flash('message', 'Thêm nhà cung cấp thành công!');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        if ($supplier->ingredients()->count() > 0) {
            session()->flash('error', 'Không thể xóa nhà cung cấp đang có nguyên liệu!');
            return;
        }
        
        $supplier->delete();
        session()->flash('message', 'Xóa nhà cung cấp thành công!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->contact_person = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->status = 'active';
        $this->supplierId = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }
}