<div>
   
    <div class="modal-body">
        <div class="row d-flex align-items-center m-0 p-0">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="search-container p-2" style="position: relative;">
                    <input type="text" wire:model.debounce.500ms="search" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded">
                    <button  wire:click="searchfilter" id="searchButtonReview" style="padding:7px 12px !important;">
                        <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="table-responsive mt-2" style="height:200px;max-height:200px;overflow-y:auto;">
        @if (session('error'))
    
             <span style="color:#f66;font-size:12px;">{{ session('error') }}</span>

        @endif
            <table class="swipes-table mt-2 border" style="width: 100%;">
                <tr style="background-color: #f6fbfc;">
                    <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                    <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
                </tr>
                @foreach ($Employees as $emp)
                <tr style="border:1px solid #ccc;">
                    <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">
                    <label class="custom-checkbox">
                            <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="EmployeeId" wire:change="updateEmployeeId" value="{{ $emp->emp_id }}">
                            <span class="checkmark"></span>
                            {{ucwords(strtolower($emp->first_name))}} {{ucwords(strtolower($emp->last_name))}}
                        </label> 
                    </td>
                    <td style="width:50%;font-size: 10px;color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 32px">{{$emp->emp_id}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button type="button"
            class="submit-btn"
            wire:click="downloadInExcel">Run</button>
        <button type="button" data-dismiss="modal"
            class="cancel-btn1"
            wire:click='resetFields'>Clear</button>
    </div>
</div>