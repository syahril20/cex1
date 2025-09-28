<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Order</h1>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        DataTable
                    </div>
                    <?php if ($this->session->userdata('user')->code === 'AGENT'): ?>
                        <a href="<?= site_url('order/order_form') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> New Order
                        </a>
                    <?php endif; ?>
                </div>


                <div class="card-body">

                    <?php
                    $orders = $this->db->get('orders')->result_array();
                    if ($this->session->userdata('user')->code === 'SUPER_ADMIN'): ?>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Airwaybill</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Airwaybill</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $o): ?>
                                        <tr>
                                            <td><?= $o['id'] ?></td>
                                            <td><?= $o['airwaybill'] ?></td>
                                            <td><?= $o['created_at'] ?></td>
                                            <td>
                                                <a href="<?= site_url('orders/detail/' . $o['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada order</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <?php
                    $userId = $this->session->userdata('user')->id;
                    $orders = $this->db->get_where('orders', ['user_id' => $userId])->result_array();
                    if ($this->session->userdata('user')->code === 'AGENT'): ?>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Airwaybill</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Airwaybill</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $o): ?>
                                        <tr>
                                            <td><?= $o['id'] ?></td>
                                            <td><?= $o['airwaybill'] ?></td>
                                            <td><?= $o['created_at'] ?></td>
                                            <td>
                                                <a href="<?= site_url('orders/detail/' . $o['id']) ?>" class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada order</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

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