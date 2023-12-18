<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class HomeStay extends Model
{
    use HasFactory;
    protected $table = 'homestays';
    public $timestamps = true;

    protected $fillable = [
        't_title',
        't_caption',
        't_utilities',
        't_phone',
        't_start_date',
        't_end_date',
        't_room',
        't_price',
        't_bed',
        't_sale',
        't_view',
        't_description',
        't_content',
        't_anbum_image',
        't_image',
        't_location_id',
        't_user_id',
        't_number_registered',
        't_follow',
        't_status',
    ];

    const STATUS = [
        1 => 'Khởi tạo',
        2 => 'Đang diễn ra',
        3 => 'Đã hoàn tất'
    ];

    public function createOrUpdate($request, $id = '')
    {
        $params = $request->except(['images', '_token', 'submit']);

        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1)
                $params['t_image'] = $image['name'];
        }

        $params['t_user_id'] = Auth::user()->id;
        $params['t_sale'] = $request->t_sale ? $request->t_sale : 0;
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 't_location_id', 'id')->where('l_status', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 't_user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'cm_homestay_id', 'id');
    }
    public function bookhomestay()
    {
        return $this->hasMany(BookHomeStay::class, 'b_homestay_id', 'id');
    }
}
