<div class="m-0 px-4" style="position: relative;">
    <a type="button" class="submit-btn" href="{{ route('home') }}" style="text-decoration:none;">Go Back</a>
    <div class="toggle-container position-relative">
        <style>
            /* Define your custom CSS classes */
            .custom-nav-tabs {
                background-color: #fff;
                border-radius: 5px;
                display: flex;
                font-weight: 500;
                text-align: center;
                color: #778899;
                width: 50%;
                font-size: 0.825rem;
            }

            .custom-nav-link {
                color: #ccc;
                /* Text color for inactive tabs */
            }

            .custom-nav-link.active {
                margin-top: 5px;
                color: white !important;
                background-color: rgb(2, 17, 79);
                border-radius: 5px;
            }

            .applyingFor {
                color: #333;
                font-size: 14px;
                font-weight: 500;
                text-align: start;
            }

            .restrictedHoliday {
                color: #778899;
                font-size: 12px;
                font-weight: normal;
                text-align: center;
            }

            .containerWidth {
                width: 85%;
                margin: 0 auto;
            }

            .imgContainer {
                width: 40%;
                margin: 0 auto;
            }

            .verticalLine {
                width: 100%;
                height: 1px;
                border-bottom: 1px solid #ccc;
                margin-bottom: 10px;
            }

            .headerText {
                color: #778899;
                font-size: 12px;
                font-weight: 500;
            }

            .paragraphContent {
                color: #333;
                font-size: 12px;
                font-weight: 500;
            }

            .viewDetails {
                color: rgb(2, 17, 53);
                font-size: 12px;
                font-weight: 500;
            }
        </style>
        <!-- leave-page.blade.php -->

        @if(session()->has('message'))
        <div class="alert alert-success w-50 position-absolute m-auto" style="right:25%;font-size:14px;">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger" style="font-size:12px;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="nav-buttons d-flex justify-content-center mx-2 p-0">
            <ul class="nav custom-nav-tabs">
                <li class="nav-item flex-grow-1">
                    <a href="#" class="nav-link custom-nav-link {{ $activeSection === 'applyButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('applyButton')">Apply</a>
                </li>
                <li class="nav-item flex-grow-1">
                    <a href="#" class="nav-link custom-nav-link {{ $activeSection === 'pendingButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('pendingButton')">Pending</a>
                </li>
                <li class="nav-item flex-grow-1">
                    <a href="#" class="nav-link custom-nav-link {{ $activeSection === 'historyButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('historyButton')">History</a>
                </li>
            </ul>
        </div>


        {{-- Apply Tab --}}
        <div class="row m-0 p-0" style="{{ $activeSection === 'applyButton' ? '' : 'display:none;' }}">
            <!-- Side Container with Sections -->
            <div class="containerWidth">
                <div id="cardElement" class="side">
                    <div>
                        <a href="#" class="side-nav-link {{ ($activeSection === 'applyButton' && $showLeaveApply) ? 'active' : '' }}" wire:click.prevent="toggleSideSection('leave')">Leave</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link {{ ($activeSection === 'applyButton' && $showRestricted) ? 'active' : '' }}" wire:click.prevent="toggleSideSection('restricted')">Restricted Holiday</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link {{ ($activeSection === 'applyButton' && $showLeaveCancel) ? 'active' : '' }}" wire:click.prevent="toggleSideSection('leaveCancel')">Leave Cancel</a>
                    </div>
                    <div class="line"></div>
                    <div>
                        <a href="#" class="side-nav-link {{ ($activeSection === 'applyButton' && $showCompOff) ? 'active' : '' }}" wire:click.prevent="toggleSideSection('compOff')">Comp Off Grant</a>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div id="leave" class="row mt-2 align-items-center " style="{{ $showLeave ? '' : 'display:none;' }}">

                <div class="containerWidth">@livewire('leave-apply') </div>

            </div>

            <div id="restricted" class="row mt-2 w-85 align-items-center" style="{{ $showRestricted ? '' : 'display:none;' }}">
                <div class="containerWidth">
                    <div class="leave-pending rounded">
                        @if($resShowinfoMessage)
                        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                            <p class="mb-0" style="font-size:10px;">Restricted Holidays (RH) are a set of holidays allocated by the
                                company that are optional for the employee to utilize. The company sets a limit on the
                                amount of holidays that can be used.</p>
                            <p class="mb-0 hideInfo" wire:click="toggleInfoRes">Hide</p>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <p class="applyingFor">Applying for
                                Restricted Holiday</p>
                            @if($resShowinfoButton)
                            <p class="info-paragraph" wire:click="toggleInfoRes">Info</p>
                            @endif
                        </div>
                        <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">
                        <p class="restrictedHoliday">You have no
                            Restricted Holiday balance, as per our record.</p>
                    </div>
                </div>
            </div>

            <div id="leaveCancel" class="row w-85 mt-2 align-items-center" style="{{ $showLeaveCancel ? '' : 'display:none;' }}">
                <div class="containerWidth"> @livewire('leave-cancel') </div>
            </div>

            <div id="compOff" class="row w-85 mt-2 align-items-center" style="{{ $showCompOff ? '' : 'display:none;' }}">
                <div class="containerWidth">
                    <div>
                        <div class="leave-pending rounded">
                            @if($compOffShowinfoMessage)
                            <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                                <p class="mb-0" style="font-size:11px;">Compensatory Off is additional leave granted as a compensation for working overtime or on
                                    an off day.</p>
                                <p class="mb-0 hideInfo" wire:click="toggleInfoCompOff">Hide</p>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between">
                                <p class="applyingFor">Applying for Comp.
                                    Off Grant</p>
                                @if($compOffShowinfoButton)
                                <p class="info-paragraph" wire:click="toggleInfoCompOff">Info</p>
                                @endif
                            </div>
                            <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">
                            <p class="restrictedHoliday">You are not
                                eligible to request for compensatory off grant. Please contact your HR for further
                                information.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- endcontent -->
            @if($showLeaveApply)
            <div class="containerWidth">@livewire('leave-apply')</div>
            @endif
        </div>

        {{-- pending --}}
        <div id="pendingButton" class="row rounded mt-4" style="{{ $activeSection === 'pendingButton' ? '' : 'display:none;' }}">

            @if($this->leavePending->isNotEmpty())

            @foreach($this->leavePending as $leaveRequest)

            <div class="container-pending mt-4 containerWidth">

                <div class="accordion rounded">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title px-2 py-3 rounded">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">Category</span>

                                <span class="accordionContentSpanValue">Leave</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">Leave Type</span>

                                <span class="accordionContentSpanValue">{{ $leaveRequest->leave_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="accordionContentSpan">No. of Days</span>

                                <span class="accordionContentSpanValue">

                                    {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}

                                </span>

                            </div>


                            <!-- Add other details based on your leave request structure -->

                            <div class="col accordion-content">

                                <span class="accordionContentSpanValue" style="color:#cf9b17 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                            </div>

                            <div class="arrow-btn">
                                <i class="fa fa-angle-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div class="content px-2">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Duration:</span>

                            <span style="font-size: 11px;">

                                <span style="font-size: 11px; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y') }} </span>

                                ( {{ $leaveRequest->from_session }} )to

                                <span style="font-size: 11px; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y') }}</span>

                                ( {{ $leaveRequest->to_session }} )

                            </span>

                        </div>

                        <div class="content px-2">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Reason:</span>

                            <span style="font-size: 11px;">{{ ucfirst( $leaveRequest->reason) }}</span>

                        </div>

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div style="display:flex; flex-direction:row; justify-content:space-between;">

                            <div class="content px-2">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                                <span style="color: #333; font-size:12px; font-weight: 500;">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                            </div>

                            <div class="content px-2">

                                <a href="{{ route('leave-history', ['leaveRequestId' => $leaveRequest->id]) }}">

                                    <span style="color: rgb(2,17,53); font-size: 12px; font-weight: 500;">View
                                        Details</span>

                                </a>
                                <button class="withdraw mb-2" wire:click="cancelLeave({{ $leaveRequest->id }})">Withdraw</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

            @else
            <div class="containerWidth">
                <div class="leave-pending rounded">

                    <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no pending records of any leave
                        transaction</p>

                </div>
            </div>



            @endif

        </div>



        {{-- history --}}

        <div id="historyButton" class="row rounded mt-4" style="{{ $activeSection === 'historyButton' ? '' : 'display:none;' }}">
            @if($this->leaveRequests->isNotEmpty())

            @foreach($this->leaveRequests->whereIn('status', ['approved', 'rejected','Withdrawn']) as $leaveRequest)

            <div class="container mt-4" style="width:85%; margin:0 auto;">

                <div class="accordion rounded ">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title px-2 py-3">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">Category</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">Leave</span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">Leave Type</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">{{ $leaveRequest->leave_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size:12px; font-weight: 500;">No. of Days</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">

                                    {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}

                                </span>

                            </div>



                            <!-- Add other details based on your leave request structure -->



                            <div class="col accordion-content">

                                @if(strtoupper($leaveRequest->status) == 'APPROVED')

                                <span class="accordionContentSpanValue" style="color:#32CD32 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                                <span class="accordionContentSpanValue" style="color:#FF0000 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @else

                                <span class="accordionContentSpanValue" style="color:#778899 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @endif

                            </div>

                            <div class="arrow-btn">
                                <i class="fa fa-angle-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div class="verticalLine"></div>

                        <div class="content px-2">

                            <span class="headerText">Duration:</span>

                            <span style="font-size: 11px;">

                                <span style="font-size: 11px; font-weight: 500;">{{ $leaveRequest->formatted_from_date }}</span>

                                ({{ $leaveRequest->from_session }} ) to

                                <span style="font-size: 11px; font-weight: 500;">{{ $leaveRequest->formatted_to_date }}</span>

                                ( {{ $leaveRequest->to_session }} )

                            </span>

                        </div>

                        <div class="content px-2">

                            <span class="headerText">Reason:</span>

                            <span style="font-size: 11px;">{{ ucfirst($leaveRequest->reason) }}</span>

                        </div>

                        <div class="verticalLine"></div>

                        <div class="d-flex flex-row justify-content-between">

                            <div class="content px-2 mb-2">

                                <span class="headerText">Applied on:</span>

                                <span class="paragraphContent">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                            </div>

                            <div class="content px-2 mb-2">

                                <a href="{{ route('leave-pending', ['leaveRequestId' => $leaveRequest->id]) }}">
                                    <span class="viewDetails">View
                                        Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            @endforeach

            @else

            <div class="containerWidth">
                <div class="leave-pending rounded">

                    <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no history records of any leave
                        transaction</p>

                </div>
            </div>

            @endif

        </div>

    </div>
</div>



<script>
    function toggleAccordion(element) {
        const accordionBody = element.nextElementSibling;
        if (accordionBody.style.display === 'block') {
            accordionBody.style.display = 'none';
            element.classList.remove('active'); // Remove active class
        } else {
            accordionBody.style.display = 'block';
            element.classList.add('active'); // Add active class
        }
    }
</script>