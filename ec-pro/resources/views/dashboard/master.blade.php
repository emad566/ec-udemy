<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <?php $ver='1.3'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/dashboard/eliteadmin-theme/assets/images/favicon.png') }}">
    <title>Elite Admin Template - The Ultimate Multipurpose admin template</title>
    <!-- This page CSS -->

    @isset($charts)
        <!-- chartist CSS -->
        <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    @endisset

    @isset($toast)
        <!--Toaster Popup message CSS -->
        <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    @endisset

    <!-- Font Aweseme -->
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/font-awesome/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/weather-icons/css/weather-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/themify-icons/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/flag-icon-css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/material-design-iconic-font/css/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/css/style.min.css?v=11') }}" rel="stylesheet">

    @isset($dashboard1)
        <!-- Dashboard 1 Page CSS -->
        <link href="{{ asset('assets/dashboard/eliteadmin-theme/css/pages/dashboard1.css') }}" rel="stylesheet">
    @endisset

    <!-- Emad CSS -->
    @empty($emad_rtl)
        <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/dashboard/css/emad-rtl.css?v='.$ver) }}" />
    @endempty

    @yield('style')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}"></script>
<![endif]-->
</head>

<body class="skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    @include('dashboard.layouts.preloader')

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                @include('dashboard.layouts.navbar-header')

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        @include('dashboard.layouts.comments')
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        @include('dashboard.layouts.messages')
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- mega menu -->
                        <!-- ============================================================== -->
                        @include('dashboard.layouts.mega-dropdown')
                        <!-- ============================================================== -->
                        <!-- End mega menu -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        @include('dashboard.layouts.user-profile')
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('dashboard.layouts.sidebar')

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            @yield('content')
            @include('dashboard.layouts.right-sidebar')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        @include('dashboard.layouts.footer')
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme//js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme//js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme//js/sidebarmenu.js') }}"></script>
    @empty($ishome)
        <!--stickey kit -->
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>
    @endempty
    <!--Custom JavaScript -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme//js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    @isset($morris)
        <!--morris JavaScript -->
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/raphael/raphael-min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/morrisjs/morris.min.js') }}"></script>
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    @endisset

    @isset($toast)
        <!-- Popup message jquery -->
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    @endisset

    @isset($dashboard1)
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/js/dashboard1.js') }}"></script>
    @endisset

    @isset($charts)
        <!-- Chart JS -->
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    @endisset



    @isset($datatable)
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/js/dashboard1.js') }}"></script>
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>

        <!-- dataTable Libs -->
        <!-- This is data table -->
        <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/datatables/datatables.min.js') }}"></script>
        <!-- start - This is for export functionality only -->
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <!-- end - This is for export functionality only -->
        <!-- datadtable JS Commands -->
        <script>
            $(function() {
                $('.datatable').DataTable();
                $(function() {
                    var table = $('#example').DataTable({
                        "language": {
                            "search": "بحث :",
                            "sLengthMenu ": "اعرض ",
                        },
                        "columnDefs": [{
                            "visible": false,
                            "targets": 2
                        }],
                        "order": [
                            [2, 'asc']
                        ],
                        "displayLength": 25,
                        "drawCallback": function(settings) {
                            var api = this.api();
                            var rows = api.rows({
                                page: 'current'
                            }).nodes();
                            var last = null;
                            api.column(2, {
                                page: 'current'
                            }).data().each(function(group, i) {
                                if (last !== group) {
                                    $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                    last = group;
                                }
                            });
                        }
                    });
                    // Order by the grouping
                    $('.datatable tbody').on('click', 'tr.group', function() {
                        var currentOrder = table.order()[0];
                        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                            table.order([2, 'desc']).draw();
                        } else {
                            table.order([2, 'asc']).draw();
                        }
                    });
                });
            });

            $('.datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

        </script>

    @endisset <!-- /End isset DataTable -->
    <!-- swal alert Files -->
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>
    <!-- /swal alert Files -->

    <!-- manual Scripts -->
    @empty($manualScripts)
        <script>
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}"
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('message') }}")
                    break;

                    case 'success':
                        toastr.success("{{ Session::get('message') }}")
                    break;

                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}")
                    break;

                    case 'error':
                        toastr.error("{{ Session::get('message') }}")
                    break;

                    default:
                        toastr.info("ALERT");
                    break;
                }
            @endif

            $(document).ready(function(){
                /* ======================================
                priew image before uploaded
                ===================================== */
                $('.uploadbtn').change(function(){
                    if ($(this).prop('files') && $(this).prop('files')[0]) {
                        var reader = new FileReader();
                        $imgId = $(this).attr('img');
                        reader.onload = function (e) {

                            $('.uploadbtnDiv img.'+$imgId).attr('src', e.target.result);
                            $('.uploadbtnDiv img.'+$imgId).addClass('showimg');
                        }
                        imgsize = $(this).prop('files')[0]['size']
                        imgsize = Math.round(imgsize / 1024, 4) + ' KB';

                        imgname = $(this).prop('files')[0]['name']

                        $('div.'+$imgId+' #image_size').html(imgsize);
                        $('div.'+$imgId+' #image_name').html(imgname);

                        reader.readAsDataURL($(this).prop('files')[0]);
                    }
                })

                $('.pdfuploadbtn').change(function(){
                    if ($(this).prop('files') && $(this).prop('files')[0]) {
                        var reader = new FileReader();
                        $imgId = $(this).attr('img');
                        reader.onload = function (e) {

                            // $('.pdfuploadbtn img.'+$imgId).attr('src', https://mwjood.emadeldeen.com/assests/images/pdf.png);
                            $('.pdfuploadbtn img.'+$imgId).addClass('showimg');
                        }
                        imgsize = $(this).prop('files')[0]['size']
                        imgsize = Math.round(imgsize / 1024, 4) + ' KB';

                        imgname = $(this).prop('files')[0]['name']

                        $('div.'+$imgId+' #image_size').html(imgsize);
                        $('div.'+$imgId+' #image_name').html(imgname);

                        reader.readAsDataURL($(this).prop('files')[0]);
                    }
                })

                //Delete Verfy
                $(document).on("click", ".deleteMe", function(e){
                    e.preventDefault();
                    var link = $(this).attr("href");
                    var msg = $(this).attr("msg");
                    var formId = $(this).attr("formId");
                    if(!msg) msg = "Once Delete, This will be Permanently Delete!"
                    swal({
                        title: "Are you Want to delete?",
                        text: msg,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                        if(formId)
                            document.getElementById(formId).submit();
                        else
                            window.location.href = link;
                        } else {
                        swal("Safe Data!");
                        }
                    });
                });

                //UpdateIsActive
                $('.updateIsActive').change(function(){
                    action = $(this).attr('action')
                    window.location.href = action;
                })

                // MultiSelect checkbox for delete
                $(document).on("change", '#allItems', function(event) {
                    if($(this).is(':checked')){
                        $('.boxItem').prop('checked', true)
                    }else{
                        $('.boxItem').prop('checked', false)
                    }
                });

            })
        </script>
    @endempty <!-- /end empty manual Scripts -->

    @yield('script')
</body>

</html>
