<div>
    <div style="background-color:#c5ffff;text-align: center;border-color: green; border-style: solid;
  border-width: 5px;">
    <h4 style="text-align: center">Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi<br>
    </h4>

</div>

    <h2>Phiếu xác nhận huỷ booking <b style="color:red">trạng thái: HUỶ </b></h2>
     Mã homestay: <b> {{$bookhomestay->b_homestay_id}} </b> <br>
   Tên homestay: <b> {{$homestay->t_title}} </b><br>
   Ngày đến: <b> {{$bookhomestay->b_start_date}} </b><br>

    <div style="background-color:#ddd;margin-top:8px">
    <div style ="margin-left:8px">
    Mã booking: <b style="color:red"> {{$bookhomestay->id}}</b><br>

    @php
         $totalPrice = ($bookhomestay->b_number*$bookhomestay->b_price);
     @endphp
    Trị giá booking: <b>{{ number_format($totalPrice, 0,',','.') }} vnd </b><br>
      Ngày booking:<b> {{$bookhomestay->created_at}}</b><br>
      Ngày Huỷ:<b> {{$bookhomestay->updated_at}}</b><br>

 <b style="color:red">Nếu có thắc mắc, quý khách vui lòng liên hệ joystay@gmail.com</b><br>
</div>
 <div style="margin-top:8px">
    Họ tên:<b> {{$user->name}}</b><br>
    email: <b>{{$user->email}}</b><br>
    Số điện thoại: <b>{{$user->phone}}</b><br>
    Địa chỉ: <b>{{$user->address}} </b><br>
</div>
<div  style="background-color:#ddd;margin-top:8px">
<div style ="margin-left:8px">
    Số phòng đặt:<b> {{$bookhomestay->b_number}} </b>
</div>
</div>

</div>
