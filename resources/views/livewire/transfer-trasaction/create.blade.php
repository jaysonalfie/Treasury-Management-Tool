<div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <div class="intro-y box p-5 border rounded-lg shadow-lg">
                    <div class="flex flex-col sm:flex-row items-center border-b pb-3 mb-5">
                        <h3 class="font-medium text-xl">Transfer funds </h3>
                    </div>

                    <div class="space-y-5">
                        <div class="mt-3" style="display: flex; flex-wrap: wrap; gap: 20px;">

                            <div class="mt-3" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                <div>
                                    <label for="from_account_id" class="block text-sm font-medium text-gray-700">Source
                                        Account</label>
                                    <select name="" 
                                            wire:model="from_account_id"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 bg-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            style="font-size: 12px; width:215px; height: 40px;">
                                        <option value="">--Select Account--</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('from_account_id')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="to_account_id" class="block text-sm font-medium text-gray-700">Destination
                                        Account</label>
                                    <select name="" 
                                            wire:model="to_account_id"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 bg-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            style="font-size: 12px; width:215px; height: 40px;">
                                        <option value="">--Select Account--</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('to_account_id')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3" style="display:flex; flex-wrap:wrap; gap:20px;">

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" 
                                       step="0.01" 
                                       min="0.01"
                                       id="amount" 
                                       wire:model="amount"
                                       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="0.00" />
                                @error('amount')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="transfer_date" class="block text-sm font-medium text-gray-700">Transfer Date</label>
                                <input type="date" 
                                       id="transfer_date" 
                                       wire:model="transfer_date"
                                       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="Transfer Date" />
                                @error('transfer_date')
                                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-3">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Transfer Description</label>
                            <textarea 
                                id="description"
                                wire:model="description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                style="font-size: 12px; min-height: 80px; max-width: 400px;"
                                placeholder="Enter transfer description (optional)..."></textarea>
                            @error('description')
                                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Success message -->
                        @if (session()->has('status') || session()->has('success'))
                            <div>
                                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-sm relative transition-colors"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('status') ?? session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Error message -->
                        @if (session()->has('error'))
                            <div>
                                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md shadow-sm relative transition-colors"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="mt-6 flex gap-4">
                            <button type="submit"
                                class="inline-flex justify-center border-transparent bg-blue-500 text-white py-2 px-4 rounded capitalize hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Transfer Funds
                            </button>

                            <a href="{{ route('transactions') }}" wire:navigate
                                class="inline-flex justify-center border border-gray-300 bg-white text-gray-700 py-2 px-4 rounded capitalize hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Cancel
                            </a>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>
</div>