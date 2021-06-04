<?php

namespace App\Http\Controllers;

use App\ProsesJPPenunjang;
use App\Periode;

use Illuminate\Http\Request;
use DB;

class ProsesJPPenunjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        
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
     * @param  \App\ProsesJPPenunjang  $prosesJPPenunjang
     * @return \Illuminate\Http\Response
     */
    public function show(ProsesJPPenunjang $prosesJPPenunjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProsesJPPenunjang  $prosesJPPenunjang
     * @return \Illuminate\Http\Response
     */
    public function edit(ProsesJPPenunjang $prosesJPPenunjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProsesJPPenunjang  $prosesJPPenunjang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProsesJPPenunjang $prosesJPPenunjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProsesJPPenunjang  $prosesJPPenunjang
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProsesJPPenunjang $prosesJPPenunjang)
    {
        //
    }

    public function proses_upah_penunjang($id_periode)
    {
        $hasil = [];
        // $id_periode = 14;

        $data_penunjangs = DB::table('proses_perhitungan')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'proses_perhitungan.id_transaksi')
            ->where('transaksi.id_periode', $id_periode)
            ->where('proses_perhitungan.proses', 'Ke 4')
            ->where(function($query) {
                $query->where('proses_perhitungan.ket_kategori', '=', 'KATEGORI TINDAKAN');
                $query->orwhere('proses_perhitungan.ket_kategori', '=', 'GIZI');
            })
            ->select('*', DB::raw('SUM(proses_perhitungan.jumlah_jp) as total'))
            ->groupBy('proses_perhitungan.ket_kategori')
            ->get();

        foreach($data_penunjangs as $row) {
            $hasil['JASPEL'] = $row->total;
            $hasil['PM'] = ($row->total * 0.4) * 0.12;
            $hasil['IKU'] = ($row->total * 0.4) * 0.48;
            $hasil['IKI'] = ($row->total * 0.4) * 0.40;
        }

        $hasil_final = [];
        $penunjangs = DB::table('karyawan_penunjang')
            ->join('point_karyawan', 'point_karyawan.id_karyawan_penunjang', 'karyawan_penunjang.id_karyawan_penunjang')
            ->get();

        $total_iki = 0;
        $total_iku = 0;
        $total_pm = 0;

        foreach($penunjangs as $row) {
            $hasil_final[$row->id_karyawan_penunjang]['ID'] = $row->id_karyawan_penunjang;
            $hasil_final[$row->id_karyawan_penunjang]['ID_KATEGORI'] = $row->bagian;
            $hasil_final[$row->id_karyawan_penunjang]['NAMA'] = $row->nama;
            $hasil_final[$row->id_karyawan_penunjang]['KREDENTIAL'] = $row->kredential;
            $hasil_final[$row->id_karyawan_penunjang]['UNIT'] = $row->unit;
            $hasil_final[$row->id_karyawan_penunjang]['POSISI'] = $row->posisi;
            $hasil_final[$row->id_karyawan_penunjang]['IKU'] = $row->kredential + $row->unit + $row->posisi;            
            $hasil_final[$row->id_karyawan_penunjang]['PERFORMA'] = $row->performa;
            $hasil_final[$row->id_karyawan_penunjang]['DISIPIN'] = $row->disiplin;
            $hasil_final[$row->id_karyawan_penunjang]['KOMPLAIN'] = $row->komplain;
            $hasil_final[$row->id_karyawan_penunjang]['IKI'] = $row->performa + $row->disiplin + $row->komplain;        
            $hasil_final[$row->id_karyawan_penunjang]['PM'] = $row->pm;

            $total_iku += $hasil_final[$row->id_karyawan_penunjang]['IKU'];
            $total_iki += $hasil_final[$row->id_karyawan_penunjang]['IKI'];
            $total_pm += $hasil_final[$row->id_karyawan_penunjang]['PM'];
        }

        foreach($hasil_final as $row) {
            $hasil_final[$row['ID']]['UANG IKU'] = $row['IKU'] / $total_iku * $hasil['IKU'];
            $hasil_final[$row['ID']]['UANG IKI'] = $row['IKI'] / $total_iki * $hasil['IKI'];
            $hasil_final[$row['ID']]['UANG PM'] = $row['PM'] / $total_pm * $hasil['PM'];   
        }

        foreach($hasil_final as $row) {
            $proses_hitung_jp_penunjang = new ProsesJPPenunjang();
            $proses_hitung_jp_penunjang->iku = $hasil_final[$row['ID']]['UANG IKU'];
            $proses_hitung_jp_penunjang->iki = $hasil_final[$row['ID']]['UANG IKI'];
            $proses_hitung_jp_penunjang->pm = $hasil_final[$row['ID']]['UANG PM'];
            $proses_hitung_jp_penunjang->id_periode = $id_periode;
            $proses_hitung_jp_penunjang->id_kategori_tindakan = $hasil_final[$row['ID']]['ID_KATEGORI'];
            $proses_hitung_jp_penunjang->id_karyawan_penunjang = $hasil_final[$row['ID']]['ID'];
            $proses_hitung_jp_penunjang->created_at = now();
            $proses_hitung_jp_penunjang->updated_at = now();
            $proses_hitung_jp_penunjang->save();
        }
        

        // dd($hasil_final);
        return redirect('daftar_upah_karyawan_penunjang/'.$id_periode)->with('alert-success', 'Proses perhitungan telah berhasil!'); 
    }

    public function index_upah()
    {
        $data_periode = new Periode();
        $data_periodes = $data_periode->SelectPeriodeDESC();

        return view('karyawan_penunjang.upah.index', compact('data_periodes'));
    }

    public function daftar_upah_karyawan_penunjang($id_periode)
    {
        $data_periode = new Periode();
        $data_periodes = $data_periode->ShowPeriode($id_periode);

        $data_upah_penunjang = new ProsesJPPenunjang();
        $data_upah_penunjangs = $data_upah_penunjang->SelectDaftarUpahPenunjang($id_periode);

        return view('karyawan_penunjang.upah.upah', compact('data_upah_penunjangs', 'data_periodes'));
    }
}
