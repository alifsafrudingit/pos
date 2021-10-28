<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="font-weight-bold">Product List</h4>
                    </div>
                    <div class="col-md-4">
                        <input wire:model="search" type="text" class="form-control" placeholder="Search product">
                    </div>
                </div>
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-3 mb-3 mt-3">
                            <div class="card shadow-lg rounded-top" wire:click="addItem({{ $product->id }})" style="cursor: pointer">
                                <img src="{{ asset('storage/images/'.$product->url) }}" style="object-fit: cover; width: 100%; height: 150px" alt="product">
                                <div class="card-footer">
                                    <h6 class="font-weight-bold">{{ $product->name }}</h6>
                                    <span>IDR {{ number_format($product->price) }}</span>
                                    <button class="btn btn-success btn-sm btn-block mt-2 rounded-lg">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    @empty
                    <div class="col-sm-12">
                        <h5 class="text-center mt-5">Product not found</h5>
                    </div>
                    @endforelse
                </div>
                <div class="mt-4" style="display:flex; justify-content:right;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="font-weight-bold mb-4">Cart</h4>
                <p class="text-danger">
                    @if (session()->has('error'))
                        * {{ session('error') }}
                    @endif
                </p>
                <table class="table table-sm table-hover shadow-sm">
                    <thead>
                        <tr class="absolute">
                            <th class="text-left">Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carts as $index=>$cart)
                            <tr>   
                                <td>{{ $cart['name'] }}</td>
                                <td class="text-center">
                                    <i wire:click="increaseItem('{{ $cart['rowId'] }}')" style="font-size:10px; cursor:pointer; color: green" class="fas fa-plus mr-2" ></i>
                                    {{ $cart['qty'] }}
                                    <i wire:click="decreaseItem('{{ $cart['rowId'] }}')" style="font-size:10px; cursor:pointer; color: orange" class="fas fa-minus ml-2"></i>
                                </td>
                                <td class="text-right"> {{ number_format($cart['price']) }}</td>
                                <td class="text-center">
                                    <i wire:click="removeItem('{{ $cart['rowId'] }}')" style="font-size:12px; cursor:pointer; color: red" class="fas fa-trash-alt"></i>
                                </td>
                            </tr> 
                        @empty
                            <td colspan="4"><h6 class="text-center mt-2">Empty Cart</h6></td>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 text-right"> 
                    <h6>Sub Total: IDR {{ number_format($summary['sub_total']) }}</h6>
                    <h6>Tax (10%) : IDR {{ number_format($summary['tax'])  }}</h6>
                    <h6 class="font-weight-bold">Total: IDR {{ number_format($summary['total']) }}</h6>
                </div>
                <div class="form-group mt-3 mb-3">
                    <input wire:model="payment" type="number" class="form-control" id="payment" placeholder="Input customer payment amount">
                    <input type="hidden" id="total" value="{{ $summary['total'] }}">
                </div>
                <form wire:submit.prevent="handleSubmit">                    
                    <div class="form-group text-right">
                        <label>Payment</label>
                        <h4 id="paymentText" wire:ignore>IDR 0</h4>
                    </div>
                    <div class="form-group text-right">
                        <label>Change</label>
                        <h4 id="changeText" wire:ignore>IDR 0</h4>
                    </div>
                    <div>
                        <button wire:ignore id="saveButton" disabled class="btn btn-primary btn-block mt-4">PAY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-custom')
    <script>
        payment.oninput = () => {
            const payment = document.getElementById('payment').value
            const total = document.getElementById('total').value

            const change = payment - total

            document.getElementById('changeText').innerHTML = `IDR ${rupiah(change)}`  
            document.getElementById('paymentText').innerHTML = `IDR ${rupiah(payment)}`  

            const saveButton = document.getElementById('saveButton')

            if (change > 0) {
                saveButton.disabled = false
            } else {
                saveButton.disabled = true
            }
        }

        const rupiah = (angka) => {
            const numberString = angka.toString()
            const split = numberString.split(',')
            const sisa = split[0].length % 3
            let rupiah = split[0].substr(0, sisa)
            const ribuan = split[0].substr(sisa).match(/\d{1,3}/gi)

            if (ribuan) {
                const separator = sisa ? '.' : ''
                rupiah += separator + ribuan.join('.')
            }

            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah
        }
    </script>
@endpush
