<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
        Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle">

            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between">
                
                <div>
                    <h2 class="font-bold p-2">Preview imported data</h2>
                </div>

                <div>
                    <a href="{{route('reupload')}}" class="w-full inline-flex justify-center border px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700  sm:ml-3 sm:w-auto ">
                        Reupload
                    </a>
                    <a href="{{route('editdata')}}" class="mt-3 w-full inline-flex justify-center border border-red-300 px-4 py-2 bg-white text-base font-medium text-black-500 hover:border-red-700  sm:mt-0 sm:ml-3 sm:w-auto ">
                        Edit Cost
                    </a>
                </div>
                
            </div>

            <hr>
            <h2 class="font-bold p-2">Format Data</h2>
            <div class="bg-white px-2 pt-5 mb-4 " style="width:800px; height:400px; overflow:auto;">
                <table class="border-collapse border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border border-slate-300 px-14">Forder</th>
                            <th class="border border-slate-300 px-14">Account Number</th>
                            <th class="border border-slate-300 px-14">Account Description</th>
                            <th class="border border-slate-300 px-14">Heading</th>
                            <th class="border border-slate-300 px-14">Account</th>
                            <th class="border border-slate-300 px-14">category</th>
                            <th class="border border-slate-300 px-14">production</th>
                            <th class="border border-slate-300 px-14">grand_total</th>
                            <th class="border border-slate-300 px-14">line_type</th>
                            <th class="border border-slate-300 px-14">line_top</th>
                            <th class="border border-slate-300 px-14">bold</th>
                            <th class="border border-slate-300 px-14">height_percent</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($formats as $format)
                        <tr class="" >
                            <td class="border border-slate-300 px-14 text-left"> {{ $format->forder }}</td>
                            <td class="border border-slate-300 px-14 text-left"> {{ $format->account_no }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->description }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->heading }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->account }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->category }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->production }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->grand_total }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->line_type }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->line_top }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->bold }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $format->height_percent }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <hr>

            <h2 class="font-bold p-2">Cost Data</h2>
            <div class="bg-white px-2 pt-5 mb-4" style="width:800px; height:400px; overflow:auto;">
                
                <table class="border-collapse border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border border-slate-300 px-14">Account Number</th>
                            <th class="border border-slate-300 px-14">Account Description</th>
                            <th class="border border-slate-300 px-14">Period Cost</th>
                            <th class="border border-slate-300 px-14">Cost To Date</th>
                            <th class="border border-slate-300 px-14">Pos</th>
                            <th class="border border-slate-300 px-14">Total Costs</th>
                            <th class="border border-slate-300 px-14">ETC</th>
                            <th class="border border-slate-300 px-14">EFC</th>
                            <th class="border border-slate-300 px-14">Budget</th>
                            <th class="border border-slate-300 px-14">Approved Overage</th>
                            <th class="border border-slate-300 px-14">Total Budget</th>
                            <th class="border border-slate-300 px-14">Over/(Under)</th>
                            <th class="border border-slate-300 px-14">Variance</th>
                            <th class="border border-slate-300 px-14">Last CTD</th>
                            <th class="border border-slate-300 px-14">Last EFC</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($costs as $cost)
                        <tr class="" >
                            <td class="border border-slate-300 px-14 text-left"> {{ $cost->account_no }}</td>
                            <td class="border border-slate-300 px-14 text-left"> {{ $cost->description }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{ $cost->period_cost }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->cost_to_date }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->pos }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->total_costs }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->etc }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->efc }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->budget }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->approved_overage }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->total_budget }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->over_under }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->variance }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->last_ctd }}</td>
                            <td class="border border-slate-300 px-14 text-right"> {{  $cost->last_efc }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            
        
        </div>
    </div>
</div>
