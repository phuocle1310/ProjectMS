<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <input:insertAttribute name = "head-plugin" /> -->
    <link rel="stylesheet" href="{{asset('/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/js/select.dataTables.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('/vendors/mdi/css/materialdesignicons.min.css')}}"> -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <!-- <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}"> -->

    <!-- <title><input:insertAttribute name="title" /></title> -->

</head>
<body>
<div class="container-scroller">
    @include('layout.header')
        <div class="container-fluid page-body-wrapper" >
            @include('layout.setting-panel')
            @include('layout.sidebar')
            <div class="main-panel" >
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('layout.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
    <!-- page-body-wrapper ends -->
</div>

<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{asset('/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
    <!-- <input:insertAttribute name = "body-plugin" /> -->
<script src="{{asset('/vendors/chart.js/Chart.min.js')}}"></script>

@stack('js')

<script src="{{asset('/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/vendors/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('/js/alerts.js')}}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('/js/off-canvas.js')}}"></script>
<script src="{{asset('/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('/js/template.js')}}"></script>
<script src="{{asset('/js/settings.js')}}"></script>
<script src="{{asset('/js/todolist.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
  <script src="{{asset('/js/dashboard.js')}}"></script>
  <script src="{{asset('/js/Chart.roundedBarCharts.js')}}"></script>
<!-- End custom js for this page-->
</body>

</html>

