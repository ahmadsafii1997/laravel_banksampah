<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('title')
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/lib/datatable/dataTables.bootstrap.min.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->

    <link rel="stylesheet" href="{{ asset('admin/assets/scss/style.css')}}">
    <link href="{{ asset('admin/assets/css/lib/vector-map/jqvmap.min.css')}}" rel="stylesheet">

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>

<body>

        <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        @include('admin.layouts.sidebar')
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">
        @include('admin.layouts.header')
        @yield('content')
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="{{ asset('admin/assets/js/vendor/jquery-2.1.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="{{ asset('admin/assets/js/plugins.js')}}"></script>
    <script src="{{ asset('admin/assets/js/main.js')}}"></script>

    <script src="{{ asset('admin/assets/js/lib/chart-js/Chart.bundle.js')}}"></script>
    <script src="{{ asset('admin/assets/js/dashboard.js')}}"></script>
    <script src="{{ asset('admin/assets/js/widgets.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/vector-map/jquery.vmap.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/vector-map/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/vector-map/jquery.vmap.sampledata.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/vector-map/country/jquery.vmap.world.js')}}"></script>
    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
        } )( jQuery );
    </script>

    <script src="{{ asset('admin/assets/js/lib/data-table/datatables.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/jszip.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/datatables-init.js')}}"></script>



    @yield('js')

</body>
</html>