<!-- new order -->
<div class="mx-auto py-2.5">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1 px-4">
        <?php foreach ($kitchen as $value) : ?>
            <div id="order-<?= $value['TransactionID']; ?>">
                <div class="w-full h-auto rounded-lg bg-white shadow-xl overflow-hidden z-10 flex flex-col justify-evenly">
                    <?php if ($value['TransactionType'] == 1) { ?>
                        <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-cyan-900">
                        <?php } else { ?>
                            <div class="text-left w-full text-sm p-2 overflow-auto border-b border-gray-200 bg-yellow-500">
                            <?php } ?>
                            <div class="flex text-sm font-semibold mb-1">
                                <div class="flex-grow text-white"><?= $value['CustomerName']; ?></div>
                                <div class="flex-grow text-right text-white"><i class="fas fa-circle-exclamation"></i></div>
                            </div>
                            <div class="flex text-xs font-semibold">
                                <div class="flex-grow text-white"><?= format_waktu(date('H:i:s', strtotime($value['TransactionDatetime']))); ?></div>
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
                            <div class="flex flex-col flex-1 text-left w-full text-sm">
                                <?php $count = 0; ?>
                                <?php foreach ($value['Menu'] as $items) : ?>
                                    <?php $count++; ?>
                                <?php endforeach; ?>
                                <?php if ($count > 0) : ?>
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
                                                </tr>
                                                <?php foreach ($items['Parent'] as $key) : ?>
                                                    <tr>
                                                        <td class="py-1 px-2 text-lg text-center"><?= $key['Qty']; ?></td>
                                                        <td class="py-1 text-lg text-left">
                                                            <span><?= $key['MenuName']; ?></span>
                                                            <br>
                                                            <small><?= $key['NoteDetail']; ?></small>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <?php if ($value['TransactionType'] == 1) : ?>
                                        <div class="w-full text-center text-lg pt-5 pb-5">
                                            <span>Open Bill Waiting</span>
                                        </div>
                                    <?php else : ?>

                                        <div class="w-full text-center text-sm pt-5 pb-5">
                                            <span>the order is waiting for confirmation<br />or the order is being prepared</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($count > 0) : ?>
                                <div class="p-4 justify-center content-center flex flex-col justify-evenly border-t border-gray-200">
                                    <button id="changeStatus" data-id="<?= $value['TransactionID']; ?>" type="submit" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                                        <span id="statusOrder">Preparing</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                </div>
            <?php endforeach; ?>
            </div>
    </div>