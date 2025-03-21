<div>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            overflow-y: hidden;
            right: -255px;
            height: 100%;
            width: 245px;
            /* Adjust width as needed */
            background-color: #fff;
            /* Adjust background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Optional box shadow */
            /* Add vertical scrollbar if needed */
            z-index: 1000;
            /* Adjust z-index */
            /* Add any other styles you need */
        }

        /* Adjust the close button position if needed */
        #closeSidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .sidebar .sidebar-header {
            background-color: #e9edf1;
            padding: 10px;
            text-align: center;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ove {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #e2b7ff;
            margin-right: 5px;
        }

        .down-arrow-ign {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid;
            margin-right: 5px;
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
        }

        .down-arrow-afd {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #7dd4ff;
            margin-right: 5px;
        }

        .down-arrow-ded {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ff9595;
            margin-right: 5px;
        }

        .sidebar .sidebar-header h2 {
            color: #7f8fa4;
            font-size: 24px;
            margin: 0;
        }

        .sidebar-content h3 {
            color: #7f8fa4;
            margin-left: 30px;
        }

        .sidebar-content p {
            color: #7f8fa4;
            font-size: 12px;
            margin-left: 30px;
        }

        .search-bar {
            display: flex;
            padding: 0;
            justify-content: start;
            width: 250px;
            /* Adjust width as needed */
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .holidayIcon {
            background-color: #f7f7f7;
        }

        .custom-button {
            padding: 2px;
            margin-bottom: 15px;
            background-color: #3eb0f7;
            color: #fff;
            width: 100px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Styling for the input */
        .search-bar input[type="search"] {
            flex: 1;
            padding: 5px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }

        /* Styling for the search icon */
        .search-bar::after {
            content: "\f002";
            /* Unicode for the search icon (font-awesome) */
            font-family: FontAwesome;
            /* Use an icon font library like FontAwesome */
            font-size: 16px;
            padding: 5px;
            color: #999;
            /* Icon color */
            cursor: pointer;
        }

        .presentIcon {
            border: 1px solid #6c757d;
        }

        .absentIcon {
            border: 1px solid #6c757d;
        }

        .offIcon {
            border: 1px solid #6c757d;
        }

        .restIcon {
            border: 1px solid #6c757d;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ffe8de;
            margin-left: -5px;
        }

        /* Styling for the search icon (optional) */
        .search-bar input[type="search"]::placeholder {
            color: #999;
            /* Placeholder color */
        }

        .search-bar input[type="search"]::-webkit-search-cancel-button {
            display: none;
            /* Hide cancel button on Chrome */
        }

        .summary {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
        }

        .Attendance {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
            max-width: 100%;
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: #dce0e5;
        }

        /* For Webkit-based browsers (Chrome, Safari, Edge) */
        .Attendance::-webkit-scrollbar {
            width: 2px;
            /* Width of the scrollbar */
            height: 8px;
        }

        /* Track (the area where the scrollbar sits) */
        .Attendance::-webkit-scrollbar-track {
            background: #fff;
            /* Background color of the track */
        }

        /* Handle (the draggable part of the scrollbar) */
        .Attendance::-webkit-scrollbar-thumb {
            background: #dce0e5;
            /* Color of the scrollbar handle */
            border-radius: 2px;
            /* Border radius of the handle */
        }

        /* Handle on hover */
        .Attendance::-webkit-scrollbar-thumb:hover {
            background: #dce0e5;
            /* Color of the scrollbar handle on hover */
        }

        .Attendance th,
        .Attendance td {
            width: auto;
            white-space: nowrap;
            /* Prevent content from wrapping */
        }

        .table {
            background: #fff;
            margin: 0;
        }

        td {
            font-size: 0.795rem;
        }

        .table tbody td {
            border-right: 1px solid #d5d5d5;
        }
        .table tbody tr {
            height: 70px;
        }

        .Attendance table tbody td {
            border-bottom: 4px solid rgba(52, 213, 157, 0.849);

            /* Vertical border color and width */
        }

        /* Remove right border for the last cell in each row to avoid extra border */
        .summary .table tbody tr td:last-child {
            border-right: none;
            background: #f2f2f2;
        }

        .Attendance .table tbody tr td:last-child {
            border-right: none;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-top: -5px;
            /* Adjust as needed for spacing */
        }


        .panel {
            display: none;
            background-color: white;
            overflow: hidden;
            border: 1px solid #cecece;
            font-size: 14px;
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
            color: #778899;
            font-size: 12px;
        }

        .presentIcon {
            background-color: #edfaed;
        }

        .absentIcon {
            background-color: #fcf0f0;
            color: #ff6666;
        }

        .offDayIcon {
            background-color: #f7f7f7;
        }

        .leaveIcon {
            background-color: #fcf2ff;
        }

        .onDutyIcon {
            background-color: #fff7eb;
        }
        .search-bar input[type="text"] {
    font-size: 12px; /* Adjust the font size as needed */
    color: #555; /* Change to your desired text color */
  /* Optional: Add border radius for rounded corners */
}

        .holidayIcon {
            background-color: #f2feff;
        }

        .alertForDeIcon {
            background-color: #edf3ff;
        }

        .deductionIcon {
            background-color: #fcd2ca;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ign-attendance-info {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #677a8e;
            margin-right: 5px;
        }
        .dropdown-for-shift-roster-download-and-dropdown
        {
            font-size: 12px;
            height:30px;
            margin-top:10px;
        }

        .emptyday {
            color: #aeadad;
            pointer-events: none;
        }
        @media screen and (max-height: 320px) {
    .shift-roster-download-and-dropdown{
      margin-top:35px;
    }
}
@media screen and (max-height: 320px){
    .dropdown-for-shift-roster-download-and-dropdown
    {
        font-size: 10px;
    }
}
    </style>
    @php

    $currentMonth=$monthNumber = DateTime::createFromFormat('F', $Month)->format('n');
    $currentYear = now()->year;
    $isHoliday=0;
    $leaveTake=0;
    $leaveType=null;
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    @endphp
    @for ($i = 1; $i <= $daysInMonth; $i++) @php $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); $dayName=date('D', $timestamp); $fullDate=date('Y-m-d', $timestamp); @endphp @endfor <div class="row m-0">
        <div class="col-md-8">
            <div class="search-bar">
                <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
            </div>


        </div>

        <div class="shift-roster-download-and-dropdown col-md-4 d-flex justify-content-end"style="float:right;">
            <button class="submit-btn py-0" wire:click="downloadExcel"style="margin:11px;">
                <i class="fa fa-download" aria-hidden="true"></i>
            </button>
                 <select class="dropdown-for-shift-roster-download-and-dropdown bg-white rounded border" 
                       style="width:50%;" name="year" 
                       wire:model="selectedMonth" 
                       wire:change="updateselectedMonth">
                         <!-- For Previous Year (2023) -->
                         <option value="{{ $previousMonth }}">{{ $previousMonth }} {{ $currentYear }}</option>
                         <option value="{{ $currentMonthForDropdown }}">{{ $currentMonthForDropdown }} {{ $currentYear }}</option>
                         <option value="{{ $nextMonth }}">{{ $nextMonth }} {{ $currentYear }}</option>

    
                 </select>
        </div>

</div>
<div class="m-0 mt-5 row" style="margin-top: 20px;">
    <div class="summary col-md-3">
        <p style="background:#ebf5ff;padding:5px 15px;font-size:0.755rem;">Summary</p>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:75%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.825rem;">
                        Employee Name</th>
                    <th style="width:25%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.8255rem;text-transform:uppercase;">
                        Reg</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Summary -->


                @foreach ($Employees as $emp)



                @if(($Employees))
                <tr>
                    <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"data-toggle="tooltip" data-placement="top"
                    title="{{ ucwords(strtolower($emp->first_name)) }} {{ ucwords(strtolower($emp->last_name)) }}({{ $emp->emp_id }})">
                        {{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}<span class="text-muted">(#{{$emp->emp_id}})</span><br /><span class="text-muted" style="font-size:11px;">{{ucwords(strtolower($emp->job_role))}}
                            @if(!empty($emp->job_location))
                            <span>, {{ucwords(strtolower($emp->job_location))}}</span>
                            @endif
                        </span>
                    </td>




                    @php
                    $dateCount=0;
                    @endphp
                    @for ($i = 1; $i <= $daysInMonth; $i++) 
                          @php 
                             $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); 
                             $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon) 
                             $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format 
                          @endphp 
                          @if($dayName==='Sat' || $dayName==='Sun' ) 
                                @php 
                                   $dateCount+=1; 
                                @endphp 
                          @endif 
                @endfor 
                    @php 
                        $noofregulardays=$daysInMonth-$dateCount-$CountOfHoliday 
                    @endphp 
                    <td>{{$noofregulardays}}</td>

                </tr>
                @else
                <td>Record Not Found</td>

                @endif

                @endforeach

                <!-- Add more rows as needed -->
            </tbody>

        </table>

    </div>
    <div class="Attendance col-md-9">

        <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Shift Days for {{date("M", mktime(0, 0, 0, $currentMonth, 1))}} ,{{$currentYear}}</p>

        <table class="table">
            @php
            // Get current month and year
            $currentMonth = DateTime::createFromFormat('F', $Month)->format('n');;
            $currentYear = date('Y');


            // Total number of days in the current month
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

            @endphp

            <thead>
                <tr>

                    @for ($i = 1; $i <= $daysInMonth; $i++) 
                          @php 
                             $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); 
                             $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon) 
                             $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format 
                          @endphp 
                        <th style="width:75%; background:#ebf5ff; color:#778899; font-weight:500; text-align:center;">
                        <div style="font-size:0.825rem;line-height:0.8;font-weight:500;">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="margin-top:-5px; font-size:0.625rem;margin-top:1px;">{{ $dayName }}</div>
                        </th>

                    @endfor
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Attendance -->

                @foreach ($Employees as $emp)


               
                <tr style="background-color:#fff;">
                   @if(!empty($emp->shift_type))
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                        
                                @php
                                    $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                                    $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                                    $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format
                                @endphp
                        
                                <td style="background-color: {{ in_array($dayName, ['Sat', 'Sun']) ? '#f2f2f2' : '#fff' }};">
                        
                                   @foreach($Holiday as $h)

                                       @if($h->date==$fullDate)

                                           @php
                                                 $isHoliday=1;
                                                 break;
                                           @endphp
                                       @endif

                                   @endforeach

                                   @foreach($ApprovedLeaveRequests1 as $empId => $leaveDetails)


                                        @if($empId==$emp->emp_id)
                    <p>
                        @php
                        foreach ($leaveDetails['dates'] as $date)
                        {
                                if($date == $fullDate)
                                {
                                    $leaveTake=1;
                                
                                }
                        }
                        @endphp
                    </p>

                    @endif

@endforeach



                        @if ($dayName === 'Sat' || $dayName === 'Sun')
                        <p style="font-weight:bold;padding-top:15px;">O</p>


                        @elseif($isHoliday==1)
                        <p style="font-weight:bold;padding-top:15px;">H</p>

                        @elseif($leaveTake==1)

                        <p style="font-weight:bold;padding-top:15px;">L</p>
                        @else
                        @php
                            $shiftroster=$this->isEmployeeAssignedDifferentShift($fullDate, $emp->emp_id)['shiftType'];
                        @endphp
                            @if(!empty($shiftroster))
                              <p style="font-weight:bold;padding-top:15px;">{{$shiftroster}}</p>
                            @else
                              <p style="font-weight:bold;padding-top:15px;">{{$emp->shift_type}}</p>
                            @endif  
                        @endif

                        </td>


                        
                        @php
                        $isHoliday=0;
                        $leaveTake=0;
                      
                        @endphp


                        @endfor
                   @else
                         <td colspan="35"style="text-align:center;">Shift Details Not Available</td>
                   @endif
                </tr>


                @endforeach
                @if($notFound)
                        <td colspan="22" style="text-align: center;font-size:12px">Record not found</td>
                        @endif
            </tbody>
        </table>
    </div>
</div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            if (sidebar.style.right === "0px" || sidebar.style.right === "") {
                sidebar.style.right = "-250px"; // Hide the sidebar
            } else {
                sidebar.style.right = "0px"; // Show the sidebar
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const closeSidebarButton = document.getElementById("closeSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "0px"; // Show the sidebar
        });

        closeSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "-250px"; // Hide the sidebar
        });
    });
</script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

    // September 2023
</script>
</div>