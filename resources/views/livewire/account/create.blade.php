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
                        <h3 class="font-medium text-xl">Create Account</h3>
                    </div>

                    <div class="space-y-5">
                        <div class="mt-3" style="display: flex; flex-wrap: wrap; gap: 20px;">
                           
                            <div class="mt-3" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="name" wire:model="name"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500 transition-colors"
                                        placeholder="name" />
                                    @error('name')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type</label>
                                    <input type="account_type" id="account_type" wire:model="account_type"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500 transition-colors"
                                        placeholder="Account Type" />
                                    @error('account_type')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>


                               

                            </div>
                        </div>

                        <div class="mt-3" style="display:flex; flex-wrap:wrap; gap:20px;">

                          <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                    <select id="currency" wire:model="currency"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 bg-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500 transition-colors">
                                        <option value="">--Select Currency--</option>
                                        @foreach($currencies as $cur)
                                            <option value="{{ $cur['name']}}">{{ $cur['name'] }}</option>
                                        @endforeach
                                    </select>

                                    @error('currency')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div>
                                    <label for="current_amount" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="current_amount" wire:model="current_amount"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500 transition-colors"
                                        placeholder="Amount" />
                                    @error('current_amount')
                                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                        </div>

                        <!-- Success message -->
                        @if (session()->has('status'))
                            <div>
                                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-sm relative transition-colors"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('status') }}</span>
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
                                class="inline-flex justify-center border-transparent bg-blue-500 text-white py-2 px-4 rounded capitalize hover:bg-blue-600">
                                Create 
                            </button>

                            <a href="{{ route('accounts') }}" wire:navigate
                                class="inline-flex justify-center border-transparent bg-red-500 text-gray-900 py-2 px-4 rounded capitalize hover:bg-red-600">
                                Back
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>
</div>