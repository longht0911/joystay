<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateInfoAccountRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Models\BookHomeStay;
use App\Models\HomeStay;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function __construct(BookHomeStay $bookhomestay)
    {
        view()->share([
            'status' => $bookhomestay::STATUS,
            'classStatus' => $bookhomestay::CLASS_STATUS,
        ]);
    }
    //
    public function infoAccount()
    {
        $user = Auth::guard('users')->user();
        return view('page.auth.account', compact('user'));
    }

    public function updateInfoAccount(UpdateInfoAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;

            if (isset($request->images) && !empty($request->images)) {
                $image = upload_image('images');
                if ($image['code'] == 1)
                    $user->avatar = $image['name'];
            }

            $user->save();
            DB::commit();
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể cập nhật tài khoản');
        }
    }

    public function changePassword()
    {
        return view('page.auth.change_password');
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            DB::commit();
            Auth::guard('users')->logout();
            return redirect()->route('page.user.account')->with('success', 'Đổi mật khẩu thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể đổi mật khẩu');
        }
    }


    public function cancelhomestay($id)
    {
        DB::beginTransaction();
        try {

            DB::commit();

            return response([
                'status_code' => 200,
                'message' => 'Hủy thành công',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            $code = 404;
            return response([
                'status_code' => $code,
                'message' => 'Không thể hủy',
            ]);
        }
    }

    public function myhomestay()
    {
        $user = Auth::guard('users')->user();
        $bookhomestays = BookHomeStay::with(['homestay'])->where('b_user_id', $user->id)->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
        return view('page.auth.my_homestay', compact('bookhomestays'));
    }

    public function updateStatus(Request $request, $status, $id)
    {
        $bookhomestay = BookHomeStay::find($id);
        $numberUser = $bookhomestay->b_number;
        if (!$bookhomestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        DB::beginTransaction();
        if ($status != $bookhomestay->b_status) {
            try {
                $bookhomestay->b_status = $status;
                if ($bookhomestay->save()) {
                    if ($status == 5) {
                        $homestay = HomeStay::find($bookhomestay->b_homestay_id);
                        $numberRegistered = $homestay->t_number_registered - $numberUser;
                        $homestay->t_number_registered = $numberRegistered > 0 ? $numberRegistered : 0;
                        $homestay->save();
                    }
                }
                $homestay = HomeStay::find($bookhomestay->b_homestay_id);
                $user = User::find($bookhomestay->b_user_id);
                $mailuser = $user->email;
                Mail::send('emailhuy', compact('user', 'bookhomestay', 'homestay'), function ($email) use ($mailuser) {
                    $email->subject('Xác nhận HUỶ BOOKING');
                    $email->to($mailuser);
                });
                DB::commit();

                return response([
                    'status_code' => 200,
                    'message' => 'Hủy thành công',
                ]);
            } catch (\Exception $exception) {
                DB::rollBack();
                $code = 404;
                return response([
                    'status_code' => $code,
                    'message' => 'Không thể hủy',
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Trạng thái đã tồn tại');
        }
    }
}
