<?php
$segment    = $this->uri->segment(2);
?>
<!-- store menu -->
<div class="flex flex-col bg-blue-gray-50 h-full w-full py-4">
    <div class="flex px-2 flex-row relative">
        <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-cyan-500 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input type="text" name="query" id="liveSearch" autocomplete="on" class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none" placeholder="Find Menu ..." />
    </div>
    <div class="container">
        <div class="h-18 p-2 relative overflow-x-scroll overflow-y-hidden">
            <div class="h-14 p-2 px-2 block relative">
                <div id="showCategoryMenu" class="absolute flex inline-block nowrap">

                </div>
            </div>
        </div>
    </div>
    <div class="h-full overflow-hidden mt-4">
        <div id="showEmptySearchResult" class="h-full overflow-y-auto px-2">
            <div id="show_menu" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-3">

            </div>
        </div>
    </div>
</div>

<!-- right sidebar -->
<div class="w-6/12 flex flex-col bg-blue-gray-50 h-full bg-white pr-4 pl-2 py-4">
    <div class="bg-white rounded-3xl flex flex-col h-full shadow">
        <div>
            <div class="px-5 pt-3 pb-2 text-center">
                <button role="button" id="addCustomerName" data-modal-toggle="addCustomerModal" class="inline-block float-left text-white bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm mb-2 px-4 py-2.5 text-center inline-flex items-center">
                    <i class="fas fa-user"></i>
                </button>
                <?php foreach ($transactionID as $value) : ?>
                    <span class="inline-block bg-brown rounded-lg px-3 py-1.5 font-medium text-sm text-white mb-2"><label class="font-normal"><?= $value['CustomerName']; ?></label></span>
                <?php endforeach; ?>
                <!-- <button role="button" id="bill" data-modal-toggle="tableModal" class="inline-block float-right text-white bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center dark:focus:ring-[#050708]/50 dark:hover:bg-[#050708]/30 mb-2">
                    <i class="fas fa-table"></i>
                </button> -->
            </div>
        </div>
        <hr class="border-b shadow-lg" />
        <div class="flex-1 flex flex-col overflow-auto">
            <?php if ($segment) : ?>
                <div class="h-12 text-center flex justify-center">
                    <div class="pl-8 text-left text-lg py-4 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div id="show_cartTotalItem" class="text-center absolute bg-cyan-500 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3">

                        </div>
                    </div>
                    <div id="destroyAllCartItem" class="flex-grow px-8 text-right text-lg py-4 relative">

                    </div>
                </div>
            <?php else : ?>
                <!-- empty cart -->
                <div class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center my-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p>CART EMPTY</p>
                </div>
            <?php endif; ?>
            <div id="show_cartItem" class="flex-1 w-full px-4 overflow-auto">

            </div>
        </div>
        <?php if ($segment) : ?>
            <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
                <div class="flex mb-1 text-lg font-semibold text-blue-gray-700">
                    <div class="text-sm text-left w-56">Sub Total</div>
                    <div class="text-sm text-right w-24">Rp. </div>
                    <div class="text-sm text-right w-1"></div>
                    <div id="showSubTotal" class="text-sm text-right w-20">

                    </div>
                </div>
                <div id="showDiscount">

                </div>
                <div id="showTotal">

                </div>
                <hr class="my-2">
                <div class="flex mb-1 text-lg font-semibold text-blue-gray-700">
                    <div id="serviceCharge" class="text-sm text-left w-56">Service Charge</div>
                    <div class="text-sm text-right w-24">Rp. </div>
                    <div class="text-sm text-right w-1"></div>
                    <div id="showServiceCharge" class="text-sm text-right w-20">

                    </div>
                </div>
                <div class="flex mb-1 text-lg font-semibold text-blue-gray-700">
                    <div class="text-sm text-left w-56">PB1</div>
                    <div class="text-sm text-right w-24">Rp. </div>
                    <div class="text-sm text-right w-1"></div>
                    <div id="showPPN" class="text-sm text-right w-20">

                    </div>
                </div>
                <div id="showTotalFinal">

                </div>
                <div id="showPaymentMethod">

                </div>
                <div id="showChanger" class="hidden">

                </div>
                <div id="underpayment" class="hidden">

                </div>
                <hr class="my-2" />
                <button id="discount" role="button" data-modal-toggle="discountModal" class="text-white rounded-lg text-xs w-full py-1 focus:outline-none bg-cyan-400">
                    Discount
                </button>
                <hr class="my-2" />
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 pb-3">
                    <button id="pm" role="button" data-modal-toggle="paymentMethodModal" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-cyan-400">
                        Payment Method
                    </button>
                    <form id="formCloseBill" method="post">
                        <div class="loadForm">

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>