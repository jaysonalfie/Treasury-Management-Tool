<?php

namespace App\Livewire\TransferTrasaction;

use App\Models\TransferTransaction;
use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{

    Use WithPagination;

    public $search;


    public function render()
    {
        return view('livewire.transfer-trasaction.listing',
    [
        'transfers' => $this->getTransaction()
                    ->oldest()
                    ->paginate(10)
    ]);
    }

    public function getTransaction(){

         return TransferTransaction::with('accountFrom', 'accountTo')
                ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('item_models.name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('itemGroup', function ($subquery) {
                            $subquery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            });
    }
}
