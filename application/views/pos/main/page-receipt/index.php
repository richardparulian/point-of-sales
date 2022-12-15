<div class="container p-3 overflow-x-hidden overflow-y-auto">
    <div class="relative w-full bg-white shadow-md rounded-2xl p-4">
        <div class="flex justify-between items-center mb-2 rounded-t border-b border-gray-600">
            <h3 class="text-base font-semibold text-gray-900 lg:text-lg mb-3">
                Reprint Bill
            </h3>
        </div>
        <table id="myTable" class="text-sm text-left text-gray-500" width="100%">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="w-2 px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Receipt Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Customer Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Transaction Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($receipt as $value) : ?>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="px-6 py-4 text-center">
                            <?= $no++; ?>
                        </th>
                        <td class="px-6 py-4 align-middle">
                            <?= $value['TransactionNumber']; ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= $value['CustomerName']; ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?php if ($value['TransactionType'] == 1) : ?>
                                <span>Dine In</span>
                            <?php else : ?>
                                <span>Take Away</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= format_indo(date('Y-m-d H:i:s', strtotime($value['update_at']))); ?>
                        </td>
                        <td class="px-6 py-4 text-center align-middle">
                            <button role="button" data-id="<?= $value['TransactionID']; ?>" id="btn-print" data-modal-toggle="printBill" class="print-button text-center text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                                Detail Bill
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>