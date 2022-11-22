<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $name;
    protected $email;
    protected $carts;
    protected $status;
    public function __construct($email,$name,$carts,$status)
    {
        $this->email = $email;
        $this->name = $name;
        $this->carts=$carts;
        $this->status=$status;
    }


    public function handle()
    {
        Mail::to($this->email)->send(new OrderShipped($this->name,$this->carts,$this->status));
    }
}
