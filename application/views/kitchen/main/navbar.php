<header class="w-full sticky top-0 z-50">
    <nav class="menu flex flex-wrap items-center justify-between w-full py-4 md:py-0 px-4 text-lg bg-black">
        <div class="mt-2">
            <button role="button" onclick="window.location.reload();" class="float-left mr-5 inline-block text-white bg-gray-700 hover:bg-gray-500  font-medium rounded-lg text-sm px-3 py-3 text-center inline-flex items-center" title="refreh">
                <i class="fas fa-arrow-rotate-right"></i>
            </button>
        </div>

        <div class="mt-1.5">
            <a href="<?= base_url('new-order'); ?>" class="mr-2 inline-block float-left text-white border border-gray-500 bg-black hover:border-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center" title="new">
                <div id="newOrder">
                
                </div>
            </a>
            <a href="<?= base_url('preparing-order'); ?>" class="mr-2 inline-block float-left text-white border border-gray-500 bg-black hover:border-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center" title="preparing">
                <div id="preparingOrder">
                    
                </div>
            </a>
            <a href="<?= base_url('ready-order'); ?>" class="mr-2 inline-block float-left text-white border border-gray-500 bg-black hover:border-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center" title="ready">
                <div id="readyOrder">
                    
                </div>
            </a>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" id="menu-button" class="sticky top-0 fixed h-6 w-6 cursor-pointer md:hidden block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>

        <div class="hidden w-full lg:flex lg:items-center lg:w-auto mt-1.5" id="menu">
            <div class="w-36">
                <div class="text-right">
                    <div id="unit"></div>
                    <div id="jam"></div>
                </div>
            </div>
        </div>
    </nav>
</header>