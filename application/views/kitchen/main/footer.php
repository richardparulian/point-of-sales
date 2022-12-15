</div>
<!-- jquery version 3.6.0 -->
<script src="<?= base_url('vendor/js/jquery-3.6.0.js'); ?>"></script>
<!-- flowbite -->
<script src="<?= base_url('vendor/js/flowbite.js'); ?>"></script>
<!-- my script -->
<script type="text/javascript">
    setInterval(function() {
        itemLoad();
    }, 2000);

    function itemLoad() {
        $(".itemList").load('<?= base_url('Kitchen/loadAjax') ?>');
    }

    setInterval(function() {
        itemLoadPreparing();
    }, 2000);

    setInterval(function() {
        itemLoadReady();
    }, 2000);

    function itemLoadPreparing() {
        $(".itemPreparing").load('<?= base_url('Kitchen/loadPreparing') ?>');
    }

    function itemLoadReady() {
        $(".itemReady").load('<?= base_url('Kitchen/loadReady') ?>');
    }

    setInterval('showTotalNewOrder()', 1000);
    setInterval('showTotalPreparing()', 1000);
    setInterval('showTotalReady()', 1000);

    function showTotalNewOrder() {
        var url = "<?= site_url('kitchen/countNewOrder') ?>";

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            dataType: "json",
            success: function(data) {
                var html = "";

                html = '(<span>' + data['total'] + '</span>) New Order';

                $("#newOrder").html(html);
            }
        });
    }

    function showTotalPreparing() {
        var url = "<?= site_url('kitchen/countPreparing') ?>";

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            dataType: "json",
            success: function(data) {
                var html = "";

                html = '(<span>' + data['total'] + '</span>) Preparing';

                $("#preparingOrder").html(html);
            }
        });
    }

    function showTotalReady() {
        var url = "<?= site_url('kitchen/countReady') ?>";

        $.ajax({
            type: "ajax",
            url: url,
            method: "GET",
            dataType: "json",
            success: function(data) {
                var html = "";

                html = '(<span>' + data['total'] + '</span>) Ready';

                $("#readyOrder").html(html);
            }
        });
    }

    function animation(span) {
        span.className = "turn";
        setTimeout(function() {
            span.className = ""
        }, 700);
    }

    function jam() {
        setInterval(function() {

            var waktu = new Date();
            var jam = document.getElementById('jam');
            var hours = waktu.getHours();
            var minutes = waktu.getMinutes();
            var seconds = waktu.getSeconds();

            if (waktu.getHours() < 10) {
                hours = '0' + waktu.getHours();
            }
            if (waktu.getMinutes() < 10) {
                minutes = '0' + waktu.getMinutes();
            }
            if (waktu.getSeconds() < 10) {
                seconds = '0' + waktu.getSeconds();
            }
            jam.innerHTML = '<span>' + hours + '</span>' +
                '<span>' + minutes + '</span>' +
                '<span>' + seconds + '</span>';

            var spans = jam.getElementsByTagName('span');
            animation(spans[2]);
            if (seconds == 0) animation(spans[1]);
            if (minutes == 0 && seconds == 0) animation(spans[0]);

        }, 1000);
    }

    $(document).ready(function() {
        showTotalNewOrder();
        showTotalPreparing();
        showTotalReady();
        jam();

        const button = document.querySelector('#menu-button');
        const menu = document.querySelector('#menu');

        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        $(document).on("click", "#changeStatus", function() {
            var transactionID = $(this).data("id");
            var url = "<?= site_url('kitchen/preparing') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    transactionID: transactionID
                },
                success: function(data) {
                    console.log(data);
                    $("#order-" + transactionID).remove();
                    showTotalNewOrder();
                    showTotalPreparing();
                    showTotalReady();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("click", "#changeStatusToReady", function() {
            var transactionID = $(this).data("id");
            var url = "<?= site_url('kitchen/ready') ?>";

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                data: {
                    transactionID: transactionID
                },
                success: function(data) {
                    $("#order-" + transactionID).remove();
                    showTotalNewOrder();
                    showTotalPreparing();
                    showTotalReady();
                },
                error: (error) => {
                    console.log(JSON.stringify(error));
                }
            });
        });

        $(document).on("change", "#default-checkbox", function(e) {
            e.preventDefault();
            var url = "<?= site_url('kitchen/updateStatusItem'); ?>";
            var status_td = $(this).val();
            var transactionDetailID = $(this).data("id");

            $.ajax({
                type: "ajax",
                url: url,
                method: "POST",
                async: true,
                dataType: "json",
                data: {
                    status_td: status_td,
                    transactionDetailID: transactionDetailID
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
    });

    /* show active sidebar */
    var url = window.location.href;

    $('nav.menu a').filter(function() {
        return this.href == url;
    }).addClass('active');
</script>
</body>

</html>