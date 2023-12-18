@if($homestay->t_status < 2)
<div class="{{ !isset($itemhomestay) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemhomestay) ? $itemhomestay : '' }}">
    <div class="project-wrap">
        <a href="{{ route('homestay.detail', ['id' => $homestay->id, 'slug' => safeTitle($homestay->t_title)]) }}" class="img"

           style="background-image: url({{ $homestay->t_image ? asset(pare_url_file($homestay->t_image)) : asset('admin/dist/img/no-image.png') }});">
           @if( $homestay->t_sale > 0)
           <span  class="price">Sale {{ $homestay->t_sale }}%</span>
           @endif
           @if( $homestay->t_sale > 0)
           <span class="price" style="margin-left:100px">
           {{ number_format($homestay->t_price-($homestay->t_price*$homestay->t_sale/100),0,',','.') }} vnd/người <br>
           <span style="text-decoration: line-through;margin-left:35px;color:#ddd">{{ number_format($homestay->t_price)}}</span>
        </span>
           @else
           <span class="price" >
           {{ number_format($homestay->t_price-($homestay->t_price*$homestay->t_sale/100),0,',','.') }} vnd/người</span>
           @endif
        </a>

        <div class="text p-4">
            @if($homestay->t_number_registered==$homestay->t_room)
            <h5 class="days" style="color:red">Đã hết phòng</h5>

            @endif
            <span class="days">{{ $homestay->t_utilities }}  </span>
            <h3>
                <a href="{{ route('homestay.detail', ['id' => $homestay->id, 'slug' => safeTitle($homestay->t_title)]) }}" title="{{ $homestay->t_title }}">
                    {{ the_excerpt($homestay->t_title, 100) }}
                </a>

            </h3>
            <p class="location"><span class="fa fa-calendar-check-o"></span> Ngày đi : {{ $homestay->t_start_date  }}</p>
            <?php $number = $homestay->t_room - $homestay->t_number_registered ?>
            <p class="location"><span class="fa fa-user"></span> Số phòng : {{ $homestay->t_room  }} - Còn trống: {{  $number  }} </p>

            <p class="location"><span class="fa fa-user"></span> Phòng đã đặt : {{  $homestay->t_number_registered  }}</p>
            @if($homestay->t_number_registered<$homestay->t_room)

            <a class="location"><span class="fa fa-user"></span> Số người đang quan tâm: {{ $homestay->t_follow  }} </a><br>
            @endif
            @if($number-$homestay->t_follow<2 && $homestay->t_number_registered!=$homestay->t_room)
            <a style="color:red"> sắp hết </a>
            @endif
            {{--<ul>--}}
            {{--<li><i class="fa fa-user" aria-hidden="true"></i> 2</li>--}}
            {{--<li><i class="fa fa-user" aria-hidden="true"></i> 3</li>--}}
            {{--</ul>--}}
        </div>
    </div>
</div>
@endif
