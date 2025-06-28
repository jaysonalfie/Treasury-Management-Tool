<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box mt-5 rounded-lg shadow-lg">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">
                        Manage Transfer Transactions
                    </h2>

                    <div class="flex gap-4">
                        <div>
                            <input type="text" wire:model.live="search" placeholder="Search"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500 transition-colors" />
                        </div>
                        <div>
                            <a href="{{route('transactions.create')}}"
                                class="inline-flex justify-center py-3 px-4 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue-500 hover:bg-blue-300 focus:ring-offset-2 focus:ring-blue-500"> New </a>
                        </div>
                    </div>

                </div>

                <div id="responsive-table">
                    <div class="preview">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead style="background-colo: #f0f0f0;">
                                    <tr>
                                        <th
                                            class="whitespace-nowrap sticky left-0 bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Transfer No
                                        </th>
                                        <th
                                            class="md:static sticky left-[1.25rem] bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Source Account
                                        </th>
                                        <th
                                            class="whitespace-nowrap 0 bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                           Destination Account
                                        </th> 
                                        <th
                                            class="whitespace-nowrap 0 bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                           Amount Transfered
                                        </th>
                                          <th
                                            class="whitespace-nowrap  bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                           Source Acccount balance
                                        </th>
                                        <th
                                            class="whitespace-nowrap  bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                           Destination Acccount balance
                                        </th>
                                        <th
                                            class="whitespace-nowrap  bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Created On
                                        </th>
                                        <th
                                            class="whitespace-nowrap  bg-gray-100 px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            Action
                                        </th>



                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td
                                                class="sticky left-0 z-30 bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{$transfer->id}}
                                            </td>
                                            <td
                                                class=" sticky left-[1.25rem] bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{$transfer->accountFrom->name}}
                                            </td>  
                                            <td
                                                class="md:static  bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{$transfer->accountTo->name}}
                                            </td> 
                                            <td
                                                class="md:static  bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{(number_format($transfer->Amount,2))}}
                                            </td>
                                            <td
                                                class="md:static  bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{(number_format($transfer->accountFrom->account_balance,2))}}
                                            </td>
                                            <td
                                                class="md:static  bg-white px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{(number_format($transfer->accountTo->account_balance,2))}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{$transfer->created_at->format('j M Y, g:i a')}}
                                                </div>
                                                {{--the message shows only if the created_at is different from the
                                                updated_at---}}
                                                @unless($transfer->created_at->eq($transfer->updated_at))
                                                    <div class="text-sm text-gray-500">{{__('edited')}}</div>
                                                @endunless
                                            </td>
                                            <td class="px-6 py-4 flex gap-6 whitespace-nowrap text-sm text-gray-500">
                                                <a href="{{route('accounts.edit', ['id' => $transfer->id])}}"
                                                    class="inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue-500 hover:bg-blue-300 focus:ring-offset-2 focus:ring-blue-500">Edit</a>

                                            </td>

                                        </tr>

                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>