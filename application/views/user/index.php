<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
        <div class="col-md-4">
        <img src="<?= base_url('assets/img/profile/') . $user['image'] ; ?>" class="card-img" alt="...">
        </div>
        <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title"><?= $user['name']; ?></h5>
            <p class="card-text"><?= $user['email']; ?></p>
            <?php $this->load->helper('date');; ?>
            <?php $date = DateTime::createFromFormat('Y-m-d H:i:s', $user['date_created']);?>
            <p class="card-text"><small class="text-muted">member since <?= $date->format( 'd M Y'); ?></small></p>
        </div>
        </div>
    </div>
    </div>
    

</div>
<!-- /.container-fluid -->

            