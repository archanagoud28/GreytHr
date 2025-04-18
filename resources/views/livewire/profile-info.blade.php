<div class="position-relative">
    <div class="position-absolute" wire:loading
        wire:target="setActiveTab,showPopupModal,closeModel,resetInputFields,applyForResignation">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>

        </div>
    </div>
    @if (session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif

    <div class="row  p-0">
        <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="md-width-prof custom-nav-link {{ $activeTab === 'personalDetails' ? 'active' : '' }}"
                        wire:click="setActiveTab('personalDetails')">Personal</div>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="md-width-prof custom-nav-link {{ $activeTab === 'accountDetails' ? 'active' : '' }}"
                        wire:click="setActiveTab('accountDetails')">Accounts & Statements</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="md-width-prof custom-nav-link {{ $activeTab === 'familyDetails' ? 'active' : '' }}"
                        wire:click="setActiveTab('familyDetails')">Family</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1"
                    style="border-left:1px solid #ccc;border-right:1px solid #ccc;">
                    <a href="#" style="border-radius:none;" class="md-width-prof custom-nav-link {{ $activeTab === 'employeeJobDetails' ? 'active' : '' }}"
                        wire:click="setActiveTab('employeeJobDetails')">Employment & Job</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1">
                    <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;"
                        class="md-width-prof custom-nav-link {{ $activeTab === 'assetsDetails' ? 'active' : '' }}"
                        wire:click="setActiveTab('assetsDetails')">Assets</a>
                </li>
            </ul>
        </div>
        <div>
            @if ($employeeDetails)
            {{-- Personal Tab --}}
            <div class="row p-0 gx-0" id="personalDetails" style=" margin:20px 0px;{{ $activeTab === 'personalDetails' ? 'display: block;' : 'display: none;' }}">
                <div class="col">
                    <div class="row px-4 gx-0 bg-white border rounded mb-3">
                        <div class="prof-container mb-3 d-flex flex-column">
                            <div class="normalTextMainProf mb-3 mt-4">
                                PROFILE
                            </div>
                            <div class="align-prof-dev row">
                                <!-- Profile Image & Location (First Column) -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    @if (session()->has('error'))
                                    <div class="alert alert-danger position-absolute" wire:poll.3s="hideAlert" style="top:-25%;">
                                        {{ session('error') }}
                                    </div>
                                    @endif

                                    @if (
                                    $employeeDetails->image !== null &&
                                    $employeeDetails->image != 'null' &&
                                    $employeeDetails->image != 'Null' &&
                                    $employeeDetails->image != ''
                                    )
                                    <!-- Check if the image is in base64 format -->
                                    @if (strpos($employeeDetails->image, 'data:image/') === 0)
                                    <!-- It's base64 -->
                                    <img src="{{ $employeeDetails->image }}" alt="binary" class="img-thumbnail" />
                                    @else
                                    <!-- It's binary, convert to base64 -->
                                    <img src="data:image/jpeg;base64,{{ $employeeDetails->image }}" alt="base" class="img-thumbnail" />
                                    @endif
                                    @else
                                    <!-- Default images based on gender -->
                                    @if ($employeeDetails->gender == 'MALE')
                                    <div class="employee-profile-image-container mb-2">
                                        <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder" alt="Default Image">
                                    </div>
                                    @elseif($employeeDetails->gender == 'FEMALE')
                                    <div class="employee-profile-image-container mb-2">
                                        <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder" alt="Default Image">
                                    </div>
                                    @else
                                    <div class="employee-profile-image-container mb-2">
                                        <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder" alt="Default Image">
                                    </div>
                                    @endif
                                    @endif
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Location</span>
                                        <div class="prof-sub-heading-value">
                                            @if ($employeeDetails->job_location)
                                            <span class="prof-sub-heading-value">{{ $employeeDetails->job_location }}</span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Name, Employee ID, Emergency Contact (Second Column) -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Name</span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->first_name && $employeeDetails->last_name)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading"> Employee ID</span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->emp_id)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->emp_id }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Primary Contact No.</span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->emergency_contact)
                                            <span class="prof-sub-heading-value"> {{ $employeeDetails->emergency_contact }}</span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Email (Third Column) -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Company E-mail</span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->email)
                                            <span class="prof-sub-heading-value" style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">
                                                {{ $employeeDetails->email }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row px-4 gx-0 bg-white border rounded mb-3">
                        <div class="prof-container mb-3 d-flex flex-column">
                            <div class="normalTextMainProf mb-3 mt-4">
                                PERSONAL
                            </div>
                            <div class="align-prof-dev row">
                                <!-- Blood Group -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Blood Group</span>
                                        <div class="prof-sub-heading-value">
                                            @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->blood_group)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->empPersonalInfo->blood_group }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Marital Status -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Marital Status</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empPersonalInfo)->marital_status)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->marital_status)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Place of Birth -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Place of Birth</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empPersonalInfo)->city)
                                            <span class="prof-sub-heading-value">
                                                {{ optional($employeeDetails->empPersonalInfo)->city }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Religion -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Religion</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empPersonalInfo)->religion)
                                            <span class="prof-sub-heading-value">
                                                {{ optional($employeeDetails->empPersonalInfo)->religion }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Date of Birth</span>
                                        <div class="prof-sub-heading-value">
                                            @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->date_of_birth)
                                            <span class="prof-sub-heading-value">
                                                {{ \Carbon\Carbon::parse($employeeDetails->empPersonalInfo->date_of_birth)->format('d-M-Y') }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Residential Status -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Residential Status</span>
                                        <div class="prof-sub-heading-value">
                                            @if ($employeeDetails->job_location)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->job_location }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Physically Challenged -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Physically Challenged</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empPersonalInfo)->physically_challenge)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->physically_challenge)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Nationality -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Nationality</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empPersonalInfo)->nationality)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower(optional($employeeDetails->empPersonalInfo)->nationality)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Spouse -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Spouse</span>
                                        <div class="prof-sub-heading-value">
                                            @if (optional($employeeDetails->empSpouseDetails)->name)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower(optional($employeeDetails->empSpouseDetails)->name)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Father Name -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">Father Name</span>
                                        <div class="prof-sub-heading-value">
                                            @php
                                            $fatherFirstName = optional($employeeDetails->empParentDetails)->father_first_name;
                                            $fatherLastName = optional($employeeDetails->empParentDetails)->father_last_name;
                                            $combinedName = trim(ucwords(strtolower($fatherFirstName)) . ' ' . ucwords(strtolower($fatherLastName)));
                                            $displayName = $combinedName ? $combinedName : '-';
                                            @endphp
                                            <span class="prof-sub-heading-value">
                                                {{ $displayName }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- International Employee -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">International Employee</span>
                                        <div class="prof-sub-heading-value">
                                            @if ($employeeDetails->inter_emp)
                                            <span class="prof-sub-heading-value">
                                                {{ ucwords(strtolower($employeeDetails->inter_emp)) }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row px-4 gx-0 bg-white border rounded mb-3">
                        <div class="prof-container mb-3 d-flex flex-column">
                            <div class="normalTextMainProf mb-3 mt-4">ADDRESS</div>
                            <div class="align-prof-dev row">
                                <!-- Permanent Address -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">
                                            Permanent Address
                                        </span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->permenant_address)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->empPersonalInfo->permenant_address }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Present Address -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">
                                            Present Address
                                        </span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->present_address)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->empPersonalInfo->present_address }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">
                                            Email
                                        </span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->empPersonalInfo)
                                            @if ($employeeDetails->empPersonalInfo->email)
                                            <span class="prof-sub-heading-value" style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">
                                                {{ $employeeDetails->empPersonalInfo->email }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile -->
                                <div class="col-12 col-sm-6 col-md-4 p-2 profile-columns">
                                    <div class="d-flex flex-column ">
                                        <span class="prof-sub-heading">
                                            Mobile
                                        </span>
                                        <div class="prof-sub-heading">
                                            @if ($employeeDetails->empPersonalInfo && $employeeDetails->empPersonalInfo->mobile_number)
                                            <span class="prof-sub-heading-value">
                                                {{ $employeeDetails->empPersonalInfo->mobile_number }}
                                            </span>
                                            @else
                                            <span class="prof-sub-heading-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-4 gx-0 bg-white border rounded mb-3">
                        <div class="prof-container mb-3 d-flex flex-column">
                            <div class="normalTextMainProf mb-3 mt-4">
                                EDUCATION
                            </div>

                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($qualifications && count($qualifications) > 0)
                                @php $detailIndex = 1; @endphp <!-- Initialize the counter for Education Details -->

                                @foreach ($qualifications as $index => $education)
                                @if (is_array($education) && count($education) > 0)
                                <!-- Show "Education Details" without a number for the first qualification -->
                                @if (count($qualifications) === 1)
                                <div style="margin-bottom: 10px;">
                                    <strong style="font-size: 13px; color: #778899;">Education Details</strong>
                                </div>
                                @elseif (count($qualifications) > 1)
                                <div style="margin-bottom: 10px;">
                                    <strong style="font-size: 13px; color: #778899;">Education Details {{ $detailIndex }}</strong>
                                </div>
                                @endif

                                <div class="row p-0 mb-0">
                                    <div class="col-4 prof-sub-heading" >
                                        Degree
                                    </div>
                                    <div class="col-4 prof-sub-heading" >
                                        Year of Passing
                                    </div>
                                    <div class="col-4 prof-sub-heading" >
                                        Institution
                                    </div>
                                </div>

                                <div class="row p-0 mb-3">
                                    <div class="col-4 prof-sub-heading-value" >
                                        {{ $education['level'] ?? 'N/A' }}
                                    </div>
                                    <div class="col-4 prof-sub-heading-value" >
                                        {{ $education['year_of_passing'] ?? 'N/A' }}
                                    </div>
                                    <div class="col-4 prof-sub-heading-value" >
                                        {{ $education['institution'] ?? 'N/A' }}
                                    </div>
                                </div>

                                @php $detailIndex++; @endphp <!-- Increment the counter for the next qualification -->
                                @endif
                                @endforeach
                                @else
                                <div class="normalTextValue" style="font-size: 12px; color: #778899; margin-left: 15px;">
                                    No Data Found
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Accounts & Statements --}}
            <div class="row p-0 gx-0" style="margin:20px auto; {{ $activeTab === 'accountDetails' ? 'display: block;' : 'display: none;' }}"
                id="accountDetails">
                <div class="col">
                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <div style="margin-top: 2%;margin-left:15px;color:#778899;font-size:12px;font-weight:500;">
                            BANK ACCOUNT</div>
                        <div class="col-6 col-md-4" style="margin-top: 5px;">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Name
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails)
                                {{ $employeeDetails->empBankDetails->bank_name }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif


                            </div>
                            <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                IFSC Code
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->ifsc_code)
                                {{ $employeeDetails->empBankDetails->ifsc_code }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Bank Account Number
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->account_number)
                                {{ $employeeDetails->empBankDetails->account_number }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                            <div style="margin-top:10px;font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Address
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->bank_address)
                                {{ $employeeDetails->empBankDetails->bank_address }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Bank Branch
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empBankDetails && $employeeDetails->empBankDetails->bank_branch)
                                {{ $employeeDetails->empBankDetails->bank_branch }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white;margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                            PF AMOUNT</div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                PF Number
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo)
                                {{ $employeeDetails->empPersonalInfo->pf_no }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                UAN
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->empPersonalInfo)
                                {{ $employeeDetails->empPersonalInfo->uan_no }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                            OTHERS IDS</div>
                        <div class="col-6">
                            <div style="margin-left: 15px; font-size: 12px">
                                ___
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="color: red; margin-left: 15px; font-size: 12px">
                                Unverified
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'familyDetails' ? 'display: block;' : 'display: none;' }}" id="familyDetails">
                <div class="row p-0 gx-0"
                    style="border-radius: 5px;  width: 100%; background-color: white; margin-bottom: 20px;">
                    <!-- Header -->
                    <div
                        style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">
                        FATHER
                        DETAILS</div>
                    <div class="row p-3 gx-0">
                        <div class="col-12 col-md-3">

                            @if ($employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image !== null && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != 'null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != 'Null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->father_image) &&
                            optional($employeeDetails->empParentDetails)->father_image != '')
                            <!-- It's binary, convert to base64 -->
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="data:image/jpeg;base64,{{ (optional($employeeDetails->empParentDetails)->father_image) }}" alt="base" />
                            @else
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="{{ asset('images/male-default.png') }}"
                                alt="Default Male Image">
                            @endif

                        </div>
                        <div class="col-6 col-md-3">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Father Name</div>
                            <div style="font-size: 12px">
                                @php
                                $fatherFirstName = optional($employeeDetails->empParentDetails)
                                ->father_first_name;
                                $fatherLastName = optional($employeeDetails->empParentDetails)
                                ->father_last_name;
                                $combinedName = trim(
                                ucwords(strtolower($fatherFirstName)) .
                                ' ' .
                                ucwords(strtolower($fatherLastName)),
                                );
                                $displayName = $combinedName ?: '-';
                                @endphp
                                @if ($displayName === '-')
                                <div class="prof-sub-heading-value">{{ $displayName }}</div>
                                @else
                                {{ $displayName }}
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Address</div>
                            <div style="font-size: 12px; width: 250px">
                                @php
                                $fatherAddress = optional($employeeDetails->empParentDetails)->father_address;
                                $fatherCity = optional($employeeDetails->empParentDetails)->father_city;
                                $fatherState = optional($employeeDetails->empParentDetails)->father_state;
                                $fatherCountry = optional($employeeDetails->empParentDetails)->father_country;
                                $combined = trim(
                                "{$fatherAddress}, {$fatherCity}, {$fatherState}, {$fatherCountry}",
                                ', ',
                                );
                                $displayValue = $combined ?: '-';
                                $hasPadding = $displayValue === '-' ? 'padding-left: 23px;' : '';
                                @endphp
                                <span style="{{ $hasPadding }}">{{ $displayValue }}</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_dob)
                                {{ \Carbon\Carbon::parse(optional($employeeDetails->empParentDetails)->father_dob)->format('d-M-Y') }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_nationality)
                                {{ optional($employeeDetails->empParentDetails)->father_nationality }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_blood_group)
                                {{ optional($employeeDetails->empParentDetails)->father_blood_group }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->father_occupation)
                                {{ optional($employeeDetails->empParentDetails)->father_occupation }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                            <div style="font-size: 12px; word-wrap: break-word;">
                                @if (optional($employeeDetails->empParentDetails)->father_religion)
                                {{ optional($employeeDetails->empParentDetails)->father_religion }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Father Email</div>
                            <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                @if (optional($employeeDetails->empParentDetails)->father_email)
                                {{ optional($employeeDetails->empParentDetails)->father_email }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-0 gx-0"
                    style="border-radius: 5px; width: 100%; background-color: white; margin-bottom: 20px;">
                    <!-- Header -->
                    <div
                        style="margin-top: 2%; margin-left: 17px; font-size: 12px; font-weight: 500;color:#778899;">
                        MOTHER
                        DETAILS</div>
                    <div class="row p-3 gx-0">
                        <div class="col-12 col-md-3">
                            @if ( $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image !== null && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != 'null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != 'Null' && $employeeDetails->empParentDetails &&
                            !empty(optional($employeeDetails->empParentDetails)->mother_image) &&
                            optional($employeeDetails->empParentDetails)->mother_image != '')
                            <!-- It's binary, convert to base64 -->
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="data:image/jpeg;base64,{{ (optional($employeeDetails->empParentDetails)->mother_image) }}" alt="base" />

                            @else
                            <img style="border-radius: 5px; margin-left: 43px; margin-top: 10px;"
                                height="100" width="100" src="{{ asset('images/female-default.jpg') }}"
                                alt="Default Female Image">
                            @endif

                        </div>
                        <div class="col-6 col-md-3">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Mother Name</div>
                            <div style="font-size: 12px">
                                @php
                                $motherFirstName = optional($employeeDetails->empParentDetails)
                                ->mother_first_name;
                                $motherLastName = optional($employeeDetails->empParentDetails)
                                ->mother_last_name;
                                $combinedName = trim(
                                ucwords(strtolower($motherFirstName)) .
                                ' ' .
                                ucwords(strtolower($motherLastName)),
                                );
                                $displayName = $combinedName ?: '-';
                                $paddingLeft = $displayName === '-' ? '39px' : '0px';
                                @endphp

                                <span class="prof-sub-heading-value">
                                    {{ $displayName }}
                                </span>
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Address</div>
                            <div style="font-size: 12px; width: 250px">
                                @php
                                $motherAddress = optional($employeeDetails->empParentDetails)->mother_address;
                                $motherCity = optional($employeeDetails->empParentDetails)->mother_city;
                                $motherState = optional($employeeDetails->empParentDetails)->mother_state;
                                $motherCountry = optional($employeeDetails->empParentDetails)->mother_country;
                                $combined = trim(
                                "{$motherAddress}, {$motherCity}, {$motherState}, {$motherCountry}",
                                ', ',
                                );
                                $displayValue = $combined ?: '-';
                                $paddingLeft = $displayValue === '-' ? '24px' : '0px';
                                @endphp

                                <span class="prof-sub-heading-value">
                                    {{ $displayValue }}
                                </span>
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Date of Birth</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_dob)
                                {{ \Carbon\Carbon::parse(optional($employeeDetails->empParentDetails)->mother_dob)->format('d-M-Y') }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Nationality</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_nationality)
                                {{ optional($employeeDetails->empParentDetails)->mother_nationality }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Blood Group</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_blood_group)
                                {{ optional($employeeDetails->empParentDetails)->mother_blood_group }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Occupation</div>
                            <div style="font-size: 12px">
                                @if (optional($employeeDetails->empParentDetails)->mother_occupation)
                                {{ optional($employeeDetails->empParentDetails)->mother_occupation }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Religion</div>
                            <div style="font-size: 12px; word-wrap: break-word;">
                                @if (optional($employeeDetails->empParentDetails)->mother_religion)
                                {{ optional($employeeDetails->empParentDetails)->mother_religion }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                            <div style="font-size: 12px; margin-top: 20px; color: #778899;">Mother Email</div>
                            <div style="font-size: 12px; word-wrap: break-word; white-space: normal;">
                                @if (optional($employeeDetails->empParentDetails)->mother_email)
                                {{ optional($employeeDetails->empParentDetails)->mother_email }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Employment & Job --}}
            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'employeeJobDetails' ? 'display: block;' : 'display: none;' }}"
                id="employeeJobDetails">
                <div class="col">
                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                        <div class="row mt-2 p-0 gx-0">
                            <div class="col-6 col-md-6">
                                <div
                                    style="margin-top: 2%;margin-left:15px;font-size:12px;font-weight:500;color:#778899; margin-bottom: 10px;">
                                    CURRENT POSITION </div>
                            </div>
                            <div class="col-6 col-md-6">
                                @if ($isResigned == '')
                                <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                    wire:click="showPopupModal">
                                    Resign
                                </div>
                                @elseif($isResigned == 'Pending')
                                <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                    wire:click="showPopupModal">
                                    Edit Resignation
                                </div>
                                @else
                                <div class="anchorTagDetails" style="margin-top: 2%; margin-left: 25px"
                                    wire:click="showPopupModal">
                                    View Resignation
                                </div>
                                @endif
                            </div>
                        </div>
                        @php
                        // Fetch the manager details directly in Blade
                        $manager = \App\Models\EmployeeDetails::where(
                        'emp_id',
                        $employeeDetails->manager_id,
                        )->first();
                        @endphp

                        <div class="col-6 col-md-3">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Cost Center
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;margin-bottom: 20px;">
                                @if ($employeeDetails->emp_domain)
                                @php
                                $domains = json_decode($employeeDetails->emp_domain);
                                @endphp

                                @if (is_array($domains) && count($domains) > 0)
                                {{ implode(', ', $domains) }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Reporting To
                            </div>
                            <div style="margin-left: 15px; font-size: 12px; margin-bottom: 20px;">
                                @if ($manager)
                                {{ ucwords(strtolower($manager->first_name)) }}
                                {{ ucwords(strtolower($manager->last_name)) }}
                                @else
                                No Manager Assigned
                                @endif
                            </div>
                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Job Mode
                            </div>
                            <div style="margin-left: 15px; font-size: 12px; margin-bottom: 10px;">
                                @if ($employeeDetails)
                                {{ ucwords(strtolower($employeeDetails->job_mode)) }}
                                @else
                                NA
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            @php
                            // Fetch the department name directly in Blade
                            $department = \App\Models\EmpDepartment::where(
                            'dept_id',
                            $employeeDetails->dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Department
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;margin-bottom: 20px;">
                                @if ($department)
                                {{ $department->department }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                            @php
                            // Fetch the department name directly in Blade
                            $subDepartment = \App\Models\EmpSubDepartments::where(
                            'sub_dept_id',
                            $employeeDetails->sub_dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Division
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($subDepartment)
                                {{ ucwords(strtolower($subDepartment->sub_department)) }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            @php
                            // Fetch the department name directly in Blade
                            $subDepartment = \App\Models\EmpSubDepartments::where(
                            'sub_dept_id',
                            $employeeDetails->sub_dept_id,
                            )->first();
                            @endphp

                            <div style="font-size: 11px; color: #778899; margin-left: 15px;">
                                Sub Department
                            </div>
                            <div style="margin-left: 15px; font-size: 12px;">
                                @if ($subDepartment)
                                {{ ucwords(strtolower($subDepartment->sub_department)) }}
                                @else
                                No Department Assigned
                                @endif
                            </div>
                        </div>
                        <div class="col-6  col-md-3">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Designation
                            </div>
                            @php
                            $jobTitle = $employeeDetails->job_role;
                            $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                            $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                            $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                            @endphp
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($convertedTitle)
                                {{ $convertedTitle }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                Location
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->job_location)
                                {{ $employeeDetails->job_location }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>

                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                Date of Join
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if ($employeeDetails->hire_date)
                                {{ \Carbon\Carbon::parse($employeeDetails->hire_date)->format('d M, Y') }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- modal -->
            @if ($showModal)
            <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            @if($isResigned == 'Pending')
                            <h6 class="modal-title">Edit Resignation</h6>
                            @elseif($isResigned == '')
                            <h6 class="modal-title">Apply For Resignation</h6>
                            @else
                            <h6 class="modal-title">Resignation Details</h6>
                            @endif
                            <button type="button" wire:click='closeModel' class="btn-close"
                                data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            </button>
                        </div>
                        @if($isResigned != 'Approved')
                        <form wire:submit.prevent="applyForResignation">
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label for="resignation_date">Resignation Date<span
                                            class="text-danger onboard-Valid">*</span></label>
                                    <input type="date" class="form-control placeholder-small"
                                        wire:model="resignation_date"
                                        wire:change="validateFields('resignation_date')" id="resignation_date"
                                        name="resignation_date">
                                    <!-- name="resignation_date" min="<?php echo date('Y-m-d'); ?>"> -->
                                    @error('resignation_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="reason">Reason<span
                                            class="text-danger onboard-Valid">*</span></label>
                                    <input type="text" placeholder="Enter reason" wire:keydown="validateFields('reason')"
                                        wire:model="reason" class="form-control placeholder-small"
                                        id="reason" name="reason">
                                    @error('reason')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label for="">Files</label> <br>
                                    <input type="file" class="form-control-file"
                                        wire:change="validateFields('signature')" wire:model="signature"
                                        id="signature" name="signature" style="font-size:12px;display:none;">
                                    <label for="signature">
                                        <img style="cursor: pointer;" width="20"
                                            src="{{ asset('images/attachments.png') }}" alt="">
                                    </label>
                                    @if($fileName!=null)
                                    <label for="">{{ $fileName }}</label>
                                    @endif
                                    <br>
                                    @error('signature')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                @if($isResigned=='')
                                <button type="submit" class="submit-btn">Submit</button>

                                <button type="button" class="cancel-btn" wire:click="resetInputFields"
                                    style="border:1px solid rgb(2,17,79);">Clear</button>
                                @else
                                <button type="submit" class="submit-btn">Update</button>
                                <button type="button" wire:click="withdrawResignation" class="submit-btn">Withdraw</button>
                                @endif
                            </div>
                        </form>
                        @else
                        <div>
                            <div class="row d-flex justify-content-center align-items-center mb-4">
                                <div class="col-md-5   form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <!-- <label for="">Resignation Date: </label> -->
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Resignation Date:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{ \Carbon\Carbon::parse($resignation_date)->format('d-M-Y') }}

                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Last Working Date:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{ \Carbon\Carbon::parse($last_working_date)->format('d-M-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Resignation Status:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{$isResigned}}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Approved On:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{ \Carbon\Carbon::parse($approvedOn)->format('d-M-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-5  form-group mt-2" style="display: flex;flex-direction:column;justify-content:center">
                                    <div class="d-flex justify-content-center" style="font-size: 11px; color: #778899; ">
                                        Reason:
                                    </div>
                                    <div class="d-flex justify-content-center" style=" font-size: 12px;color:#000;">
                                        {{$reason}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            @endif
            {{-- Assets --}}

            <div class="row p-0 gx-0" style="margin:20px auto;border-radius: 5px; {{ $activeTab === 'assetsDetails' ? 'display: block;' : 'display: none;' }}"
                id="assetsDetails">
                <div class="col">
                    <div class="row p-3 gx-0"
                        style="border-radius: 5px;width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;font-size:13px;font-weight:500;color:#778899;margin-bottom: 10px;">
                            ACESS CARD DETAILS</div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Card No
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                @if (optional($employeeDetails->empPersonalInfo)->adhar_no)
                                {{ optional($employeeDetails->empPersonalInfo)->adhar_no }}
                                @else
                                <span class="prof-sub-heading-value">-</span>
                                @endif

                            </div>
                            <div style="margin-top: 20px; font-size: 11px; color: #778899; margin-left: 15px">
                                PREVIOUS
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                No Data Found
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 11px; color: #778899; margin-left: 15px">
                                Validity
                            </div>
                            <div style="margin-left: 15px; font-size: 12px">
                                ____
                            </div>
                        </div>
                    </div>

                    <div class="row p-3 gx-0"
                        style="border-radius: 5px; height: 100px; width: 100%; background-color: white; margin-bottom: 20px;">
                        <div
                            style="margin-top: 2%;margin-left:15px;color:#778899;font-size:13px;font-weight:500;margin-bottom: 10px;">
                            ASSETS</div>
                        <div class="col">
                            <div style="font-size: 12px; color: black; margin-left: 15px">
                                No Data Found
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div
                    class="mt-4 d-flex flex-column justify-content-center align-items-center m-auto bg-white people-nodata-container">
                    <div class="d-flex flex-column align-items-center">
                        <img class="people-nodata-img" src="{{ asset('images/nodata.png') }}" alt=""
                            height="300" width="200">
                    </div>
                </div>
            </div>


            @endif

        </div>


        <script>
            function toggleAccordion(element) {
                const accordionBody = element.nextElementSibling;
                const arrowIcon = element.querySelector('.fa'); // Select the arrow icon

                if (accordionBody.style.display === 'block') {
                    accordionBody.style.display = 'none';
                    element.classList.remove('active'); // Remove active class
                    arrowIcon.classList.remove('rotate'); // Remove rotation class
                } else {
                    accordionBody.style.display = 'block';
                    element.classList.add('active'); // Add active class
                    arrowIcon.classList.add('rotate'); // Add rotation class
                }
            }
        </script>