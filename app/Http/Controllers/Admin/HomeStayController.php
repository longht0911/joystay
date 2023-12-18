<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomeStay;
use App\Models\Location;
use App\Http\Requests\HomeStayRequest;
use Illuminate\Support\Facades\DB;
class HomeStayController extends Controller
{
    //
    protected $homestay;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(HomeStay $homestay, Location $location)
    {
        view()->share([
            'homestay_active' => 'active',
            'status' => $homestay::STATUS,
            'locations' => $location->where('l_status', 1)->get()
        ]);
        $this->homestay = $homestay;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $homestays = HomeStay::with('location');
        if ($request->t_title) {
            $homestays->where('t_title', 'like', '%'.$request->t_title.'%');
        }

        if ($request->t_start_date) {
            $startDate = date('Y-m-d', strtotime($request->t_start_date));
            $homestays->where('t_start_date', '>=', $startDate);
        }

        if ($request->t_end_date) {
            $endDate = date('Y-m-d', strtotime($request->t_end_date));
            $homestays->where('t_end_date', '<=', $endDate);
        }

        $homestays = $homestays->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.homestay.index', compact('homestays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.homestay.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeStayRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $this->homestay->createOrUpdate($request);
            DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $homestay = HomeStay::findOrFail($id);

        if (!$homestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.homestay.edit', compact('homestay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $this->homestay->createOrUpdate($request, $id);
            DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $homestay = HomeStay::find($id);
        if (!$homestay) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $homestay->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
}
