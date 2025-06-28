<?php

namespace App\Livewire\TransferTrasaction;

use Exception;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\TransferTransaction;

class Create extends Component
{

    public $from_account_id;
    public $to_account_id;
    public $amount;
    public $transfer_date;
    public $description;
    public $accounts;

    public function render()
    {

        $this->accounts = Account::get();
        return view('livewire.transfer-trasaction.create');
    }


    public function rules()
    {

        return [
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|decimal:0,6',
            'transfer_date' => 'required|date',
            'description' => 'nullable',
        ];
    }


    public function save()
    {

        $validated = $this->validate();

        DB::beginTransaction();

        $fromAccount = Account::find($this->from_account_id);
       
        $toAccount = Account::find($this->to_account_id);


        if(!$fromAccount){
            throw new Exception('Source account not found');
        }

        if(!$toAccount){
            throw new Exception('Destination account not found');
        }

        if($fromAccount->account_balance < $this->amount){
            session()->flash('error', 'Insufficient Balnce in source account');
        }

        try {

            $transfer = TransferTransaction::create([

                'from_account_id' => $this->from_account_id,
                'to_account_id' => $this->to_account_id,
                'Amount' => $this->amount,
                'transfer_date' => $this->transfer_date,
                'description' => $this->description,
                'created_by'=> auth()->id(),
                'created_on'=> Carbon::now(),

            ]);

   

         $fromAccount->decrement('account_balance', $this->amount);
         $toAccount->increment('account_balance', $this->amount);

        DB::commit();
        $this->reset();

        return redirect()->route('transactions')->with('message', 'Transfer completed successfully');

        } catch (Exception $e) {

            DB::rollBack();
            session()->flash('Transfer failed:' . $e->getMessage());


        }
    }


}
