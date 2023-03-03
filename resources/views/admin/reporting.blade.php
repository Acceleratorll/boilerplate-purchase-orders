@extends('admin.layouts.admin')

@section('content')
    <!-- page content -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          Halaman reporting  
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <select id="products" name="products[]" class="select2" multiple="multiple" style="width: 100%" autocomplete="off">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input name="dates" style="width: 100%"/>
            </div>
        </div>
        <div id="product_price_range">
            <canvas class="canvasChartProduct">
            </canvas>
        </div>
        <div id="output" style="margin: 30px;"></div>
    </div>
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
    {{ Html::script(mix('assets/admin/js/users/edit.js')) }}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script>
    <script>
        $('input[name="dates"]').daterangepicker();
        $.ajax({
            url: 'reporting/all-data-product',
            success: function(response){
                $("#output").pivot(
                    response,
                    {
                        rows: ["created_range"],
                        cols: ["price_range"]
                    }
                );
            }
        })
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
                        response.less_50k, 
                        response.more_1m, 
                        response._50k_99k, 
                        response._100k_999k];
                    new Chart($el.find('.canvasChartProduct'), self._defaults);
                }
            });
        }
    };

    productPriceRange.init($('#product_price_range'));
    </script>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
    {{ Html::style(mix('assets/admin/css/users/edit.css')) }}
    <link rel="stylesheet" type="text/css" href="https://pivottable.js.org/dist/pivot.css">
@endsection