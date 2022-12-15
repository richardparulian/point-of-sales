<!-- complete -->
<div class="mx-auto py-2.5">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
        <?php foreach ($menuComplete as $value) : ?>
            <div id="order-<?= $value['TransactionID']; ?>">
                <div class="w-full rounded-lg bg-white shadow-xl overflow-hidden z-10 flex flex-col justify-evenly">
                    <?php if ($value['TransactionType'] == 1) { ?>
                        <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-cyan-900">
                        <?php } else { ?>
                            <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-yellow-500">
                            <?php } ?>
                            <div class="flex text-sm font-semibold mb-1">
                                <div class="flex-grow text-white"><?= $value['CustomerName']; ?></div>
                                <div class="flex-grow text-white text-right"><i class="fas fa-thumbs-up"></i></div>
                            </div>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow text-white"><?= format_waktu(date('H:i:s', strtotime($value['update_at']))); ?></div>
                            </div>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow text-white"><?= $value['TransactionNumber']; ?></div>
                                <?php if ($value['TransactionType'] == 1) : ?>
                                    <div class="flex-grow text-right text-white">Dine In</div>
                                <?php else : ?>
                                    <div class="flex-grow text-right text-white">Take Away</div>
                                <?php endif; ?>
                            </div>
                            </div>
                            <div class="flex flex-col flex-1 text-left w-full text-sm overflow-auto">
                                <table class="w-full text-xs">
                                    <tbody>
                                        <?php foreach ($menu as $items) : ?>
                                            <?php if ($items['TransactionID'] == $value['TransactionID']) : ?>
                                                <tr>
                                                    <td class="py-1 text-sm text-center"><?= $items['Qty']; ?></td>
                                                    <td class="py-1 text-sm text-left"><span><?= $items['MenuName']; ?></span></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 justify-center content-center flex flex-col justify-evenly">
                                <!-- <input type="hidden" id="transactionID" name="transactionID" value="<?= $value['TransactionID']; ?>">
                                <button id="changeStatus" type="submit" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-cyan-400 hover:bg-cyan-600">
                                    <span id="statusOrder">Preparing</span>
                                </button> -->
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
            </div>
    </div>
</div>