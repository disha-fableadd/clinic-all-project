@php
    use App\Models\Setting;

    $currentProjectTypeId = (int) Setting::getValue('project_type_id', 1);
@endphp


<style>
    .menu-link.active {

        color: black;

        background-color: #cfece0;

        border-radius: 15px;

        margin: 0 10px;

        padding: 0 1px;

    }



    .submenu.active>a {

        color: black;

        background-color: #cfece0;

        border-radius: 15px;

        margin: 0 10px;

        padding: 12px 15px !important;

    }



    .menu-link1.active {

        background-color: #cfece0;

        color: black;

        border-radius: 15px;

        /* margin: 0 10px ; */



    }



    .submenu ul {

        /* padding-left: 20px; */

        color: black;

    }



    .submenu.active>a .menu-arrow {

        transform: rotate(90deg);

        transition: transform 0.3s ease;

    }
</style>



<div class="sidebar" id="sidebar">

    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu mt-3">

            <ul>
                <!-- <li class="menu-title">Main</li> -->


                <li class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <a href="{{ route('dashboard') }}"> <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span></a>

                </li>



                @if (app('hasPermission')(3, 'view'))

                    <li class="submenu {{ request()->routeIs('user.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-user-md"></i><span>Staffs</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('user.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(3, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('user.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('user.index') }}"><i class="fa fa-users icons "></i><span
                                            style="

                                                                                                                                                                                                                                                            padding-left: 5px;">
                                            All
                                            Staffs

                                        </span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(3, 'create'))
                                <li class="menu-link1 {{ request()->routeIs('user.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('user.create') }}"><i class="fa fa-user-plus icons"></i><span
                                            style="

                                                                                                                                                                                                                                                            padding-left: 5px;">
                                            Add
                                            Staff

                                        </span></a>

                                </li>
                            @endif



                        </ul>

                    </li>

                @endif


                @if (app('hasPermission')(30, 'view'))
                    <li class="submenu {{ request()->routeIs('daily_data.*') ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-file-medical-alt"></i> <!-- Changed from fa-calendar -->
                            <span>Daily Register</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="{{ request()->routeIs('daily_data.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(30, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('daily_data.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('daily_data.index') }}">
                                        <i class="fas fa-list-alt icons"></i> <!-- Changed from fa-calendar-check -->
                                        <span style="padding-left: 5px;">All Daily Register</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(30, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('daily_data.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('daily_data.create') }}">
                                        <i class="fas fa-plus-circle icons"></i> <!-- Changed from fa-calendar-plus -->
                                        <span style="padding-left: 5px;">Add Daily Register</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif


                @php
                    $isPatientRole = optional(Auth::user()?->role)->name === 'Patient';
                    $hasPatient = app('hasPermission')(5, 'view') || app('hasPermission')(5, 'create');
                    $hasDiagnosis = app('hasPermission')(35, 'view') || app('hasPermission')(35, 'create');
                    $hasReferalDoctor = app('hasPermission')(36, 'view') || app('hasPermission')(36, 'create');
                @endphp

                @if ($hasPatient || $hasDiagnosis || $hasReferalDoctor)
                    <li
                        class="submenu {{ request()->routeIs('patients.*', 'diagnosis.*', 'referaldoctor.*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-wheelchair"></i>
                            <span>Patients</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul
                            style="{{ request()->routeIs('patients.*', 'diagnosis.*', 'referaldoctor.*') ? 'display: block;' : 'display: none;' }}">
                            {{-- Patients --}}
                            @if (app('hasPermission')(5, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('patients.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('patients.index') }}">
                                        <i class="fa fa-procedures icons"></i>
                                        <span style="padding-left: 5px;">All Patients</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(5, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('patients.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('patients.create') }}">
                                        <i class="fa fa-user-injured icons"></i>
                                        <span style="padding-left: 5px;">Add Patient</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Diagnosis --}}
                            @if (app('hasPermission')(35, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('diagnosis.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('diagnosis.index') }}">
                                        <i class="fa fa-stethoscope icons"></i>
                                        <span style="padding-left: 5px;">All Diagnosis</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(35, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('diagnosis.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('diagnosis.create') }}">
                                        <i class="fa fa-notes-medical icons"></i>
                                        <span style="padding-left: 5px;">Add Diagnosis</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(36, 'view'))
                                <li class="menu-link {{ request()->routeIs('referaldoctor.index') ? 'active' : '' }}">

                                    <a href="{{ route('referaldoctor.index') }}">
                                        <i class="fa-solid fa-user-doctor"></i>
                                        <span> All Reference Doctor</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @php
                    $hasAppointmentView = app('hasPermission')(6, 'view');
                    $hasAppointmentCreate = app('hasPermission')(6, 'create') && !$isPatientRole;
                @endphp

                @if ($hasAppointmentView || $hasAppointmentCreate)

                    <li class="submenu {{ request()->routeIs('appointment.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-calendar"></i>

                            <span>Appointments</span><span class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('appointment.*') ? 'display: block;' : 'display: none;' }}">

                            @if ($hasAppointmentView)
                                <li
                                    class="menu-link1 {{ request()->routeIs('appointment.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('appointment.index') }}"><i
                                            class="fa fa-calendar-check icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">All

                                            Appointments</span> </a>

                                </li>
                            @endif

                            @if ($hasAppointmentCreate)
                                <li
                                    class="menu-link1 {{ request()->routeIs('appointment.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('appointment.create') }}"><i
                                            class="fa fa-calendar-plus icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">

                                            Add

                                            Appointment</span></a>

                                </li>
                            @endif



                        </ul>

                    </li>

                @endif

                @php
                    $hasFollowupView = app('hasPermission')(2, 'view');
                    $hasFollowupCreate = app('hasPermission')(2, 'create') && !$isPatientRole;
                @endphp

                @if ($hasFollowupView || $hasFollowupCreate)

                    <li class="submenu {{ request()->routeIs('followup.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-user"></i> <span>Followup</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('followup.*') ? 'display: block;' : 'display: none;' }}">

                            @if ($hasFollowupView)
                                <li class="menu-link1 {{ request()->routeIs('followup.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('followup.index') }}"><i class="fa fa-list icons"></i><span
                                            style="

                                                                                                                                                                                                                                                            padding-left: 5px;">
                                            All

                                            Followup</span></a>

                                </li>
                            @endif

                            @if ($hasFollowupCreate)
                                <li
                                    class="menu-link1 {{ request()->routeIs('followup.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('followup.create') }}"><i
                                            class="fa fa-plus-circle icons"></i><span
                                            style="

                                                                                                                                                                                                                                                            padding-left: 5px;">
                                            Add
                                            Followup

                                        </span></a>

                                </li>
                            @endif

                        </ul>

                    </li>

                @endif

                @if (app('hasPermission')(34, 'view'))
                    <li class="menu-link {{ request()->routeIs('machine.index') ? 'active' : '' }}">

                        <a href="{{ route('machine.index') }}"> <i class="fa fa-cogs "></i> <span> All
                                Machine</span></a>

                    </li>
                @endif






                @php
                    $hasTreatment = app('hasPermission')(7, 'view') || app('hasPermission')(7, 'create');
                    $hasTreatmentBooking = app('hasPermission')(31, 'view') || app('hasPermission')(31, 'create');
                    $hasSymptoms = app('hasPermission')(7, 'view') || app('hasPermission')(7, 'create');
                @endphp

                @if ($hasTreatment || $hasTreatmentBooking)
                    <li
                        class="submenu {{ request()->routeIs('treatment.*', 'treatment_booking.*', 'symptoms.*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-user-doctor"></i> {{-- Changed icon --}}
                            <span>Treatments</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul
                            style="{{ request()->routeIs('treatment.*', 'treatment_booking.*', 'symptoms.*') ? 'display: block;' : 'display: none;' }}">
                            {{-- Treatment --}}
                            @if (app('hasPermission')(7, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('treatment.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('treatment.index') }}">
                                        <i class="fa fa-stethoscope icons"></i>
                                        <span style="padding-left: 5px;">All Treatments</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(7, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('treatment.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('treatment.create') }}">
                                        <i class="fa fa-notes-medical icons"></i>
                                        <span style="padding-left: 5px;">Add Treatment</span>
                                    </a>
                                </li>
                            @endif





                            {{-- Treatment Booking --}}
                            @if (app('hasPermission')(31, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('treatment_booking.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('treatment_booking.index') }}">
                                        <i class="fa fa-file-medical icons"></i>
                                        <span style="padding-left: 5px;">All Booking</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(31, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('treatment_booking.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('treatment_booking.create') }}">
                                        <i class="fa fa-plus-circle icons"></i>
                                        <span style="padding-left: 5px;">Add Booking</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(7, 'view'))
                                <li class="menu-link {{ request()->routeIs('symptoms.index') ? 'active' : '' }}">

                                    <a href="{{ route('symptoms.index') }}"> <i class="fa fa-medkit "></i> <span> All
                                            Symptoms</span></a>

                                </li>
                            @endif
                        </ul>
                    </li>
                @endif



                @php
                    $hasMedicinePermission = app('hasPermission')(4, 'view') || app('hasPermission')(4, 'create');
                    $hasPatientMedicinePermission =
                        app('hasPermission')(17, 'view') || app('hasPermission')(17, 'create');
                    $isAdmin = Auth::check() && optional(Auth::user()->role)->name === 'Admin';
                @endphp

                @if ($hasMedicinePermission || $hasPatientMedicinePermission || $isAdmin)
                    <li
                        class="submenu {{ request()->routeIs('medicine.*', 'patient_medicine.*', 'category.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-pills"></i> <span>Medicines</span><span
                                class="menu-arrow"></span></a>

                        <ul
                            style="{{ request()->routeIs('medicine.*', 'patient_medicine.*', 'category.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(4, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('medicine.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('medicine.index') }}">
                                        <i class="fa fa-pills icons"></i><span style="padding-left: 5px;">All
                                            Medicines</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(4, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('medicine.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('medicine.create') }}">
                                        <i class="fa fa-capsules icons"></i><span style="padding-left: 5px;">Add
                                            Medicines</span>
                                    </a>
                                </li>
                            @endif


                            @if ($isAdmin)
                                <li
                                    class="menu-link1 {{ request()->routeIs('category.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('category.index') }}">
                                        <i class="fa fa-list icons"></i><span style="padding-left: 5px;">All
                                            Categories</span>
                                    </a>
                                </li>
                            @endif

                            <li
                                class="menu-link1 {{ request()->routeIs('medicine_unit.index') ? 'active' : '' }} mt-1">
                                <a href="{{ route('medicine_unit.index') }}">
                                    <i class="fa fa-medkit"></i>
                                    <span style="padding-left: 5px;">Medicine Units</span>
                                </a>
                            </li>

                            @if (app('hasPermission')(17, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('patient_medicine.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('patient_medicine.index') }}">
                                        <i class="fa fa-plus-circle icons"></i><span style="padding-left: 5px;">All
                                            Patient
                                            Medicine</span>
                                    </a>
                                </li>
                                <li class="menu-link {{ request()->routeIs('codemaster.index') ? 'active' : '' }}">
                                    <a href="{{ route('codemaster.index') }}"><i
                                            class="fa fa-prescription-bottle-medical"></i><span
                                            style="padding-left: 5px;">Code </span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Expense --}}

                @if (app('hasPermission')(33, 'view'))

                    <li class="submenu {{ request()->routeIs('expense.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-calendar-check-o"></i> <span>Expense</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('expense.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(33, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('expense.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('expense.index') }}"><i
                                            class="fa fa-stethoscope icons"></i><span style="padding-left: 5px;">All
                                            Expense</span></a>
                                </li>
                            @endif
                            @if (app('hasPermission')(33, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('expense.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('expense.create') }}"><i
                                            class="fa fa-notes-medical icons"></i><span style="padding-left: 5px;">
                                            Add Expense</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif



                {{-- assessment + homeadvice --}}
                @php
                    $hasAssessment = app('hasPermission')(28, 'view') || app('hasPermission')(28, 'create');
                    $hasHomeadvice = app('hasPermission')(29, 'view') || app('hasPermission')(29, 'create');
                @endphp

                @if ($hasAssessment || $hasHomeadvice)
                    <li class="submenu {{ request()->routeIs('assessment.*', 'homeadvice.*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa-solid fa-user-doctor"></i> {{-- Changed icon --}}
                            <span>Assessment</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul
                            style="{{ request()->routeIs('assessment.*', 'homeadvice.*') ? 'display: block;' : 'display: none;' }}">
                            {{-- Assessment --}}
                            @if (app('hasPermission')(28, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('assessment.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('assessment.index') }}">
                                        <i class="fa fa-stethoscope icons"></i>
                                        <span style="padding-left: 5px;">All Assessment</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(28, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('assessment.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('assessment.create') }}">
                                        <i class="fa fa-notes-medical icons"></i>
                                        <span style="padding-left: 5px;">Add Assessment</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Treatment Booking --}}
                            @if (app('hasPermission')(29, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('homeadvice.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('homeadvice.index') }}">
                                        <i class="fa fa-file-medical icons"></i>
                                        <span style="padding-left: 5px;">All Homeadvice</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(29, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('homeadvice.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('homeadvice.create') }}">
                                        <i class="fa fa-plus-circle icons"></i>
                                        <span style="padding-left: 5px;">Add Homeadvice</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


 @if ($currentProjectTypeId !== 3)
                @if (app('hasPermission')(32, 'view'))

                    <li class="submenu {{ request()->routeIs('soap.*') ? 'active' : '' }}">

                        <a href="#"><i class="fas fa-file-medical"></i>
                            <span>SOAP</span><span class="menu-arrow"></span>
                        </a>

                        <ul style="{{ request()->routeIs('soap.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(32, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('soap.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('soap.index') }}">
                                        <i class="fa fa-file-alt icons"></i>
                                        <span style="padding-left: 5px;">All SOAP</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(32, 'create'))
                                <li class="menu-link1 {{ request()->routeIs('soap.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('soap.create') }}">
                                        <i class="fa fa-plus-circle icons"></i>
                                        <span style="padding-left: 5px;">Add SOAP</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


  @endif




 @if ($currentProjectTypeId !== 3)

                @php
                    $hasTherapy26 = app('hasPermission')(26, 'view') || app('hasPermission')(26, 'create');
                    $hasTherapy27 = app('hasPermission')(27, 'view') || app('hasPermission')(27, 'create');
                @endphp

                @if ($hasTherapy26 || $hasTherapy27)
                    <li class="submenu {{ request()->routeIs('therapy.*', 'assign-therapy.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa-solid fa-heart-pulse"></i> <span>Therapy</span><span
                                class="menu-arrow"></span></a>

                        <ul
                            style="{{ request()->routeIs('therapy.*', 'assign-therapy.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(26, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('therapy.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('therapy.index') }}">
                                        <i class="fa-solid fa-dna icons"></i><span style="padding-left: 5px;">All
                                            Therapy</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(26, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('therapy.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('therapy.create') }}">
                                        <i class="fa-solid fa-file-medical icons"></i><span
                                            style="padding-left: 5px;">Add
                                            Therapy</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(27, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('assign-therapy.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('assign-therapy.index') }}">
                                        <i class="fa-solid fa-user-doctor icons"></i><span
                                            style="padding-left: 5px;">All
                                            Assigned Therapies</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(27, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('assign-therapy.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('assign-therapy.create') }}">
                                        <i class="fa-solid fa-notes-medical icons"></i><span
                                            style="padding-left: 5px;">Assign
                                            Therapy</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @php
                    $hasPathology19 = app('hasPermission')(19, 'view') || app('hasPermission')(19, 'create');
                    $hasPathology20 = app('hasPermission')(20, 'view') || app('hasPermission')(20, 'create');
                @endphp

                @if ($hasPathology19 || $hasPathology20)
                    <li
                        class="submenu {{ request()->routeIs('pathology.*', 'pathology_reports.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-user"></i> <span>Pathology</span><span
                                class="menu-arrow"></span></a>

                        <ul
                            style="{{ request()->routeIs('pathology.*', 'pathology_reports.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(19, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('pathology.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('pathology.index') }}">
                                        <i class="fa fa-list icons"></i>
                                        <span style="padding-left: 5px;">All Pathology</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(19, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('pathology.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('pathology.create') }}">
                                        <i class="fa fa-plus-circle icons"></i>
                                        <span style="padding-left: 5px;">Add Pathology</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(20, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('pathology_reports.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('pathology_reports.index') }}">
                                        <i class="fa fa-file-medical-alt icons"></i>
                                        <span style="padding-left: 5px;">All Pathology Report</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(20, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('pathology_reports.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('pathology_reports.create') }}">
                                        <i class="fa fa-file-medical icons"></i>
                                        <span style="padding-left: 5px;">Add Pathology Report</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @php
                    $hasRadiology21 = app('hasPermission')(21, 'view') || app('hasPermission')(21, 'create');
                    $hasRadiology22 = app('hasPermission')(22, 'view') || app('hasPermission')(22, 'create');
                @endphp

                @if ($hasRadiology21 || $hasRadiology22)
                    <li
                        class="submenu {{ request()->routeIs('radiology-tests.*', 'radiology-reports.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-flask"></i> <span>Radiology</span><span
                                class="menu-arrow"></span></a>

                        <ul
                            style="{{ request()->routeIs('radiology-tests.*', 'radiology-reports.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(21, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('radiology-tests.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('radiology-tests.index') }}">
                                        <i class="fa fa-list icons"></i><span style="padding-left: 5px;">Radiology
                                            Tests</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(21, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('radiology-tests.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('radiology-tests.create') }}">
                                        <i class="fa fa-plus-circle icons"></i><span style="padding-left: 5px;">Add
                                            Radiology
                                            Test</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(22, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('radiology-reports.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('radiology-reports.index') }}">
                                        <i class="fa fa-list icons"></i><span style="padding-left: 5px;">Radiology
                                            Reports</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(22, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('radiology-reports.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('radiology-reports.create') }}">
                                        <i class="fa fa-plus-circle icons"></i><span style="padding-left: 5px;">Add
                                            Radiology
                                            Reports</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                  @endif
@if (app('hasPermission')(37, 'view'))

                    <li class="submenu {{ request()->routeIs('dietchart.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-cutlery"></i> <span>Diet Chart</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('dietchart.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(37, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('dietchart.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('dietchart.index') }}"><i class="fa fa-list icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                                    padding-left: 5px;">
                                            All

                                            Diet Chart</span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(37, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('dietchart.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('dietchart.create') }}"><i
                                            class="fa fa-plus-circle icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                                    padding-left: 5px;">
                                            Add
                                            Diet Chart

                                        </span></a>

                                </li>
                            @endif

                        </ul>

                    </li>

                @endif

                 @if ($currentProjectTypeId !== 3)
                @if (app('hasPermission')(25, 'view'))
                    <li class="submenu {{ request()->routeIs('ipd_admit.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-procedures"></i> <span>IPD</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('ipd_admit.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(25, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('ipd_admit.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('ipd_admit.index') }}"><i class="fa fa-list icons"></i><span
                                            style=" padding-left: 5px;">
                                            All IPD</span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(25, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('ipd_admit.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('ipd_admit.create') }}"><i
                                            class="fa fa-clipboard-list icons"></i><span style="padding-left: 5px;">
                                            Add IPD

                                        </span></a>

                                </li>
                            @endif

                        </ul>

                    </li>
                @endif

                @if (app('hasPermission')(23, 'view'))

                    <li class="submenu {{ request()->routeIs('opd_visit.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-stethoscope"></i> <!-- Changed icon -->
                            <span>OPD</span><span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->routeIs('opd_visit.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(23, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('opd_visit.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('opd_visit.index') }}">
                                        <i class="fa fa-file-medical icons"></i> <!-- Changed icon -->
                                        <span style="padding-left: 5px;">All OPD</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(23, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('opd_visit.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('opd_visit.create') }}">
                                        <i class="fa fa-plus-square icons"></i> <!-- Changed icon -->
                                        <span style="padding-left: 5px;">Add OPD</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (app('hasPermission')(8, 'view'))

                    <li class="submenu {{ request()->routeIs('service.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-hospital-o"></i>

                            <span>Diagnostic service</span><span class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('service.*') ? 'display: block;' : 'display: none;' }}">



                            @if (app('hasPermission')(8, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('service.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('service.index') }}"><i class="fa fa-hospital icons"></i><span
                                            style="

                                                                                                                                                                                                                                                            padding-left: 5px;">
                                            All

                                            Diagnostic Service</a></span>

                                </li>
                            @endif

                            @if (app('hasPermission')(8, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('service.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('service.create') }}"><i
                                            class="fa fa-building icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">Add

                                            Diagnostic Service</span> </a>

                                </li>
                            @endif



                        </ul>

                    </li>

                @endif






                <!-- // OT -->

                @if (app('hasPermission')(24, 'view'))
                    <li class="submenu {{ request()->routeIs('ot.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-heartbeat"></i> <!-- Changed icon for OT main -->
                            <span>OT Procedure</span><span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->routeIs('ot.*') ? 'display: block;' : 'display: none;' }}">
                            @if (app('hasPermission')(24, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('ot.index') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('ot.index') }}">
                                        <i class="fa fa-notes-medical icons"></i> <!-- Changed icon for All OT -->
                                        <span style="padding-left: 5px;">All OT Procedure</span>
                                    </a>
                                </li>
                            @endif

                            @if (app('hasPermission')(24, 'create'))
                                <li class="menu-link1 {{ request()->routeIs('ot.create') ? 'active' : '' }} mt-1">
                                    <a href="{{ route('ot.create') }}">
                                        <i class="fa fa-user-md icons"></i> <!-- Changed icon for Add OT -->
                                        <span style="padding-left: 5px;">Add OT Procedure</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

  @endif

                @if (app('hasPermission')(9, 'view'))

                    @if (app('hasPermission')(9, 'create'))
                        <li class="menu-link {{ request()->routeIs('calender.index') ? 'active' : '' }}">

                            <a href="{{ route('calender.index') }}"><i
                                    class="fa fa-calendar"></i><span>Calendar</span></a>

                        </li>
                    @endif

                @endif

                 @if ($currentProjectTypeId !== 3)
                @if (app('hasPermission')(10, 'view'))
                    <li class="submenu {{ request()->routeIs('discharge.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-procedures"></i>

                            <span>Discharge</span><span class="menu-arrow"></span>

                        </a>

                        <ul style="{{ request()->routeIs('discharge.*') ? 'display: block;' : 'display: none;' }}">



                            @if (app('hasPermission')(10, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('discharge.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('discharge.index') }}"><i
                                            class="fa fa-clipboard-list icons"></i><span
                                            style="

                                                                                                                                                                                                                                            padding-left: 5px;">All

                                            Discharges</span> </a>

                                </li>
                            @endif



                            @if (app('hasPermission')(10, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('discharge.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('discharge.create') }}"><i
                                            class="fa fa-file-medical icons"></i><span
                                            style="

                                                                                                                                                                                                                            padding-left: 5px;">
                                            Add

                                            Discharge

                                        </span></a>

                                </li>
                            @endif



                        </ul>

                    </li>
                @endif

                @if (app('hasPermission')(11, 'view'))

                    <li class="submenu {{ request()->routeIs('inventory.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-cogs"></i> <span>Inventory</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('inventory.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(11, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('inventory.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('inventory.index') }}"><i class="fa fa-cogs icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">All

                                            Inventory</span></a>

                                </li>
                            @endif

                            {{-- @if (app('hasPermission')(11, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('inventory.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('inventory.create') }}"><i
                                            class="fa fa-plus-circle icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">Add

                                            Inventory</span></a>

                                </li>
                            @endif --}}

                        </ul>

                    </li>

                @endif

                @if (app('hasPermission')(12, 'view'))

                    <li class="submenu {{ request()->routeIs('supplier.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-truck"></i> <span>Supplier</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('supplier.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(12, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('supplier.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('supplier.index') }}"><i class="fa fa-truck icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                                                padding-left: 10px;">All

                                            Suppliers</span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(12, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('supplier.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('supplier.create') }}"><i
                                            class="fa fa-plus-circle icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">Add

                                            Supplier</span></a>

                                </li>
                            @endif

                        </ul>

                    </li>

                @endif
                  @endif

                @if (app('hasPermission')(13, 'view'))

                    <li class="submenu {{ request()->routeIs('report.*') ? 'active' : '' }}">

                        <a href="#"><i class="fa fa-file-medical"></i> <span>Medical Report</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->routeIs('report.*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(13, 'view'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('medicalreport.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('report.index') }}"><i
                                            class="fa fa-file-medical icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">All

                                            Medical Reports</span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(13, 'create'))
                                <li
                                    class="menu-link1 {{ request()->routeIs('report.create') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('report.create') }}"><i
                                            class="fa fa-plus-circle icons"></i><span
                                            style="

                                                                                                                                                                                                                                                                            padding-left: 5px;">Add

                                            Medical Report</span></a>

                                </li>
                            @endif

                        </ul>

                    </li>

                @endif




   @if ($currentProjectTypeId !== 3)
                @if (app('hasPermission')(18, 'view'))
                    <li class="menu-link {{ request()->routeIs('invoice.index') ? 'active' : '' }}">


                        <a href="{{ route('invoice.index') }}"> <i class="fa fa-file-invoice"></i>
                            <span>Invoice</span></a>

                    </li>
                @endif
  @endif

                @if (app('hasPermission')(14, 'view'))
                    <li class="menu-link {{ request()->routeIs('chart') ? 'active' : '' }}">

                        <a href="{{ route('chart') }}"> <i class="fas fa-chart-line"></i> <span>Report</span></a>

                    </li>
                @endif

                {{-- @if (app('hasPermission')(16, 'view'))
                    <li class="menu-link {{ request()->routeIs('email.index') ? 'active' : '' }}">

                        <a href="{{ route('email.index') }}"> <i class="fas fa-envelope"></i> <span>Email</span></a>

                    </li>
                @endif --}}


                {{-- @if (app('hasPermission')(15, 'view'))

                    <li class="submenu {{ request()->is('sms*') ? 'active' : '' }}">

                        <a href="#"><i class="fas fa-sms"></i> <span>SMS </span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->is('sms*') ? 'display: block;' : 'display: none;' }}">

                            @if (app('hasPermission')(15, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('sms.index') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('sms.index') }}"><i class="fas fa-sms icons"></i><span
                                            style="padding-left: 5px;"> SMS Marketing</span></a>

                                </li>
                            @endif

                            @if (app('hasPermission')(15, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('sms.template') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('sms.template') }}"><i class="fas fa-cogs icons"></i><span
                                            style="padding-left: 5px;"> SMS Settings</span></a>

                                </li>
                            @endif



                        </ul>

                    </li>

                @endif --}}

                {{-- @if (app('hasPermission')(15, 'view'))

                    <li class="submenu {{ request()->is('sms*') ? 'active' : '' }}">

                        <a href="#"><i class="fas fa-cogs icons"></i> <span>Setting</span><span
                                class="menu-arrow"></span></a>

                        <ul style="{{ request()->is('sms*') ? 'display: block;' : 'display: none;' }}">


                            @if (app('hasPermission')(15, 'view'))
                                <li class="menu-link1 {{ request()->routeIs('sms.template') ? 'active' : '' }} mt-1">

                                    <a href="{{ route('sms.template') }}"><i class="fas fa-cogs icons"></i><span
                                            style="padding-left: 5px;">Settings</span></a>

                                </li>
                            @endif



                        </ul>

                    </li>

                @endif   --}}

                @if (app('hasPermission')(36, 'view'))
                    <li class="menu-link {{ request()->routeIs('taxrate.index') ? 'active' : '' }}">
                        <a href="{{ route('taxrate.index') }}">
                            <i class="fa fa-money-bill"></i>
                            <span>Tax Rate</span>
                        </a>
                    </li>
                @endif


                {{-- @if (in_array(auth()->user()->role, ['admin', 'sub-admin'])) --}}
                    {{-- <li><a href="{{ route('plans.planlist') }}"
                            class="{{ request()->routeIs('plans.planlist') ? 'active' : '' }}">Plans</a></li>
                    <li><a href="{{ route('plans.details') }}"
                            class="{{ request()->routeIs('plans.details') ? 'active' : '' }}">Plan Details</a></li> --}}
                {{-- @endif --}}
                {{-- @if (in_array(auth()->user()->role, ['admin', 'sub-admin'])) --}}
                    <li><a href="{{ route('plans.myplan') }}"><i class="fa-solid fa-file-invoice-dollar"></i>My Plan Details</a></li>
                {{-- @endif --}}


                @if (app('hasPermission')(15, 'view'))
                    <li class="menu-link {{ request()->routeIs('sms.template') ? 'active' : '' }}">
                        <a href="{{ route('sms.template') }}">
                            <i class="fas fa-cogs icons"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                @endif







                @php
                    $user = Auth::user();
                    $role = optional($user->role)->name;
                @endphp


                @if ($role !== 'Patient')
                    <li class="menu-link {{ request()->routeIs('knowledge.index') ? 'active' : '' }}">
                        <a href="{{ route('knowledge.index') }}">
                            <i class="fas fa-book"></i> <span>Knowledge Base</span>
                        </a>
                    </li>
                @endif



                <li class="menu-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}"><i class="fa fa-user"></i> <span>My Profile</span></a>
                </li>

                <li class="menu-link ">
                    <a href="#" id="logout-button"><i class="fa fa-sign-out-alt"></i> <span>Logout</span></a>
                </li>

            </ul>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on('click', '#logout-button', function(e) {
        e.preventDefault(); // Prevent default link behavior

        console.log("Logout button clicked"); // Debugging

        $.ajax({
            url: "/api/logout",
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json",
            },
            success: function(response) {
                console.log("Logout successful:", response);

                // Clear storage
                sessionStorage.removeItem('token');
                sessionStorage.clear();

                // Redirect to login page
                window.location.href = "/";
            },
            error: function(xhr) {
                console.error("Logout failed:", xhr.responseText);

                // Force logout
                sessionStorage.removeItem('token');
                sessionStorage.clear();
                window.location.href = "/";
            }
        });
    });
</script>
