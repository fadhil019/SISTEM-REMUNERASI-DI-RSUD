<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use DB;
use PDF;

use App\User;
use App\Periode;
use App\Ruangan;
use App\KategoriTindakan;

class RekapData extends Model
{
    public function SelectRekapDataDokterPerPeriode($id){
        $data_dokter = DB::table('dokter')
        ->orderby('dokter.id_dokter', 'ASC')
        ->get();

        $hasil = [];
        $i = 0;
        
        foreach($data_dokter as $row){
            $hasil[$i]['id_dokter'] = $row->id_dokter;
            $hasil[$i]['nama_dokter'] = $row->nama_dokter;
            $data_proses_perhitungan_id_dokter = DB::table('proses_perhitungan')
            ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->where('transaksi.id_periode', '=', $id)
            ->where('proses_perhitungan.id_dokter', '=', $row->id_dokter)
            ->where('proses_perhitungan.proses', '=', 'Ke 4')
            ->get();
            
            $tmp_upah_jasa = 0;
            foreach($data_proses_perhitungan_id_dokter as $row_perhitungan){
                $tmp_upah_jasa += $row_perhitungan->jumlah_jp;
            }

            $tmp_upah_jasa_kat = 0;
            if(isset($row->id_kategori_tindakan))
            {
                $data_proses_perhitungan_id_kat_dokter = DB::table('proses_perhitungan')
                ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->where('transaksi.id_periode', '=', $id)
                ->where('proses_perhitungan.id_kategori_tindakan', '=', $row->id_kategori_tindakan)
                ->where('proses_perhitungan.proses', '=', 'Ke 4')
                ->get();
                
                foreach($data_proses_perhitungan_id_kat_dokter as $row_perhitungan_kat_dokter){
                    $tmp_upah_jasa_kat += $row_perhitungan_kat_dokter->jumlah_jp;
                }
            }

            // $data_proses_perhitungan_jtl = DB::table('proses_perhitungan')
            // ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            // ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            // ->where('transaksi.id_periode', '=', $id)
            // ->where('proses_perhitungan.proses', '=', 'Ke 4')
            // ->get();
            // foreach($data_proses_perhitungan_jtl as $row_perhitungan_jtl){
            //     $hasil[$i]['tmp_jtl'][$row_perhitungan_jtl->id_proses_perhitungan] = $row_perhitungan_jtl->jumlah_jp;
            // }
            // $tmp_jasa_jtl = 0;
            // foreach($hasil[$i]['tmp_jtl'] as $row) {
            //     $tmp_jasa_jtl += $row;
            // }
            // $hasil[$i]['upah_jasa'] = $tmp_upah_jasa + ($tmp_jasa_jtl * 0.15);
            $hasil[$i]['upah_jasa'] = $tmp_upah_jasa + $tmp_upah_jasa_kat;
            // $tmp_upah_jasa = 0;
            $i++;
        }
        // dd($hasil);
        return $hasil;
    }

    public function DetailRekapDataDokterPerPeriode($id, $id_karyawan){
        $data_dokter = DB::table('dokter')
        ->where('dokter.id_dokter', $id_karyawan)
        ->orderby('dokter.id_dokter', 'ASC')
        ->get();

        $hasil = [];
        $i = 0;
        
        foreach($data_dokter as $row){
            $hasil[$i]['id_dokter'] = $row->id_dokter;
            $hasil[$i]['id_kategori_tindakan'] = $row->id_kategori_tindakan; 
            if(isset($row->id_kategori_tindakan))
            {
                $kat_tindakan_detail = KategoriTindakan::find($row->id_kategori_tindakan);
                $hasil[$i]['nama_kategori_tindakan'] = $kat_tindakan_detail->nama;
            }
            $hasil[$i]['nama_dokter'] = $row->nama_dokter;
            $data_proses_perhitungan_id_dokter = DB::table('proses_perhitungan')
            ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->where('transaksi.id_periode', '=', $id)
            ->where('proses_perhitungan.id_dokter', '=', $row->id_dokter)
            ->where('proses_perhitungan.proses', '=', 'Ke 4')
            ->get();
            
            foreach($data_proses_perhitungan_id_dokter as $row_perhitungan){
                $ruangan = Ruangan::find($row_perhitungan->id_ruangan);
                $hasil[$i]['tmp_ruangan'][$row_perhitungan->id_proses_perhitungan]= $row_perhitungan->jumlah_jp;
                $hasil[$i]['ruangan'][$ruangan->nama_ruangan] = $row_perhitungan->jumlah_jp;
            }

            if(isset($row->id_kategori_tindakan))
            {
                $data_proses_perhitungan_id_kat_dokter = DB::table('proses_perhitungan')
                ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->where('transaksi.id_periode', '=', $id)
                ->where('proses_perhitungan.id_kategori_tindakan', '=', $row->id_kategori_tindakan)
                ->where('proses_perhitungan.proses', '=', 'Ke 4')
                ->get();
                
                foreach($data_proses_perhitungan_id_kat_dokter as $row_perhitungan_kat_dokter){
                    $hasil[$i]['tmp_kategori_tindakan'][$row_perhitungan_kat_dokter->id_proses_perhitungan]= $row_perhitungan_kat_dokter->jumlah_jp;
                }
            }

            $tmp_jasa_ruangan = 0;
            $tmp_jasa_kategori = 0;
            $tmp_jasa_jtl = 0;
            if(isset($hasil[$i]['tmp_kategori_tindakan']))
            {
                foreach($hasil[$i]['tmp_kategori_tindakan'] as $row) {
                    $tmp_jasa_kategori += $row;
                }
            }
            if(isset($hasil[$i]['tmp_ruangan']))
            {
                foreach($hasil[$i]['tmp_ruangan'] as $row) {
                    $tmp_jasa_ruangan += $row;
                }
            }

            
            $hasil[$i]['upah_jasa_total'] = $tmp_jasa_kategori + $tmp_jasa_ruangan;
            $hasil[$i]['upah_jasa_kategori'] = $tmp_jasa_kategori;
            $i++;
        }
        
        // dd($hasil);
        return $hasil;
    }

    public function SelectRekapDataKategoriTindakanPerPeriode($id){
        $data_kategori_tindakan = DB::table('kategori_tindakan')
        ->where('kategori_tindakan.kategori_data', '=', 'Penunjang')
        ->orderby('kategori_tindakan.id_kategori_tindakan', 'ASC')
        ->get();

        $hasil = [];
        $i = 0;
        
        foreach($data_kategori_tindakan as $row){
            $hasil[$i]['id_kategori_tindakan'] = $row->id_kategori_tindakan;
            $hasil[$i]['nama_kategori_tindakan'] = $row->nama;
            $hasil[$i]['bagian_kategori_tindakan'] = $row->kategori_data;
            $tmp_upah_jasa = 0;
            if($row->nama == 'GIZI')
            {
                $data_proses_perhitungan = DB::table('proses_perhitungan')
                ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->where('transaksi.id_periode', '=', $id)
                ->where('proses_perhitungan.ket_kategori', '=', 'GIZI')
                ->where('proses_perhitungan.proses', '=', 'Ke 4')
                ->get();
                
                foreach($data_proses_perhitungan as $row_perhitungan){
                    $tmp_upah_jasa += $row_perhitungan->jumlah_jp;
                }
            }
            else
            {
                $data_proses_perhitungan = DB::table('proses_perhitungan')
                ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->where('transaksi.id_periode', '=', $id)
                ->where('proses_perhitungan.id_kategori_tindakan', '=', $row->id_kategori_tindakan)
                ->where('proses_perhitungan.proses', '=', 'Ke 4')
                ->get();
                
                foreach($data_proses_perhitungan as $row_perhitungan){
                    $tmp_upah_jasa += $row_perhitungan->jumlah_jp;
                }
            }
            // $data_proses_perhitungan_jtl = DB::table('proses_perhitungan')
            // ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            // ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            // ->where('transaksi.id_periode', '=', $id)
            // ->where('proses_perhitungan.proses', '=', 'Ke 4')
            // ->get();
            // foreach($data_proses_perhitungan_jtl as $row_perhitungan_jtl){
            //     $hasil[$i]['tmp_jtl'][$row_perhitungan_jtl->id_proses_perhitungan] = $row_perhitungan_jtl->jumlah_jp;
            // }
            // $tmp_jasa_jtl = 0;
            // foreach($hasil[$i]['tmp_jtl'] as $row) {
            //     $tmp_jasa_jtl += $row;
            // }
            // $hasil[$i]['upah_jasa'] = $tmp_upah_jasa + ($tmp_jasa_jtl * 0.15);
            $hasil[$i]['upah_jasa'] = $tmp_upah_jasa;
            $i++;
        }
        // $jmlh_kat_tindakan = $this->SelectRekapDataKategoriTindakanPerPeriode($id);
        // $jmlh_kat_ruangan = $this->SelectRekapDataRuanganPerPeriode($id);
        // $jmlh_kat_admin = $this->SelectRekapDataAdminRemuPerPeriode($id);
        //dd($hasil);
        //dd($data_kategori_tindakan);
        return $hasil;
    }

    public function SelectRekapDataRuanganPerPeriode($id){
        $data_ruangan = DB::table('ruangan')
        ->orderby('ruangan.id_ruangan', 'ASC')
        ->get();

        $hasil = [];
        $index = 0;
        
        foreach($data_ruangan as $row){
            $hasil[$index]['id_ruangan'] = $row->id_ruangan;
            $hasil[$index]['nama_ruangan'] = $row->nama_ruangan;
            $hasil[$index]['bagian'] = 'Perawat';
            
            $data_proses_perhitungan_rpp = DB::table('proses_perhitungan')
            ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
            ->where('transaksi.id_periode', '=', $id)
            // ->where('proses_perhitungan.id_ruangan', '=', $row->id_ruangan)
            ->where('proses_perhitungan.ket_kategori', '=', 'PERAWAT '.$row->nama_ruangan)
            ->where('proses_perhitungan.proses', '=', 'Ke 4')
            ->get();
            $tmp_upah_jasa = 0;
            foreach($data_proses_perhitungan_rpp as $row_perhitungan){
                $tmp_upah_jasa += $row_perhitungan->jumlah_jp;
            }           
            $hasil[$index]['upah_jasa'] = $tmp_upah_jasa; 
            $index++;
        }
        $i = 0;
        $data_proses_perhitungan_jtl = DB::table('data_keuangan_pasien')
        ->where('id_periode', '=', $id)
        ->get();
        foreach($data_proses_perhitungan_jtl as $row_perhitungan_jtl){
            $hasil[$i]['tmp_jtl'][$row_perhitungan_jtl->id_data_keuangan_pasien] = $row_perhitungan_jtl->nominal_uang;
            
        }
        $tmp_jasa_jtl = 0;
        foreach($hasil[$i]['tmp_jtl'] as $row) {
            $tmp_jasa_jtl += $row;
        }
        $i++;

        // dd($hasil);
        return $hasil;
    }

    public function SelectRekapDataAdminRemuPerPeriode($id){
        $hasil = [];
        $arr_bagian_admin = ['Admin umum', 'Admin rekam medis', 'Struktural'];
        $index = 0;
        
        foreach($arr_bagian_admin as $val) 
        {
            if($val == "Admin rekam medis") {
                $hasil[$index]['nama_kategori'] = $val;
                $hasil[$index]['bagian'] = $val;
                $data_keuangan_pasien = DB::table('data_keuangan_pasien')
                ->select('nominal_uang')
                ->join('periode', 'periode.id_periode', '=', 'data_keuangan_pasien.id_periode')
                ->where('data_keuangan_pasien.id_periode', '=', $id)
                ->orderby('data_keuangan_pasien.id_data_keuangan_pasien', 'ASC')
                ->get();
                $tmp_nominal_uang = 0;
                foreach($data_keuangan_pasien as $row_data_keuangan){
                    $tmp_nominal_uang += $row_data_keuangan->nominal_uang;
                }
                $tmp_upah_jasa = 0;
                    
                $data_proses_perhitungan = DB::table('proses_perhitungan')
                ->join('data_pasien', 'data_pasien.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->join('transaksi', 'transaksi.id_data_pasien', '=', 'proses_perhitungan.id_data_pasien')
                ->where('transaksi.id_periode', '=', $id)
                ->where('proses_perhitungan.ket_kategori', '=', 'ADM')
                ->where('proses_perhitungan.proses', '=', 'Ke 4')
                ->get();
                foreach($data_proses_perhitungan as $row_perhitungan){
                    $tmp_upah_jasa += $row_perhitungan->jumlah_jp;
                }
        
                
                $hasil[$index]['upah_jasa'] = $tmp_upah_jasa;
            }
            else
            {
                $hasil[$index]['nama_kategori'] = $val;
                $hasil[$index]['bagian'] = $val;
                $i = 0;
                $data_proses_perhitungan_jtl = DB::table('data_keuangan_pasien')
                ->where('id_periode', '=', $id)
                ->get();
                foreach($data_proses_perhitungan_jtl as $row_perhitungan_jtl){
                    $hasil[$i]['tmp_jtl'][$row_perhitungan_jtl->id_data_keuangan_pasien] = $row_perhitungan_jtl->nominal_uang;
                    
                }
                $tmp_jasa_jtl = 0;
                foreach($hasil[$i]['tmp_jtl'] as $row) {
                    $tmp_jasa_jtl += $row;
                }
                $i++;
                if($val == "Struktural")
                {
                    $hasil[$index]['upah_jasa'] = $tmp_jasa_jtl * 0.1;
                }
                else
                {
                    $hasil[$index]['upah_jasa'] = $tmp_jasa_jtl * 0.05;
                }
            }
            $index++;
        }
        // dd($hasil);
        // admin rekam medis = adm proses k4
        // admin umum = (sum(data_keuangan) * 0.05)
        // admin stuktural = (sum(data_keuangan) * 0.1)
        // jtl = (sum(data_keuangan) * 0.15)
        return $hasil;
    }

    public function tampungJTL($id) {
        $hasil = [];
        $data_proses_perhitungan_jtl = DB::table('data_keuangan_pasien')
        ->where('id_periode', '=', $id)
        ->get();
        foreach($data_proses_perhitungan_jtl as $row_perhitungan_jtl){
            $hasil['tmp_jtl'][$row_perhitungan_jtl->id_data_keuangan_pasien] = $row_perhitungan_jtl->nominal_uang;
            
        }
        $tmp_jasa_jtl = 0;
        foreach($hasil['tmp_jtl'] as $row) {
            $tmp_jasa_jtl += $row;
        }
        
        $jmlh_kat_ruangan = $this->SelectRekapDataRuanganPerPeriode($id);
        $tmp_jmlh_kat_ruangan = 0;
        for ($i=0; $i < count($jmlh_kat_ruangan); $i++) { 
            if($jmlh_kat_ruangan[$i]['upah_jasa'] > 0)
            {
                $tmp_jmlh_kat_ruangan ++;
            }
        }

        $jmlh_kat_kategori_tindakan = $this->SelectRekapDataKategoriTindakanPerPeriode($id);
        $tmp_jmlh_kategori_tindakan = 0;
        for ($i=0; $i < count($jmlh_kat_kategori_tindakan); $i++) { 
            if($jmlh_kat_kategori_tindakan[$i]['upah_jasa'] > 0)
            {
                $tmp_jmlh_kategori_tindakan ++;
            }
        }

        $jmlh_kat_admin = $this->SelectRekapDataKategoriTindakanPerPeriode($id);
        $tmp_jmlh_kat_admin = 0;
        for ($i=0; $i < count($jmlh_kat_admin); $i++) { 
            if($jmlh_kat_admin[$i]['upah_jasa'] > 0)
            {
                $tmp_jmlh_kat_admin ++;
            }
        }
        $hasil['JTL'][0]['nama_kategori'] = 'JTL';
        $hasil['JTL'][0]['bagian'] = 'JTL';
        $hasil['JTL'][0]['upah_jasa'] = ($tmp_jasa_jtl * 0.15) / ($tmp_jmlh_kat_admin + $tmp_jmlh_kat_ruangan + $tmp_jmlh_kategori_tindakan);
        // dd($hasil['JTL'][0]['upah_jasa']);
        return $hasil;
    }

    public function createPDF() {
        // retreive all records from db
        $data = Employee::all();
  
        // share data to view
        view()->share('employee',$data);
        $pdf = PDF::loadView('pdf_view', $data);
  
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }
}
