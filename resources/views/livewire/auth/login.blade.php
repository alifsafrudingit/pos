<div class="container">
    <div class="row mt-5">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center font-weight-bold mb-4 mt-2">Sign In to POS</h2>
                    @if (session()->has('error'))
                        <span class="text-danger">{{ session('error') }}</span>
                    @endif
                    <form wire:submit.prevent="submit">
                        <div class="form-group">
                            {{-- <label for="email" class="font-weight-bold">Email</label> --}}
                            <input wire:model="form.email" type="email" class="form-control" placeholder="Email"
                            @error('form.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            {{-- <label for="password" class="font-weight-bold">Password</label> --}}
                            <input wire:model="form.password" type="password" class="form-control" placeholder="Password">
                            @error('form.password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-success btn-block font-weight-bold">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
