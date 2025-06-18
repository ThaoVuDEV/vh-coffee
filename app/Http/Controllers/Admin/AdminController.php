<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller{
    public function index(){
        return view('admin.dashboard');
    }
    public function categories(){
        return view('admin.category');
    }
    public function product(){
        return view('admin.product');
    }
    public function table(){
        return view('admin.table');
    }
      public function suppliers()
      {
    
          return view('admin.supplier');
      }
  
      public function ingredients()
      {
          return view('admin.ingredients');
      }
  
      public function ingredientTransactions()
      {
          return view('admin.ingredient-transactions');
      }
  
      // Báo cáo tồn kho
      public function stockReport()
      {
          return view('admin.stock-report');
      }
}