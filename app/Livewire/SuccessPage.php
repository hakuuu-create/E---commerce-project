<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Session;

#[Title('Success page - E-commerce project')]
class SuccessPage extends Component{
    #[Url]
    public $session_id;
    public function render(){

        //give the latest order for the current login user
        $latest_order = Order::with('address')->where('user_id',auth('web')->user()->id)->latest()->first();

        if($this->session_id){
            Stripe::setApikey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            if($session_info->payment_status != 'paid'){
                $latest_order->payment_status = 'failed';
                $latest_order->save();
                return redirect()->route('cancel');
            }else if($session_info->payment_status == 'paid'){
                $latest_order->payment_status = 'paid';
                $latest_order->save();
            }
        }

        return view('livewire.success-page',[
            'order' => $latest_order,
        ]);
    } 
}
