<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <?php $ver = '1.6.0'; ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sleek - Admin Dashboard Template</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500"
        rel="stylesheet" />
    <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="{{ asset('assets/dashboard/plugins/toaster/toastr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/flag-icons/css/flag-icon.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/ladda/ladda.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/dashboard/css/sleek.rtl.css') }}" />

    <!-- Emad css -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/dashboard/css/emad-rtl.css?v='.$ver) }}" />

     <!-- toaster js-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

     <!-- Fontawesome Fonts-->
    <script src="https://kit.fontawesome.com/c7125b87e6.js" crossorigin="anonymous"></script>

    <!-- datatable -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    @yield('style')

    <!-- FAVICON -->
    <link href="{{ asset('assets/dashboard/img/favicon.png') }}" rel="shortcut icon" />

    <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <script src="{{ asset('assets/dashboard/plugins/nprogress/nprogress.js') }}"></script>
</head>


<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
    <script>
        NProgress.configure({
            showSpinner: false
        });
        NProgress.start();

    </script>

    <div class="mobile-sticky-body-overlay"></div>

    <div class="wrapper">

        <!--
          ====================================
          ——— LEFT SIDEBAR WITH FOOTER
          =====================================
        -->
        @include('dashboard.layouts.sidebar')

        <div class="page-wrapper">
            <!-- Header -->
            @include('dashboard.layouts.header')

            <!-- Header -->
            <div class="content-wrapper">
                <div class="content">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            @include('dashboard.layouts.footer')
        </div>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCn8TFXGg17HAUcNpkwtxxyT9Io9B_NcM" defer></script>
    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/toaster/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/charts/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/jquery-mask-input/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/jekyll-search.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/sleek.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/chart.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/date-range.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/map.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom.js') }}"></script>

    <!-- toaster js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Emad Js && Emad Bootstrap JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

    <!-- swal alert Files -->
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>
    <!-- /swal alert Files -->

    <!-- dataTable -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <!-- /dataTable -->


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
            $('.is_active').change(function(){
                action = $(this).attr('action')
                window.location.href = action;
            })

            // dataTable
            $('.datatable').DataTable( {
                "language": {
                    "search": "بحث :",
                    "sLengthMenu ": "اعرض ",
                },
                "lengthMenu": [[10, 25, 50, 100, 200, 500 , 1000, -1], [10, 25, 50, 100, 200, 500 , 1000, "All"]],
                "pageLength": 10,
                "oLanguage": {
                    "sProcessing":   "جارٍ التحميل...",
                    "sLengthMenu":   "أظهر _MENU_ مدخلات",
                    "sZeroRecords":  "لم يعثر على أية سجلات",
                    "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix":  "",
                    "sSearch":       "ابحث:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "الأول",
                        "sPrevious": "السابق",
                        "sNext":     "التالي",
                        "sLast":     "الأخير"
                    }
                }

            });
        })
    </script>
    @yield('script')
</body>

</html>
