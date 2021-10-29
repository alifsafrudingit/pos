<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction as TransactionModel;

class Transaction extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $transactions = TransactionModel::where('invoice_number', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->paginate(10);

        return view('livewire.transaction', compact('transactions'));
    }
}
