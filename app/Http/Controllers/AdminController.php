<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Booking;
use App\Pengeluaran;
use Datetime;

class AdminController extends Controller
{
    //
    //$countUser = User::count();
    public function index()
    {
        $first = new Datetime(date("Y-m-01"));
        $last = date("Y-m-t");
        $month = date('m');
        $year = date('Y');


        $data['title'] = "Dashboard";

        $data['user'] = User::count();
        $data['bulan_ini'] = Booking::where('status','!=','batal')->whereBetween('created_at',[$first,$last])->count();
        $data['total'] = Booking::count();
        $data['gagal'] = Booking::where('status','=','batal')->count();
        /*$arr = [
            'title'=>$title,
            'user'=>$hitung_user,
            'bulan_ini'=>$hitung_bulan_ini,
            'total'=>$hitung_total,
            'gagal'=>$booking_gagal
        ];*/

        

        for ($x = 1; $x <= 12; $x++) {
            $data['masuk'][$x] = Booking::whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $x)
                        ->where('status', '=', 'lunas')
                        ->sum('total_harga');
            $data['keluar'][$x] = Pengeluaran::whereYear('tanggal', '=', $year)
                        ->whereMonth('tanggal', '=', $x)
                        ->sum('total');
        }

        $data['pemasukan'] = Booking::whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where('status', '=', 'lunas')
                        ->sum('total_harga');
        $data['pengeluaran'] = Pengeluaran::whereYear('tanggal', '=', $year)
                        ->whereMonth('tanggal', '=', $month)
                        ->sum('total');
        //dd($data);
        //return view('admin.dashboard', $arr);
        return view('admin.dashboard', $data);
        //return view('admin.dashboard', compact('arr','chart_pn'));
    }
}
