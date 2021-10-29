<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Storage;

class Product extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    
    public $name,$url,$description,$stock,$price;

    public function render()
    {
        $products = ProductModel::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->paginate(10);
       
        return view('livewire.product', [
            'products' => $products
        ]);
    }

    public function previewImage()
    {
        $this->validate([
            'url' => 'image|max:2048'
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'url' => 'image|max:2048|required',
            'description' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        $imageName = md5($this->url.microtime().'.'.$this->url->extension());

        Storage::putFileAs(
            'public/images',
            $this->url,
            $imageName
        );

        ProductModel::create([
            'name' => $this->name,
            'url' => $imageName,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price
        ]);

        session()->flash('info', 'Product Created Successfully');

        $this->name = '';
        $this->url = '';
        $this->description = '';
        $this->stock = '';
        $this->price = '';
    }
}
