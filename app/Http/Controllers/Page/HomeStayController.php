<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\User;
use App\Models\BookHomeStay;
use App\Http\Requests\BookHomeStayRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class HomeStayController extends Controller
{
    //
    public function index(Request $request)
    {
        $homestays = HomeStay::with('user');

        if ($request->key_homestay) {
            $homestays->where('t_title', 'like', '%' . $request->key_homestay . '%');
        }

        if ($request->t_start_date) {
            $startDate = date('Y-m-d', strtotime($request->t_start_date));
            $homestays->where('t_start_date', '>=', $startDate);
        }

        if ($request->t_end_date) {
            $endDate = date('Y-m-d', strtotime($request->t_end_date));
            $homestays->where('t_end_date', '<=', $endDate);
        }

        if ($request->price) {
            $price = explode('-', $request->price);
            $homestays->whereBetween('t_price', [$price[0], $price[1]]);
        }

        $homestays = $homestays->orderBy('t_start_date')->paginate(NUMBER_PAGINATION_PAGE);

        $viewData = [
            'homestays' => $homestays
        ];
        return view('page.homestay.index', $viewData);
    }

    public function detail(Request $request, $id)
    {
        $homestay = HomeStay::with(['comments' => function ($query) use ($id) {
            $query->with(['user', 'replies' => function ($q) {
                $q->with('user')->limit(10);
            }])->where('cm_homestay_id', $id)->where('cm_status', '1')->limit(20)->orderByDesc('id');
        }])->find($id);

        if (!$homestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        $homestays = HomeStay::where('t_location_id', $homestay->t_location_id)->where('id', '<>', $id)->orderBy('id')->limit(NUMBER_PAGINATION_PAGE)->get();

        return view('page.homestay.detail', compact('homestay', 'homestays'));
    }

    public function bookHomeStay(Request $request, $id, $slug)
    {
        if (!Auth::guard('users')->check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt homestay');
        }
        $homestay = HomeStay::find($id);

        if (!$homestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        $user =  User::find(Auth::guard('users')->user()->id);

        return view('page.homestay.book', compact('homestay', 'user'));
    }

    public function postBookHomeStay(BookHomeStayRequest $request, $id)
    {
        $homestay = HomeStay::find($id);
        $numberUser = $request->b_number;
        if (($homestay->t_number_registered + $numberUser) > $homestay->t_room) {
            return redirect()->back()->with('error', 'Số lượng đăng ký đã vượt quá giới hạn');
        }

        DB::beginTransaction();
        try {
            $params = $request->except(['_token']);
            $user = Auth::guard('users')->user();
            $params['b_homestay_id'] = $id;
            $params['b_user_id'] = $user->id;
            $params['b_status'] = 1;
            $params['b_price'] = $homestay->t_price - ($homestay->t_price * $homestay->t_sale / 100);

            $book = BookHomeStay::create($params);
            if ($book) {
                $homestay->t_follow = $homestay->t_follow + $numberUser;
                $homestay->save();
            }
            DB::commit();
            $mail = $user->email;
            // Mail::send('emailtn', compact('book', 'homestay', 'user'), function ($email) use ($mail) {
            //     $email->subject('Thông tin xác nhận đơn Booking');
            //     $email->to($mail);
            // });
            return redirect()->route('page.home')->with('success', 'Cám ơn bạn đã đặt homestay chúng tôi sẽ liên hệ sớm để xác nhận.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
    public function loi()
    {

        return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
    }
}
