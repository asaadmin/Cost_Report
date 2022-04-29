<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-4 sm:align-middle">

            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-baseline">
                
                <div>
                    <h2 class="font-bold p-2">Preview imported data</h2>
                </div>

                <div>
                    <a href="{{route('template')}}" class="w-full inline-flex justify-center bg-primary-red px-3 py-2 text-white sm:ml-3 sm:w-auto ">
                        Template
                    </a>
                </div>

                <div>
                    
                    <a href="{{route('reupload')}}" class="mt-3 w-full inline-flex justify-center bg-primary-red px-3 py-2 text-white sm:ml-3 sm:w-auto ">
                        Reupload
                    </a>
                    <a href="{{route('editdata')}}" class="mt-3 w-full inline-flex justify-center bg-primary-red px-3 py-2 text-white sm:mt-0 sm:ml-3 sm:w-auto ">
                        Create Cost
                    </a>
                </div>
                
            </div>

            <hr>
            <h2 class="font-bold p-2">Format Data</h2>
            <div class="bg-white px-2 pt-3 mb-4 " style="width:800px; height:300px; overflow:auto;">
                <table class="border-collapse border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border border-slate-300 px-3">Forder</th>
                            <th class="border border-slate-300 px-3">Account Number</th>
                            <th class="border border-slate-300 px-3">Account Description</th>
                            <th class="border border-slate-300 px-3">Heading</th>
                            <th class="border border-slate-300 px-3">Account</th>
                            <th class="border border-slate-300 px-3">category</th>
                            <th class="border border-slate-300 px-3">production</th>
                            <th class="border border-slate-300 px-3">grand_total</th>
                            <th class="border border-slate-300 px-3">line_type</th>
                            <th class="border border-slate-300 px-3">line_top</th>
                            <th class="border border-slate-300 px-3">bold</th>
                            <th class="border border-slate-300 px-3">height_percent</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($formats as $format)
                        <tr class="" >
                            <td class="border border-slate-300 px-3 text-center"> {{ $format->forder }}</td>
                            <td class="border border-slate-300 px-3 text-left"> {{ $format->account_no }}</td>
                            <td class="border border-slate-300 px-3 text-left"> {{ $format->description }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->heading }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->account }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->category }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->production }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->grand_total }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->line_type }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->line_top }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->bold }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $format->height_percent }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <hr>

            <h2 class="font-bold p-2">Cost Data</h2>
            <div class="bg-white px-2 pt-3 mb-4" style="width:800px; height:300px; overflow:auto;">
                
                <table class="border-collapse border border-slate-400">
                    <thead>
                        <tr>
                            <th class="border border-slate-300 px-3">Account Number</th>
                            <th class="border border-slate-300 px-3">Account Description</th>
                            <th class="border border-slate-300 px-3">Period Cost</th>
                            <th class="border border-slate-300 px-3">Cost To Date</th>
                            <th class="border border-slate-300 px-3">Pos</th>
                            <th class="border border-slate-300 px-3">Total Costs</th>
                            <th class="border border-slate-300 px-3">ETC</th>
                            <th class="border border-slate-300 px-3">EFC</th>
                            <th class="border border-slate-300 px-3">Budget</th>
                            <th class="border border-slate-300 px-3">Approved Overage</th>
                            <th class="border border-slate-300 px-3">Total Budget</th>
                            <th class="border border-slate-300 px-3">Over/(Under)</th>
                            <th class="border border-slate-300 px-3">Variance</th>
                            <th class="border border-slate-300 px-3">Last CTD</th>
                            <th class="border border-slate-300 px-3">Last EFC</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($costs as $cost)
                        <tr class="" >
                            <td class="border border-slate-300 px-3 text-left"> {{ $cost->account_no }}</td>
                            <td class="border border-slate-300 px-3 text-left"> {{ $cost->description }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{ $cost->period_cost }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->cost_to_date }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->pos }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->total_costs }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->etc }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->efc }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->budget }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->approved_overage }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->total_budget }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->over_under }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->variance }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->last_ctd }}</td>
                            <td class="border border-slate-300 px-3 text-right"> {{  $cost->last_efc }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            
        
        </div>
    </div>
</div>
