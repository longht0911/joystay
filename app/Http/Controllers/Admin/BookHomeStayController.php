<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookHomeStay;
use App\Models\HomeStay;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class BookHomeStayController extends Controller
{

    protected $bookhomestay;

    public function __construct(BookHomeStay $bookhomestay,HomeStay $homestay)
    {
        view()->share([
            'book_homestay_active' => 'active',
            'status' => $bookhomestay::STATUS,
            'classStatus' => $bookhomestay::CLASS_STATUS,
            'homestays' => $homestay::get(),
        ]);
        $this->bookhomestay = $bookhomestay;
    }
    //
    public function index(Request $request)
    {
        $bookhomestays = BookHomeStay::with(['homestay', 'user']);


        if ($request->name_homestay) {
            $namehomestay = $request->name_homestay;
            $bookhomestays->whereIn('b_homestay_id', function ($q) use ($namehomestay) {
                $q->from('homestays')
                    ->select('id')
                    ->where('t_title', 'like', '%'.$namehomestay.'%');
            });
        }

        if ($request->b_homestay_id) {
            $bookhomestays->where('b_homestay_id', $request->b_homestay_id);

        }
        if ($request->b_name) {
            $bookhomestays->where('b_name', 'like', '%'.$request->b_name.'%');
        }
        if ($request->b_email) {
            $bookhomestays->where('b_email', $request->b_email);
        }

        if ($request->b_phone) {
            $bookhomestays->where('b_phone', $request->b_phone);
        }

        $bookhomestays = $bookhomestays->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
        return view('admin.book_homestay.index', compact('bookhomestays'));
    }

    public function delete($id)
    {
        $bookhomestay = BookHomeStay::find($id);
        if (!$bookhomestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $bookhomestay->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

    public function updateStatus(Request $request, $status, $id)
    {
        $bookhomestay = BookHomeStay::find($id);
        $numberUser = $bookhomestay->b_number;
        if (!$bookhomestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    $temp= $bookhomestay->b_status;
        DB::beginTransaction();
        if($status != $bookhomestay->b_status && $status > $bookhomestay->b_status ){
        try {
            $bookhomestay->b_status = $status;

            if ($bookhomestay->save()) {
                if($status == 4 && $temp !=3){
                    return redirect()->back()->with('error', 'thao tác lỗi');
                }
                if ($status == 5 ) {
                    if($temp ==4 ) {
                        return redirect()->back()->with('error', 'Thao tác sai');
                    }
                    if($temp==1){
                        $homestay = Homestay::find($bookhomestay->b_homestay_id);
                    $homestay->t_follow= $homestay->t_follow - $numberUser;
                    $homestay->save();
                    $user = User::find($bookhomestay->b_user_id);
                    $mailuser =$user->email;
                    Mail::send('emailhuy',compact('user','bookhomestay','homestay'),function($email) use($mailuser){
                        $email->subject('Xác nhận HUỶ BOOKING');
                        $email->to($mailuser);
                    });
                    }else {
                        $homestay = Homestay::find($bookhomestay->b_homestay_id);
                    $homestay->t_number_registered = $homestay->t_number_registered - $numberUser;
                    $homestay->save();
                    $user = User::find($bookhomestay->b_user_id);
                    $mailuser =$user->email;
                    Mail::send('emailhuy',compact('user','bookhomestay','homestay'),function($email) use($mailuser){
                        $email->subject('Xác nhận HUỶ BOOKING');
                        $email->to($mailuser);
                    });
                    }

                }
                if($status==3){

                    if($temp == 2) {
                        $homestay = Homestay::find($bookhomestay->b_homestay_id);
                        $user = User::find($bookhomestay->b_user_id);
                        $mailuser =$user->email;
                        Mail::send('emailtt',compact('user','bookhomestay','homestay'),function($email) use($mailuser){
                            $email->subject('Xác nhận thanh toán');
                            $email->to($mailuser);
                        });
                    }
                    if($temp == 1) {

                        $homestay = Homestay::find($bookhomestay->b_homestay_id);
                        $homestay->t_number_registered = $homestay->t_number_registered + $numberUser;
                        $homestay->t_follow = $homestay->t_follow - $numberUser;
                        $homestay->save();
                        $user = User::find($bookhomestay->b_user_id);
                        $mailuser =$user->email;
                        Mail::send('emailtt',compact('user','bookhomestay','homestay'),function($email) use($mailuser){
                            $email->subject('Xác nhận thanh toán');
                            $email->to($mailuser);
                        });
                    }

                }
                if($status==2  ){

                    $homestay = Homestay::find($bookhomestay->b_homestay_id);
                    $homestay->t_number_registered = $homestay->t_number_registered + $numberUser;
                    $homestay->t_follow = $homestay->t_follow - $numberUser;
                    $homestay->save();
                    $user = User::find($bookhomestay->b_user_id);
                    $mailuser =$user->email;
                    Mail::send('email',compact('user','bookhomestay','homestay'),function($email) use($mailuser){
                        $email->subject('Xác nhận booking');
                        $email->to($mailuser);
                    });
                }
            }

            DB::commit();
            return redirect()->route('book.homestay.index')->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }else {
        return redirect()->back()->with('error', 'Lỗi thao tác');
    }
    }
}
