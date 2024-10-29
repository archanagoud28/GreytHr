<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use App\Models\Chating;
use App\Notifications\ResetPasswordLink;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;

class EmployeeDetails extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $table = 'employee_details';
    protected $fillable = [
        'emp_id',
        'company_id',
        'department_id',
        'sub_department_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'image',
        'hire_date',
        'employee_type',
        'job_role',
        'manager_id',
        'employee_status',
        'emergency_contact',
        'password',
        'inter_emp',
        'job_location',
        'is_starred',
        'status',
        'dept_head',
        'job_mode',
        'resignation_date',
        'resignation_reason',
        'notice_period',
        'last_working_date',
        'extension',
        'experience',
        'shift_type',
        // 'shift_start_time',
        // 'shift_end_time',
        'emp_domain',
        'referral',
        'probation_Period',
        'service_age',
        'confirmation_date',
    ];

    protected $casts = [
        'company_id' => 'array',
    ];

    public function empBankDetails()
    {
        return $this->hasOne(EmpBankDetail::class, 'emp_id', 'emp_id');
    }

    public function empParentDetails()
    {
        return $this->hasOne(EmpParentDetails::class, 'emp_id', 'emp_id');
    }

    public function empPersonalInfo()
    {
        return $this->hasOne(EmpPersonalInfo::class, 'emp_id', 'emp_id');
    }
    public function empSpouseDetails()
    {
        return $this->hasOne(EmpSpouseDetails::class, 'emp_id', 'emp_id');
    }
    public function empDepartment()
    {
        return $this->hasOne(EmpDepartment::class, 'dept_id', 'dept_id');
    }
    public function empSubDepartment()
    {
        return $this->hasOne(EmpSubDepartments::class, 'dept_id', 'dept_id');
    }
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'emp_id');
    }
    public function leaveApplies()
    {
        return $this->hasMany(LeaveRequest::class, 'emp_id', 'emp_id');
    }
    public function swipeRecords()
    {
        return $this->hasMany(SwipeRecord::class, 'emp_id', 'emp_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'company_id', 'company_id');
    }
    public function canCreatePost()
    {

        return $this->emp_id === 'emp_id'  || $this->hasPermission('create-post');
    }

    // Inside the EmployeeDetails model
    public function starredPeople()
    {
        return $this->hasMany(StarredPeople::class, 'emp_id', 'emp_id');
    }

    public function conversations()
    {

        return $this->hasMany(Chating::class, 'sender_id')->orWhere('receiver_id', $this->emp_id)->whereNotDeleted();
    }
    public function personalInfo()
    {
        return $this->hasOne(EmpPersonalInfo::class, 'emp_id', 'emp_id');
    }
    public function getImageUrlAttribute()
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->attributes['image']);
    }
    public function getHireDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

    // public function sendPasswordResetNotification($token)
    // {

    //     // Your own implementation.
    //     $this->notify(new ResetPasswordLink($token));
    // }
}
