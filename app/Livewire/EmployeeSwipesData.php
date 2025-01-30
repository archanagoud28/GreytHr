<?php

/*
 * File Name                       : EmployeeSwipesData.php
 * Description                     : This file contains the implementation of all the employees who swiped in today and we can get the swipe record of the employees before today's date.
 * Creator                         : Pranita Priyadarshi
 * Email                           : priyadarshipranita72@gmail.com
 * Organization                    : PayG.
 * Date                            : 2023-12-07
 * Framework                       : Laravel (10.10 Version)
 * Programming Language            : PHP (8.1 Version)
 * Database                        : MySQL
 * Models                          : SwipeRecord, EmployeeDetails
 */

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\SwipeRecord;
use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use PDO;
use Spatie\SimpleExcel\SimpleExcelWriter;

class EmployeeSwipesData extends Component
{
    public $employees;
    public $startDate;

    public $doorSwipeTime;
    public $accessCardDetails;
    public $endDate;









    public $selectedWebEmployeeId;
    public $deviceId;
    public $selectedEmployeeId;
    
    public $webSwipeDirection;
    public $swipeTime;
    public $employeeId;
    public $isPending=0;

    public $webDeviceId;
    public $webDeviceName;
    public $isApply=1;
    public $selectedShift;
    public $employeeShiftDetails;
    public $selectedSwipeTime;

    public $defaultApply=1;
    public $search = '';
    public $searching = 0;
    public $selectedSwipeLogTime = [];
    public $swipeLogTime = null;
    public $status;

    public function mount()
    {
        try {
            $today = now()->startOfDay();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            $this->startDate=now()->toDateString();
            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
                ->where('employee_status', 'active')
                ->join('company_shifts', function ($join) {
                    $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                        ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
                })
                ->select(
                    'employee_details.*',
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->get();

            // Check if the user swiped today
            $userSwipesToday = SwipeRecord::where('emp_id', $authUser->emp_id)
                ->where('created_at', '>=', $today)
                ->where('created_at', '<', $today->copy()->endOfDay())
                ->exists();

            $agent = new Agent();
            $this->status = $userSwipesToday ? ($agent->isMobile() ? 'Mobile' : ($agent->isDesktop() ? 'Desktop' : '-')) : '-';
        } catch (\Exception $e) {
            Log::error('Error in mount method: ' . $e->getMessage());
            $this->status = 'Error';
        }
    }



    public function viewDoorSwipeButton()
    {
        Log::info('Welcome to viewDoorSwipeButton method');
        $this->isApply = 1;
        $this->isPending = 0;
        $this->defaultApply = 1;
    
        $this->swipeTime = null;
        $this->webSwipeDirection=null;
        $this->webDeviceName=null;
        $this->webDeviceId=null;
       
        $today = now()->toDateString();
        $authUser = Auth::user();
        $userId = $authUser->emp_id;

        $isManager = EmployeeDetails::where('manager_id', $userId)->exists();
        if($isManager)
        {

            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
            ->orWhere('emp_id',$userId)
            ->where('employee_status', 'active')
            ->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            })
            ->select(
                'employee_details.first_name',
                'employee_details.emp_id',
                'employee_details.last_name',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            )
            ->get();
        }
        else
        {
            $managedEmployees = EmployeeDetails::where('emp_id', $userId)

            ->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            })
            ->select(
                'employee_details.first_name',
                'employee_details.emp_id',
                'employee_details.last_name',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            )
            ->get();
        }

        $this->employees = $this->processSwipeLogs($managedEmployees, $this->startDate);

        Log::info('isApply: ' . $this->isApply);
        Log::info('isPending: ' . $this->isPending);
        Log::info('defaultApply: ' . $this->defaultApply);

        // Debugging: Log the output of processWebSignInLogs
        Log::info('Employees: ', ['employees' => $this->employees]);

    }
    public function processWebSignInLogs()
    {

        $today=$this->startDate;
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        $webSignInData = [];
        $isManager = EmployeeDetails::where('manager_id', $userId)->exists();
        if($isManager)
        {

            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
            ->orWhere('emp_id',$userId)
            ->where('employee_status', 'active')
            ->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            })
            ->select(
                'employee_details.*',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            )
            ->get();
        }
        else
        {
            $managedEmployees = EmployeeDetails::where('emp_id', $userId)

            ->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            })
            ->select(
                'employee_details.*',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            )
            ->get();
        }
        $todaySwipeRecords = SwipeRecord::whereDate('created_at', $this->startDate)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->get();

                foreach ($managedEmployees as $employee) {
                    $normalizedEmployeeId = $employee->emp_id;
                    // Check if there's a swipe record from the external database
                    $employeeSwipeLog = $todaySwipeRecords->where('emp_id', $normalizedEmployeeId);



                    if ($employeeSwipeLog && $employeeSwipeLog->isNotEmpty()) {
                        $webSignInData[] = [
                            'employee' => $employee,
                            'swipe_log' => $employeeSwipeLog,
                        ];
                    }
                }

                return $webSignInData;


    }

    public function viewWebsignInButton()
    {
        Log::info('Welcome to viewWebsignInButton method');
        $this->isApply = 0;
        $this->isPending = 1;
        $this->defaultApply = 0;
        $this->accessCardDetails=null;
        $this->deviceId=null;
        $this->employees = $this->processWebSignInLogs();
        Log::info('isApply: ' . $this->isApply);
        Log::info('isPending: ' . $this->isPending);
        Log::info('defaultApply: ' . $this->defaultApply);

        // Debugging: Log the output of processWebSignInLogs
        Log::info('Employees: ', ['employees' => $this->employees]);

    }

    public function handleEmployeeSelection()
    {
        $parts = explode('-', $this->selectedEmployeeId);
        
        
        $this->doorSwipeTime=$parts[3];
        $this->selectedEmployeeId = $parts[0].'-'.$parts[1];
        $currentDate = Carbon::today();
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $normalizedId=str_replace('-', '', $this->selectedEmployeeId);
        // Construct the table name for SQL Server
        $tableName = 'DeviceLogs_' . $month . '_' . $year;
        $this->accessCardDetails = DB::connection('sqlsrv')
                    ->table(table: $tableName)
                    ->where('UserId', $normalizedId)
                  
                    ->value('UserId');
        $this->deviceId=  DB::connection('sqlsrv')
        ->table(table: $tableName)
        ->where('UserId', $normalizedId)
      
        ->value('DeviceId');           
        
    }
    public function updateDate()
    {

        $this->startDate = $this->startDate;
    }

    public function handleEmployeeWebSelection()
    {
      
        // $this->selectedWebEmployeeId=$this->selectedWebEmployeeId;
        $parts = explode('-', $this->selectedWebEmployeeId);
        
        $this->selectedWebEmployeeId = $parts[0].'-'.$parts[1];
        $this->swipeTime = $parts[3];
        $this->webSwipeDirection=$parts[4];
        $this->webDeviceName=SwipeRecord::where('emp_id',$this->selectedWebEmployeeId)->where('in_or_out',$this->webSwipeDirection)->where('swipe_time',$this->swipeTime)->whereDate('created_at',$this->startDate)->value('device_name');
        $this->webDeviceId=SwipeRecord::where('emp_id',$this->selectedWebEmployeeId)->where('in_or_out',$this->webSwipeDirection)->where('swipe_time',$this->swipeTime)->whereDate('created_at',$this->startDate)->value('device_id');
       
        // Construct the table name for SQL Server
      
        
        // $this->webDeviceId=  SwipeRecord::where('')         
        
    }
    public function downloadFileforSwipes()
    {
        try {
            $today = now()->toDateString();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
                ->where('employee_status', 'active')
                ->get();

            $swipeData = [];


            if ($this->isApply == 1 && $this->isPending == 0 && $this->defaultApply == 1) {
                $title = 'First Door Swipe Data';
                $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Direction'];
                $employeesInExcel = $this->processSwipeLogs($managedEmployees, $this->startDate);
                foreach ($employeesInExcel as $employee) {
                    foreach($employee['swipe_log'] as $log)
                    {
                            $swipeData[] = [
                                            $employee['employee']->emp_id,
                                            ucwords(strtolower($employee['employee']->first_name)).' '.ucwords(strtolower($employee['employee']->last_name)),
                                            Carbon::parse($log->logDate)->format('jS F Y') ,
                                            Carbon::parse($log->logDate)->format('H:i:s'),
                                            $log->Direction,
                                        ];
                    }
                    
                    
                }
                
            } elseif ($this->isApply == 0 && $this->isPending == 1 && $this->defaultApply == 0) {
                $title = 'Web Sign In Data';
                $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Web Sign In Data'];
                $employeesInExcel = $this->processWebSignInLogs();
                foreach ($employeesInExcel as $employee) {
                    foreach($employee['swipe_log'] as $log)
                    {
                            $swipeData[] = [
                                            $employee['employee']->emp_id,
                                            ucwords(strtolower($employee['employee']->first_name)).' '.ucwords(strtolower($employee['employee']->last_name)),
                                            Carbon::parse($log->created_at)->format('jS F Y') ,
                                            Carbon::parse($log->swipe_time)->format('H:i:s'),
                                            $log->in_or_out,
                                        ];
                    }
                    
                    
                }
                
            } 
            

           
            $filePath = storage_path('app/todays_present_employees.xlsx');

            SimpleExcelWriter::create($filePath)
                ->addRow([$title])
                ->addRow($headerColumns)
                ->addRows($swipeData)
                ->close();

            return response()->download($filePath, 'todays_present_employees.xlsx');
        } catch (\Exception $e) {
            Log::error('Error downloading file for swipes: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while downloading the file for swipes. Please try again.');
            return redirect()->back();
        }
    }

    public function updatedSelectedShift($value)
    {
        // This method will be called whenever the selected radio button changes
        // $value will contain the value of the selected shift ('GS', 'AS', or 'ES')
        Log::info('Selected Shift: ' . $value);

        // You can handle the selected value here

        $this->selectedShift = $value;
        // $this->formattedSelectedShift='General Shift';


    }
    public function searchEmployee()
    {
        $this->searching = 1;
    }


    public function processSwipeLogs($managedEmployees, $today)
    {
        $swipeCardData = [];
        $today=$this->startDate;

        $normalizedIds = $managedEmployees->pluck('emp_id')->map(function ($id) {
            return str_replace('-', '', $id);
        });
        $currentDate = Carbon::today();
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        // Construct the table name for SQL Server
        $tableName = 'DeviceLogs_' . $month . '_' . $year;
        // dd($tableName);

        try {
            // Check if the table exists

            if (DB::connection('sqlsrv')->getSchemaBuilder()->hasTable($tableName)) {


                if($today)
                {

                    $externalSwipeLogs = DB::connection('sqlsrv')
                    ->table($tableName)
                    ->select('UserId', 'logDate', 'Direction')
                    ->whereIn('UserId', $normalizedIds)
                    ->whereRaw("CONVERT(DATE, logDate) = ?", $today)
                    ->get();

                }
                else
                {
                    $externalSwipeLogs = DB::connection('sqlsrv')
                    ->table($tableName)
                    ->select('UserId', 'logDate', 'Direction')
                    ->whereIn('UserId', $normalizedIds)
                    ->whereRaw("CONVERT(DATE, logDate) = ?", [now()->format('Y-m-d')])
                    ->get();


                }
            } else {
                $externalSwipeLogs = collect();
            }

        } catch (\Exception $e) {
            // Handle exceptions related to external database query
            // Log or handle the exception
            $externalSwipeLogs = collect();  // Proceed with an empty collection
        }


        foreach ($managedEmployees as $employee) {
            $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);
            // Check if there's a swipe record from the external database
            $employeeSwipeLog = $externalSwipeLogs->where('UserId', $normalizedEmployeeId);



            if ($employeeSwipeLog && $employeeSwipeLog->isNotEmpty()) {
                $swipeCardData[] = [
                    'employee' => $employee,
                    'swipe_log' => $employeeSwipeLog,
                ];
            }
        }


        return $swipeCardData;
    }




    public function render()
    {
        if($this->isApply==1&&$this->isPending==0&&$this->defaultApply==1)
        {
            $this->viewDoorSwipeButton();

        }
        elseif($this->isApply==0&&$this->isPending==1&&$this->defaultApply==0)
        {
            $this->viewWebsignInButton();
        }

        // Determine the SignedInEmployees based on conditions




        return view('livewire.employee-swipes-data', [
            'SignedInEmployees' => $this->employees,

        ]);
    }
}
