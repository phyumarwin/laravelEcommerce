<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $prodColorSelectedQuantity, $quantityCount = 1, $productColorId;

    public function addToWishList($productId)
    {
        //dd($productId);
        if(Auth::check())
        {
            //dd('am in');
            if(Wishlist::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists())
            {
                session()->flash('message','Already added to wishlist');
                return false;
            }
            else
            {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                session()->flash('message','Wishlist Added Successfully');
            }
            
        }
        else
        {
            session()->flash('error','Please login to continue');
            return false;
        }
    }

    public function colorSelected($productColorId)  
    {
        //dd($productColorId);
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if($this->prodColorSelectedQuantity == 0)
        {
            $this->prodColorSelectedQuantity = 'outOfStock';
        }
    }

    public function incrementQuantity()
    {
        if($this->quantityCount < 10)
        {
            $this->quantityCount++;
        }
        
    }

    public function decrementQuantity()
    {
        if($this->quantityCount > 1)
        {
            $this->quantityCount--;
        }
    }

    public function addToCart(int $productId)
    {
        if(Auth::check())
        {
            if($this->product->where('id',$productId)->where('status','0')->exists())
            {
                if($this->product->productColors()->count() > 1)
                {
                    if($this->prodColorSelectedQuantity != NULL)
                    {
                        if(Cart::where('user_id', auth()->user()->id)
                                ->where('product_id', $productId)
                                ->where('product_color_id', $this->productColorId)
                                ->exists())
                        {
                            session()->flash('message', 'Product Already Added');
                        }
                        else
                        {
                            $productColor = $this->product->productColors()->where('id',$this->productColorId)->first();
                            if($productColor->quantity > 0)
                            {
                                if($productColor->quantity > $this->quantityCount)
                                {
                                    // Insert Product to Cart
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->quantityCount
                                    ]);

                                    session()->flash('message', 'Product Added to Cart');
                                }
                                else
                                {
                                    // $this->dispatch('message', [
                                    // 'text' => 'Only '.$productColor->quantity.' Quantity Available',
                                    // 'type' => 'warning',
                                    // 'status' => 404
                                    // ]);
                                    session()->flash('error', 'Only'.$productColor->quantity.' Quantity Available');
                                }
                            }
                            else
                            {
                                // $this->dispatch('message', [
                                //     'text' => 'Out of Stock',
                                //     'type' => 'warning',
                                //     'status' => 404
                                // ]);
                                session()->flash('error', 'Out of Stock');
                            }
                        }
                        
                    }
                    else
                    {
                        // $this->dispatch('message', [
                        //     'text' => 'Select Your Product Color',
                        //     'type' => 'info',
                        //     'status' => 404
                        // ]);
                        session()->flash('error', 'Select Your Product Color');
                    }
                }
                else
                {
                    if(Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists())
                    {
                        // $this->dispatch('message', [
                        //     'text' => 'Product Already Added',
                        //     'type' => 'warning',
                        //     'status' => 200
                        // ]);
                        session()->flash('message', 'Product Already Added');
                    }
                    else
                    {
                        if($this->product->quantity > 0)
                        {
                            if($this->product->quantity > $this->quantityCount)
                            {
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);
                                // $this->dispatch('message', [
                                //     'text' => 'Product Added to Cart',
                                //     'type' => 'success',
                                //     'status' => 200
                                //     ]);
                                session()->flash('message', 'Product Added to Cart');
                            }
                            else
                            {
                                // $this->dispatch('message', [
                                // 'text' => 'Only '.$this->product->quantity.' Quantity Available',
                                // 'type' => 'warning',
                                // 'status' => 404
                                // ]);
                                session()->flash('error', 'Only'.$this->product->quantity.' Quantity Available');
                            }
                        }
                        else
                        {
                            // $this->dispatch('message', [
                            // 'text' => 'Out of Stock',
                            // 'type' => 'warning',
                            // 'status' => 404
                            // ]);
                            session()->flash('error', 'Out of Stock');
                        } 
                    }
                }
                
            }
            else
            {
                // $this->dispatch('message', [
                //     'text' => 'Product Does not Exist',
                //     'type' => 'warning',
                //     'status' => 401
                // ]);
                session()->flash('error', 'Product Does not Exist');
            }
        }
        else
        {
            // $this->dispatch('message', [
            //     'text' => 'Please login to add to card',
            //     'type' => 'info',
            //     'status' => 401
            // ]);
            session()->flash('error', 'Please login to add to card');
        }
    }
    public function mouth($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }
    
    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
