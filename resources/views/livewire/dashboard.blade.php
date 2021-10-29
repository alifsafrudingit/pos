<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-info shadow-">
                        <div class="card-body">
                            <h5 class="text-white">Transactions Total</h5>
                            <h2 class="text-white font-weight-bold text-right">{{ $count_transaction }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-secondary shadow-">
                        <div class="card-body">
                            <h5 class="text-white">Products Available</h5>
                            <h2 class="text-white font-weight-bold text-right">{{ $count_product_available }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-warning shadow-">
                        <div class="card-body">
                            <h5 class="text-white">Product Not Available</h5>
                            <h2 class="text-white font-weight-bold text-right">{{ $count_product_not_available }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-danger shadow-">
                        <div class="card-body">
                            <h5 class="text-white">Registered User</h5>
                            <h2 class="text-white font-weight-bold text-right">{{ $count_user }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4">
                        <div class="card-body">
                            <h3>Sale Chart</h3>
                            <div style="height: 32rem;">
                                <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
