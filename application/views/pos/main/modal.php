<!-- Modal AddOn -->
<div id="modalAddOn" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto" style="height: 100%">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Add On
                </h3>
                <button id="closeModalAddOn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="formAddOn" method="post">
                <div class="p-6 space-y-6">
                    <div id="showAddOn" class="grid grid-cols-1">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 rounded-b">
                    <button type="button" id="submit" class="text-white w-full bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-4 py-2 text-center items-center mr-2 mb-2">
                        Save Add On
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Customer & List Customer -->
<div id="addCustomerModal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <!-- <div class="fixed glass w-full h-screen left-0 top-0 z-0"></div> -->
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative bg-white rounded-3xl shadow">
            <div class="flex justify-between items-center py-2 px-6 rounded-t border-b border-gray-600">
                <h3 class="text-base font-semibold text-gray-900 lg:text-lg">
                    Customer Name
                </h3>
                <button type="button" id="closeModalCustomer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="p-3">
                <div id="my" class="hidden">
                    <form method="post" id="formCustomer" action="<?php echo base_url("Favorite/startTransaction"); ?>">
                        <div class="text-left w-full text-sm mb-2 overflow-auto">
                            <div class="text-center">
                                <input name="customerName" id="customerName" type="text" class="w-full bg-white shadow border rounded-lg focus:bg-white focus:shadow-lg text-gray-700 py-2 px-3 leading-tight focus:outline-none" placeholder="Customer Name..." required>
                            </div>
                            <div class="radio-group grid grid-cols-2 gap-4 mt-2">
                                <div class="radio">
                                    <input type="radio" id="dine-in" name="transType" value="1" required>
                                    <label for="dine-in" class="block text-center px-3 py-2 bg-white rounded-lg border border-grey border-solid border-2">
                                        <div class="font-semibold uppercase tracking-wide"><strong>Dine In</strong></div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <input type="radio" id="take-away" name="transType" value="2" required>
                                    <label for="take-away" class="block text-center px-3 py-2 bg-white rounded-lg border border-grey border-solid border-2">
                                        <div class="font-semibold uppercase tracking-wide"><strong>Take Away</strong></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <button type="submit" class="text-white w-full bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-4 py-1 text-center items-center mr-2 mb-2">Save New Customer</button>
                        </div>
                    </form>
                    <hr>
                </div>
                <div class="relative mb-2 mt-2 text-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 py-2 px-3 pointer-events-none">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>
                    <input type="text" id="liveSearchCustomer" autocomplete="off" class="w-full bg-white shadow border rounded-lg focus:bg-white focus:shadow-lg text-gray-700 py-2 px-3 leading-tight focus:outline-none pl-10 p-2.5" placeholder="Search by Name">
                </div>
                <div id="myx" class="">
                    <div class="w-full">
                        <button role="button" id="showCreateNewCustomer" class="text-white w-full bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-4 py-1 text-center items-center mr-2 mb-2">
                            Create New Customer
                        </button>
                    </div>
                </div>
                <hr class="my-2">
                <div class="container">
                    <div class="tabs w-full">
                        <input type="radio" id="radio-1" name="tab" checked />
                        <label class="tab" for="radio-1">Customer List
                            <span class="notification">
                                <?= $countCustomer['total']; ?>
                            </span>
                        </label>
                        <input type="radio" id="radio-2" name="tab" />
                        <label class="tab" for="radio-2">Close Bill List</label>
                        <span class="glider"></span>
                    </div>
                </div>
                <div id="panels">
                    <div class="panel-1 tab-content active">
                        <p class="text-sm my-2 font-normal text-gray-500 font-semibold text-gray-400">RECENTLY CREATED</p>
                        <div id="myz" class="overflow-y-auto overflow-x-hidden h-72">
                            <ul class="list-cs my-2 space-y-3 mr-1" id="showListCustomer">

                            </ul>
                        </div>
                    </div>
                    <div class="panel-2 tab-content">
                        <p class="text-sm my-2 font-normal text-gray-500 font-semibold text-gray-400">RECENTLY CLOSE BILL</p>
                        <div class="overflow-y-auto overflow-x-hidden h-72">
                            <ul class="list-close-bill my-2 mr-1">

                            </ul>
                        </div>
                    </div>
                    <div id="reload"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Payment Method -->
<div id="paymentMethodModal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center py-2 px-6 rounded-t border-b border-gray-600">
                <h3 class="text-base font-semibold text-gray-900 lg:text-lg dark:text-white">
                    Payment Method
                </h3>
                <button id="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="paymentMethodModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="form" class="form" method="post">
                <div class="p-6">
                    <div class="flex flex-wrap mb-2">
                        <div class="w-full text-center px-3 mb-6 md:mb-0">
                            <div class="select-none h-auto w-full text-center px-2">
                                <div class="flex mb-1 text-lg text-blue-gray-700">
                                    <div class="text-sm text-left w-40">Grand Total</div>
                                    <div class="text-sm text-right w-full">Rp. </div>
                                    <div id="showGrandTotal" class="text-sm text-right w-24">

                                    </div>
                                </div>
                            </div>
                            <hr class="my-2" />
                            <div class="inline-block relative w-full mt-1 px-1">
                                <select id="paymentMethod" name="idPaymentMethod" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option disabled value="" selected>Choose Payment Method</option>
                                    <?php foreach ($paymentMethod as $value) : ?>
                                        <option value="<?= $value['PaymentMethodID']; ?>">
                                            <?= $value['PaymentMethodName']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-3 mt-2 text-blue-gray-700 px-3 pt-2 pb-3 rounded-lg bg-blue-gray-50">
                                <div class="flex text-lg font-semibold">
                                    <div class="flex-grow text-left">AMOUNT</div>
                                    <div class="flex text-right">
                                        <div class="mr-2">Rp</div>
                                        <input type="text" value="0" name="inputCash" id="inputCash" class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none" required />
                                    </div>
                                </div>
                                <hr class="my-2" />
                                <div class="grid grid-cols-3 gap-2 mt-2">
                                    <?php foreach ($price as $val) : ?>
                                        <button type="button" data-amount="<?= $val; ?>" id="button-cash" class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                                            +<span><?= number_format($val, 0, ",", ".") ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 w-full">
                        <input type="hidden" name="idTransaction" id="idTransaction" value="">
                        <input type="submit" id="paymentMethodButton" value="Save Payment" class="bg-black-50 hover:bg-black-100 text-white text-md px-4 py-1 rounded-lg w-full focus:outline-none">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Daily Report -->
<div id="daily-report" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-4xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Report Transaction Detail
                </h3>
                <button type="button" class="btnDaily text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 h-96 overflow-x-hidden overflow-y-auto">
                <div class="relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="w-2 px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Items
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Note
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody id="showDetailDailyReport"></tbody>
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 space-x-2 rounded-b border-t border-gray-200">
                <button type="button" class="btnDaily text-white bg-black-50 hover:bg-black-100 focus:outline-none rounded-lg border border-black-20 text-sm font-medium px-5 py-2.5 focus:z-10">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Print Bill -->
<div id="printBill" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0" id="overlay"></div>
    <div class="relative p-4 w-full max-w-md h-full md:h-auto" style="height: 100%">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow-xl">
            <!-- Modal body -->
            <div id="printArea" class="p-1 space-y-1">
                <div id="showTransaction" class="text-left w-full text-sm pl-5 pr-5 pt-5">

                </div>
                <div class="text-left w-full text-sm pl-5 pr-5">
                    <table class="text-xs gridtable">
                        <thead>
                            <tr>
                                <th class="py-1 text-left">Item</th>
                                <th class="py-1 w-2/12 text-center">Qty</th>
                                <th class="py-1 w-3/12 text-right">Subtotal Price</th>
                            </tr>
                        </thead>
                        <tbody id="showTransactionDetail">

                        </tbody>
                    </table>
                </div>
                <div id="showTransactionFinal" class="text-left w-full text-sm pl-5 pr-5">

                </div>
                <div id="showPaymentMethodTrans" class="text-left w-full text-sm pl-5 pr-5">

                </div>
                <div id="showChange" class="text-left w-full text-sm pl-5 pr-5">

                </div>
                <div class="w-full text-center text-sm" style="margin-top: 50px">
                    <div id="show-footer">

                    </div>
                </div>
            </div>
            <div class="flex items-center p-6 space-x-2 rounded-b">
                <?php if ($this->uri->segment(2)) : ?>
                    <form method="post" action="<?= base_url('favorite/updateCash/' . $this->uri->segment(2)); ?>">
                        <button type="submit" class="text-center text-white rounded-lg text-md w-full py-1 px-16 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                            Close
                        </button>
                    </form>
                <?php else : ?>
                    <button id="closePrintBill" type="button" data-modal-toggle="printBill" class="text-center text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                        Close
                    </button>
                <?php endif; ?>
                <button type="button" onclick="printDiv('printArea','<?php echo $this->uri->segment(2); ?>')" target="_blank" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-50 hover:bg-black-100">
                    Print Bill
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Void Modal -->
<div id="modalVoid" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0" id="overlay"></div>
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow-xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900">
                    Transaction Void
                </h3>
                <button id="closeModalVoid" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modalVoid">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div id="showReasonVoid">

            </div>
        </div>
    </div>
</div>

<!-- Modal Notes -->
<div id="modal-note-detail" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-5">
                <h3 class="text-xl font-medium text-gray-900">
                    Add notes to your dish
                </h3>
                <button id="close-modal-note-detail" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-2 space-y-2">
                <form id="formNotes" method="post">
                    <div class="w-full">
                        <div class="py-2 px-3">
                            <textarea id="notes" name="notes" maxlength="100" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Example: Make my food spicy!" autofocus></textarea>
                        </div>
                        <div class="flex justify-between items-center py-2 px-3">
                            <input type="hidden" id="transactionDetailID" name="id" value="">
                            <button type="submit" id="btn-notes" class="inline-flex text-white bg-black-50 hover:bg-black-100 focus:outline-none rounded-lg border border-black-20 text-sm font-medium px-5 py-2.5 focus:z-10">
                                Save Notes
                            </button>
                            <div id="the-count" class="flex pl-0 space-x-1 sm:pl-2">
                                <span id="current">0</span>
                                <span id="maximum">/ 100</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="detailCustomerModal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0"></div>
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto" style="height: 100%">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center py-2 px-4 rounded-t border-b border-gray-600">
                <h3 class="text-base font-semibold text-gray-900 lg:text-lg dark:text-white">
                    Detail Order
                </h3>
                <button id="closeModalDetailOrder" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="formTableCloseBill" method="post">
                <div class="p-4">
                    <div id="">
                        <div class="w-full text-sm mb-2 overflow-y-auto overflow-x-hidden">
                            <div id="showTbl">

                            </div>
                            <hr class="my-2">
                            <table class="text-sm gridtable">
                                <thead>
                                    <tr>
                                        <th class="py-1 text-left">Item</th>
                                        <th class="py-1 w-2/12 text-center">Qty</th>
                                        <th class="py-1 w-3/12 text-center">Status Order</th>
                                    </tr>
                                </thead>
                                <tbody id="showTrs">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div id="btnConfirmTakeAway" class="flex items-center p-3 space-x-2 rounded-b">
                    <input type="submit" id="saveTableButton" value="Confirm" class="bg-black-50 hover:bg-black-100 text-white text-md mt-2 py-1 rounded-lg w-full focus:outline-none">
                </div>
                <div id="showBtnPrintSummary" class="w-full pl-3 pr-3">

                </div>
            </form>
        </div>
    </div>
</div>

<div id="detailCustomerDineInModal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0"></div>
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto" style="height: 100%">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center py-2 px-4 rounded-t border-b border-gray-600">
                <h3 class="text-base font-semibold text-gray-900 lg:text-lg dark:text-white">
                    Detail Order
                </h3>
                <button id="closeModalDetailOrderDineIn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="" method="post">
                <div class="p-4">
                    <div>
                        <div id="showInputTable">

                        </div>
                        <div class="w-full text-sm mb-2 overflow-x-hidden overflow-y-auto">
                            <div id="showTblDineIn">

                            </div>
                            <hr class="my-2">
                            <table class="text-sm gridtable">
                                <thead>
                                    <tr>
                                        <th class="py-1 w-5/12 text-left">Item</th>
                                        <th class="py-1 w-2/12 text-center">Qty</th>
                                        <th class="py-1 w-3/12 text-center">Status Confirm</th>
                                        <th class="py-1 w-3/12 text-center">Status Order</th>
                                        <th class="py-1 w-2/12 text-center">Delivered</th>
                                    </tr>
                                </thead>
                                <tbody id="showTrsDineIn">

                                </tbody>
                            </table>
                            <div class="w-full mt-2">
                                <button type="button" onclick="printSummary('<?php echo $this->uri->segment(2); ?>')" target="_blank" class="text-white w-full bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-md px-4 py-2 text-center items-center mr-2 mb-2">
                                    Print Summary
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Discount -->
<div id="discountModal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0" id="overlay"></div>
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center py-2 px-6 rounded-t border-b border-gray-600">
                <h3 class="text-base font-semibold text-gray-900 lg:text-lg dark:text-white">
                    Discount
                </h3>
                <button id="closeDiscount" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="discountModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="formDiscount" class="form" method="post">
                <div class="p-6">
                    <div class="flex flex-wrap mb-2">
                        <div class="w-full text-center px-3 mb-6 md:mb-0">
                            <div class="inline-block relative w-full mt-1 px-1">
                                <select id="discounts" name="discounts" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option disabled value="" selected>Choose Discount</option>
                                    <?php foreach ($discount as $value) : ?>
                                        <option value="<?= $value['DiscountID']; ?>">
                                            <?= $value['DiscountName']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 w-full">

                        <input type="submit" id="discountButton" value="Save Discount" class="bg-black-50 hover:bg-black-100 text-white text-md px-4 py-1 rounded-lg w-full focus:outline-none">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>