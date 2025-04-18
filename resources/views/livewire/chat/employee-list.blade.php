<div>
    <div class="position-absolute" wire:loading wire:target="message">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <div class="container-fluid my-1" id='chartScreen'>
        <div class="wrapper-canvas bg-white" style="height: 93vh">
            {{-- chat side bar --}}
            <livewire:chat.chat-side-bar />
            <div class="row m-0 p-0" style="width:100% !important">
                <!-- Left Side: Department Dropdown -->
                <div class="col-md-3 border-end bg-white" style="height: 92vh; overflow-y: auto;">
                    <div class="bg-white" style="height: 100%;"> <!-- Set background color and full height -->
                        <div class="d-flex flex-column mb-2">
                            <h6 class="text-start text-5xl font-bold py-3 px-4">Departments</h6>
                            <select class="form-control mb-4" wire:model="selectedDepartment" wire:change="filter">
                                <option value="">All Departments</option>
                                <!-- Default option for "All Departments" -->
                                @foreach ($departments as $department)
                                    <option value="{{ $department->dept_id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Conditionally render the sub-department dropdown -->
                        @if ($selectedDepartment && $selectedDepartment != '')
                            <select class="form-control mb-4" wire:model="selectedSubDepartment" wire:change="filter">
                                <option value="">Select Sub-Department</option>
                                @foreach ($subDepartments as $subDepartment)
                                    <option value="{{ $subDepartment->sub_dept_id }}">{{ $subDepartment->sub_department }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Search and Employee Details -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="col-md-6">
                            <h6 class="text-start text-5xl font-bold py-3 px-4 employees-details-chat">Chat Users</h6>
                        </div>
                        <div class="col-md-6 ">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." wire:model="searchTerm"
                                    aria-label="Search" aria-describedby="search-addon" wire:input="filter">
                                <button class="submit-btn" wire:click="filter" id="search-addon">Search</button>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0 p-0 justify-content-center" style="overflow-y: auto; height: 80vh;">
                        @forelse ($employeeDetails as $key => $employee)
                            <div class="col-md-4 mb-3"> <!-- Increase width to col-lg-4 -->
                                <div class="card" wire:key="employee-{{ $employee->emp_id }}">
                                    <div class="col d-flex align-items-center justify-content-center mt-4">
                                        <img height="50" width="50" style="border-radius:50%;"
                                            src="{{ $employee->image
                                                ? 'data:image/jpeg;base64,' . $employee->image
                                                : ($employee->gender === 'MALE'
                                                    ? asset('images/male-default.png')
                                                    : asset('images/female-default.jpg')) }}"
                                            alt="Avatar">
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="chat-employee-name"
                                                title="{{ ucwords(strtolower($employee->first_name)) }}&nbsp;{{ ucwords(strtolower($employee->last_name)) }}">{{ ucwords(strtolower($employee->first_name)) }}&nbsp;{{ ucwords(strtolower($employee->last_name)) }}</span>
                                        </div>
                                        @php
                                            $jobTitle = $employee->job_role;
                                            $convertedTitle = preg_replace('/\bII\b/', 'I', $jobTitle);
                                            $convertedTitle = preg_replace('/\bII\b/', 'II', $jobTitle);
                                            $convertedTitle = preg_replace('/\bIII\b/', 'III', $convertedTitle);
                                        @endphp
                                        <p class="card-text px-4 mb-0" style="display: inline-block;">
                                            {{ $convertedTitle ? $convertedTitle : 'N/A' }}</p>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="chat-emp-head d-flex flex-column align-items-start gap-1">
                                                <span>Employee Id</span>
                                                <span>Department</span>
                                                <span>Join Date</span>

                                            </div>
                                            <div class="chat-emp-details d-flex flex-column align-items-end gap-1">
                                                <span>{{ $employee->emp_id }}</span>
                                                @if ($employee->job_role)
                                                    <span class="text-truncate"
                                                        title="{{ $employee->job_role }}">{{ $employee->job_role }}</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                                @if ($employee->hire_date)
                                                    <span>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d M, Y') }}</span>
                                                @else
                                                    <span>N/A</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex gap-4 justify-content-center">
                                        <!-- Call Icon -->
                                        <button class="cancel-btn px-4 d-flex align-items-center justify-content-center"
                                            style="border:1px solid rgb(12,17,79); border-radius: 10px; width: 30px; height: 30px;cursor:pointer;">
                                            <i class="fas fa-phone-alt fa-rotate-90"
                                                style="font-size: 13px;padding:5px;"></i>
                                        </button>
                                        <!-- Chat Icon -->
                                        <button class="submit-btn px-4 d-flex align-items-center justify-content-center"
                                            style="border-radius: 10px; width: 30px; height: 30px;cursor:pointer;"
                                            wire:click="message('{{ $employee->emp_id }}')">
                                            <i class="fas fa-comment" style="font-size: 14px;padding:5px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col text-center">No employees found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
