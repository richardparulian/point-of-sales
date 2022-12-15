<div class="container p-3 overflow-x-hidden overflow-y-auto">
    <div class="relative w-full bg-white shadow-md rounded-2xl p-4">
        <div class="flex justify-between items-center mb-2 rounded-t border-b border-gray-600">
            <h3 class="text-base font-semibold text-gray-900 lg:text-lg mb-3">
                Void Transaction
            </h3>
        </div>
        <table id="voidTransaction" class="text-sm text-gray-500" width="100%">
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
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Subtotal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Discount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Transaction
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Grand Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($voids as $value) : ?>
                    <tr class="border-b hover:bg-gray-50">
                        <th class="px-6 py-4 text-center">
                            <?= $no++; ?>
                        </th>
                        <td class="px-6 py-4 align-middle">
                            <?= $value['trn']; ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= $value['csn']; ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= format_indo(date('Y-m-d H:i:s', strtotime($value['update_at']))); ?>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= number_format($value['sbt'], 0, ",", "."); ?> IDR
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= number_format($value['dsc'], 0, ",", "."); ?> IDR
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= number_format($value['ttl'], 0, ",", "."); ?> IDR
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <?= number_format($value['gtt'], 0, ",", "."); ?> IDR
                        </td>
                        <td class="px-6 py-4 text-center align-middle">

                            <?php if ($value['StatusVoid'] == 1) : ?>
                                <button type="button" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-cyan-400" disabled>
                                    Pending
                                </button>
                            <?php elseif ($value['StatusVoid'] == 2) : ?>
                                <button type="button" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-cyan-400" disabled>
                                    Approve
                                </button>
                            <?php else : ?>
                                <button type="button" data-id="<?= $value['tid']; ?>" data-modal-toggle="modalVoid" class="btn-void text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                                    Void
                                </button>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>