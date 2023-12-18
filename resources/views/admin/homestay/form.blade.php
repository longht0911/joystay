<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('t_title') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tiêu đề homestay <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" class="form-control"  placeholder="Tiêu đề homestay" name="t_title" value="{{ old('t_title',isset($homestay) ? $homestay->t_title : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('t_title') }}</p></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Địa điểm <sup class="text-danger">(*)</sup></label>
                                    <select class="custom-select" name="t_location_id">
                                        <option value="">Chọn địa điểm</option>
                                        @foreach($locations as $location)
                                            <option
                                                    {{old('t_location_id', isset($homestay->t_location_id ) ? $homestay->t_location_id  : '') == $location->id ? 'selected="selected"' : ''}}
                                                    value="{{$location->id}}"
                                            >
                                                {{$location->l_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_location_id') }}</p></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="custom-select" name="t_status">
                                        @foreach($status as $key => $statu)
                                            <option
                                                    {{old('t_status', isset($homestay->t_status ) ? $homestay->t_status : '') == $key ? 'selected="selected"' : ''}}
                                                    value="{{$key}}"
                                            >
                                                {{$statu}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_status') }}</p></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Số lượng phòng<sup class="text-danger">(*)</sup></label>
                                    <input type="text" class="form-control"  placeholder="" name="t_room" value="{{ old('t_room',isset($homestay) ? $homestay->t_room : '') }}">
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_location_id') }}</p></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Giảm giá </label>
                                        <input type="number" max="100" class="form-control"  placeholder="" name="t_sale" value="{{ old('t_sale',isset($homestay) ? $homestay->t_sale : '') }}">
                                        <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_sale') }}</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Giá/người: <sup class="text-danger">(*)</sup></label>
                                    <input type="number" class="form-control"  placeholder="" name="t_price" value="{{ old('t_price',isset($homestay) ? $homestay->t_price : '') }}">
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_price') }}</p></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Số điện thoại liên hệ:</label>
                                    <input type="text" class="form-control"  placeholder="" name="t_phone" value="{{ old('t_phone',isset($homestay) ? $homestay->t_phone : '') }}">
                                    <span class="text-danger"><p class="mg-t-5">{{ $errors->first('t_phone') }}</p></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('t_caption') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Caption <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" class="form-control"  placeholder="Caption" name="t_caption" value="{{ old('t_caption',isset($homestay) ? $homestay->t_caption : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('t_caption') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('t_utilities') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Tiện ích <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" class="form-control"  placeholder="Tiện ích" name="t_utilities" value="{{ old('t_utilities',isset($homestay) ? $homestay->t_utilities : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('t_utilities') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('t_description') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Mô tả  </label>
                            <div>
                                <textarea name="t_description" id="t_description" cols="30" rows="10" class="form-control" style="height: 225px;">{{ old('t_description', isset($homestay) ? $homestay->t_description : '') }}</textarea>
                                <script>
                                    ckeditor(t_description);
                                </script>
                                @if ($errors->first('t_description'))
                                    <span class="text-danger">{{ $errors->first('t_description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('t_content') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Giới thiệu homestay </label>
                            <div>
                                <textarea name="t_content" id="t_content" cols="30" rows="10" class="form-control" style="height: 225px;">{{ old('t_content', isset($homestay) ? $homestay->t_content : '') }}</textarea>
                                <script>
                                    ckeditor(t_content);
                                </script>
                                @if ($errors->first('t_content'))
                                    <span class="text-danger">{{ $errors->first('t_content') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Xuất bản</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-set">
                            <button type="submit" name="submit" value="{{ isset($homestay) ? 'update' : 'create' }}" class="btn btn-info">
                                <i class="fa fa-save"></i> Lưu dữ liệu
                            </button>
                            <button type="reset" name="reset" value="reset" class="btn btn-danger">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Thời gian diễn ra </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Ngày bắt đầu <sup class="text-danger">(*)</sup></label>
                            <input type="date" class="form-control" name="t_start_date" value="{{ old('t_start_date', isset($homestay) ? $homestay->t_start_date : '') }}">
                            @if ($errors->first('t_start_date'))
                                <span class="text-danger">{{ $errors->first('t_start_date') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Ngày kết thúc <sup class="text-danger">(*)</sup></label>
                            <input type="date" class="form-control" name="t_end_date" value="{{ old('t_end_date', isset($homestay) ? $homestay->t_end_date : '') }}">
                            @if ($errors->first('t_end_date'))
                                <span class="text-danger">{{ $errors->first('t_end_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh </h3>
                    </div>
                    <div class="card-body" style="min-height: 288px">
                        <div class="form-group">
                            <div class="input-group input-file" name="images">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-choose" type="button">Chọn tệp</button>
                                </span>
                                <input type="text" class="form-control" placeholder='Không có tệp nào ...'/>
                                <span class="input-group-btn"></span>
                            </div>
                            <span class="text-danger "><p class="mg-t-5">{{ $errors->first('images') }}</p></span>
                            @if(isset($homestay) && !empty($homestay->t_image))
                                <img src="{{ asset(pare_url_file($homestay->t_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                            @else
                                <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 150px; width:100%;">
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
</div>
