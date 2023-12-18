@extends('page.layouts.page')
@section('title', 'Đặt homestay')
@section('style')
@stop
@section('seo')
@stop
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('/page/images/bg_1.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>homestays <i class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Đặt homestay</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row d-flex contact-info">
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <h3 class="mb-2">Địa chỉ</h3>
                        <p>Hà Đông, Hà Nội</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-phone"></span>
                        </div>
                        <h3 class="mb-2">Số điện thoại liên hệ</h3>
                        <p><a href="tel://1234567920">0123456789</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-paper-plane"></span>
                        </div>
                        <h3 class="mb-2">Địa chỉ email</h3>
                        <p><a href="mailto:info@yoursite.com">joystay@gmail.com</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-globe"></span>
                        </div>
                        <h3 class="mb-2">Website</h3>
                        <p><a href="#">http://youtube.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-6 order-md-last">
                    <p></p>
                    <form action="{{ route('post.book.homestay', $homestay->id) }}" method="POST" class="bg-light p-5 contact-form">
                        @csrf
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Họ và tên <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="b_name" value="{{ old('b_name', isset($user) ? $user->name : '') }}" class="form-control" placeholder="Họ và tên">
                            @if ($errors->first('b_name'))
                                <span class="text-danger">{{ $errors->first('b_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Email <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="b_email" value="{{ old('b_email', isset($user) ? $user->email : '') }}" class="form-control" placeholder="Email">
                            @if ($errors->first('b_email'))
                                <span class="text-danger">{{ $errors->first('b_email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Số điện thoại <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="b_phone" value="{{ old('b_phone', isset($user) ? $user->phone : '') }}" class="form-control" placeholder="Số điện thoại">
                            @if ($errors->first('b_phone'))
                                <span class="text-danger">{{ $errors->first('b_phone') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Địa chỉ <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="b_address" value="{{ old('b_address', isset($user) ? $user->address : '') }}" class="form-control" placeholder="Địa chỉ">
                            @if ($errors->first('b_address'))
                                <span class="text-danger">{{ $errors->first('b_address') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Số phòng muốn đặt <sup class="text-danger">(*)</sup></label>
                            <input type="number" name="b_number" class="form-control" placeholder="số phòng muốn đặt">
                            @if ($errors->first('b_number'))
                                <span class="text-danger">{{ $errors->first('b_number') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Ghi chú</label>
                            <textarea name="b_note"  placeholder="Thông tin chi tiết để chúng tôi liên hệ nhanh chóng..." id="message" cols="20" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <input type="submit" value="Đặt homestay" class="btn btn-primary py-3 px-5">
                            </div>
                        </div>

                    </form>

                </div>

                <div class="col-md-6 text-center">
                    <div class="col-md-12">
                        <h2 class="mb-3 title-book">{{ $homestay->t_title }}</h2>
                        <h2 class="mb-3">{{ isset($homestay->location) ? $homestay->location->l_name : '' }}</h2>
                        <p>Caption : {{ $homestay->t_caption }}</p>
                        <p class="price-homestay">Giá: <span>{{ number_format($homestay->t_price-($homestay->t_price*$homestay->t_sale/100),0,',','.') }}</span> vnd</p>
                        <p>Tiện ích : {{ $homestay->t_utilities }}</p>
                        <p>Số điện thoại liên hệ : {{ $homestay->t_phone }}</p>
                        <p>Số phòng trống : {{ $homestay->t_room }}</p>
                        <p>Đã đăng ký : {{ $homestay->t_number_registered }}</p>
                        <div class="phoneWrap">
                            <div class="hotline">032.555.6896</div>
                            <div class="hotline">012.345.6789</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <img src="{{ asset('page/images/travel.jpg') }}" alt="" class="image-book">
                    </div>
                    <div>
</div>
                </div>
            </div>
        </div>
        <script>
    $('.a').on('input',function(){
        var $a =$(this).val();
        var $p = $(this).parents('tr');
        var $b=300;
        var $t=$p.find('.t');
        $t.text($b*$a);
    })
</script>
    </section>
@stop
@section('script')
@stop
