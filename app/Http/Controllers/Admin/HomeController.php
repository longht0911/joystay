<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Date;
use App\Models\Article;
use App\Models\User;
use App\Models\BookHomeStay;
use Illuminate\Support\Facades\DB;
use App\Models\HomeStay;


class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    protected $homestay;
    public function __construct()
    {
        view()->share([
            'home_active' => 'active',

        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  //
  $user = User::count();
  $article = Article::count();
  $bookhomestay = Bookhomestay::count();
  $homestay = HomeStay::count();

  // Thống kê trạng thái đơn hàng
  // Tiep nhan
  $transactionDefault = Bookhomestay::where('b_status',1)->select('id')->count();
  // Đã xác nhận
  $transactionProcess = Bookhomestay::where('b_status',2)->select('id')->count();
  // Thành công
  $transactionSuccess = Bookhomestay::where('b_status',3)->select('id')->count();
  // kết thúc
  $transactionFinish = Bookhomestay::where('b_status',4)->select('id')->count();
  //Cancel
  $transactionCancel = Bookhomestay::where('b_status',5)->select('id')->count();

  $statusTransaction = [
      [
          'Tiếp nhận' , $transactionSuccess, false
      ],
      [
          'Đã xác nhận' , $transactionProcess, false
      ],
      [
          'Đã thanh toán' , $transactionDefault, false
      ],
      [
          'Đã kết thúc' , $transactionFinish, false
      ],
      [
          'Huỷ bỏ' , $transactionCancel, false
      ]
  ];

  $month = $request->select_month ? $request->select_month : date('m');
  $year = $request->select_year ? $request->select_year : date('Y');
  $listDay = Date::getListDayInMonth($month, $year);

  //Thống kê số lượng người lớn hàng đặt homestay
  $revenueTransactionMonth = Bookhomestay::whereMonth('created_at', $month)->whereYear('created_at', $year)
      ->select(DB::raw('sum(b_number) as totalMoney'), DB::raw('DATE(created_at) day'))
      ->groupBy('day')
      ->get()->toArray();

  // Thống kê khối lượng trẻ em đặt homestay

  //thống kê doanh thu
  $money = Bookhomestay::where('b_status',3)->whereMonth('created_at', $month)->whereYear('created_at', $year)
  ->select(DB::raw('(sum(b_price*b_number)) as totalMoney'), DB::raw('DATE(created_at) day'))
  ->groupBy('day')
  ->get()->toArray();
  $arrmoney = [];
  $arrRevenueTransactionMonth = [];
  $arrRevenueTransactionMonthDefault = [];
  foreach($listDay as $day) {
      $total = 0;
      foreach ($revenueTransactionMonth as $key => $revenue) {
          if ($revenue['day'] ==  $day) {
              $total = $revenue['totalMoney'];
              break;
          }
      }

      $arrRevenueTransactionMonth[] = (int)$total;
      $total = 0;
      foreach ($money as $key => $revenue) {
          if ($revenue['day'] ==  $day) {
              $total = $revenue['totalMoney'];
              break;
          }
      }
      $arrmoney[] = (int)$total;
  }
  $homestays = homestay::orderByDesc('t_follow')->limit(3)->get();
  $viewData = [
      'user' => $user,
      'article' => $article,
      'bookhomestay' => $bookhomestay,
      'homestay' => $homestay,
      'homestays' => $homestays,
      'statusTransaction'          => json_encode($statusTransaction),
      'listDay'                    => json_encode($listDay),
      'arrRevenueTransactionMonth' => json_encode($arrRevenueTransactionMonth),
      'arrRevenueTransactionMonthDefault' => json_encode($arrRevenueTransactionMonthDefault),
      'arrmoney' => json_encode($arrmoney),
  ];
  return view('admin.home.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
