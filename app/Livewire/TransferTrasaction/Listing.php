<?php

namespace App\Livewire\TransferTrasaction;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TransferTransaction;

class Listing extends Component
{

    use WithPagination;

    public $search;

    public $accounts;

    public $accountFilter = '';
    public $currencyFilter = '';
    public $statusFilter = '';


    public function render()
    {

        $this->accounts = Account::get();
        return view(
            'livewire.transfer-trasaction.listing',
            [
                'transfers' => $this->getTransaction()
                    ->oldest()
                    ->paginate(10)
            ]
        );
    }

       public function updatedAccountFilter()
    {
        $this->resetPage();
    }

    public function updatedCurrencyFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    // public function getTransaction()
    // {
    //     return TransferTransaction::with('accountFrom', 'accountTo', 'creator')
    //         ->when($this->search, function ($query) {
    //             $query->where(function ($q) {

    //                 $q->whereHas('accountFrom', function ($subquery) {
    //                     $subquery->where('name', 'like', '%' . $this->search . '%');
    //                 })
    //                     ->orWhereHas('accountTo', function ($subquery) {
    //                         $subquery->where('name', 'like', '%' . $this->search . '%');
    //                     });
    //             });
    //         });

    // }

     public function getTransaction()
    {
        $query = TransferTransaction::with('accountFrom', 'accountTo', 'creator');

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $searchTerm = '%' . $this->search . '%';
                
                $q->where('Amount', 'like', $searchTerm)
                  ->orWhere('desription', 'like', $searchTerm)
                  ->orWhere('transfer_date', 'like', $searchTerm)
                  ->orWhereHas('accountFrom', function ($subquery) use ($searchTerm) {
                      $subquery->where('name', 'like', $searchTerm);
                  })
                  ->orWhereHas('accountTo', function ($subquery) use ($searchTerm) {
                      $subquery->where('name', 'like', $searchTerm);
                  });
            });
        }

        // Account filter - search in both from and to accounts
        if ($this->accountFilter) {
            $query->where(function ($q) {
                $q->where('from_account_id', $this->accountFilter)
                  ->orWhere('to_account_id', $this->accountFilter);
            });
        }

        // Currency filter - filter by accounts that have the selected currency
        if ($this->currencyFilter) {
            $query->where(function ($q) {
                $q->whereHas('accountFrom', function ($subquery) {
                    $subquery->where('currency', $this->currencyFilter);
                })
                ->orWhereHas('accountTo', function ($subquery) {
                    $subquery->where('currency', $this->currencyFilter);
                });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return $query;
    }

    // Clear all filters method (optional)
    public function clearFilters()
    {
        $this->search = '';
        $this->accountFilter = '';
        $this->currencyFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }
}
