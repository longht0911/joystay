<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookHomeStay extends Model
{
    use HasFactory;
    protected $table = 'book_homestays';
    public $timestamps = true;

    const STATUS = [
        1 => 'Tiếp nhận',
        2 => 'Đã xác nhận',
        3 => 'Đã thanh toán',
        // 4 => 'Đã kết thúc',
        5 => 'Đã hủy',
    ];
    const CLASS_STATUS = [
        1 => 'btn-secondary',
        2 => 'btn-info',
        3 => 'btn-success',
        // 4 => 'btn-warning',
        5 => 'btn-danger',
    ];

    protected $fillable = [
        'b_homestay_id',
        'b_user_id',
        'b_name',
        'b_email',
        'b_phone',
        'b_address',
        'b_start_date',
        'b_note',
        'b_number',
        'b_price',
        'b_status'
    ];

    public function homestay()
    {
        return $this->belongsTo(HomeStay::class, 'b_homestay_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'b_user_id', 'id');
    }
}
