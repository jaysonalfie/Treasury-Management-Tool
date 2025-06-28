<?php

namespace App\Livewire\Account;

use Exception;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Create extends Component
{

    public $name;
    public $account_type;
    public $currency;
    public $current_amount;

    public $currencies = [];


    public function render()
    {
        return view('livewire.account.create',
    );
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150|',
            'account_type' => 'required|string|max:150|',
            'currency' => 'string|string|max:150|',
            'current_amount' => 'required|numeric|decimal:0,6',
        ];
    }

    public function mount()
    {
        $this->currencies = [
            [
                'id' => 1,
                'name' => 'KES'
            ],
            [
                'id' => 2,
                'name' => 'USD'
            ],
            [
                'id' => 3,
                'name' => 'NGN'
            ]
        ];

    }

    public function save()
    {

        $validated = $this->validate();

        DB::beginTransaction();

        try {

            Account::create([
                'name' => $this->name,
                'account_type' => $this->account_type,
                'currency' => $this->currency,
                'account_balance' => $this->current_amount,
                'created_by' => auth()->id(),
                'created_on' => Carbon::now(),
            ]);

            DB::commit();
            $this->reset();
            session()->flash('status', 'Account created successfully');

        } catch (Exception $e) {

            DB::rollback();
            session()->flash('error', 'Error creating account:' . $e->getMessage());

        }
    }
}
