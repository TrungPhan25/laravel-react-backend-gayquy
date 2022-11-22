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
    public function __construct($name,$carts,$status)
    {
        $this->name=$name;
        $this->carts=$carts;
        $this->status=$status;

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
                'carts'=>$this->carts
            ]);
        }elseif ($this->status==1){
            return $this->view('mail.donor',[
                'name'=>$this->name,
            ]);
        }

    }
}
