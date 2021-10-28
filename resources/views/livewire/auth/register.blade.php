<div class="container">
    <div class="row mt-2">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center font-weight-bold ">Register</h2>
                    <form wire:submit.prevent="submit">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Name</label>
                            <input wire:model="form.name" type="text" class="form-control">
                            @error('form.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input wire:model="form.email" type="email" class="form-control">
                            @error('form.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Password</label>
                            <input wire:model="form.password" type="password" class="form-control">
                            @error('form.password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Password</label>
                            <input wire:model="form.password_confirmation" type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block font-weight-bold">REGISTER</button>
                        </div>
                        <div class="form-group text-right pr-4">
                            <a href="/login">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
