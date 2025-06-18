<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class AdminCategory extends Component
{
    public $name;
    public $editingCategory;
    public $editName;
    public $deletingCategory;

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'editName' => 'required|string|max:255|unique:categories,name,' . ($this->editingCategory ? $this->editingCategory->id : 'null'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'editName.required' => 'Tên danh mục là bắt buộc',
            'editName.unique' => 'Tên danh mục đã tồn tại',
        ];
    }

    public function createCategory()
    {
        $this->validate(['name' => $this->rules()['name']]);

        Category::create([
            'name' => $this->name,
        ]);

        $this->reset('name');
        $this->dispatch('show-success', 'Đã thêm danh mục thành công!');
        $this->dispatch('close-modal', 'add-category-modal');    }

    public function editCategory($categoryId)
    {
        $this->editingCategory = Category::find($categoryId);
        $this->editName = $this->editingCategory->name;
    }

    public function updateCategory()
    {
        $this->validate(['editName' => $this->rules()['editName']]);

        $this->editingCategory->update([
            'name' => $this->editName,
        ]);

        $this->reset(['editingCategory', 'editName']);
        $this->dispatch('show-success', 'Đã cập nhật danh mục thành công!');
        $this->dispatch('close-modal', 'edit-category-modal');    }

    public function confirmDelete($categoryId)
    {
        $this->deletingCategory = Category::find($categoryId);
    }

    public function deleteCategory()
    {
        if ($this->deletingCategory) {
            $this->deletingCategory->delete();
            $this->reset('deletingCategory');
            $this->dispatch('show-success', 'Đã xóa danh mục thành công!');
            $this->dispatch('close-modal', 'delete-category-modal');        }
    }

    public function render()
    {
        $categories = Category::latest()->get();

        return view('livewire.admin.admin-categories', [
            'categories' => $categories
        ]);
    }
}