<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Dashboard extends Component
{
    public function render()
    {
        $count_transaction = Transaction::count();
        $count_product_available = Product::where('stock', '>', '0')->count();
        $count_product_not_available = Product::where('stock', '=', '0')->count();
        $count_user = User::count();

        return view('livewire.dashboard', compact('count_transaction', 'count_product_available', 'count_product_not_available','count_user'));
    }
}
