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
                    $q->where('item_models.name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('itemGroup', function ($subquery) {
                            $subquery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            });
    }
}
