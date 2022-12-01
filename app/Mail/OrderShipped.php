<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $name;
    protected $carts;
    protected $status;
    protected $customer_id;
    public function __construct($name,$carts,$status,$customer_id)
    {
        $this->name=$name;
        $this->carts=$carts;
        $this->status=$status;
        $this->customer_id=$customer_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->status==0){
            return $this->view('mail.order',[
                'name'=>$this->name,
                'carts'=>$this->carts,
                'customer_id'=>$this->customer_id,
            ]);
        }elseif ($this->status==1){
            return $this->view('mail.donor',[
                'name'=>$this->name,
            ]);
        }

    }
}
