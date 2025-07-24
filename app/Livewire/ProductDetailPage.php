<?php

namespace App\Livewire;

use App\Models\Product;
use Jantinnerezo\LivewireAlert\Concerns\SweetAlert2;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Product Detail Page - E-Commerce project')]
class ProductDetailPage extends Component{

    use SweetAlert2;
    public $slug;
    public $quantity = 1;

    public function mount($slug){
        $this->slug = $slug;
    }

    public function increaseQty(){
        $this->quantity++;
    }

    public function decreaseQty(){
       
       if ($this->quantity > 1){
        $this->quantity--;
       } 
    }

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCartWithQty($product_id,$this->quantity);

        $this->dispatch('update_cart-count',total_count: $total_count)->to(Navbar::class);
       
        //notif letakkan disini
    }
    
    public function render(){
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug',$this->slug)->firstOrfail(),
        ]);
    }
}
