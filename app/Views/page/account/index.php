<?= $this->extend('layout.php') ?>

<?= $this->section('script') ?>
<!-- datatable -->
<script src="<?= base_url('js/datatables.min.js') ?>"></script>
<script>
    $('#account-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<!-- datatable -->
<link rel="stylesheet" href="<?= base_url('css/datatables.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--
        Requirement about account management
        1. Account mirror will be provided as table account in trx schema
        2. Account act as server microservice, and need to register to the assets meta
        3. Metadata have data as
         - name of the service (trx)
         - sitename (trx)
         - access_key (trx)
         - site_url (all below will be meta)
         - site_name
         - site_desc
         - site_port
         - bandwidth (optional)
         - quota
         - user_id (relative to the trx)
         - date_created
         - date_updated
    -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Register New Account Access</h3>
                </div>
                <form action="<?= base_url('account/save')?>" method="POST">
                    <div class="card-body">
                        <?= csrf_field()?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name">
                                </div>
                                <div class="form-group">
                                    <label for="site_url">Site URL</label>
                                    <input type="text" class="form-control" id="site_url" name="site_url">
                                </div>
                                <div class="form-group">
                                    <label for="site_desc">Site Description</label>
                                    <input type="text" class="form-control" id="site_desc" name="site_desc">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="site_port">Site Port</label>
                                    <input type="number" class="form-control" id="site_port" name="site_port">
                                </div>
                                <div class="form-group">
                                    <label for="bandwidth">Bandwidth</label>
                                    <input type="number" class="form-control" id="bandwidth" name="bandwidth">
                                </div>
                                <div class="form-group">
                                    <label for="quota">Quota</label>
                                    <input type="number" class="form-control" id="quota" name="quota">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <button type="submit" class="btn btn-primary text-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Accounts List Data</h3>
                </div>
                <div class="card-body">
                    <table id="account-table" class="table table-bordered table-hover" style="max-width: 100%;">
                        <thead>
                            <tr>
                                <th width="5">No.</th>
                                <th width="10">Name</th>
                                <th width="15">Site Name</th>
                                <th width="5">Access Key</th>
                                <th width="20">Site URL</th>
                                <th width="30">Site Desc</th>
                                <th width="10">Date Created</th>
                                <th width="10">Status</th>
                                <th width="10">Action</th>
                            </tr>
                        </thead>
                        <tbody style="max-width: 100%;">
                            <?php if (isset($mAccData)) : foreach ($mAccData as $key => $data) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $data->name ?></td>
                                        <td><?= $data->access->site_name ?></td>
                                        <td><?= $data->access_key ?></td>
                                        <td><?= $data->access->site_url . ':' . $data->access->site_port ?></td>
                                        <td><?= $data->access->site_desc ?></td>
                                        <td><?= $data->date_created ?> </td>
                                        <td><?= ($data->access_validation === 'Y' ? 'Active' : 'Inactive') ?></td>
                                        <td>Action Later</td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>