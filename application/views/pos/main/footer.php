</div>
<!-- jquery version 3.6.0 -->
<script type="text/javascript" src="<?= base_url('vendor/js/jquery-3.6.0.js'); ?>"></script>
<!-- flowbite -->
<script type="text/javascript" src="<?= base_url('vendor/js/flowbite.js'); ?>"></script>
<!-- toastr -->
<script type="text/javascript" src="<?= base_url('vendor/js/toastr.min.js'); ?>"></script>
<!-- moment -->
<script type="text/javascript" src="<?= base_url('vendor/js/moment.js'); ?>"></script>
<!-- datatable -->
<script type="text/javascript" src="<?= base_url('vendor/DataTables/datatables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('vendor/DataTables/Buttons-2.2.3/js/dataTables.buttons.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('vendor/DataTables/Buttons-2.2.3/js/buttons.jqueryui.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('vendor/DataTables/JSZip-2.5.0/jszip.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('vendor/DataTables/Buttons-2.2.3/js/buttons.print.min.js'); ?>"></script>
<!-- Datepicker -->
<script type="text/javascript" src="<?= base_url('vendor/js/jquery-ui.js'); ?>"></script>

<!-- my script -->
<script type="text/javascript">
    $(function() {
        $("#start_date").datepicker({
            "dateFormat": "yy-mm-dd",
            "showAnim": "slideDown"
        });
        $("#end_date").datepicker({
            "dateFormat": "yy-mm-dd",
            "showAnim": "slideDown"
        });
    });

    $('#notes').keyup(function() {

        var characterCount = $(this).val().length,
            current = $('#current'),
            maximum = $('#maximum'),
            theCount = $('#the-count');

        current.text(characterCount);

        /*This isn't entirely necessary, just playin around*/
        if (characterCount < 70) {
            current.css('color', '#666');
        }
        if (characterCount > 70 && characterCount < 90) {
            current.css('color', '#666');
        }
        if (characterCount > 90 && characterCount < 100) {
            current.css('color', '#666');
        }
    });

    var mySegment = "<?= $this->uri->segment(2) ?>";
    const myInterval = setInterval('showCloseBillForConfirm()', 5000);
    setInterval('showCartItem()', 1000);
    setInterval('showTotalItemCart()', 1000);
    setInterval('showTotalCart()', 1000);
    setInterval('showChanger()', 1000);
    if (mySegment != "") {
        setInterval('itemLoad()', 3000);
        setInterval('destroyAll()', 1000);
    } else {

    }

    function destroyAll() {
        var segment = "<?= $this->uri->segment(2) ?>";
        var url = "<?= site_url('favorite/getTransactionForReload/') ?>" + segment;

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";
                var btnTrash = "";

                for (var i = 0; i < data['transaction'].length; i++) {
                    if (data['count'].total > 0) {
                        html += '<button id="destroy-cart" data-id="' + data['transaction'][i].TransactionID + '" data-status="' + data['transaction'][i].StatusTransaction + '" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none" disabled>' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />' +
                            '</svg>' +
                            '</button>';
                    } else {
                        html += '<button id="destroy-cart" data-id="' + data['transaction'][i].TransactionID + '" data-status="' + data['transaction'][i].StatusTransaction + '" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />' +
                            '</svg>' +
                            '</button>';
                    }
                }
                $("#destroyAllCartItem").html(html);
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function itemLoad() {
        var segment = "<?= $this->uri->segment(2) ?>";
        var url = "<?= site_url('favorite/getTransactionForReload/') ?>" + segment;

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";

                for (var i = 0; i < data['transaction'].length; i++) {
                    html += '<button id="closeBill" data-id="' + data['transaction'][i].TransactionID + '" data-status="' + data['transaction'][i].StatusTransaction + '" type="submit" data-modal-toggle="printBill" class="text-white rounded-lg text-md w-full py-1 mt-2 focus:outline-none bg-black-100" disabled>Close Bill</button>';
                }
                $(".loadForm").html(html);
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function transactionByStatus(start_date, end_date) {
        var url = "<?= site_url('report/getDailyReportTransaction') ?>";

        $.ajax({
            url: url,
            method: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function(data) {
                var i = '1';

                $('#reportTransaction').DataTable({
                    responsive: true,
                    data: data,
                    columns: [{
                            data: "TransactionID",
                            render: function(data, type, row, meta) {
                                return i++;
                            }
                        },
                        {
                            data: "TransactionNumber",
                            render: function(data, type, row) {
                                return "<button type='button' id='daily' data-id='" + row.TransactionID + "' class='daily-report-detail text-white rounded-lg text-md w-full py-1 focus:outline-none bg-black-50 hover:bg-black-100'>" + row.TransactionNumber + "</button>"
                            }
                        },
                        {
                            data: "CustomerName",
                        },
                        {
                            data: "TransactionDatetime",
                            render: function(data, type, row, meta) {
                                return moment(row.TransactionDatetime).format('DD-MM-YYYY');
                            }
                        },
                        {
                            data: "SubTotalTransaction",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        },
                        {
                            data: "Discount",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        },
                        {
                            data: "TotalTransaction",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        },
                        {
                            data: "PPN",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        },
                        {
                            data: "ServiceCharge",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        },
                        {
                            data: "GrandTotalTransaction",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        }
                    ],
                    "dom": "<'fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'lBfr>" +
                        "t" +
                        "<'fg-toolbar ui-toolbar ui-corner-bl ui-corner-br'ip>",
                    "buttons": [
                        'excel', 'print'
                    ],
                });
                $(".buttons-excel").removeClass("dt-button").addClass("bg-black-50 hover:bg-black-100 text-white rounded-lg focus:outline-none w-24 text-sm p-1.5 ml-auto");
                $(".buttons-print").removeClass("dt-button").addClass("bg-black-50 hover:bg-black-100 text-white rounded-lg focus:outline-none w-24 text-sm p-1.5 ml-auto");
            }
        });
    }

    function reportIncomeByDate(start_date, end_date) {
        var url = "<?= site_url('income/getReportIncomeByDate') ?>";

        $.ajax({
            url: url,
            method: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function(data) {
                var i = 1;

                $('#incomeReportTransaction').DataTable({
                    responsive: true,
                    data: data,
                    columns: [{
                            data: "PaymentMethodID",
                            render: function(data, type, row, meta) {
                                return i++;
                            }
                        },
                        {
                            data: "PaymentMethodName",
                        },
                        {
                            data: "TotalTransaction",
                            render: $.fn.dataTable.render.number('.', ' IDR', ',', 0)
                        }
                    ],
                    "dom": "<'fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'lBfr>" +
                        "t" +
                        "<'fg-toolbar ui-toolbar ui-corner-bl ui-corner-br'ip>",
                    "buttons": [
                        'excel', 'print'
                    ]
                });
                $(".buttons-excel").removeClass("dt-button").addClass("bg-black-50 hover:bg-black-100 text-white rounded-lg focus:outline-none w-24 text-sm p-1.5 ml-auto");
                $(".buttons-print").removeClass("dt-button").addClass("bg-black-50 hover:bg-black-100 text-white rounded-lg focus:outline-none w-24 text-sm p-1.5 ml-auto");
            }
        });
    }

    function showCategoryMenu() {
        var urlCategoryMenu = "<?= site_url('favorite/getCategoryMenu') ?>";

        $.ajax({
            type: "ajax",
            url: urlCategoryMenu,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    html += '<button data-id="' + data[i].CategoryName + '" role="button" class="moveCategoryMenu cursor-pointer inline-flex w-auto justify-center text-white bg-black-50 hover:bg-black-100 focus:ring-2 focus:outline-none focus:ring-[#050708]/50 text-sm font-medium mt-1 mb-2 ml-1 mr-2 px-2.5 py-0.5 rounded-2xl">' + data[i].CategoryName + '</button>';
                }
                $("#showCategoryMenu").html(html);
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showDataMenu() {
        var urlMenu = "<?= site_url('favorite/getFavorite') ?>";
        var segment = "<?= $this->uri->segment(2) ?>";

        $.ajax({
            type: "ajax",
            url: urlMenu,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var getSegment = segment;
                var html = "";
                var menuImage = "";
                for (var i = 0; i < data.length; i++) {
                    if (data[i].MenuImage == null || data[i].MenuImage == '') {
                        menuImage = '<img src="<?= site_url('vendor/img/logo/logo-milou.png') ?>" alt="Milou Farm House" />';
                    } else {
                        menuImage = '<img src="http://151.106.113.196:8097/assets/dist/menuimg/' + data[i].MenuImage + '" alt="' + data[i].MenuName + '" />';
                    }
                    html += '<div id="mydiv" role="button" data-id="' + data[i].MenuID + '" data-name="' + data[i].MenuName + '" data-price="' + data[i].MenuPrice + '" data-image="' + data[i].MenuImage + '" class="add-cart select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg">' +
                        menuImage +
                        '<div class="flex pb-3 px-3 text-sm mt-3">' +
                        '<p class="flex-grow truncate mr-1">' + data[i].MenuName + '</p>' +
                        '<p class="nowrap font-semibold">' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(data[i].MenuPrice) + '</p>' +
                        '</div>' +
                        '</div>';
                }
                $("#show_menu").html(html);
                if (getSegment) {
                    $("#show_menu").removeClass("disabledbutton");
                } else {
                    $("#show_menu").addClass("disabledbutton");
                }
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showCartItem() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var urlCartItem = "<?= site_url('favorite/getCartItem/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: urlCartItem,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var iconButton = "";
                    var note = "";
                    var menuImage = "";
                    var statusTransaction = "";
                    var btnNoteDetail = "";
                    var btnDecrement = "";
                    var btnIncrement = "";
                    var btnNoteDetailAdd = "";
                    var btnDecrementAdd = "";
                    var btnIncrementAdd = "";
                    var btnAddOn = "";

                    for (var x = 0; x < data['checkTransactionNumber'].length; x++) {
                        statusTransaction = data['checkTransactionNumber'][x].StatusTransaction;
                    }

                    for (var i = 0; i < data['getItemTransaction'].length; i++) {

                        for (var j = 0; j < data['menu'].length; j++) {
                            if (data['menu'][j].MenuID == data['getItemTransaction'][i].MenuID) {
                                if (data['menu'][j].MenuType == "AddOn") {
                                    btnAddOn = '<button id="addOn" type="button" class="hidden text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-1 focus:ring-gray-200 font-medium rounded-2xl text-xs px-2.5 py-0.5 text-xs mr-1"><i class="fas fa-plus"></i> Add On</button>';
                                } else {
                                    btnAddOn = '<button id="addOn" type="button" data-id="' + data['menu'][j].MenuID + '" data-idtransactiondetail="' + data['getItemTransaction'][i].TransactionDetailID + '" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-1 focus:ring-gray-200 font-medium rounded-2xl text-xs px-2.5 py-0.5 text-xs mr-1"><i class="fas fa-plus"></i> Add On</button>';
                                }
                            }
                        }

                        if (data['getItemTransaction'][i].NoteDetail == '') {
                            iconButton = '<i class="fas fa-notes-medical"></i>';
                            note = '';
                        } else {
                            iconButton = '<i class="fas fa-pencil"></i>';
                            note = '<div class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-1.5 px-1.5 flex">' +
                                '<span class="text-xs font-semibold">Notes' +
                                '<p class="text-xs font-normal">' + data['getItemTransaction'][i].NoteDetail + '</p>' +
                                '</span>' +
                                '</div>';
                        }

                        if (data['getItemTransaction'][i].MenuImage == null || data['getItemTransaction'][i].MenuImage == '') {
                            menuImage = '<img src="<?= site_url("vendor/img/logo/logo-milou.png") ?>" alt="Milou Farm House" class="rounded-lg h-16 w-16 bg-white shadow mr-2" />';
                        } else {
                            menuImage = '<img src="http://151.106.113.196:8097/assets/dist/menuimg/' + data['getItemTransaction'][i].MenuImage + '" alt="' + data['getItemTransaction'][i].MenuImage + '" class="rounded-lg h-16 w-16 bg-white shadow mr-2" />';
                        }

                        if (data['getItemTransaction'][i].StatusForKitchen == 1 || data['getItemTransaction'][i].StatusForKitchen == 2) {
                            btnNoteDetail = '<button type="button" class="btn-note-detail text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-1 focus:ring-gray-200 font-medium rounded-2xl text-xs px-2.5 py-0.5" disabled>' + iconButton + ' Notes</button>';
                            btnDecrement = '<button class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none" disabled><i class="fas fa-minus text-xs"></i></button>';
                            btnIncrement = '<button class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none" disabled><i class="fas fa-plus text-xs"></i></button>';
                            btnAddOn = '<button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-1 focus:ring-gray-200 font-medium rounded-2xl text-xs px-2.5 py-0.5 text-xs mr-1" disabled><i class="fas fa-plus"></i> Add On</button>';
                        } else {
                            btnNoteDetail = '<button id="btn-note-detail" type="button" data-id="' + data['getItemTransaction'][i].TransactionDetailID + '" class="btn-note-detail text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-1 focus:ring-gray-200 font-medium rounded-2xl text-xs px-2.5 py-0.5">' + iconButton + ' Notes</button>';
                            btnDecrement = '<button data-id="' + data['getItemTransaction'][i].TransactionDetailID + '" data-qty="' + data['getItemTransaction'][i].Qty + '" data-status="' + statusTransaction + '" id="decrement-cart" class="decrement-cart rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none"><i class="fas fa-minus text-xs"></i></button>';
                            btnIncrement = '<button data-id="' + data['getItemTransaction'][i].TransactionDetailID + '" data-qty="' + data['getItemTransaction'][i].Qty + '" id="increment-cart" class="increment-cart rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none"><i class="fas fa-plus text-xs"></i></button>';
                        }

                        html += '<div class="select-none mb-0.5 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-1.5 px-1.5 flex justify-center">' +
                            menuImage +
                            '<div class="flex-grow">' +
                            '<h5 class="text-xs font-bold ml-1">' + data['getItemTransaction'][i].MenuName + '</h5>' +
                            '<p class="text-xs block mb-1 ml-1">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['getItemTransaction'][i].Price) + '</p>' +
                            '<div class="w-full grid grid-cols-2">' +
                            btnAddOn +
                            btnNoteDetail +
                            '</div>' +
                            '</div>' +
                            '<div id="disable" class="self-center">' +
                            '<div class="w-28 grid grid-cols-3 gap-2 ml-2">' +
                            btnDecrement +
                            '<input type="text" data-id="' + data['getItemTransaction'][i].TransactionDetailID + '" id="quantity" value="' + data['getItemTransaction'][i].Qty + '" class="change-quantity bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-xs" readonly/>' +
                            btnIncrement +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div id="showNotes">' +
                            note +
                            '</div>';


                        $.each(data['getItemTransaction'][i].Parent, function(index, value) {

                            if (value.StatusForKitchen == 1 || value.StatusForKitchen == 2) {
                                btnDecrement = '<button class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none" disabled><i class="fas fa-minus text-xs"></i></button>';
                                btnIncrement = '<button class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none" disabled><i class="fas fa-plus text-xs"></i></button>';

                            } else {
                                btnDecrement = '<button data-id="' + value.TransactionDetailID + '" data-ex="' + data['getItemTransaction'][i].TransactionDetailID + '" data-qty="' + value.Qty + '" data-status="' + statusTransaction + '" id="decrement-cart" class="decrement-cart rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none"><i class="fas fa-minus text-xs"></i></button>';
                                btnIncrement = '<button data-id="' + value.TransactionDetailID + '" data-qty="' + value.Qty + '" id="increment-cart" class="increment-cart rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none"><i class="fas fa-plus text-xs"></i></button>';
                            }

                            html += '<div class="select-none mb-0.5 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-1.5 px-1.5 flex justify-center">' +
                                '<div class="flex-grow">' +
                                '<h5 class="text-xs font-bold ml-1">' + value.MenuName + '</h5>' +
                                '<p class="text-xs block mb-1 ml-1">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(value.Price) + '</p>' +
                                '<div class="w-full grid grid-cols-2">' +
                                '</div>' +
                                '</div>' +
                                '<div id="disable" class="self-center">' +
                                '<div class="w-28 grid grid-cols-3 gap-2 ml-2">' +
                                btnDecrement +
                                '<input type="text" data-id="' + value.TransactionDetailID + '" id="quantity" value="' + value.Qty + '" class="change-quantity bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-xs" readonly/>' +
                                btnIncrement +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div id="showNotes">' +
                                '</div>';
                        });
                    }
                    $("#show_cartItem").html(html);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showTotalItemCart() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var urlTotalItemCart = "<?= site_url('favorite/getCartItem/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: urlTotalItemCart,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var totalQty = 0;
                    var totalQtyMain = 0;
                    var totalQtyAdd = 0;
                    for (var i = 0; i < data['getItemTransaction'].length; i++) {
                        var qtyMain = parseInt(data['getItemTransaction'][i].Qty);
                        totalQtyMain += qtyMain;

                        $.each(data['getItemTransaction'][i].Parent, function(index, value) {
                            var qtyAdd = parseInt(value.Qty);
                            totalQtyAdd += qtyAdd;
                        })

                        totalQty = totalQtyMain + totalQtyAdd;
                    }
                    html += '<div class="text-md">' + totalQty + '</div>';
                    $("#show_cartTotalItem").html(html);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showTotalCart() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var urlTotalCart = "<?= site_url('favorite/getCartItem/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: urlTotalCart,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var htmlSubtotal = "";
                    var htmlPPN = "";
                    var htmlServiceCharge = "";
                    var htmlPackageService = "";
                    var htmlTotal = "";
                    var htmlTotalFinal = "";
                    var subTotalMain = 0;
                    var subTotalAdd = 0;
                    var grandTotal = 0;
                    var grandTotalMain = 0;
                    var grandTotalAdd = 0;
                    var totalPPN = 0;
                    var totalServiceCharge = 0;
                    var totalScSt = 0;
                    var totalDiscount = 0;
                    var discount = 0;
                    var totalFinal = 0;

                    for (var i = 0; i < data['getItemTransaction'].length; i++) {
                        var qty = parseInt(data['getItemTransaction'][i].Qty);
                        var price = parseInt(data['getItemTransaction'][i].Price);
                        subTotalMain = qty * price;
                        grandTotalMain += subTotalMain
                        $.each(data['getItemTransaction'][i].Parent, function(index, value) {
                            var qtyAdd = parseInt(value.Qty);
                            var priceAdd = parseInt(value.Price);
                            subTotalAdd = qtyAdd * priceAdd;
                            grandTotalAdd += subTotalAdd;
                        })

                        grandTotal = grandTotalMain + grandTotalAdd
                    }

                    for (var x = 0; x < data['checkTransactionNumber'].length; x++) {
                        if (data['checkTransactionNumber'][x].TransactionType == 2) {
                            document.getElementById('serviceCharge').innerHTML = 'Package & Service';
                        } else {
                            document.getElementById('serviceCharge').innerHTML = 'Service Charge';
                        }

                        discount = data['checkTransactionNumber'][x].Discount;
                    }

                    if (grandTotal <= discount) {
                        totalDiscount = 0;
                        totalPPN = 0;
                        totalServiceCharge = 0;
                        totalFinal = 0;
                    } else {
                        totalDiscount = grandTotal - discount;

                        totalServiceCharge = totalDiscount * 7 / 100;
                        totalScSt = totalDiscount + totalServiceCharge;
                        totalPPN = totalScSt * 10 / 100;
                        totalFinal = totalScSt + totalPPN;
                    }

                    htmlSubTotal = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(grandTotal) + '</div>';

                    htmlPPN = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(Math.ceil(totalPPN)) + '</div>';

                    htmlServiceCharge = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(Math.ceil(totalServiceCharge)) + '</div>';

                    htmlTotal = '<hr class="my-2">' +
                        '<div class="flex mb-1 text-lg font-semibold text-blue-gray-700">' +
                        '<div class="text-sm text-left w-56">Total</div>' +
                        '<div class="text-sm text-right w-24">Rp. </div>' +
                        '<div class="text-sm text-right w-1"></div>' +
                        '<div class="text-sm text-right w-20">' +
                        '<div>' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(Math.ceil(totalDiscount)) + '</div>' +
                        '</div>' +
                        '</div>';

                    htmlTotalFinal = '<hr class="my-2" />' +
                        '<div class="flex mb-1 text-lg font-semibold text-blue-gray-700">' +
                        '<div class="text-sm text-left w-56">Grand Total</div>' +
                        '<div class="text-sm text-right w-24">Rp. </div>' +
                        '<div class="text-sm text-right w-1"></div>' +
                        '<div class="text-sm text-right w-20">' +
                        '<div>' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(Math.ceil(totalFinal / 100) * 100) + '</div>' +
                        '</div>' +
                        '</div>';


                    $("#showSubTotal").html(htmlSubTotal);
                    $("#showPPN").html(htmlPPN);
                    $("#showServiceCharge").html(htmlServiceCharge);
                    $("#showTotal").html(htmlTotal);
                    $("#showTotalFinal").html(htmlTotalFinal);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showDiscount() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var url = "<?= site_url('favorite/getDiscount/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: url,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var htmlTotalFinal = "";
                    var totalPPN = 0;
                    var totalServiceCharge = 0;
                    var subTotal = 0;
                    var grandTotal = 0;
                    var discount = 0;
                    var totalDiscount = 0;
                    var totalFinal = 0;

                    for (var i = 0; i < data['getItemTransaction'].length; i++) {
                        var qty = parseInt(data['getItemTransaction'][i].Qty);
                        var price = parseInt(data['getItemTransaction'][i].Price);
                        subTotal = qty * price;
                        grandTotal += subTotal;
                    }

                    for (var x = 0; x < data['checkTransactionNumber'].length; x++) {
                        html += '<hr class="my-2">' +
                            '<div class="flex text-sm font-semibold text-blue-gray-700">' +
                            '<div class="text-sm text-left w-32">Discount</div>' +
                            '<div class="text-sm text-right w-full">Rp. </div>' +
                            '<div class="text-sm text-right w-28">' +
                            new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(Math.ceil(data['checkTransactionNumber'][x].Discount)) +
                            '</div>' +
                            '<div class="text-sm text-right w-10 text-red-500">' +
                            '<button data-id="' + data['checkTransactionNumber'][x].TransactionID + '" id="removeDiscount" role="button"><i class="fas fa-circle-minus"></i></button>' +
                            '</div>' +
                            '</div>';

                        discount = parseInt(data['checkTransactionNumber'][x].Discount);
                    }

                    if (grandTotal <= discount) {
                        totalDiscount = 0;
                        totalPPN = 0;
                        totalServiceCharge = 0;
                        totalFinal = 0;
                    } else {
                        totalDiscount = grandTotal - discount;
                        totalPPN = totalDiscount * 10 / 100;
                        totalServiceCharge = totalDiscount * 7 / 100;
                        totalFinal = totalDiscount + totalPPN + totalServiceCharge;
                    }

                    htmlSubTotal = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(grandTotal) + '</div>';

                    htmlPPN = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(totalPPN) + '</div>';

                    htmlServiceCharge = '<div>' + new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(totalServiceCharge) + '</div>';

                    htmlTotal = '<hr class="my-2">' +
                        '<div class="flex mb-1 text-lg font-semibold text-blue-gray-700">' +
                        '<div class="text-sm text-left w-56">Total</div>' +
                        '<div class="text-sm text-right w-24">Rp. </div>' +
                        '<div class="text-sm text-right w-1"></div>' +
                        '<div class="text-sm text-right w-20">' +
                        '<div>' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(totalDiscount) + '</div>' +
                        '</div>' +
                        '</div>';

                    htmlTotalFinal = '<hr class="my-2" />' +
                        '<div class="flex mb-1 text-lg font-semibold text-blue-gray-700">' +
                        '<div class="text-sm text-left w-56">Grand Total</div>' +
                        '<div class="text-sm text-right w-24">Rp. </div>' +
                        '<div class="text-sm text-right w-1"></div>' +
                        '<div class="text-sm text-right w-20">' +
                        '<div>' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(totalFinal) + '</div>' +
                        '</div>' +
                        '</div>';

                    if (discount == 0) {
                        $("#showDiscount").addClass("hidden");
                    } else {
                        $("#showDiscount").removeClass("hidden");
                    }

                    $("#showDiscount").html(html);
                    $("#showSubTotal").html(htmlSubTotal);
                    $("#showPPN").html(htmlPPN);
                    $("#showServiceCharge").html(htmlServiceCharge);
                    $("#showTotal").html(htmlTotal);
                    $("#showTotalFinal").html(htmlTotalFinal);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showPaymentMethod() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var urlPaymentMethod = "<?= site_url('favorite/getPaymentMethod/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: urlPaymentMethod,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var nominal = 0;
                    for (var i = 0; i < data.length; i++) {
                        html += '<hr class="my-2">' +
                            '<div class="flex text-sm font-semibold text-blue-gray-700">' +
                            '<div class="text-sm text-left w-32">' + data[i].PaymentMethodName + '</div>' +
                            '<div class="text-sm text-right w-full">Rp. </div>' +
                            '<div class="text-sm text-right w-28">' +
                            new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data[i].Nominal) +
                            '</div>' +
                            '<div class="text-sm text-right w-10 text-red-500">' +
                            '<button data-id="' + data[i].PayMethodTransID + '" id="removePaymentMethod" role="button"><i class="fas fa-circle-minus"></i></button>' +
                            '</div>' +
                            '</div>';
                        nominal = parseInt(data[i].Nominal)
                    }

                    if (nominal == 0) {
                        $("#showPaymentMethod").addClass("hidden");
                    } else {
                        $("#showPaymentMethod").removeClass("hidden");
                    }
                    $("#showPaymentMethod").html(html);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showChanger() {
        var transactionNumber = "<?= $this->uri->segment(2) ?>";
        if (transactionNumber != "") {
            var urlChanger = "<?= site_url('favorite/getChanger/') ?>" + transactionNumber;

            $.ajax({
                type: "ajax",
                url: urlChanger,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var htmlTotal = "";
                    var subTotal = 0;
                    var grandTotal = 0;
                    var nominal = 0;
                    var totalNominal = 0;
                    var changer = 0;
                    var totalPPN = 0;
                    var totalServiceCharge = 0;
                    var totalScSt = 0;
                    var discount = 0;
                    var totalAfterDiscount = 0;
                    var grandtotal = 0;

                    for (var x = 0; x < data["getItemTransaction"].length; x++) {
                        var qty = parseInt(data["getItemTransaction"][x].Qty);
                        var price = parseInt(data["getItemTransaction"][x].Price);
                        subTotal = qty * price;
                        grandTotal += subTotal;
                    }

                    for (var x = 0; x < data['checkTransactionNumber'].length; x++) {
                        if (data['checkTransactionNumber'][x].TransactionType == 1) {
                            totalPPN = grandTotal * 10 / 100;
                            totalServiceCharge = grandTotal * 7 / 100;
                            total = grandTotal + totalPPN + totalServiceCharge;
                        } else {
                            totalPPN = grandTotal * 10 / 100;
                            totalServiceCharge = grandTotal * 7 / 100;
                            total = grandTotal + totalPPN + totalServiceCharge;
                        }

                        discount = data['checkTransactionNumber'][x].Discount;
                    }

                    for (var i = 0; i < data["paymentMethod"].length; i++) {
                        nominal = parseInt(data["paymentMethod"][i].Nominal)
                        totalNominal += nominal
                    }

                    totalAfterDiscount = grandTotal - discount;
                    totalservice = totalAfterDiscount * 7 / 100;
                    totalScSt = totalAfterDiscount + totalservice
                    totalppn = totalScSt * 10 / 100;
                    totalFinal = totalScSt + totalppn;
                    changer = totalNominal - (Math.ceil(totalFinal / 100) * 100);

                    if (discount > grandTotal) {
                        changer = 0;
                    }

                    grandtotal = totalAfterDiscount + totalppn + totalservice;

                    htmlTotal += new Intl.NumberFormat("id-ID", {
                        currency: "IDR"
                    }).format(Math.ceil(grandtotal / 100) * 100);

                    $("#showGrandTotal").html(htmlTotal);

                    if (changer == 0 || changer > 0) {
                        html += '<hr class="my-2">' +
                            '<div class="flex text-sm font-semibold text-green-700">' +
                            '<div class="text-sm text-left w-56">Changer</div>' +
                            '<div class="text-sm text-right w-24">Rp. </div>' +
                            '<div class="text-sm text-right w-1">' +

                            '</div>' +
                            '<div class="text-sm text-right w-20">' +
                            new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(Math.round(changer / 100) * 100) +
                            '</div>' +
                            '</div>';
                        $("#showChanger").html(html);
                        $("#showChanger").removeClass("hidden");
                        $("#underpayment").addClass("hidden");
                    } else {
                        html += '<hr class="my-2">' +
                            '<div id="up" class="flex text-sm font-semibold text-red-500">' +
                            '<div class="text-sm text-left w-56">Underpayment</div>' +
                            '<div class="text-sm text-right w-24">Rp. </div>' +
                            '<div class="text-sm text-right w-1">' +

                            '</div>' +
                            '<div class="text-sm text-right w-20">' +
                            new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(Math.round(changer / 100) * 100) +
                            '</div>' +
                            '</div>';
                        $("#underpayment").html(html);
                        $("#underpayment").removeClass("hidden");
                        $("#showChanger").addClass("hidden");
                    }

                    if (grandTotal == 0) {
                        $("#showChanger").addClass("hidden");
                    }

                    if (discount != 0) {
                        $("#discount").prop("disabled", true);
                        $("#discount").addClass("bg-cyan-400");
                        $("#discount").removeClass("bg-black-50 hover:bg-black-100");
                    } else {
                        $("#discount").prop("disabled", false);
                        $("#discount").removeClass("bg-cyan-400");
                        $("#discount").addClass("bg-black-50 hover:bg-black-100");
                    }

                    if (changer == 0 || changer > 0) {
                        $("#closeBill").addClass("bg-black-50 hover:bg-black-100");
                        $("#closeBill").removeClass("bg-black-100");
                        $("#closeBill").prop("disabled", false);
                        $("#pm").prop("disabled", true);
                        $("#pm").addClass("bg-cyan-400");
                        $("#pm").removeClass("bg-black-50 hover:bg-black-100");

                    } else {
                        $("#pm").prop("disabled", false);
                        $("#pm").removeClass("bg-cyan-400");
                        $("#pm").addClass("bg-black-50 hover:bg-black-100");
                        $("#closeBill").removeClass("bg-black-50 hover:bg-black-100");
                        $("#closeBill").addClass("bg-black-100");
                        $("#closeBill").prop("disabled", true);
                    }

                    if (grandTotal == 0) {
                        $("#closeBill").prop("disabled", true);
                        $("#closeBill").addClass("bg-black-100");
                        $("#closeBill").removeClass("bg-black-50 hover:bg-black-100");
                    }
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        } else {
            return false;
        }
    }

    function showListCustomer() {
        var urlMoveCustomer = "<?= site_url('favorite/getTransaction') ?>";

        $.ajax({
            type: "ajax",
            url: urlMoveCustomer,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";
                var type = "";
                for (var i = 0; i < data.length; i++) {

                    if (data[i].TransactionType == 1) {
                        type = 'Dine In';
                        detail = '<button type="button" id="btn-detailDineIn" data-tabid="' + data[i].TableID + '" data-id="' + data[i].TransactionID + '" data-type="' + data[i].TransactionType + '" class="pl-5 pr-5 ml-3 whitespace-nowrap font-normal text-white text-center text-sm px-2.5 py-0.5 rounded-xl bg-black-50 hover:bg-black-100"><i class="fas fa-info"></i></button>';
                    } else {
                        type = 'Take Away';
                        detail = '<span class="pl-5 pr-5 ml-3 whitespace-nowrap font-normal text-white text-center text-sm px-2.5 py-0.5 rounded-xl"></span>';
                    }

                    html += '<li class="flex">' +
                        '<a href="<?= site_url() ?>favorite-list/' + data[i].TransactionNumber + '" class="flex items-center p-3 text-base font-bold text-gray-700 bg-cyan-50 rounded-2xl hover:bg-blue-300 group hover:shadow bg-gray-600 hover:bg-gray-500 hover:text-white text-white w-full">' +
                        '<i class="fas fa-user mr-2"></i>' +
                        '<span class="flex-1 ml-3 whitespace-nowrap font-normal text-sm">' + data[i].CustomerName + '</span>' +
                        '<span class="flex-1 ml-3 whitespace-nowrap font-normal text-white text-center text-sm py-0.5 rounded-xl bg-yellow-500">' + type + '</span>' +

                        '<span class="flex-1 ml-3 whitespace-nowrap font-normal text-sm text-right">' + moment(data[i].TransactionDatetime).format('HH:mm') + '</span>' +
                        '</a>' +
                        detail +
                        '</li>';
                }
                $("#showListCustomer").html(html);
                $('ul.list-cs a').filter(function() {
                    return this.href == url;
                }).addClass('active');
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showCloseBillForConfirm() {
        var url = "<?= site_url('favorite/getDataCloseBillForConfirm') ?>";

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";
                var btnConfirm = "";
                //var progress = "";

                for (var i = 0; i < data.length; i++) {

                    if (data[i].StatusTransaction == 1) {
                        btnConfirm = '';
                        //progress = '<div class="transition-all ease-out duration-1000 bg-blue-300 h-full w-0 text-xs absolute text-center text-gray-600 font-semibold"></div>';
                    } else if (data[i].StatusTransaction == 2) {
                        setInterval(myInterval);
                        btnConfirm = '';
                        //progress = '<div class="transition-all ease-out duration-1000 bg-blue-300 h-full w-32 text-xs absolute text-center text-gray-600 font-semibold">Waiting</div>';
                    } else if (data[i].StatusTransaction == 3) {
                        setInterval(myInterval);
                        btnConfirm = '';
                        //progress = '<div class="transition-all ease-out duration-1000 bg-blue-300 relative h-full w-60 text-xs absolute text-center text-gray-600 font-semibold">Preparing</div>';
                    } else if (data[i].StatusTransaction == 4) {
                        setInterval(myInterval);
                        btnConfirm = '<button id="btn-complete" data-id="' + data[i].TransactionID + '" type="button" class="flex-2 ml-2 whitespace-nowrap text-center font-normal text-sm text-white bg-cyan-300 hover:bg-cyan-200 focus:outline-none rounded-lg border border-black-20 text-sm font-medium px-2 py-0.5 focus:z-10">Complete</button>';
                        //progress = '<div class="transition-all ease-out duration-1000 bg-blue-300 relative h-full w-72 text-xs absolute text-center text-gray-600 font-semibold">Ready</div>';
                    } else if (data[i].StatusTransaction == 5) {
                        btnConfirm = '';
                        //progress = '<div class="transition-all ease-out duration-1000 bg-blue-300 relative h-full w-100 text-xs absolute text-center text-gray-600 font-semibold">Complete</div>';
                    } else {
                        btnConfirm = '';
                    }

                    html += '<li>' +
                        '<a class="flex items-center p-3 text-base font-bold text-gray-700 bg-cyan-50 rounded-2xl group w-full">' +
                        '<i class="fas fa-user mr-2"></i>' +
                        '<span class="flex-1 ml-3 whitespace-nowrap font-normal">' + data[i].CustomerName + '</span>' +
                        '<button id="btn-detailConfirm" data-tabid="' + data[i].TableID + '" data-id="' + data[i].TransactionID + '" data-type="' + data[i].TransactionType + '" type="button" class="flex-2 ml-2 whitespace-nowrap text-center font-normal text-sm text-white bg-black-50 hover:bg-black-100 focus:outline-none rounded-lg border border-black-20 text-sm font-medium px-2 py-0.5 focus:z-10">Detail</button>' +
                        btnConfirm +
                        '<span class="ml-3 whitespace-nowrap font-normal text-sm text-right">' + moment(data[i].update_at).format('HH:mm') + '</span>' +
                        '</a>' +
                        '</li>' +
                        '<div class="h-4 relative max-w-lg rounded-full overflow-hidden">' +
                        // '<div id="bar" class="w-full h-full bg-gray-200 absolute">' +
                        // progress +
                        // '</div>' +
                        '</div>';
                }
                $(".list-close-bill").html(html);

                var bars = document.querySelectorAll('#bar > div');
                console.clear();

                setInterval(function() {
                    bars.forEach(function(bar) {
                        var getWidth = parseFloat(bar.dataset.progress);

                        for (var i = 0; i < getWidth; i++) {
                            bar.style.width = i + '%';
                        }
                    });
                }, 500);
            }
        });
    }

    function showTransactionCloseBill() {
        var url = "<?= site_url('favorite/getDataCloseBillForConfirm') ?>";

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            async: true,
            dataType: "json",
            success: function(data) {
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    if (data[i].TableID == 0) {
                        html += '<div class="radio mb-1">' +
                            '<input type="radio" id="' + data[i].TransactionNumber + '" name="idTransaction" value="' + data[i].TransactionID + '" required>' +
                            '<label for="' + data[i].TransactionNumber + '" class="block text-left text-sm px-3 py-2 bg-white rounded-lg border border-grey border-solid border-2">' +
                            '<div class="font-semibold tracking-wide"><strong>' + data[i].CustomerName + '</strong></div>' +
                            '</label>' +
                            '</div>';
                    } else {
                        html += '';
                    }
                }
                $("#showTableCloseBill").html(html);
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showDataMenuSearch(query) {
        var urlLiveSearchMenu = "<?= site_url('favorite/liveSearchMenu') ?>";

        $.ajax({
            type: "ajax",
            url: urlLiveSearchMenu,
            method: "POST",
            data: {
                query: query
            },
            success: function(data) {
                console.log(data);
                if (JSON.parse(data) != "") {
                    var html = "";
                    var menuImage = "";
                    $.each(JSON.parse(data), function(index, value) {
                        if (value.MenuImage == null || value.MenuImage == '') {
                            menuImage = '<img src="<?= site_url('vendor/img/logo/logo-milou.png') ?>" alt="' + value.MenuName + '" />';
                        } else {
                            menuImage = '<img src="http://151.106.113.196:8097/assets/dist/menuimg/' + value.MenuImage + '" alt="' + value.MenuName + '" />';
                        }
                        html += '<div id="mydiv" role="button" data-id="' + value.MenuID + '" data-name="' + value.MenuName + '" data-price="' + value.MenuPrice + '" data-image="' + value.MenuImage + '" class="add-cart select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg">' +
                            menuImage +
                            '<div class="flex pb-3 px-3 text-sm -mt-3">' +
                            '<p class="flex-grow truncate mr-1">' + value.MenuName + '</p>' +
                            '<p class="nowrap font-semibold">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(value.MenuPrice) + '</p>' +
                            '</div>' +
                            '</div>';
                    });
                    $("#show_menu").addClass("grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-3");
                    $("#show_menu").removeClass("h-full overflow-y-auto");
                    $("#show_menu").html(html);
                } else {
                    var htmlEmpty = "";
                    htmlEmpty += '<div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25">' +
                        '<div class="w-full text-center">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />' +
                        '</svg>' +
                        '<p class="text-xl">' +
                        'EMPTY SEARCH RESULT' +
                        '<br />' +
                        '<span class="font-semibold"></span>' +
                        '</p>' +
                        '</div>' +
                        '</div>';

                    $("#show_menu").removeClass("grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-3");
                    $("#show_menu").addClass("h-full overflow-y-auto");
                    $("#show_menu").html(htmlEmpty);
                }
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showDatalistCustomer(query) {
        var urlLiveSearchCustomer = "<?= site_url('favorite/liveSearchListCustomer') ?>";

        $.ajax({
            type: "ajax",
            url: urlLiveSearchCustomer,
            method: "POST",
            data: {
                query: query
            },
            success: function(data) {
                if (JSON.parse(data) != "") {
                    var html = "";
                    $.each(JSON.parse(data), function(index, value) {
                        html += '<li class="mr-1">' +
                            '<a href="<?= site_url() ?>favorite-list/' + value.TransactionNumber + '" class="flex items-center p-3 text-base font-bold text-gray-700 bg-cyan-50 rounded-lg hover:bg-cyan-100 group hover:shadow bg-gray-600 hover:bg-gray-500 text-white w-full">' +
                            '<i class="fas fa-user"></i>' +
                            '<span class="flex-1 ml-3 whitespace-nowrap font-normal">' + value.CustomerName + '</span>' +
                            '<span class="flex-1 ml-3 whitespace-nowrap font-normal text-sm text-right">' + moment(value.TransactionDatetime).format('DD MMM YYYY HH:mm') + '</span>' +
                            '</a>' +
                            '</li>';
                    });
                    $("#myz").addClass("overflow-y-auto overflow-x-hidden");
                    $("#showListCustomer").removeClass("h-full");
                    $("#showListCustomer").html(html);
                } else {
                    var htmlEmpty = "";
                    htmlEmpty += '<div class="select-none flex flex-wrap content-center justify-center h-full opacity-25">' +
                        '<div class="w-full text-center">' +
                        '<p class="text-sm">' +
                        'Data Not Available' +
                        '<br />' +
                        '<span class="font-semibold"></span>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                    $("#myz").removeClass("overflow-y-auto overflow-x-hidden");
                    $("#showListCustomer").addClass("h-full");
                    $("#showListCustomer").html(htmlEmpty);
                }
            },
            error: (error) => {
                console.log(JSON.stringify(error));
            }
        });
    }

    function showDetailOrder() {
        $(document).on("click", "#btn-detailConfirm", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/getDetailOrder') ?>";
            var id = $(this).data("id");

            const targetEl = document.getElementById('detailCustomerModal');
            const modal = new Modal(targetEl);
            modal.show();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    var htmlTbl = ""
                    var htmlTrs = "";
                    var htmlBtn = "";
                    var tblnum = "";
                    var statusItems = "";
                    $.each(data, function(index, value) {

                        if (value.StatusTransaction == 5) {
                            $("#saveTableButton").addClass("hidden");
                        } else {
                            $("#saveTableButton").removeClass("hidden");
                        }

                        if (value.TableNumber == '') {
                            tblnum = '<div class="flex-grow text-right">No Table</div>';
                        } else {
                            tblnum = '<div class="flex-grow text-right">' + value.TableNumber + '</div>';
                        }

                        if (value.StatusTransactionDetail == 1) {
                            statusItems = '<td class="py-1 w-3/12 text-center font-semibold">' +
                                '<span class="bg-green-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-lg">Ready</span>' +
                                '</td>';
                        } else {
                            statusItems = '<td class="py-1 w-3/12 text-center font-semibold"><i class="fas fa-clock"></i></td>';
                        }

                        if (value.TransactionType == 1) {
                            $("#showSelectTable").removeClass("hidden");

                            htmlTbl = '<div class="flex text-sm font-semibold">' +
                                '<div class="flex-grow">Table</div>' +
                                tblnum +
                                '</div>' +
                                '<input type="hidden" id="transType" value="' + value.TransactionType + '">' +
                                '<input type="hidden" id="idt" value="' + value.TransactionID + '">' +
                                '<input type="hidden" id="idtbl" value="' + value.TableID + '">';
                        } else {
                            $("#showSelectTable").addClass("hidden");
                            $("#tableNumber").val(0);

                            htmlTbl = '<div class="flex text-sm font-semibold">' +
                                '<div class="flex-grow">Transaction Type</div>' +
                                '<div>Take Away</div>' +
                                '</div>' +
                                '<input type="hidden" id="transType" value="' + value.TransactionType + '">' +
                                '<input type="hidden" id="idt" value="' + value.TransactionID + '">' +
                                '<input type="hidden" id="idtbl" value="' + value.TableID + '">';
                        }

                        if (value.StatusForKitchen == 1 || value.StatusForKitchen == 2) {
                            $("#btnConfirmTakeAway").addClass("hidden");
                        } else {
                            $("#btnConfirmTakeAway").removeClass("hidden");
                        }

                        htmlTrs += '<tr class="pr-2">' +
                            '<td class="py-1 text-left"><span>' + value.MenuName + '</span></td>' +
                            '<td class="py-1 w-2/12 text-center font-semibold">' + value.Qty + '</td>' +
                            statusItems +
                            '</tr>';

                        htmlBtn = '<button type="button" onclick="printSummary(' + value.TransactionNumber + ')" target="_blank" class="text-white w-full bg-black-50 hover:bg-black-100 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-md px-4 py-1 text-center items-center mr-2 mb-2">Print Summary</button>';
                    });
                    $("#showBtnPrintSummary").html(htmlBtn);
                    $("#showTbl").html(htmlTbl);
                    $("#showTrs").html(htmlTrs);
                }
            });
        });
    }

    function showDetailOrderDineIn() {
        $(document).on("click", "#btn-detailDineIn", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/getDetailOrderDineIn') ?>";
            var id = $(this).data("id");

            const targetEl = document.getElementById('detailCustomerDineInModal');
            const modal = new Modal(targetEl);
            modal.show();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    var htmlTbl = ""
                    var htmlTrs = "";
                    var htmlInputTable = "";
                    var tblnum = "";
                    var statusItems = "";
                    var statusKitchen = "";
                    var statusDelivered = "";
                    var statusItemsAdd = "";
                    var statusKitchenAdd = "";
                    var statusDeliveredAdd = "";

                    for (var i = 0; i < data['transaction'].length; i++) {
                        if (data['transaction'][i].TableNumber != '') {
                            htmlInputTable = '';
                            tblnum = '<div class="flex-grow text-right">' + data['transaction'][i].TableNumber + '</div>';
                        } else {
                            htmlInputTable = '<div class="inline-block relative w-full px-1">' +
                                '<input type="number" name="tableNumber" id="tableNumber" class="showInputDineIn w-full bg-white shadow border rounded-lg focus:bg-white focus:shadow-lg text-gray-700 py-2 px-3 leading-tight focus:outline-none" placeholder="Table Number" required />' +
                                '</div>' +
                                '<div class="items-center space-x-2 rounded-b">' +
                                '<button type="button" id="btnSaveTable" data-id="' + data['transaction'][i].TransactionID + '" class="showSaveTableButton bg-black-50 hover:bg-black-100 text-white text-md mt-2 py-1 rounded-lg w-full focus:outline-none">Save Table</button>' +
                                '</div>' +
                                '<hr class="showSaveTableButton my-2">';
                            tblnum = '<div class="flex-grow text-right">Table Not Selected</div>';
                        }

                        htmlTbl = '<div class="flex text-sm font-semibold">' +
                            '<div class="flex-grow">Table</div>' +
                            tblnum +
                            '</div>' +
                            '<input type="hidden" id="transType" value="' + data['transaction'][i].TransactionType + '">' +
                            '<input type="hidden" id="idt" value="' + data['transaction'][i].TransactionID + '">' +
                            '<input type="hidden" id="idtbl" value="' + data['transaction'][i].TableID + '">';
                    }

                    if (data['count'].total < 1) {
                        htmlTrs = '<hr class="my-2" />' +
                            '<div class="w-full text-center mt-2">' +
                            '<span>Item Not Found</span>' +
                            '</div>';
                    } else {

                        for (var j = 0; j < data['transactionDetail'].length; j++) {
                            if (data['transactionDetail'][j].StatusTransactionDetail == 1) {
                                statusItems = '<td class="py-1 w-3/12 text-center font-semibold">' +
                                    '<span class="bg-green-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-lg">Ready</span>' +
                                    '</td>';
                                statusDelivered = '<input id="delivered" data-id="' + data['transactionDetail'][j].TransactionDetailID + '" name="delivered" type="checkbox" value="1" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">';
                            } else {
                                statusItems = '<td class="py-1 w-3/12 text-center font-semibold"><i class="fas fa-clock"></i></td>';
                                statusDelivered = '<input disabled type="checkbox" value="" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">'
                            }

                            if (data['transactionDetail'][j].StatusDelivered == 1) {
                                statusDelivered = '<input disabled checked type="checkbox" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">';
                            }

                            if (data['transactionDetail'][j].StatusForKitchen == 1 || data['transactionDetail'][j].StatusForKitchen == 2) {
                                statusKitchen = '<i class="fas fa-circle-check"></i>';
                            } else {
                                statusKitchen = '<button type="button" id="btnConfirmDineIn" data-transaction="' + data['transactionDetail'][j].TransactionID + '" data-detail="' + data['transactionDetail'][j].TransactionDetailID + '" class="pl-5 pr-5 ml-3 whitespace-nowrap font-normal text-white text-center text-sm px-2.5 py-0.5 rounded-lg bg-black-50 hover:bg-black-100">Confirm</button>';
                            }

                            htmlTrs += '<tr class="pr-2">' +
                                '<td class="py-1 w-5/12 text-left"><span>' + data['transactionDetail'][j].MenuName + '</span></td>' +
                                '<td class="py-1 w-2/12 text-center font-semibold">' + data['transactionDetail'][j].Qty + '</td>' +
                                '<td class="py-1 w-3/12 text-center font-semibold">' + statusKitchen + '</td>' +
                                statusItems +
                                '<td class="py-1 w-2/12 text-center font-semibold">' +
                                statusDelivered +
                                '</td>' +
                                '</tr>';

                            $.each(data['transactionDetail'][j].Parent, function(index, value) {
                                if (value.StatusTransactionDetail == 1) {
                                    statusItemsAdd = '<td class="py-1 w-3/12 text-center font-semibold">' +
                                        '<span class="bg-green-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-lg">Ready</span>' +
                                        '</td>';
                                    statusDeliveredAdd = '<input id="delivered" data-id="' + value.TransactionDetailID + '" name="delivered" type="checkbox" value="1" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">';
                                } else {
                                    statusItemsAdd = '<td class="py-1 w-3/12 text-center font-semibold"><i class="fas fa-clock"></i></td>';
                                    statusDeliveredAdd = '<input disabled type="checkbox" value="" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">'
                                }

                                if (value.StatusDelivered == 1) {
                                    statusDeliveredAdd = '<input disabled checked type="checkbox" class="items w-4 h-4 text-black bg-gray-100 rounded border-gray-300 focus:ring-black">';
                                }

                                if (value.StatusForKitchen == 1 || value.StatusForKitchen == 2) {
                                    statusKitchenAdd = '<i class="fas fa-circle-check"></i>';
                                } else {
                                    statusKitchenAdd = '<button type="button" id="btnConfirmDineIn" data-transaction="' + value.TransactionID + '" data-detail="' + value.TransactionDetailID + '" class="pl-5 pr-5 ml-3 whitespace-nowrap font-normal text-white text-center text-sm px-2.5 py-0.5 rounded-lg bg-black-50 hover:bg-black-100">Confirm</button>';
                                }
                                htmlTrs += '<tr class="pr-2">' +
                                    '<td class="py-1 w-5/12 text-left"><span>' + value.MenuName + '</span></td>' +
                                    '<td class="py-1 w-2/12 text-center font-semibold">' + value.Qty + '</td>' +
                                    '<td class="py-1 w-3/12 text-center font-semibold">' + statusKitchenAdd + '</td>' +
                                    statusItemsAdd +
                                    '<td class="py-1 w-2/12 text-center font-semibold">' +
                                    statusDeliveredAdd +
                                    '</td>' +
                                    '</tr>';
                            })
                        }
                    }
                    $("#showInputTable").html(htmlInputTable);
                    $("#showTblDineIn").html(htmlTbl);
                    $("#showTrsDineIn").html(htmlTrs);
                }
            });
        });
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function beep() {
        const audio = new Audio('../vendor/sound/beep-29.mp3');
        audio.play();
    }

    function clearSound() {
        var csMusic = new Audio('../vendor/sound/button-21.mp3')
        csMusic.play();
    }

    /* show active sidebar */
    var url = window.location.href;

    $('ul.menu a').filter(function() {
        return this.href == url;
    }).addClass('active');

    $('[name=tab]').each(function(i, d) {
        var content = $(this).prop('checked');

        if (content) {
            $('.tab-content').eq(i)
                .addClass('active');
        }
    });

    $('[name=tab]').on('change', function() {
        var content = $(this).prop('checked');

        var i = $('[name=tab]').index(this);

        $('.tab-content').removeClass('active');
        $('.tab-content').eq(i).addClass('active');
    });

    $('.transType').click(function() {
        if (!$(this).hasClass('bg-cyan-400 text-white')) {
            $(this).addClass('bg-cyan-400 text-white');
            $(this).removeClass('text-gray-400');
        }
    });

    function printDiv(divName, transNumber) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function printSummary(transNumber) {
        $.ajax({
            type: "ajax",
            url: "http://192.168.18.173/printtest/index.php?transNumber=" + transNumber,
            method: "GET",
            crossDomain: true,
            async: true,
            dataType: "json",
            success: function(data) {
                console.log('qweqwe');
                location.reload();
                return false;
            }
        });
    }

    /* callback */
    $(document).ready(function() {
        showDataMenu();
        showCategoryMenu();
        showCartItem();
        showTotalItemCart();
        showTotalCart();
        showListCustomer();
        showCloseBillForConfirm();
        showDiscount();
        showPaymentMethod();
        showChanger();
        transactionByStatus();
        reportIncomeByDate();
        showDetailOrder();
        showDetailOrderDineIn();
        itemLoad();
        destroyAll();

        $('#myTable').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });

        $('#voidTransaction').DataTable({
            lengthChange: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });

        $(document).on("click", "#closeModalDetailOrder", function() {
            const targetEl = document.getElementById('detailCustomerModal');
            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        });

        $(document).on("click", "#closeModalDetailOrderDineIn", function() {
            const targetEl = document.getElementById('detailCustomerDineInModal');
            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        });

        $("#formTableCloseBill").on("submit", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/updateTable') ?>";
            var idTransaction = $("#idt").val();
            var tableNumber = $("#tableNumber").val();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    tableNumber: tableNumber,
                    idTransaction: idTransaction
                },
                success: function(data) {
                    //showDetailOrder();
                    const targetEl = document.getElementById('detailCustomerModal');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                    //location.reload();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#btnSaveTable", function() {
            var url = "<?= site_url('favorite/updateTableForDineIn') ?>";
            var idTransaction = $("#idt").val();
            var tableNumber = $("#tableNumber").val();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    tableNumber: tableNumber,
                    idTransaction: idTransaction
                },
                success: function(data) {
                    const targetEl = document.getElementById('detailCustomerDineInModal');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                }
            })
        })

        $(document).on("click", "#btnConfirmDineIn", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/confirmForDineIn') ?>";
            var idTransactionDetail = $(this).data('detail');
            var idTransaction = $(this).data('transaction');

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    idTransactionDetail: idTransactionDetail,
                    idTransaction: idTransaction
                },
                success: function(data) {
                    const targetEl = document.getElementById('detailCustomerDineInModal');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            })
        })

        $(document).on("click", "#filter", function(e) {
            e.preventDefault();

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if (start_date != "" || end_date != "") {
                $('#reportTransaction').DataTable().destroy();
                transactionByStatus(start_date, end_date);
            }
        });

        $(document).on("click", "#filterIncome", function(e) {
            e.preventDefault();

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if (start_date != "" || end_date != "") {
                $('#incomeReportTransaction').DataTable().destroy();
                reportIncomeByDate(start_date, end_date);
            }
        });

        $(document).on("click", "#reset", function(e) {
            e.preventDefault();

            $("#start_date").val(''); // empty value
            $("#end_date").val('');

            $('#reportTransaction').DataTable().destroy();
            transactionByStatus();
        });

        $(document).on("click", "#resetIncome", function(e) {
            e.preventDefault();

            $("#start_date").val(''); // empty value
            $("#end_date").val('');

            $('#incomeReportTransaction').DataTable().destroy();
            reportIncomeByDate();
        });

        $(document).on("click", "#showCreateNewCustomer", function() {
            $("#my").removeClass("hidden");
            $("#myx").addClass("hidden");
        });

        $(document).on("click", ".moveCategoryMenu", function() {
            var urlGetMenu = "<?= site_url('favorite/getFavorite') ?>";
            var segment = "<?= $this->uri->segment(2) ?>";
            var id_category = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: urlGetMenu,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var menuImage = "";
                    var getSegment = segment;
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].MenuImage == null || data[i].MenuImage == '') {
                            menuImage = '<img src="<?= site_url('vendor/img/logo/logo-milou.png') ?>" alt="Milou Farm House" />';
                        } else {
                            menuImage = '<img src="http://151.106.113.196:8097/assets/dist/menuimg/' + data[i].MenuImage + '" alt="' + data[i].MenuName + '" />';
                        }

                        if (id_category == data[i].CategoryName) {
                            html += '<div id="mydiv" role="button" data-id="' + data[i].MenuID + '" data-name="' + data[i].MenuName + '" data-price="' + data[i].MenuPrice + '" data-image="' + data[i].MenuImage + '" class="add-cart select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg">' +
                                menuImage +
                                '<div class="flex pb-3 px-3 text-sm -mt-3">' +
                                '<p class="flex-grow truncate mr-1">' + data[i].MenuName + data[i].MenuImage + '</p>' +
                                '<p class="nowrap font-semibold">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(data[i].MenuPrice) + '</p>' +
                                '</div>' +
                                '</div>';
                        }

                        if (id_category == 1) {
                            html += '<div id="mydiv" role="button" data-id="' + data[i].MenuID + '" data-name="' + data[i].MenuName + '" data-price="' + data[i].MenuPrice + '" data-image="' + data[i].MenuImage + '" class="add-cart select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg">' +
                                menuIamge +
                                '<div class="flex pb-3 px-3 text-sm -mt-3">' +
                                '<p class="flex-grow truncate mr-1">' + data[i].MenuName + '</p>' +
                                '<p class="nowrap font-semibold">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(data[i].MenuPrice) + '</p>' +
                                '</div>' +
                                '</div>';
                        }
                    }
                    $("#show_menu").html(html);
                    if (getSegment) {
                        $("#show_menu").removeClass("disabledbutton");
                    } else {
                        $("#show_menu").addClass("disabledbutton");
                    }
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#addOn", function() {
            const targetEl = document.getElementById('modalAddOn');
            const modal = new Modal(targetEl);
            modal.show();

            var url = "<?= site_url('favorite/getMenuAddOn') ?>";
            var menuId = $(this).data("id");
            var transactionDetailId = $(this).data("idtransactiondetail");

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    menuId: menuId
                },
                success: function(data) {
                    var html = "";

                    $.each(JSON.parse(data), function(index, value) {
                        html += '<div class="flex items-center mb-1">' +
                            '<div class="w-5 mt-2 text-left">' +
                            '<input id="red-checkbox" name="menuIdAddOn[]" type="checkbox" value="' + value.MenuID + '" class="w-4 h-4 text-red-600 bg-gray-100 rounded border-gray-300 focus:ring-red-500">' +
                            '<input type="hidden" name="transactiondetailid" value="' + transactionDetailId + '" />' +
                            '</div>' +
                            '<div class="w-full">' +
                            '<label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900">' + value.MenuName + '</label>' +
                            '</div>' +
                            '<div class="w-20 text-sm font-bold">' +
                            '<span>' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(value.MenuPrice) + '</span>' +
                            '</div>' +
                            '</div>';
                    })
                    $("#showAddOn").html(html)
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            })
        })

        $("#submit").on("click", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>"
            var url = "<?= site_url('favorite/addOnMenu/') ?>" + transactionNumber
            var formData = $("#formAddOn").serializeArray();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: formData,
                success: function(data) {
                    showCartItem();
                    const targetEl = document.getElementById('modalAddOn');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                }
            });
        });

        $(document).on("click", "#closeModalAddOn", function() {
            const targetEl = document.getElementById('modalAddOn');
            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        })

        $(document).on("click", ".add-cart", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var menu_id = $(this).data("id");
            var menu_name = $(this).data("name");
            var menu_image = $(this).data("image");
            var menu_price = $(this).data("price");
            var menu_quantity = 1;

            $.ajax({
                url: "<?= site_url('favorite/addToCart/') ?>" + transactionNumber,
                method: "POST",
                data: {
                    menu_id: menu_id,
                    menu_name: menu_name,
                    menu_price: menu_price,
                    menu_image: menu_image,
                    menu_quantity: menu_quantity
                },
                success: function(data) {
                    showCartItem();
                    showTotalItemCart();
                    showTotalCart();
                    showChanger();
                    beep();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $("#formNotes").on("submit", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/addNotes') ?>";
            var form = $("#formNotes").serialize();

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: form,
                dataType: "json",
                success: function(data) {
                    showCartItem();
                    showTotalItemCart();
                    showTotalCart();
                    showChanger();

                    const targetEl = document.getElementById('modal-note-detail');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", ".decrement-cart", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var transaction_detail_id = $(this).data('id');
            var statusTransaction = $(this).data('status');
            var menu_quantity = parseInt($(this).data('qty')) - 1;

            if (menu_quantity < 1) {
                if (statusTransaction == null) {
                    $.ajax({
                        url: "<?= site_url('favorite/destroyCartItem/') ?>" + transactionNumber,
                        method: "POST",
                        data: {
                            transaction_detail_id: transaction_detail_id
                        },
                        success: function(data) {
                            console.log(data);
                            showCartItem();
                            showTotalItemCart();
                            showTotalCart();
                            showChanger();
                            clearSound();
                        },
                        error: (error) => {
                            console.log(JSON.stringify(error));
                        }
                    });
                } else {
                    window.location.href = "<?= site_url("favorite-list") ?>";
                    alert("Transaksi ini sudah selesai!");
                }

            } else {
                $.ajax({
                    url: "<?= site_url('favorite/increment_decrementQtyCart/') ?>" + transactionNumber,
                    method: "POST",
                    data: {
                        transaction_detail_id: transaction_detail_id,
                        menu_quantity: menu_quantity
                    },
                    success: function(data) {
                        showCartItem();
                        showTotalItemCart();
                        showTotalCart();
                        showChanger();
                        beep();
                    },
                    error: (error) => {
                        console.log(JSON.stringify(error));
                    }
                });
            }
        });

        $(document).on("click", ".increment-cart", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var transaction_detail_id = $(this).data('id');
            var menu_quantity = parseInt($(this).data('qty')) + 1;

            $.ajax({
                url: "<?= site_url('favorite/increment_decrementQtyCart/') ?>" + transactionNumber,
                method: "POST",
                data: {
                    transaction_detail_id: transaction_detail_id,
                    menu_quantity: menu_quantity
                },
                success: function(data) {
                    showCartItem();
                    showTotalItemCart();
                    showTotalCart();
                    showChanger();
                    beep();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("keyup change", ".change-quantity", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var menu_id = $(this).data('id');
            var menu_quantity = $(this).val();

            $.ajax({
                url: "<?= site_url('favorite/increment_decrementQtyCart/') ?>" + transactionNumber,
                method: "POST",
                data: {
                    menu_id: menu_id,
                    menu_quantity: menu_quantity
                },
                success: function(data) {
                    showCartItem();
                    showTotalItemCart();
                    showTotalCart();
                    showChanger();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#destroy-cart", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var url = "<?= site_url('favorite/destroyAllCartItem/') ?>" + transactionNumber;
            var statusTransaction = $(this).data('status');

            if (statusTransaction == null) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    data: {},
                    success: function(data) {
                        console.log(data);
                        showCartItem();
                        showTotalItemCart();
                        showTotalCart();
                        showChanger();
                        clearSound();
                    },
                    error: (error) => {
                        console.log(JSON.stringify(error));
                    }
                });
            } else {
                window.location.href = "<?= site_url("favorite-list") ?>";
                alert("Transaksi ini sudah selesai!");
            }
        });

        var zero = 0;
        $(document).on("click", "#button-cash", function(e) {
            e.preventDefault();
            var amount = $(this).data('amount');
            zero += amount;
            var result = zero;
            var inputCash = $("#inputCash").val(new Intl.NumberFormat("id-ID", {
                currency: "IDR"
            }).format(result));

            if (inputCash === "") {
                zero = 0;
            }
            beep();
        });

        $(document).on("keyup", "#inputCash", function() {
            var inputCash = document.getElementById('inputCash');
            inputCash.addEventListener('keyup', function(e) {
                inputCash.value = formatRupiah(this.value);
            });
            var newInput = parseInt(inputCash.value.replace(/[^0-9]/g, ''), 10);
            zero = newInput;

            if (inputCash.value === "") {
                zero = 0;
            } else {
                newInput += zero;
            }
            beep();
            //if (isNaN(newInput)) newInput = 0;
        });

        $(document).on("keyup", "#discounts", function() {
            var discounts = document.getElementById('discounts');
            discounts.addEventListener('keyup', function(e) {
                discounts.value = formatRupiah(this.value);
            });
            var newInput = parseInt(discounts.value.replace(/[^0-9]/g, ''), 10);
            zero = newInput;

            if (discounts.value === "") {
                zero = 0;
            } else {
                newInput += zero;
            }
            beep();
        });

        $("#formDiscount").on("submit", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var url = "<?= site_url('favorite/saveDiscount/') ?>" + transactionNumber;
            var input = document.getElementById("discounts");
            var discounts = input.value;

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    discounts: discounts
                },
                success: function(data) {
                    console.log(data);
                    document.getElementById('form').reset();
                    $("#closeDiscount").click();
                    showCartItem();
                    showDiscount();
                    showChanger();
                    zero = 0;
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#removeDiscount", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var url = "<?= site_url('favorite/removeDiscount/') ?>" + transactionNumber;
            var id = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    showCartItem();
                    showDiscount();
                    showChanger();
                    clearSound();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $("#form").on("submit", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var urlSavePaymentMethod = "<?= site_url('favorite/saveMethodPayment/') ?>" + transactionNumber;
            var idTransaction = $("#idTransaction").val();
            var select = document.getElementById("paymentMethod");
            var idPaymentMethod = select.options[select.selectedIndex].value;
            var input = document.getElementById("inputCash");
            var inputCash = input.value;

            $.ajax({
                type: "ajax",
                url: urlSavePaymentMethod,
                method: "POST",
                data: {
                    idTransaction: idTransaction,
                    idPaymentMethod: idPaymentMethod,
                    inputCash: inputCash
                },
                success: function(data) {
                    document.getElementById('form').reset();
                    $("#close").click();
                    showCartItem();
                    showPaymentMethod();
                    showChanger();
                    beep();
                    zero = 0;
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#removePaymentMethod", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var id = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: "<?= site_url('favorite/removePaymentMethod/') ?>" + transactionNumber,
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    showCartItem();
                    showPaymentMethod();
                    showChanger();
                    clearSound();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $("#formCloseBill").on("click", "#closeBill", function(e) {
            e.preventDefault();
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var url = "<?= site_url('favorite/closeBill/') ?>" + transactionNumber;
            var form = $("#formCloseBill").serialize();
            var statusTransaction = $(this).data('status');

            if (statusTransaction == null) {
                const targetEl = document.getElementById('printBill');
                const modal = new Modal(targetEl);
                modal.show();

                $.ajax({
                    type: "ajax",
                    url: url,
                    method: "POST",
                    data: form,
                    dataType: "json",
                    success: function(data) {
                        showPrintBill();
                    }
                });
            } else {
                window.location.href = "<?= site_url('favorite-list') ?>"
                alert("Transaksi ini sudah selesai!");
            }
        });

        // Sabbil Imoetzz
        function showPrintBill() {
            var transactionNumber = "<?= $this->uri->segment(2) ?>";
            var url = "<?= site_url('favorite/getDataCloseBill/') ?>" + transactionNumber;
            var session = "<?= $this->session->userdata('Username') ?>";

            $.ajax({
                url: url,
                method: "GET",
                async: true,
                dataType: "json",
                success: function(data) {
                    var htmlTransaction = "";
                    var htmlTransactionFinal = "";
                    var htmlTransactionDetail = "";
                    var htmlPaymentMethod = "";
                    var htmlChange = "";
                    var transactionType = "";
                    var subTotalPrice = "";
                    var subTotalPriceAdd = "";
                    var no = 1;
                    var totalTransaction = "";
                    var countPrice = 0;
                    var change = 0;
                    var ppn = "";
                    var sc = "";
                    var pns = "";
                    var footer = "";
                    var discount = "";
                    var totalDiscount = 0;
                    var grandTotal = 0;

                    for (var x = 0; x < data['transaction'].length; x++) {

                        if (data['transaction'][x].StatusTransaction == 5) {
                            footer = '<span>Thank you for coming</span><br />' +
                                '<span><i class="fab fa-instagram"></i> miloufarmhouse</span>';
                        } else {
                            footer = '<span>Thank you for coming</span><br />' +
                                '<span><i class="fab fa-instagram"></i> miloufarmhouse</span>' +
                                '<span>(Copy Bill)</span>';
                        }

                        if (data['transaction'][x].TransactionType == 1) {
                            transactionType = "Dine In";
                            ppn = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">PB1 (10.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].PPN)) + '</div>' +
                                '</div>';
                            sc = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Service Charge (7.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].ServiceCharge)) + '</div>' +
                                '</div>';
                        } else {
                            transactionType = "Take Away";
                            ppn = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">PB1 (10.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].PPN)) + '</div>' +
                                '</div>';
                            sc = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Package & Service (7.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].ServiceCharge)) + '</div>' +
                                '</div>';
                        }

                        if (data['transaction'][x].Discount != 0) {
                            discount = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Discount</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].Discount)) + '</div>' +
                                '</div>' +
                                '<hr class="my-2" />';
                        } else {
                            discount = '';
                        }

                        totalTransaction = data['transaction'][x].TotalTransaction;
                        totalDiscount = data['transaction'][x].Discount;
                        grandTotalTransaction = totalTransaction - totalDiscount;

                        htmlTransaction += '<div class="text-center">' +
                            '<img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" alt="Milou Farm House" class="w-32 h-32 inline-block" />' +
                            '</div>' +
                            '<div class="text-center mb-5">' + data['transaction'][x].Address + '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">' + moment(data['transaction'][x].TransactionDatetime).format('DD MMM YYYY') + '</div>' +
                            '<div>' + moment(data['transaction'][x].TransactionDatetime).format('HH:mm') + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Receipt Number</div>' +
                            '<div>' + data['transaction'][x].TransactionNumber + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Customer Name</div>' +
                            '<div>' + data['transaction'][x].CustomerName + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Collected By</div>' +
                            '<div>' + session + '</div>' +
                            '</div>' +
                            '<hr class="my-2" />' +
                            '<div class="text-center text-xs font-semibold">' + transactionType + '</div>' +
                            '<hr class="my-2" />';

                        htmlTransactionFinal += '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Subtotal</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transaction'][x].SubTotalTransaction) + '</div>' +
                            '</div>' +
                            discount +
                            sc +
                            ppn +
                            pns +
                            '<hr class="my-2" />' +
                            '<div class="flex text-xs font-bold">' +
                            '<div class="flex-grow">Grand Total</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transaction'][x].GrandTotalTransaction) + '</div>' +
                            '</div>';

                        var grandtotal = data['transaction'][x].GrandTotalTransaction;
                    }

                    for (var y = 0; y < data['transactionDetail'].length; y++) {

                        subTotalPrice = parseInt(data['transactionDetail'][y].Price) * parseInt(data['transactionDetail'][y].Qty);

                        htmlTransactionDetail += '<tr class="pr-2">' +
                            /* '<td class="py-1 w-1/12 text-center">' + no++ + '</td>' + */
                            '<td class="py-1 text-left">' +
                            '<span>' + data['transactionDetail'][y].MenuName + '</span>' +
                            '<br />' +
                            '<small>Rp. ' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transactionDetail'][y].Price) + '</small>' +
                            '</td>' +
                            '<td class="py-1 w-2/12 text-center font-semibold">' + data['transactionDetail'][y].Qty + '</td>' +
                            '<td class="py-1 w-3/12 text-right font-semibold">' +
                            '<span>Rp. </span>' +
                            '<span>' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(subTotalPrice) + '</span>' +
                            '</td>' +
                            '</tr>';

                        $.each(data['transactionDetail'][y].Parent, function(index, value) {

                            subTotalPriceAdd = parseInt(value.Qty) * parseInt(value.Price);

                            htmlTransactionDetail += '<tr class="pr-2">' +
                                '<td class="py-1 text-left">' +
                                '<span>' + value.MenuName + '</span>' +
                                '<br />' +
                                '<small>Rp. ' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(value.Price) + '</small>' +
                                '</td>' +
                                '<td class="py-1 w-2/12 text-center font-semibold">' + value.Qty + '</td>' +
                                '<td class="py-1 w-3/12 text-right font-semibold">' +
                                '<span>Rp. </span>' +
                                '<span>' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(subTotalPriceAdd) + '</span>' +
                                '</td>' +
                                '</tr>';
                        })
                    }

                    for (var z = 0; z < data['paymentMethod'].length; z++) {

                        countPrice += parseInt(data['paymentMethod'][z].Nominal);

                        htmlPaymentMethod += '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">' + data['paymentMethod'][z].PaymentMethodName + '</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['paymentMethod'][z].Nominal) + '</div>' +
                            '</div>';
                    }
                    change = countPrice - grandtotal;

                    htmlChange = '<hr class="my-2" />' +
                        '<div class="flex text-xs font-semibold">' +
                        '<div class="flex-grow">Change</div>' +
                        '<div class="flex-grow text-right">Rp. </div>' +
                        '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(change) + '</div>' +
                        '</div>';

                    $("#showTransaction").html(htmlTransaction);
                    $("#showTransactionDetail").html(htmlTransactionDetail);
                    $("#showTransactionFinal").html(htmlTransactionFinal);
                    $("#showPaymentMethodTrans").html(htmlPaymentMethod);
                    $("#showChange").html(htmlChange);
                }
            });
        }

        $(document).on("keyup", "#liveSearch", function() {
            var search = $(this).val();

            if (search != "") {
                showDataMenuSearch(search);
            } else {
                showDataMenuSearch();
            }
        });

        $(document).on("keyup", "#liveSearchCustomer", function() {
            var searchCustomer = $(this).val();

            if (searchCustomer != "") {
                showDatalistCustomer(searchCustomer);
            } else {
                showDatalistCustomer();
            }
        });

        $(document).on("click", ".daily-report-detail", function() {
            var idTransaction = $(this).data("id");
            var url = "<?= site_url('report/getTransactionDetail') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    idTransaction: idTransaction
                },
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var no = 1;
                    $.each(data, function(index, value) {
                        html +=
                            '<tr class="bg-white border-b">' +
                            '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">' + no++ + '</th>' +
                            '<td class="px-6 py-4">' + value.MenuName + '</td>' +
                            '<td class="px-6 py-4">' + value.NoteDetail + '</td>' +
                            '<td class="px-6 py-4">' + value.Qty + '</td>' +
                            '<td class="px-6 py-4">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(value.Price) + ' IDR</td>' +
                            '</tr>';
                    });
                    $("#showDetailDailyReport").html(html);
                    const targetEl = document.getElementById('daily-report');
                    const modal = new Modal(targetEl);
                    modal.show();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });

        });

        $(document).on("click", ".btnDaily", function() {
            const targetEl = document.getElementById('daily-report');

            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        });

        $(document).on("click", "#closePrintBill", function() {
            const targetEl = document.getElementById('printBill');

            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        });

        $(document).on("click", ".print-button", function() {
            var idTransaction = $(this).data("id");
            var url = "<?= site_url('receipt/getDataPrintBill') ?>";
            var session = "<?= $this->session->userdata('Username') ?>";

            $.ajax({
                url: url,
                method: "POST",
                async: true,
                data: {
                    idTransaction: idTransaction
                },
                dataType: "json",
                success: function(data) {
                    var htmlTransaction = "";
                    var htmlTransactionFinal = "";
                    var htmlTransactionDetail = "";
                    var htmlPaymentMethod = "";
                    var htmlChange = "";
                    var transactionType = "";
                    var subTotalPrice = "";
                    var subTotalPriceAdd = "";
                    var no = 1;
                    var totalTransaction = "";
                    var countPrice = 0;
                    var change = 0;
                    var ppn = "";
                    var sc = "";
                    var pns = "";
                    var discount = "";
                    var totalDiscount = 0;
                    var grandTotal = 0;

                    for (var x = 0; x < data['transaction'].length; x++) {
                        if (data['transaction'][x].TransactionType == 1) {
                            transactionType = "Dine In";
                            ppn = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">PB1 (10.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].PPN)) + '</div>' +
                                '</div>';
                            sc = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Service Charge (7.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].ServiceCharge)) + '</div>' +
                                '</div>';
                        } else {
                            transactionType = "Take Away";
                            ppn = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">PB1 (10.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].PPN)) + '</div>' +
                                '</div>';
                            sc = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Package & Service (7.0%)</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].ServiceCharge)) + '</div>' +
                                '</div>';
                        }

                        if (data['transaction'][x].Discount != 0) {
                            discount = '<div class="flex text-xs font-semibold">' +
                                '<div class="flex-grow">Discount</div>' +
                                '<div class="flex-grow text-right">Rp. </div>' +
                                '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(Math.ceil(data['transaction'][x].Discount)) + '</div>' +
                                '</div>' +
                                '<hr class="my-2" />';
                        } else {
                            discount = '';
                        }

                        totalTransaction = data['transaction'][x].TotalTransaction;
                        totalDiscount = data['transaction'][x].Discount;
                        grandTotalTransaction = totalTransaction - totalDiscount;

                        htmlTransaction += '<div class="text-center">' +
                            '<img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" alt="Milou Farm House" class="w-32 h-32 inline-block" />' +
                            '</div>' +
                            '<div class="text-center mb-5">' + data['transaction'][x].Address + '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">' + moment(data['transaction'][x].TransactionDatetime).format('DD MMM YYYY') + '</div>' +
                            '<div>' + moment(data['transaction'][x].TransactionDatetime).format('HH:mm') + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Receipt Number</div>' +
                            '<div>' + data['transaction'][x].TransactionNumber + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Customer Name</div>' +
                            '<div>' + data['transaction'][x].CustomerName + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Collected By</div>' +
                            '<div>' + session + '</div>' +
                            '</div>' +
                            '<hr class="my-2" />' +
                            '<div class="text-center text-xs font-semibold">' + transactionType + '</div>' +
                            '<hr class="my-2" />';

                        htmlTransactionFinal += '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Subtotal</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transaction'][x].SubTotalTransaction) + '</div>' +
                            '</div>' +
                            discount +
                            sc +
                            ppn +
                            pns +
                            '<hr class="my-2" />' +


                            '<div class="flex text-xs font-bold">' +
                            '<div class="flex-grow">Grand Total</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transaction'][x].GrandTotalTransaction) + '</div>' +
                            '</div>';
                        var grandtotal = data['transaction'][x].GrandTotalTransaction;
                    }

                    for (var y = 0; y < data['transactionDetail'].length; y++) {

                        subTotalPrice = parseInt(data['transactionDetail'][y].Price) * parseInt(data['transactionDetail'][y].Qty);

                        htmlTransactionDetail += '<tr class="pr-2">' +
                            /* '<td class="py-1 w-1/12 text-center">' + no++ + '</td>' + */
                            '<td class="py-1 text-left">' +
                            '<span>' + data['transactionDetail'][y].MenuName + '</span>' +
                            '<br />' +
                            '<small>Rp. ' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['transactionDetail'][y].Price) + '</small>' +
                            '</td>' +
                            '<td class="py-1 w-2/12 text-center font-semibold">' + data['transactionDetail'][y].Qty + '</td>' +
                            '<td class="py-1 w-3/12 text-right font-semibold">' +
                            '<span>Rp. </span>' +
                            '<span>' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(subTotalPrice) + '</span>' +
                            '</td>' +
                            '</tr>';

                        $.each(data['transactionDetail'][y].Parent, function(index, value) {

                            subTotalPriceAdd = parseInt(value.Qty) * parseInt(value.Price);

                            htmlTransactionDetail += '<tr class="pr-2">' +
                                '<td class="py-1 text-left">' +
                                '<span>' + value.MenuName + '</span>' +
                                '<br />' +
                                '<small>Rp. ' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(value.Price) + '</small>' +
                                '</td>' +
                                '<td class="py-1 w-2/12 text-center font-semibold">' + value.Qty + '</td>' +
                                '<td class="py-1 w-3/12 text-right font-semibold">' +
                                '<span>Rp. </span>' +
                                '<span>' + new Intl.NumberFormat("id-ID", {
                                    currency: "IDR"
                                }).format(subTotalPriceAdd) + '</span>' +
                                '</td>' +
                                '</tr>';
                        })
                    }

                    for (var z = 0; z < data['payMethodTrans'].length; z++) {

                        countPrice += parseInt(data['payMethodTrans'][z].Nominal);

                        htmlPaymentMethod += '<div class="flex text-xs font-bold">' +
                            '<div class="flex-grow">' + data['payMethodTrans'][z].PaymentMethodName + '</div>' +
                            '<div class="flex-grow text-right">Rp. </div>' +
                            '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                                currency: "IDR"
                            }).format(data['payMethodTrans'][z].Nominal) + '</div>' +
                            '</div>';
                    }

                    change = countPrice - grandtotal;

                    htmlChange = '<hr class="my-2" />' +
                        '<div class="flex text-xs font-semibold">' +
                        '<div class="flex-grow">Change</div>' +
                        '<div class="flex-grow text-right">Rp. </div>' +
                        '<div class="w-12 text-right">' + new Intl.NumberFormat("id-ID", {
                            currency: "IDR"
                        }).format(change) + '</div>' +
                        '</div>';

                    $("#showTransaction").html(htmlTransaction);
                    $("#showTransactionDetail").html(htmlTransactionDetail);
                    $("#showTransactionFinal").html(htmlTransactionFinal);
                    $("#showPaymentMethodTrans").html(htmlPaymentMethod);
                    $("#showChange").html(htmlChange);

                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", ".btn-void", function(e) {
            e.preventDefault();
            var idTransaction = $(this).data("id");
            var url = "<?= site_url('voids/getDataAllTransaction') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                async: true,
                data: {
                    idTransaction: idTransaction
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var html = "";
                    for (var x = 0; x < data['transaction'].length; x++) {
                        html = '<div class="p-4 space-y-2">' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">' + moment(data['transaction'][x].update_at).format('DD MMM YYYY') + '</div>' +
                            '<div>' + moment(data['transaction'][x].update_at).format('HH:mm') + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Receipt Number</div>' +
                            '<div>' + data['transaction'][x].TransactionNumber + '</div>' +
                            '</div>' +
                            '<div class="flex text-xs font-semibold">' +
                            '<div class="flex-grow">Customer Name</div>' +
                            '<div>' + data['transaction'][x].CustomerName + '</div>' +
                            '</div>' +
                            '<textarea id="reason" name="reason_void" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Your reason..."></textarea>' +
                            '</div>' +

                            '<div class="flex items-center p-4 space-x-2 rounded-b">' +
                            '<button id="void" data-id="' + data['transaction'][x].TransactionID + '" type="button" class="text-white rounded-lg text-md w-full py-1 focus:outline-none bg-black-50 hover:bg-black-100">Submit</button>' +
                            '</div>';
                    }
                    $("#showReasonVoid").html(html);
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#void", function() {
            var idTransaction = $(this).data("id");
            var reason_void = $("#reason").val();
            var url = "<?= site_url('voids/insertTransactionToVoid') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                async: true,
                data: {
                    idTransaction: idTransaction,
                    reason_void: reason_void
                },
                dataType: "json",
                success: function(data) {
                    $("#closeModalVoid").click();
                    window.location.reload();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#btn-note-detail", function() {
            var url = "<?= site_url('favorite/getUpdateItemCart') ?>";
            var id = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                async: true,
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    var val = "";
                    $.each(data, function(index, value) {
                        val = value.NoteDetail;
                    })
                    $("#transactionDetailID").val(id);
                    $("#notes").val(val);

                    const targetEl = document.getElementById('modal-note-detail');
                    const modal = new Modal(targetEl);
                    modal.show();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#close-modal-note-detail", function() {
            const targetEl = document.getElementById('modal-note-detail');

            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
        });

        $(document).on("click", "#btn-confirm", function() {
            var id = $(this).data("id");
            var url = "<?= site_url('favorite/updateStatusTransaction') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    showCloseBillForConfirm();
                }
            });
        });

        $(document).on("click", "#btn-complete", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "<?= site_url('favorite/updateStatusTransactionComplete') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    location.reload();
                }
            });
        });

        $(document).on("click", "#delivered", function(e) {
            e.preventDefault();
            var url = "<?= site_url('favorite/itemsDelivered'); ?>";
            var delivered = $(this).val();
            var detailID = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    delivered: delivered,
                    detailID: detailID
                },
                success: function(data) {
                    const targetEl = document.getElementById('detailCustomerDineInModal');
                    const modal = new Modal(targetEl);
                    $("#aku").remove();
                    modal.hide();
                }
            });
        });

        $(document).on("click", "#closeModalCustomer", function(e) {
            e.preventDefault();
            const targetEl = document.getElementById('addCustomerModal');

            const modal = new Modal(targetEl);
            $("#aku").remove();
            modal.hide();
            location.reload();
        });
    });
</script>
</body>

</html>