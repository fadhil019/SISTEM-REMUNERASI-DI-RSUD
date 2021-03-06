@extends('layouts.index')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header mb-n3">
    @if(\Session::has('alert-success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('alert-success')}}
        </div>
    @endif
    @if(\Session::has('alert-failed'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('alert-failed')}}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="row pt-2 mb-2">
                <div class="col-sm-6">
                    <h1>Daftar upah karyawan admin periode <br>({{ $data_periodes->bulan }} - {{ $data_periodes->tahun }})</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-12">
        <input type="hidden" value="{{ $no = 1 }}">
        <div class="card">
            <div class="card-header">
                <div class="row pt-2 mb-2">
                    <div class="col-sm-6">
                        <!-- <h4>Daftar nama dokter</h4> -->
                        <span>*klik pada nama karyawan untuk melihat detail</span>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2" id="tombol_pdf_dokter"></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable_pdf_dokter" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <!-- <th>Kreed</th>
                            <th>Unit</th>
                            <th>Posisi</th>
                            <th>Performa</th>
                            <th>Disiplin</th>
                            <th>Komplain</th>
                            <th>PM</th> -->
                            <th>IKU</th>
                            <th>IKI</th>
                            <th>PM</th>
                            <th>Total Upah jasa Pelayanan</th>
                            <!-- <th>Tindakan</th> -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <!-- <th>Kreed</th>
                            <th>Unit</th>
                            <th>Posisi</th>
                            <th>Performa</th>
                            <th>Disiplin</th>
                            <th>Komplain</th>
                            <th>PM</th> -->
                            <th>IKU</th>
                            <th>IKI</th>
                            <th>PM</th>
                            <th>Total Upah jasa Pelayanan</th>
                            <!-- <th>Tindakan</th> -->
                        </tr>
                    </tfoot>
                    <tbody>
                        @for($i=0; $i < count($data_upah_admins); $i++)
                            <tr>
                                <td>{{ ($i+1) }}</td>
                                <td><a href="{{ url('detail_upah_karyawan_admin/'. $data_periodes->id_periode . '/' . $data_upah_admins[$i]['id_karyawan_admin']) }}" class="text-dark">{{ $data_upah_admins[$i]['nama'] }}</a></td>
                                <!-- <td>{{ $data_upah_admins[$i]['kredential'] }}</td>
                                <td>{{ $data_upah_admins[$i]['unit'] }}</td>
                                <td>{{ $data_upah_admins[$i]['posisi'] }}</td>
                                <td>{{ $data_upah_admins[$i]['performa'] }}</td>
                                <td>{{ $data_upah_admins[$i]['disiplin'] }}</td>
                                <td>{{ $data_upah_admins[$i]['komplain'] }}</td>
                                <td>{{ $data_upah_admins[$i]['pm'] }}</td> -->
                                <td>Rp. {{ number_format($data_upah_admins[$i]['iku'],2,",",".") }}</td>
                                <td>Rp. {{ number_format($data_upah_admins[$i]['iki'],2,",",".") }}</td>
                                <td>Rp. {{ number_format($data_upah_admins[$i]['pm_proses'],2,",",".") }}</td>
                                <td>Rp. {{ number_format($data_upah_admins[$i]['iku'] + $data_upah_admins[$i]['iki'] + $data_upah_admins[$i]['pm_proses'],2,",",".") }}</td>
                                <!-- <td>
                                    <a href="#"  class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> Ubah</a>
                                </td> -->
                            </tr>
                        @endfor
                    </tbody> 
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('script')

@endsection