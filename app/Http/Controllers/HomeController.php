<?php

namespace App\Http\Controllers;

use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;
use App\Charts\DashboardBersihHarian;
use App\Charts\DashboardKotorHarian;
use App\Dao\Enums\TransactionType;
use App\Dao\Models\Bersih;
use App\Dao\Models\Transaksi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (auth()->check()) {
            return redirect()->route('login');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(DashboardKotorHarian $sebaran, DashboardBersihHarian $perbandingan)
    {
        if (auth()->check() && auth()->user()->active == false) {
            return redirect()->route('login');
        }

        $bersih = 0;
        $kotor = 0;
        $reject = 0;
        $rewash = 0;

        $date = date('Y-m-d');

        $rs_id = auth()->user()->rs_id;
        if ($rs_id) {

            $bersih = Bersih::where(Bersih::field_rs_id(), $rs_id)
                ->where(Bersih::field_report(), $date)
                ->where(Bersih::field_status(), TransactionType::BERSIH)
                ->count();

            $kotor = Transaksi::where(Transaksi::field_rs_ori(), $rs_id)
                ->whereDate(Transaksi::field_created_at(), $date)
                ->where(Transaksi::field_status_transaction(), TransactionType::KOTOR)
                ->count();

            $reject = Transaksi::where(Transaksi::field_rs_ori(), $rs_id)
                ->whereDate(Transaksi::field_created_at(), $date)
                ->where(Transaksi::field_status_transaction(), TransactionType::REJECT)
                ->count();

            $rewash = Transaksi::where(Transaksi::field_rs_ori(), $rs_id)
                ->whereDate(Transaksi::field_created_at(), $date)
                ->where(Transaksi::field_status_transaction(), TransactionType::REWASH)
                ->count();
        }

        return view('pages.home.home', [
            'sebaran' => $sebaran->build(),
            'perbandingan' => $perbandingan->build(),
            'kotor' => $kotor,
            'bersih' => $bersih,
            'reject' => $reject,
            'rewash' => $rewash
        ]);
    }

    public function console()
    {
        return LaravelWebConsole::show();
    }

    public function doc()
    {
        return view('doc');
    }

    public function error402()
    {
        return view('errors.402');
    }
}
