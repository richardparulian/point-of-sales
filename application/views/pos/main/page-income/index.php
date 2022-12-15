<div class="container p-3 overflow-x-hidden overflow-y-auto">
    <div class="relative w-full bg-white shadow-md rounded-2xl p-4">
        <div class="flex justify-between items-center mb-2 rounded-t border-b border-gray-600">
            <h3 class="text-base font-semibold text-gray-900 lg:text-lg mb-3">
                Income Report Transaction
            </h3>
        </div>
        <!-- <div class="w-full">
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td class="p-unset">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                                    <i class="fas fa-calendar-days"></i>
                                </span>
                                <input type="text" id="income_start_date" name="start_date" class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-1.5" placeholder="Start Date">
                            </div>
                        </td>
                        <td class="pt-0 pl-3">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                                    <i class="fas fa-calendar-days"></i>
                                </span>
                                <input type="text" id="income_end_date" name="end_date" class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-1.5" placeholder="End Date">
                            </div>
                        </td>
                        <td class="pt-0">
                            <div class="flex">
                                <button id="filterIncome" type="button" class="text-white mr-1 rounded-lg text-md w-full py-1 bg-black-50 hover:bg-black-100 block flex-1 min-w-0 p-2">Filter</button>
                                <button id="resetIncome" type="button" class="text-white rounded-lg text-md w-full py-1 bg-black-50 hover:bg-black-100 block flex-1 min-w-0 p-2">Reset</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> -->
        <hr class="my-2">
        <table id="incomeReportTransaction" class="text-sm text-gray-500" width="100%">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="w-2 px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Payment Method
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Total Income
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>