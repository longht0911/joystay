@extends('page.layouts.page')
@section('title', 'Thông tin tài khoản - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
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
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Danh sách <i class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Đặt homestay</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row">
                @include('page.common.sideBarUser')
                <div class="col-lg-9 ftco-animate py-md-5">
                    <table class="table table-hover table-bordered my-homestay">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle; width: 3%">STT</th>
                                <th style="vertical-align: middle; width: 20%">Tên homestay</th>
                                <th style="vertical-align: middle;">Thông tin</th>
                                <th style="vertical-align: middle;" class=" text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$bookhomestays->isEmpty())
                                @php $i = $bookhomestays->firstItem(); @endphp
                                @foreach($bookhomestays as $homestay)
                                    <tr>
                                        <td style="vertical-align: middle; width: 3%">{{ $i }}</td>
                                        <td style="vertical-align: middle; width: 30%">
                                            <p>{{ $homestay->homestay->t_title }}</p>
                                            <p><b>Ngày khởi hành : </b> {{ $homestay->homestay->t_start_date }}</p>
                                            <p><b>Ngày trở về : </b> {{ $homestay->homestay->t_end_date }}</p>
                                        </td>
                                        <td style="vertical-align: middle; width: 50%">
                                         <p><b>Mã booking : </b> {{ $homestay->id }}</p>
                                            <p><b>Số phòng đặt : </b> {{ $homestay->b_number}} - <b>Tiền 1 phòng</b>: {{ number_format($homestay->b_price, 0,',','.') }} vnd</p>




                                            @php
                                            $totalPrice = ($homestay->b_number*$homestay->b_price);
                                            @endphp
                                            <p><b>Tổng tiền :</b> {{ number_format($totalPrice, 0,',','.') }} vnd</p>
                                            <p><b>Ghi chú :</b> {{ $homestay->b_note }}</p>
                                        </td>
                                        <td style="vertical-align: middle; width: 17%">
                                            @if($homestay->b_status != 1)
                                                <button type="button" class="btn btn-block {{ $classStatus[$homestay->b_status] }} btn-sm btn-status-order">{{ $status[$homestay->b_status]  }}</button>
                                            @endif
                                            @if($homestay->b_status == 1)
                                                <a class="btn btn-block btn-danger btn-sm btn-cancel-order" href="{{ route('post.cancel.order.homestay', ['status' => 5, 'id' => $homestay->id]) }}" >Hủy</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                                {{ $bookhomestays->links('page.pagination.default') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .col-md-8 -->
            </div>

        </div>
    </section>
@stop
@section('script')
@stop
