<?php

namespace App\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $totalPrice = 0;

    public function decrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData)
        {
            if($cartData->productColor()->where('id',$cartData->product_color_id)->exists())
            {
                $productColor = $cartData->productColor()->where('id',$cartData->product_color_id)->first();
                if($productColor->quantity > $cartData->quantity)
                {
                    $cartData->decrement('quantity');
                    session()->flash('message','Quantity Updated Successfully');
                }
                else
                {
                    session()->flash('error','Only'.$productColor->quantity. 'Quantity Available');
                }
            }
            else
            {
                if($cartData->product->quantity > $cartData->quantity)
                {
                    $cartData->decrement('quantity');
                    $this->dispatch('message', [
                        'text' => 'Order Placed Successfully',
                        'type' => 'error',
                        'status' => 200
                    ]);
                    //session()->flash('message','Quantity Updated Successfully');
                }
                else
                {
                    $this->dispatch('message', [
                        'text' => 'Something went wrong',
                        'type' => 'error',
                        'status' => 500
                    ]);
                    //session()->flash('message','Only'.$cartData->product->quantity. 'Quantity Available');
                }
            }              
        }
        else
        {
            session()->flash('message', 'Something Went Wrong!');
        }
    }

    public function incrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData)
        {
            if($cartData->productColor()->where('id',$cartData->product_color_id)->exists())
            {
                $productColor = $cartData->productColor()->where('id',$cartData->product_color_id)->first();
                if($productColor->quantity > $cartData->quantity)
                {
                    $cartData->increment('quantity');
                    session()->flash('message','Quantity Updated Successfully');
                }
                else
                {
                    session()->flash('error','Only'.$productColor->quantity. 'Quantity Available');
                }
            }
            else
            {
                if($cartData->product->quantity > $cartData->quantity)
                {
                    $cartData->increment('quantity');
                    session()->flash('message','Quantity Updated Successfully');
                }
                else
                {
                    session()->flash('error','Only'.$cartData->product->quantity. 'Quantity Available');
                }
            }              
        }
        else
        {
            session()->flash('message', 'Something Went Wrong!');
        }
    }

    public function removeCartItem(int $cartId)
    {
        $cartRemoveData = Cart::where('user_id', auth()->user()->id)->where('id',$cartId)->first();
        if($cartRemoveData)
        {
            $cartRemoveData->delete();
            $this->dispatch('CartAddedUpdated');
            session()->flash('message','Cart Item Removed Successfully');
        }
        else
        {
            session()->flash('error','Something Went Wrong');
        }
    }
    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show',[
            'cart' => $this->cart
        ]);
    }
}
