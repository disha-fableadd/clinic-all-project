<!DOCTYPE html>

<html lang="en">





<!-- index22:59-->



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="robots" content="noindex, nofollow"> 
 
<!-- <link rel="shortcut icon" type="image/x-icon" href="{{asset(env('IMAGE_PATH').'admin/assets/img/favicon.ico')}}"> -->

    <link rel="shortcut icon" type="image/x-icon"
        href="{{asset(env('IMAGE_PATH') . 'admin/assets/img/logo.png')}}">

    <!-- Add to homescreen configuration -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Fablead-HMS">
    <link rel="apple-touch-icon" href="{{asset(env('IMAGE_PATH') . 'admin/assets/img/logo.png')}}">

    <title>Fablead-HMS</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css"
        href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/font-awesome.min.css')}}">

    <link rel="stylesheet" type="text/css"
        href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/fullcalendar.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/select2.min.css')}}">

    <!-- <link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH').'admin/assets/css/bootstrap-datetimepicker.min.css')}}"> -->

    <link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/style.css')}}">

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <script src=" https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset(env('IMAGE_PATH') . 'admin/assets/js/select2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">

    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/common.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset(env('IMAGE_PATH') . 'admin/assets/css/app.css')}}">


<style>
        .select2-container--default .select2-selection--single.is-invalid {
            border: 2px solid #e74c3c !important;
            background-color: #fff6f6 !important;
        }


        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            border: 2px solid #e74c3c !important;
        }

        /* searchbar inside dropdown */
        .select2-container .select2-selection--single {
            height: 40px !important;
            border: 1px solid rgb(207 236 224) !important;
            border-radius: 25px !important;
            padding: 6px 12px;
            font-size: 14px;
            color: black !important;
            background-color: #fff;
            box-shadow: none;
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid rgb(207 236 224) !important;
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            z-index: 1051;
            margin-top: 6px !important;
            border-radius: 15px !important;
            /* border-top: 0 !important; */
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: rgb(207 236 224) !important;
            color: black !important;
            border-radius: 15px !important;
            margin: 2px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid rgb(207 236 224) !important;
            border-radius: 25px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            color: #6c757d;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            right: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #495057 !important;
        }

        .select2-search__field {
            padding-left: 10px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-search__field {
            display: inline-block !important;
            width: 100% !important;
            min-height: 35px;
            padding: 6px 8px;
            margin: 4px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
        }




        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: rgb(207, 236, 224) !important;
            color: black !important;
            border-radius: 20px !important;
            /* padding: 2px 10px !important; */
            border: none;
            font-size: 14px;
            font-weight: normal !important;
            text-align: center;
            max-width: fit-content;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: rgb(207 236 224) !important;
            border-radius: 15px !important;
            margin: 2px !important;
            color: black !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: rgb(207 236 224) !important;
            border-radius: 15px !important;
            margin: 2px !important;
            color: black !important;
        }









        .table th {

            border-top: 0 !important;

        }

        .table {
            color: #000 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 20px 20px 0 0 !important;
            /* overflow: hidden !important; */
        }

        div.dt-container.dt-empty-footer tbody>tr:last-child>* {
            border-bottom: 1px solid transparent !important;
        }

        .all {

            display: flex;

            justify-content: space-between;

            align-items: center;



        }



        .fc-toolbar.fc-header-toolbar {

            margin-bottom: 0 !important;

        }









        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,

        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,

        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before,

        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {

            opacity: 6 !important;

        }



        table.dataTable th.dt-type-numeric,

        table.dataTable th.dt-type-date,

        table.dataTable td.dt-type-numeric,

        table.dataTable td.dt-type-date {

            text-align: left !important;

        }







        .chart-container {

            width: 512px;

            height: 430px;

            /* Adjust as needed */

        }



        .icon-style {

            background-color: white;



            color: rgb(157 195 179);

            padding: 10px;

            border-radius: 50%;



        }



        .icon-style1 {

            background-color: white;

            font-size: 25px;

            color: rgb(157 195 179);

            padding: 10px;

            border-radius: 50%;



        }





        .form-container {

            width: 100%;



            padding: 30px;

            background-color: #ffffff;

            border-radius: 10px;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

            margin: 20px auto;

        }



        .offset-lg-2 {

            margin: auto;

            width: 80%;

        }



        .icon {

            font-size: 15px;

            display: flex;



        }



        .icon .icon1 {

            padding: 8px;

            background-color: #f89884;

            color: white;

            border-radius: 10px;



        }



        .icon .icon2 {

            padding: 8px;

            background-color: #f89884;

            color: white;

            border-radius: 10px;

        }



        .icon .icon3 {

            padding: 8px;

            background-color: #f89884;

            color: white;

            border-radius: 10px;

        }



        .icon .icon4 {

            padding: 8px;

            background-color: #f89884;

            color: white;

            border-radius: 10px;

        }


        table.dataTable>thead>tr>th,
        {
        padding: 10px;
        border-bottom: 1px solid #f89884 !important;



        }

        .table thead th {
            /* border-bottom: 1px solid #f89884 !important; */
            /* border-top-right-radius: 20px !important; */


        }

        /* .dt-orderable-asc {
            border-top-left-radius: 20px !important;
        } */

        .table thead tr {

            background-color: #f89884;

            color: white;

            text-align: center;

            border-top-right-radius: 20px !important;

            border-top-left-radius: 20px !important;

        }



        .table thead th {

            text-align: center;

            border-right: 1px solid #ffffff75;

        }



        .page-title {

            color: #565656;

            font-size: 25px;

            font-weight: normal;

            margin-bottom: 10px;

            text-align: left;

            padding-left: 12px;

        }





        @media (max-width: 767px) {




            /* a.mobile_btn {

                padding: 20px 20px ;

            }  */



            .userProfile {
                width: 100px !important;
                height: 100px !important;
            }

            .margin-text {
                margin: 5px !important;
            }

            .margin-img {
                margin: auto 0;
            }

            .icon-style1 {


                font-size: 15px;

            }








            div.dt-container div.dt-layout-row:not(.dt-layout-table) {
                display: flex !important;

                align-items: stretch;
                gap: 10px;
                /* Optional spacing */
            }

            .dt-search label {
                display: none !important;
            }

            .dt-length label {
                display: none !important;
            }

            /* Style the search input placeholder */
            input[type="search"]::placeholder {
                color: #999;
                font-size: 14px;
                text-align: center;
                /* Optional */
            }

            input[type="search"] {
                width: 100% !important;
                font-size: 14px;
                padding: 8px 12px;
                border-radius: 10px;
                border: 1px solid #f4a48b;
            }






            div.dt-container select.dt-input {
                padding: 9px !important;
            }

            .header .wrap {

                display: none;

            }

            div.dt-container .dt-input {

                border-radius: 50px !important;

            }


            /* 
            .page-title {

                padding: 0 !important;

            } */



            .eye-btn {

                /* padding: 0 !important; */

                margin: 0 !important;



            }



            .smssend {

                margin-left: 0 !important;

            }



            .prv-btn {

                padding: 10px 33px !important;

            }



            .all-form {

                width: 100% !important;

            }



            .form-container {

                width: 100% !important;
                padding: 10px !important;

            }



            .table-responsive {

                overflow-x: auto !important;

                -webkit-overflow-scrolling: touch !important;

                /* For smooth scrolling on mobile */

            }



            /* .patient-form {

                height: 760px;

            } */

            .edit-patient-form {
                height: 800px !important;
            }

            .patient-form2 {

                height: 755px;

            }

            .page-title {
                font-size: 14px !important;
                padding-left: 10px !important;
                text-align: left !important;
                padding-top: 5px !important;
            }


            .appo-form {

                height: 580px;

            }



            .follow-form {

                height: 735px;

            }

            .medi-form {
                height: 505px;
            }

            .view-service {
                margin-left: 0 !important;
            }

            .offset-lg-2 {
                width: 100%;
                padding: 10px;
            }

            .view-discharge {
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

            .discharge-form1 {
                height: 800px;
            }

            .discharge-form2 {
                height: 690px;
            }

            .medicine-form {

                height: 510px;

            }


            .report-form {

                height: 600px;

            }



            .buttons {

                display: flex;

            }



            .emailtemp {

                margin-right: 5px;

            }



            /* .offset-lg-2{

         width: 0;

        } */



            .nav-tabs {

                flex-direction: column;

                /* Stack items vertically */

                display: flex;

                padding: 0;

            }



            .nav-tabs .nav-item {

                width: 100%;

                /* Full width */

                text-align: center;

            }



            .nav-tabs .nav-link {

                display: block;

                width: 100%;

                text-align: center;

                padding: 10px 15px;

                border: 1px solid #ddd;

                /* Optional: Add border to separate tabs */

                border-radius: 5px;

                margin-bottom: 5px;

                /* Space between tabs */

            }

            #multiStepForm {

                width: 100% !important;

            }




        }

        @media (min-width: 768px) and (max-width: 1366px) {

            #multiStepForm,
            #appointmentForm,
            #editTreatmentForm,
            #createTreatmentForm,
            #followupForm,
            #medicineForm,
            #categoryForm,
            #editCategoryForm,
            #createmedicineForm,
            #createServiceForm,
            #editServiceForm,
            #dischargeform,
            #editSupplierForm,
            #createSupplierForm,
            #medicalReportForm,
            #editProfileForm {

                width: 100% !important;

            }

            .discharge-title {
                text-align: left !important;
                /* padding-left: 180px; */
            }

            .calender-apointment,
            .about-padding {
                padding-top: 9px !important;
            }

            .report-title {
                text-align: left !important;
                /* padding-left: 160px !important; */
            }

            .report-btn {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .sms-float {
                text-align: right !important;
            }

            .template-create {
                text-align: left !important;
                padding-left: 15px !important;
            }

            .service-title {
                text-align: left !important;
                padding-left: 15px !important;
            }

            .supplier-btn {
                text-align: right;
                padding-right: 15px !important;
            }

            .inventory-btn {
                text-align: right !important;
                padding-right: 15px !important;
            }

            .inventory-title {
                text-align: left !important;
                padding-left: 15px !important;
            }

            .discharge-btn {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .service-text {
                padding-left: 0 !important;
                text-align: left !important;

            }

            .service-btn {
                text-align: right !important;
                padding-right: 15px !important;

            }

            .pm-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .pm-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .offset-lg-2 {
                width: 100%;
                padding: 10px;
            }

            .category-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .category-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .staff-title {
                padding-left: 0px !important;
                text-align: left !important;
            }

            .staff-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .patient-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .patient-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .appointment-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .appointment-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .treatment-title {
                padding-left: 0px !important;
                text-align: left !important;

            }

            .treatment-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .followup-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .followup-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            .medicine-title {
                padding-left: 15px !important;
                text-align: left !important;
            }

            .medicine-button {
                padding-right: 15px !important;
                text-align: right !important;
            }

            /* Mobile view padding & table optimizations for all pages */
            .page-wrapper > .content,
            .content {
                padding: 12px 10px calc(68px + env(safe-area-inset-bottom)) 10px !important;
            }

            .content > .row {
                margin-left: -5px !important;
                margin-right: -5px !important;
            }

            .content [class*="col-"] {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }

            .card {
                margin-bottom: 15px !important;
                border-radius: 16px !important;
            }

            .card .card-header {
                padding: 12px 14px !important;
                border-top-left-radius: 16px !important;
                border-top-right-radius: 16px !important;
            }

            .card-body,
            .card-body1 {
                padding: 0 10px 12px 10px !important;
            }

            .table-responsive {
                padding: 0 !important;
                margin-bottom: 0 !important;
                border: 0 !important;
            }

            .table.custom-table,
            table.dataTable,
            .table {
                width: 100% !important;
                margin-bottom: 0 !important;
            }

            .table.custom-table > tbody > tr > td,
            .table.custom-table > tbody > tr > th,
            .table.custom-table > tfoot > tr > td,
            .table.custom-table > tfoot > tr > th,
            .table.custom-table > thead > tr > td,
            .table.custom-table > thead > tr > th,
            .table td,
            .table th,
            table.dataTable th,
            table.dataTable td {
                padding: 9px 7px !important;
            }

            .table.custom-table > tbody > tr > td:first-child,
            .table.custom-table > thead > tr > th:first-child,
            .table td:first-child,
            .table th:first-child,
            table.dataTable th:first-child,
            table.dataTable td:first-child {
                padding-left: 6px !important;
            }

            .table.custom-table > tbody > tr > td:last-child,
            .table.custom-table > thead > tr > th:last-child,
            .table td:last-child,
            .table th:last-child,
            table.dataTable th:last-child,
            table.dataTable td:last-child {
                padding-right: 6px !important;
            }

            div.dataTables_wrapper {
                padding: 0 !important;
            }

            div.dataTables_wrapper .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            div.dataTables_wrapper [class*="col-"] {
                padding-left: 4px !important;
                padding-right: 4px !important;
            }

            div.dataTables_wrapper div.dataTables_length,
            div.dataTables_wrapper div.dataTables_filter {
                margin-bottom: 8px !important;
            }

            div.dataTables_wrapper div.dataTables_filter input {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

        }
    </style>

</head>



<body>

    <div class="main-wrapper">

        @include('layout.header')

        @include('layout.sidebar')



        @yield('content')


        @yield('scripts')


        <script>
    function setBranch(branchId, branchName) {
    localStorage.setItem("selectedBranchId", branchId);
    localStorage.setItem("selectedBranchName", branchName);

    // Redirect to dashboard with branch_id
    window.location.href = `/dashboard?branch_id=${branchId}`;
}



        </script>

        @include('layout.footer')