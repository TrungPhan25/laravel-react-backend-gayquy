
<h3> Xin chào; {{$name}} Bạn đã đặt hàng thành công</h3>
<table>
    @php
    $totla_price=0;
    @endphp
    @foreach($carts as $cart)
        @php
            $totla_price=$totla_price+$cart->quantity*$cart->price;
        @endphp
    <div class="row">
        Tên sản phẩm: {{$cart->slug}}     |    Tên sản phẩm: {{$cart->quantity}}    |    số tiền: {{$cart->price}}vnđ
    </div>
    @endforeach
    <div class="row">
        Tổng số tiền là: {{$totla_price}} vnđ
    </div>
</table>
