<!-- preparing -->
<div class="mx-auto py-2.5">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-1 px-4">
        <?php foreach ($menuPreparing as $value) : ?>
            <div id="order-<?= $value['TransactionID']; ?>">
                <div class="w-full h-auto rounded-lg bg-white shadow-xl overflow-hidden z-10 flex flex-col justify-evenly">
                    <?php if ($value['TransactionType'] == 1) { ?>
                        <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-cyan-900">
                        <?php } else { ?>
                            <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-yellow-500">
                            <?php } ?>
                            <div class="flex font-semibold mb-1">
                                <div class="flex-grow text-lg text-white"><?= $value['CustomerName']; ?></div>
                                <div class="flex-grow text-white text-right"><i class="fas fa-clock"></i></div>
                            </div>
                            <div class="flex text-lg font-semibold">
                                <div class="flex-grow text-white"><?= format_waktu(date('H:i:s', strtotime($value['TransactionDatetime']))); ?></div>
                            </div>
                            <div class="flex text-lg font-semibold">
                                <div class="flex-grow text-white"><?= $value['TransactionNumber']; ?></div>
                                <?php if ($value['TransactionType'] == 1) : ?>
                                    <div class="flex-grow text-right text-white">Dine In</div>
                                <?php else : ?>
                                    <div class="flex-grow text-right text-white">Take Away</div>
                                <?php endif; ?>
                            </div>
                            </div>
                            <div class="flex flex-col flex-1 text-left w-full">
                                <?php $count = 0; ?>
                                <?php foreach ($value['Menu'] as $items) : ?>
                                    <?php $count++; ?>
                                <?php endforeach; ?>
                                <?php if ($count > 0) : ?>
                                    <form id="check" method="post">
                                        <table class="w-full text-xs">
                                            <tbody>
                                                <?php foreach ($value['Menu'] as $items) : ?>
                                                    <tr>
                                                        <td class="py-1 px-2 text-lg text-center"><?= $items['Qty']; ?></td>
                                                        <td class="py-1 text-lg text-left">
                                                            <span><?= $items['MenuName']; ?></span>
                                                            <br>
                                                            <small><?= $items['NoteDetail']; ?></small>
                                                        </td>
                                                        <td class=" px-2 text-lg text-center align-middle">
                                                            <?php if ($items['StatusTransactionDetail'] == 1) : ?>
                                                                <input checked onclick="return false;" id="checked-checkbox" name="status_td" type="checkbox" value="1" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">
                                                            <?php else : ?>
                                                                <input id="default-checkbox" data-id="<?= $items['TransactionDetailID']; ?>" name="status_td" type="checkbox" value="1" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </form>
                                <?php else : ?>
                                    <div class="w-full text-center text-sm pt-5 pb-5">
                                        <span>Waiting for a new order<br />please check the new order menu</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 justify-center content-center flex flex-col justify-evenly">
                                <?php if ($value['TransactionType'] == 2 && $count > 0) : ?>
                                    <button id="changeStatusToReady" data-id="<?= $value['TransactionID']; ?>" type="submit" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                                        <span>Ready</span>
                                    </button>
                                <?php else : ?>

                                <?php endif; ?>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
            </div>
    </div>
</div>