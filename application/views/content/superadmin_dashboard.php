<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

        <h1 class="mt-4">Superadmin Dashboard</h1>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Total Users</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="fs-4"><?= $total_users ?? 0 ?></span>
                        <a class="small text-white stretched-link" href="<?= base_url('superadmin/users') ?>">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Active Sessions</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="fs-4"><?= $active_sessions ?? 0 ?></span>
                        <a class="small text-white stretched-link" href="<?= base_url('superadmin/sessions') ?>">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Pending Requests</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="fs-4"><?= $pending_requests ?? 0 ?></span>
                        <a class="small text-white stretched-link" href="<?= base_url('superadmin/requests') ?>">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">System Alerts</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="fs-4"><?= $system_alerts ?? 0 ?></span>
                        <a class="small text-white stretched-link" href="<?= base_url('superadmin/alerts') ?>">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        User Growth (Monthly)
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Activity Overview
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
            
        </div>
    </main>

    <?php $this->load->view('layout/footer'); ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/datatables-simple-demo.js') ?>"></script>
    <script src="<?= base_url('assets/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('assets/demo/chart-bar-demo.js') ?>"></script>
</div>