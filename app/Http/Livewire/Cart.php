<?php

namespace App\Http\Livewire;

use DB;
use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Cart extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tax = '10%';

    public $search = '';

    public $payment = 0;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%'.$this->search.'%')->orderBy('created_at', 'DESC')->paginate(8);

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->tax,
            'order' => 1
        ]);

        \Cart::session(Auth()->id())->condition($condition);

        $items = \Cart::session(Auth()->id())->getContent()->sortBy(function ($cart) {
            return $cart->attributes->get('added_at');
        });

        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->quantity,
                    'pricesingle' => $item->price,
                    'price' => $item->getPriceSum()
                ];
            }

            $cartData = collect($cart);
        }

        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();

        $newCondition = \Cart::session(Auth()->id())->getCondition('pajak');
        $pajak = $condition->getCalculatedValue($sub_total);

        $summary = [
            'sub_total' => $sub_total,
            'tax' => $pajak,
            'total' => $total
        ];

        return view('livewire.cart', [
            'products' => $products,
            'carts' => $cartData,
            'summary' => $summary
        ]);
    }

    public function addItem($id)
    {
        $rowId = "Cart".$id;
        $cart = \Cart::session(Auth::user()->id)->getContent();
        $checkItemId = $cart->whereIn('id', $rowId);

        $idProduct = substr($rowId,4,5);
        $product = Product::find($idProduct);

        if ($checkItemId->isNotEmpty()) {
            if ($product->stock == $checkItemId[$rowId]->quantity) {
                session()->flash('error', 'Stok yang tersedia sudah kosong');
            } else {
                \Cart::session(Auth::user()->id)->update($rowId, [
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }
        } else {
            if ($product->stock == 0) {
                session()->flash('error', 'Stok yang tersedia sudah kosong');
            } else {
                \Cart::session(Auth::user()->id)->add([
                    'id' => "Cart".$product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'attribut' => [
                        'added_at' => Carbon::now()
                    ]
                ]);
            }
        }
    }

    public function increaseItem($rowId) 
    {
        $idProduct = substr($rowId,4,5);
        $product = Product::find($idProduct);

        $cart = \Cart::session(Auth()->id())->getContent();
        
        $checkItem = $cart->whereIn('id', $rowId);

        if ($product->stock == $checkItem[$rowId]->quantity) {
            session()->flash('error', 'Stok yang tersedia sudah kosong');
        } else {
            if ($product->stock == 0) {
                session()->flash('error', 'Stok yang tersedia sudah kosong');
            } else {
                \Cart::session(Auth()->id())->update($rowId, [
                    'quantity' => [
                        'relative' => true,
                        'value' => 1
                    ]
                ]);
            }
        }

    }

    public function decreaseItem($rowId) 
    {
        $idProduct = substr($rowId,4,5);
        $product = Product::find($idProduct);

        $cart = \Cart::session(Auth()->id())->getContent();
        
        $checkItem = $cart->whereIn('id', $rowId);

        if ($checkItem[$rowId]->quantity == 1) {
            $this->removeItem($rowId);
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1
                ]
            ]);
        }
    }

    public function removeItem($rowId) 
    {
        \Cart::session(Auth()->id())->remove($rowId);
    }

    public function handleSubmit()
    {
        $cartTotal = \Cart::session(Auth()->id())->getTotal();
        $bayar = $this->payment;
        $change =  (int)$bayar - (int)$cartTotal;
        
        if ($change >= 0) {
            DB::beginTransaction();

            try {
                $allCart = \Cart::session(Auth()->id())->getContent();

                $filterCart = $allCart->map(function($item) {
                    return [
                        'id' => substr($item->id, 4,5 ),
                        'quantity' => $item->quantity
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = Product::find($cart['id']);

                    if ($product->stock === 0) {
                        return session()->flash('error', 'Jumlah produk kurang');
                    } 

                    $product->decrement('stock', $cart['quantity']);
                }

                $id = IdGenerator::generate([
                    'table' => 'transactions',
                    'length' => 10,
                    'prefix' => 'INV-',
                    'field' => 'invoice_number'
                ]);

                Transaction::create([
                    'invoice_number' => $id,
                    'user_id' => Auth()->id(),
                    'pay' => $bayar,
                    'total' => $cartTotal
                ]);

                foreach ($filterCart as $cart) {
                    TransactionDetail::create([
                        'product_id' => $cart['id'],
                        'invoice_number' => $id,
                        'qty' => $cart['quantity']
                    ]);
                }

                \Cart::session(Auth()->id())->clear();
                $this->payment = 0;

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return session()->flash('error', $th);
            }
        }
    }
}
