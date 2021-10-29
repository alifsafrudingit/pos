<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="font-weight-bold mb-3">Product List</h2>
                        </div>
                        <div class="col-md-4">
                            <input wire:model="search" type="text" class="form-control" placeholder="Search product">
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead class="table-success">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th width="20%">Image</th>
                                    <th>Description</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index=>$product)                                
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ asset('storage/images/'.$product->url) }}" alt="product image" class="img-fluid"></td>
                                    <td>{{ $product->description }}</td>
                                    <td class="text-center">{{ $product->stock }}</td>
                                    <td>{{ number_format($product->price) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="mt-4" style="display:flex; justify-content:center;">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3">Create Product</h2>
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input wire:model="name" type="text" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Product Image</label>
                            <div class="custom-file">
                                <input wire:model="url" type="file" class="custom-file-input" id="customFile">
                                <label for="customFile" class="custom-file-label">Choose Image</label>
                                @error('url')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if ($url)
                                <label class="mt-2">Image Preview</label>
                                <img src="{{ $url->temporaryUrl() }}" class="img-fluid" alt="Preview Image">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea wire:model="description" type="text" class="form-control"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>  
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input wire:model="stock" type="number" class="form-control">
                            @error('stock')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label for="">Price</label>
                            <input wire:model="price" type="number" class="form-control">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit Product</button>    
                        </div> 
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h3>{{ $name }}</h3>
                    <h3>{{ $url }}</h3>
                    <h3>{{ $description }}</h3>
                    <h3>{{ $stock }}</h3>
                    <h3>{{ $price }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
