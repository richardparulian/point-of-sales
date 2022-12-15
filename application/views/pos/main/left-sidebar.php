<?php
$data    = $this->M_Global->getData("Transaction")->result_array();
?>
<!-- left sidebar -->
<div class="flex flex-row w-auto flex-shrink-0 pl-2 pr-2 py-2">
    <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl menu">
        <a href="<?= base_url(''); ?>" class="flex items-center justify-center h-16 w-16 bg-cyan-50 text-cyan-700 rounded-2xl">
            <img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" />
        </a>
        <ul class="flex flex-col space-y-2 mt-8 menu">
            <hr class="mb-5">
            <li>
                <a href="<?= base_url('favorite-list'); ?>" data-menu="Favorite" class="flex items-center rounded-2xl <?php foreach ($data as $value) {
                                                                                                                            if ($this->uri->segment(2) == $value['TransactionNumber']) {
                                                                                                                                echo "active";
                                                                                                                            }
                                                                                                                        } ?>">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-star text-2xl"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('receipt-list'); ?>" class="flex items-center rounded-2xl" data-menu="Reprint Bill">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-receipt text-2xl"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('receipt-list-before-close'); ?>" class="flex items-center rounded-2xl" data-menu="Print Bill Before Close">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-print text-2xl"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('void-list'); ?>" class="flex items-center rounded-2xl" data-menu="Transaction Void">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-file-circle-minus text-2xl"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('daily-report-transaction-list'); ?>" class="flex items-center rounded-2xl" data-menu="Daily Report Transaction">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-book text-2xl"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('income-transaction-list'); ?>" class="flex items-center rounded-2xl" data-menu="Income Report Transaction">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-money-check-dollar text-2xl"></i>
                    </span>
                </a>
            </li>
            <hr>
            <li>
                <a href="<?= base_url('sign-out'); ?>" class="flex items-center rounded-2xl" data-menu="sign-out">
                    <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-16 w-16 rounded-2xl">
                        <i class="fas fa-right-from-bracket text-2xl"></i>
                    </span>
                </a>
            </li>
        </ul>
        <a class="mt-auto flex items-center justify-center text-cyan-100 h-10 w-10 focus:outline-none my-rounded-full" data-title="<?= $this->session->userdata('Username'); ?>">
            <i class="fas fa-user"></i>
        </a>
    </div>
</div>