@extends('admin.layouts.main')
@section('title', '')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('book.homestay.index') }}">Đặt homestay</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3 class="card-title">From tìm kiếm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="name_homestay" class="form-control mg-r-15" placeholder="Tên homestay">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <select class="custom-select" name="b_homestay_id">
                                            <option value="">Chọn mã homestay</option>
                                            @foreach($homestays as $homestay)
                                                    <option value="{{$homestay->id}}">
                                                        {{$homestay->id}}-{{$homestay->t_title}}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="b_name" class="form-control mg-r-15" placeholder="Tên khách hàng">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="b_email" class="form-control mg-r-15" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="b_phone" class="form-control mg-r-15" placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success " style="margin-right: 10px"><i class="fas fa-search"></i> Tìm kiếm </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th>Tên homestay-Mã homestay</th>
                                    <th>Thông tin khách hàng</th>
                                    <th>Dữ liệu homestay</th>
                                    <th class="text-center">Trạng thái</th>
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                    <th class=" text-center">Hành động</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if (!$bookhomestays->isEmpty())
                                    @php $i = $bookhomestays->firstItem(); @endphp
                                    @foreach($bookhomestays as $book)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; width: 2%">{{ $i }}</td>
                                            <td style="vertical-align: middle; width: 15%" class="title-content">
                                                {{ isset($book->homestay) ? $book->homestay->t_title : '' }}
                                               <p>({{ isset($book->homestay) ? $book->homestay->id : '' }})</p>
                                            </td>
                                            <td style="vertical-align: middle; width: 20%" class="title-content">
                                                <p><b>Tên</b>: {{ $book->b_name }}</p>
                                                <p><b>Email</b>: {{ $book->b_email }}</p>
                                                <p><b>Phone</b>: {{ $book->b_phone }}</p>
                                                {{--  <p><b>Địa chỉ</b>: {{ $book->user->address }}</p>  --}}
                                            </td>
                                            <td style="vertical-align: middle; width: 35%" class="title-content">
                                                <p><b>Số phòng đặt:</b>: {{ $book->b_number}} - <b>Tiền 1 phòng</b>: {{ number_format($book->b_price, 0,',','.') }} vnd</p>
                                                @php
                                                    $totalPrice = $book->b_number*$book->b_price;
                                                @endphp
                                                <p><b>Tổng tiền </b>: {{ number_format($totalPrice, 0,',','.') }} vnd</p>
                                                <p><b>mã booking</b>: {{ $book->id }}</p>
                                                <p><b>điểm đón</b>: {{ $book->b_address }}</p>
                                                <p><b>Ghi chú</b>: {{ $book->b_note }}</p>
                                            </td>
                                            <td style="vertical-align: middle; width: 11%">
                                                <button type="button" class="btn btn-block {{ $classStatus[$book->b_status] }} btn-xs">{{ $status[$book->b_status] }}</button>
                                            </td>
                                            @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                            <td style="vertical-align: middle; width: 17%">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu action-transaction" role="menu">
                                                        <li><a href="{{ route('book.homestay.delete', $book->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                        @foreach($status as $key => $item)
                                                            <li class="update_book_homestay" url='{{ route('book.homestay.update.status', ['status' => $key, 'id' => $book->id]) }}'><a><i class="fas fa-check"></i>  {{ $item }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </td>
                                            @endif
                                        </tr>
                                        @php $i++ @endphp
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if($bookhomestays->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $bookhomestays->appends($query = '')->links() }}
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@stop
