<div class="w-full flex flex-wrap">
    <!-- Login Section -->
    <div class="w-full md:w-1/2 flex flex-col">
        <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
            <a href="<?= base_url() ?>" class="select-none cursor-pointer transition-shadow overflow-hidden bg-white shadow-sm hover:shadow-xl rounded-2xl">
                <img src="<?= base_url('vendor/img/logo/logo-milou.png'); ?>" class="h-28 w-28" />
            </a>
        </div>
        <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
            <p class="text-center text-lg mb-5">Welcome to Milou Farm House! Sign In First :</p>

            <?php if ($this->session->flashdata('message')) : ?>
                <div id="alert-2" class="flex p-4 mb-4 bg-red-100 rounded-lg dark:bg-red-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                        <?php echo $this->session->flashdata('message'); ?> <a href="#" class="font-semibold underline hover:text-red-800 dark:hover:text-red-900"></a>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
            <hr>
            <form action="<?= base_url('auth'); ?>" method="post">
                <div class="flex flex-col pt-4">
                    <label class="text-lg font-semibold">Email</label>
                    <input type="text" id="username" name="username" placeholder="Username" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="flex flex-col pt-4">
                    <label class="text-lg font-semibold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="text-white rounded-2xl text-lg w-full py-3 mt-8 focus:outline-none bg-black-50 hover:bg-black-100">Sign In</button>
            </form>
        </div>
    </div>
    <!-- Image Section -->
    <div class="w-1/2 shadow-2xl">
        <img class="object-cover w-full h-screen hidden md:block" src="<?= base_url('vendor/img/bg-login.png'); ?>">
    </div>
</div>