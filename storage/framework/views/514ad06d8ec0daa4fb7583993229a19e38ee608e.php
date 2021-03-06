<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header mb-n3">
    <?php if(\Session::has('alert-success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('alert-success')); ?>

        </div>
    <?php endif; ?>
    <?php if(\Session::has('alert-failed')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('alert-failed')); ?>

        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <div class="row pt-2 mb-2">
                <div class="col">
                    <h1>Rekap data periode " <?php echo e($data_periodes->bulan); ?> - <?php echo e($data_periodes->tahun); ?> "</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="mr-2"><a href="#" data-toggle="modal" data-target="#create_data" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</a></li>
                    </ol>
                </div> -->
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="row">
        <div class="col-12">
        <input type="hidden" value="<?php echo e($no = 1); ?>">
        <div class="card">
            <div class="card-header">
                <div class="row pt-2 mb-2">
                    <div class="col-sm-6">
                        <h4>Daftar nama dokter</h4>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama dokter</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama dokter</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php for($i=0; $i < count($rekap_data_dokters); $i++): ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td><?php echo e($rekap_data_dokters[$i]['nama_dokter']); ?></td>
                                <td><?php echo e($rekap_data_dokters[$i]['upah_jasa']); ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody> 
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12">
        <input type="hidden" value="<?php echo e($no = 1); ?>">
        <div class="card">
            <div class="card-header">
                <div class="row pt-2 mb-2">
                    <div class="col-sm-6">
                        <h4>Daftar kategori lainnya</h4>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php for($i=0; $i < count($rekap_data_kategori_tindakans); $i++): ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td><?php echo e($rekap_data_kategori_tindakans[$i]['nama_kategori_tindakan']); ?></td>
                                <td><?php echo e($rekap_data_kategori_tindakans[$i]['bagian_kategori_tindakan']); ?></td>
                                <td><?php echo e($rekap_data_kategori_tindakans[$i]['upah_jasa']); ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody> 
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12">
        <input type="hidden" value="<?php echo e($no = 1); ?>">
        <div class="card">
            <div class="card-header">
                <div class="row pt-2 mb-2">
                    <div class="col-sm-6">
                        <h4>Daftar ruangan</h4>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable3" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php for($i=0; $i < count($rekap_data_ruangans); $i++): ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td><?php echo e($rekap_data_ruangans[$i]['nama_ruangan']); ?></td>
                                <td><?php echo e($rekap_data_ruangans[$i]['bagian']); ?></td>
                                <td><?php echo e($rekap_data_ruangans[$i]['upah_jasa']); ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody> 
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12">
        <input type="hidden" value="<?php echo e($no = 1); ?>">
        <div class="card">
            <div class="card-header">
                <div class="row pt-2 mb-2">
                    <div class="col-sm-6">
                        <h4>Daftar admin remunerasi</h4>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable4" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama kategori</th>
                            <th>Bagian</th>
                            <th>Upah jasa pelayanan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><?php echo e($rekap_data_admin_remus['nama_kategori']); ?></td>
                            <td><?php echo e($rekap_data_admin_remus['bagian']); ?></td>
                            <td><?php echo e($rekap_data_admin_remus['upah_jasa']); ?></td>
                        </tr>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT\KERJAAN\TA-FADHIL-NEW\resources\views/rekap_data/daftar_rekap_data.blade.php ENDPATH**/ ?>