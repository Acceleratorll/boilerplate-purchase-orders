@extends('admin.layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          Halaman reporting  
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <select id="products" name="products[]" class="js-example-basic-multiple" multiple="multiple" style="width: 100%" autocomplete="off">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input name="dates"/>
            </div>
        </div>
        <div id="product_price_range" class="x_panel tile">
            <canvas class="canvasChartProduct" height="520" width="520" style="margin: 15px 10px 10px 0">
            </canvas>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $('input[name="dates"]').daterangepicker();

        var productPriceRange = {
        _defaults: {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
                labels: [
                    '< 50000',
                    '50000 - 99999',
                    '100000 - 999999',
                    '>= 1000000'
                ],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        "#3498DB",
                        "#3498DB",
                        "#9B59B6",
                        "#E74C3C",
                    ],
                    hoverBackgroundColor: [
                        "#36CAAB",
                        "#49A9EA",
                        "#B370CF",
                        "#E95E4F",
                    ]
                }]
            },
            options: {
                legend: false,
                responsive: false
            }
        },
        init: function ($el) {
            var self = this;
            $el = $($el);
            $.ajax({
                url: 'reporting/chart-product',
                success: function (response) {
                    self._defaults.data.datasets[0].data = [
                        response.less_50000, 
                        response._50000_99999, 
                        response._100000_999999, 
                        response.more_than_equal_1000000];
                    new Chart($el.find('.canvasChartProduct'), self._defaults);
                }
            });
        }
    };

    productPriceRange.init($('#product_price_range'));
    </script>
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
