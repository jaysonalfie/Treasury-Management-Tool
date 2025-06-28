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

 public function getTransaction()
{
    return TransferTransaction::with('accountFrom', 'accountTo', 'creator')
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                // Search only in account names (both source and destination)
                $q->whereHas('accountFrom', function ($subquery) {
                    $subquery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('accountTo', function ($subquery) {
                    $subquery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        });

}
}
