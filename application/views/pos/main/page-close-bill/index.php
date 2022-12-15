<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= base_url('vendor/img/logo/logo-milou.ico'); ?>" type="image/x-icon" />
    <!-- tailwind -->
    <link rel="stylesheet" href="<?= base_url('vendor/css/tailwind.min.css'); ?>" />
    <!-- style -->
    <link rel="stylesheet" href="<?= base_url('vendor/css/style.css'); ?>" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="<?= base_url('vendor/css/all.css') ?>" />
</head>

<body class="bg-blue-gray-50">
    <!-- view-after-print-bill -->
    <div id='DivIdToPrint' class="hidden overflow-auto">
        <div class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap">
            <div class="w-full bg-white overflow-hidden z-10">
                <div class="text-left w-full text-sm p-1 overflow-auto">
                    <div class="text-center">
                        <img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" alt="Milou Farm House" class="mb-1 w-24 h-24 inline-block" />
                    </div>
                    <?php foreach ($checkTransactionNumber as $value) : ?>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow"><?= format_indo(date('Y-m-d', strtotime($value['update_at']))); ?></div>
                            <div><?= format_waktu(date('H:i:s', strtotime($value['update_at']))); ?></div>
                        </div>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">Receipt Number</div>
                            <div><?= $value['TransactionNumber']; ?></div>
                        </div>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">Customer Name</div>
                            <div><?= $value['CustomerName']; ?></div>
                        </div>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">Collected By</div>
                            <div><?= $this->session->userdata("Username"); ?></div>
                        </div>
                        <hr class="my-2" />
                        <?php if ($value['TransactionType'] == 1) : ?>
                            <div class="text-center text-xs font-semibold">Dine In</div>
                        <?php else : ?>
                            <div class="text-center text-xs font-semibold">Take Away</div>
                        <?php endif; ?>
                        <hr class="my-2" />
                    <?php endforeach; ?>
                    <div>
                        <table class="w-full text-xs">
                            <thead>
                                <tr>
                                    <th class="py-1 w-1/12 text-center">#</th>
                                    <th class="py-1 text-left">Item</th>
                                    <th class="py-1 w-2/12 text-center">Qty</th>
                                    <th class="py-1 w-3/12 text-right">Subtotal Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($transactionDetail as $value) : ?>
                                    <?php
                                    $subTotalPrice = $value['Price'] * $value['Qty'];
                                    ?>
                                    <tr>
                                        <td class="py-2 text-center"><?= $no++; ?></td>
                                        <td class="py-2 text-left">
                                            <span><?= $value['MenuName']; ?></span>
                                            <br />
                                            <small><?= number_format($value['Price'], 0, ",", "."); ?></small>
                                        </td>
                                        <td class="py-2 text-center font-semibold"><?= $value['Qty']; ?></td>
                                        <td class="py-2 text-right font-semibold">
                                            <span>Rp. </span>
                                            <span><?= number_format($subTotalPrice, 0, ",", "."); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-2" />
                    <div>
                        <?php foreach ($checkTransactionNumber as $value) : ?>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow">Subtotal</div>
                                <div class="flex-grow text-right">Rp. </div>
                                <div class="w-12 text-right"><?= number_format($value['SubTotalTransaction'], 0, ",", "."); ?></div>
                            </div>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow">PPN (11.0%)</div>
                                <div class="flex-grow text-right">Rp. </div>
                                <div class="w-12 text-right"><?= number_format($value['PPN'], 0, ",", "."); ?></div>
                            </div>
                            <hr class="my-2" />
                            <div class="flex text-xs font-bold">
                                <div class="flex-grow">Total</div>
                                <div class="flex-grow text-right">Rp. </div>
                                <div class="w-12 text-right"><?= number_format($value['TotalTransaction'], 0, ",", "."); ?></div>
                            </div>
                        <?php endforeach; ?>
                        <hr class="my-2" />
                        <?php foreach ($paymentMethod as $value) : ?>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow"><?= $value['PaymentMethodName']; ?></div>
                                <div class="flex-grow text-right">Rp. </div>
                                <div class="w-12 text-right"><?= number_format($value['Nominal'], 0, ",", "."); ?></div>
                            </div>
                        <?php endforeach; ?>
                        <?php $plus = 0; ?>
                        <?php foreach ($paymentMethod as $value) : ?>
                            <?php foreach ($checkTransactionNumber as $total) : ?>
                                <?php
                                $plus   += $value['Nominal'];
                                $result = $plus - $total['TotalTransaction'];
                                ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <hr class="my-2" />
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">Change</div>
                            <div class="flex-grow text-right">Rp. </div>
                            <div class="w-12 text-right"><?= number_format($result, 0, ",", "."); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- view-before-print-bill -->
    <div class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
        <div class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10">
            <div class="text-left w-full text-sm p-5 overflow-auto">
                <div class="text-center">
                    <img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" alt="Milou Farm House" class="mb-1 w-24 h-24 inline-block" />
                </div>
                <?php foreach ($checkTransactionNumber as $value) : ?>
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow"><?= format_indo(date('Y-m-d', strtotime($value['update_at']))); ?></div>
                        <div><?= format_waktu(date('H:i:s', strtotime($value['update_at']))); ?></div>
                    </div>
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">Receipt Number</div>
                        <div><?= $value['TransactionNumber']; ?></div>
                    </div>
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">Customer Name</div>
                        <div><?= $value['CustomerName']; ?></div>
                    </div>
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">Collected By</div>
                        <div><?= $this->session->userdata("Username"); ?></div>
                    </div>
                    <hr class="my-2" />
                    <?php if ($value['TransactionType'] == 1) : ?>
                        <div class="text-center text-xs font-semibold">Dine In</div>
                    <?php else : ?>
                        <div class="text-center text-xs font-semibold">Take Away</div>
                    <?php endif; ?>
                    <hr class="my-2" />
                <?php endforeach; ?>
                <div class="overflow-y-auto overflow-x-hidden h-36">
                    <table class="w-full text-xs">
                        <thead>
                            <tr>
                                <th class="py-1 w-1/12 text-center">#</th>
                                <th class="py-1 text-left">Item</th>
                                <th class="py-1 w-2/12 text-center">Qty</th>
                                <th class="py-1 w-4/12 text-right p-1">Subtotal Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($transactionDetail as $value) : ?>
                                <?php
                                $subTotalPrice = $value['Price'] * $value['Qty'];
                                ?>
                                <tr>
                                    <td class="py-2 text-center"><?= $no++; ?></td>
                                    <td class="py-2 text-left">
                                        <span><?= $value['MenuName']; ?></span>
                                        <br />
                                        <small><?= number_format($value['Price'], 0, ",", "."); ?></small>
                                    </td>
                                    <td class="py-2 text-center font-semibold"><?= $value['Qty']; ?></td>
                                    <td class="py-2 text-right font-semibold p-1">
                                        <span>Rp. </span>
                                        <span><?= number_format($subTotalPrice, 0, ",", "."); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <hr class="my-2" />
                <div>
                    <?php foreach ($checkTransactionNumber as $value) : ?>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">Subtotal</div>
                            <div class="flex-grow text-right">Rp. </div>
                            <div class="w-12 text-right"><?= number_format($value['SubTotalTransaction'], 0, ",", "."); ?></div>
                        </div>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow">PPN (11.0%)</div>
                            <div class="flex-grow text-right">Rp. </div>
                            <div class="w-12 text-right"><?= number_format($value['PPN'], 0, ",", "."); ?></div>
                        </div>
                        <hr class="my-2" />
                        <div class="flex text-xs font-bold">
                            <div class="flex-grow">Total</div>
                            <div class="flex-grow text-right">Rp. </div>
                            <div class="w-12 text-right"><?= number_format($value['TotalTransaction'], 0, ",", "."); ?></div>
                        </div>
                    <?php endforeach; ?>
                    <hr class="my-2" />
                    <?php foreach ($paymentMethod as $value) : ?>
                        <div class="flex text-xs font-semibold">
                            <div class="flex-grow"><?= $value['PaymentMethodName']; ?></div>
                            <div class="flex-grow text-right">Rp. </div>
                            <div class="w-12 text-right"><?= number_format($value['Nominal'], 0, ",", "."); ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php $plus = 0; ?>
                    <?php foreach ($paymentMethod as $value) : ?>
                        <?php foreach ($checkTransactionNumber as $total) : ?>
                            <?php
                            $plus   += $value['Nominal'];
                            $result = $plus - $total['TotalTransaction'];
                            ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <hr class="my-2" />
                    <div class="flex text-xs font-semibold">
                        <div class="flex-grow">Change</div>
                        <div class="flex-grow text-right">Rp. </div>
                        <div class="w-12 text-right"><?= number_format($result, 0, ",", "."); ?></div>
                    </div>
                </div>
            </div>
            <div class="p-4 grid grid-cols-2 gap-4">
                <a href="<?= base_url('favorite'); ?>" type="submit" class="print-button text-center text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                    Close
                </a>
                <button type="button" onclick="printDiv();" target="_blank" class="print-button text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                    Print Bill
                </button>
            </div>
        </div>
    </div>

    <!-- jquery version 3.6.0 -->
    <script src="<?= base_url('vendor/js/jquery-3.6.0.js'); ?>"></script>
    <!-- my script -->
    <script type="text/javascript">
        function printDiv() {

            var divToPrint = document.getElementById('DivIdToPrint');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();

            newWin.document.write(
                '<head>' +
                '<meta charset="UTF-8" />' +
                '<meta http-equiv="X-UA-Compatible" content="IE=edge" />' +
                '<meta name="viewport" content="width=device-width, initial-scale=1.0" />' +
                '<link rel="shortcut icon" href="<?= base_url(); ?>vendor/img/logo/logo-milou.ico" type="image/x-icon" />' +
                '<link rel="stylesheet" href="<?= base_url(); ?>vendor/css/tailwind.min.css" />' +
                '<link rel="stylesheet" href="<?= base_url(); ?>vendor/css/style.css" />' +
                '<link rel="stylesheet" href="<?= base_url() ?>vendor/css/all.css" />' +
                '</head>' +
                '<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>'
            );

            newWin.document.close();

        }
    </script>
</body>

</html>