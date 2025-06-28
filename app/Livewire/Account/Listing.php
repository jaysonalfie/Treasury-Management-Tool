<?php

namespace App\Livewire\Account;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
   use WithPagination;
    public $search;
    public function render()
    {
        return view('livewire.account.listing',[
        'accounts'=> $this->getAccount()
            ->oldest()
            ->paginate(10)
        ]);
    }

    
     public function getAccount()
    {
        return Account::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('account_type', 'like', '%'. $this->search . '%')
                        ->orWhere('currency', 'like', '%'. $this->search . '%');

                });
            });
    }
}
