<?php

namespace App\Http\Livewire;

use DB;
use Faker\Factory;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Dashboard extends Component
{
    public function render()
    {
        $faker = Factory::create();

        $count_transaction = Transaction::count();
        $count_product_available = Product::where('stock', '>', '0')->count();
        $count_product_not_available = Product::where('stock', '=', '0')->count();
        $count_user = User::count();

        $data_month = [];

        foreach (range(1,12) as $month) {          
            $data_month[] = TransactionDetail::select(DB::raw("COUNT(*) as total"))->whereMonth('created_at', $month)->first()->total;
        }

        $columnChartModel = (new ColumnChartModel());
        foreach ($data_month as $key => $item) {
            $columnChartModel->addColumn($key+1, $item, $faker->hexColor());
        }

        $columnChartModel
            ->withoutLegend()
            ->setTitle('Number of Products Sold')
            ->withDataLabels()
            ->setAnimated(true)
            ;

        return view('livewire.dashboard', compact('count_transaction', 'count_product_available', 'count_product_not_available','count_user', 'columnChartModel'));
    }
}
