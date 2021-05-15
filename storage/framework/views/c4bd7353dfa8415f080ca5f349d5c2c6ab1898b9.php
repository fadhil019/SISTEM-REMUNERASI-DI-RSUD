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
                    <h1>Daftar perhitungan ruangan rawat jalan periode " <?php echo e($data_periodes->bulan); ?> - <?php echo e($data_periodes->tahun); ?> "</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-12">
        <input type="hidden" value="<?php echo e($no = 1); ?>">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            
                            
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            
                            
                            <th>Tindakan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $__currentLoopData = $data_ruangans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data_ruangan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data_ruangan->kategori_ruangan == "Rawat jalan"): ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td><?php echo e($data_ruangan->nama_ruangan); ?></td>
                                    
                                    
                                    <td>
                                        <a href="<?php echo e(url('show_proses_perhitungan_rawat_jalan/'.$data_periodes->id_periode.'/'.$data_ruangan->id_ruangan)); ?>" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> Pilih ruangan</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT\KERJAAN\TA-FADHIL\resources\views/pasien/p_rawat_jalan_kd/ruangan_p_rawat_jalan.blade.php ENDPATH**/ ?>