let mix = require('laravel-mix');

// Bootstrap
mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css');
mix.copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js');
mix.copyDirectory('node_modules/bootstrap/dist/fonts', 'public/fonts');

// jQuery
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js');

// Font Awsome
mix.copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/css/font-awesome.min.css');
mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts');

// Ionicons
mix.copy('node_modules/ionicons/dist/css/ionicons.min.css', 'public/css/ionicons.min.css');
mix.copyDirectory('node_modules/ionicons/dist/fonts', 'public/fonts');

// AdminLTE
mix.copy('node_modules/admin-lte/dist/js/adminlte.min.js', 'public/js/adminlte.min.js');
mix.copy('node_modules/admin-lte/dist/css/AdminLTE.min.css', 'public/css/AdminLTE.min.css');
mix.copyDirectory('node_modules/admin-lte/dist/css/skins', 'public/css/skins');

// Plugins
mix.copyDirectory('node_modules/admin-lte/plugins', 'public/plugins');
mix.copy('node_modules/chart.js/Chart.min.js', 'public/plugins/Chart.js/Chart.min.js');
mix.copy('node_modules/flot/jquery.flot.js', 'public/plugins/flot/jquery.flot.js');
mix.copy('node_modules/morris.js/morris.min.js', 'public/plugins/morris.js/morris.min.js');
mix.copy('node_modules/morris.js/morris.css', 'public/plugins/morris.js/morris.css');
mix.copyDirectory('node_modules/morris.js/lib', 'public/plugins/morris.js/lib');
mix.copy('node_modules/jquery-sparkline/jquery.sparkline.min.js', 'public/plugins/jquery-sparkline/jquery.sparkline.min.js');
mix.copyDirectory('node_modules/ion-rangeslider', 'public/plugins/ion-slider');
mix.copyDirectory('node_modules/bootstrap-datepicker/dist', 'public/plugins/datepicker');
mix.copy('node_modules/bootstrap-daterangepicker/daterangepicker.js', 'public/plugins/daterangepicker/daterangepicker.js');
mix.copyDirectory('node_modules/bootstrap-colorpicker/dist', 'public/plugins/colorpicker');
mix.copyDirectory('node_modules/datatables.net', 'public/plugins/datatables.net');
mix.copyDirectory('node_modules/datatables.net-bs', 'public/plugins/datatables.net-bs');
mix.copy('node_modules/jquery-knob/dist/jquery.knob.min.js', 'public/plugins/jquery-knob/jquery.knob.min.js');
mix.copy('node_modules/slimscroll/lib/slimscroll.js', 'public/plugins/slimscroll/slimscroll.js');

