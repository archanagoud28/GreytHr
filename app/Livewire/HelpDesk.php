<?php
// File Name                       : HelpDesk.php
// Description                     : This file contains the information about various IT requests related to the catalog. 
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories, 
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access. 
// Creator                         : Asapu Sri Kumar Mmanikanta,Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\HelpDesks;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class HelpDesk extends Component
{
    use WithFileUploads;

    public $searchTerm = '';
    public $isRotated = false;
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $peopleFound = true;
    public $category;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $showDialogFinance = false;
    public $record;
    public $activeTab = 'active';
    public $selectedPeople = [];
    public function open()
    {
        $this->showDialog = true;
    }

    public function openFinance()
    {
        $this->showDialogFinance = true;
    }

    public function close()
    {
        $this->showDialog = false;
    }

    public function closeFinance()
    {
        $this->showDialogFinance = false;
    }
    protected $rules = [
        'category' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
        'cc_to' => 'required',
        'priority' => 'required|in:High,Medium,Low',
        'image' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'category.required' => ' category is required.',
        'subject.required' => ' subject is required.',
        'description.required' => ' description is required.',
        'priority.required' => ' priority is required.',
        'priority.in' => ' priority must be one of: High, Medium, Low.',
        'image.image' => ' file must be an image.',
        'image.max' => ' image size must not exceed 2MB.',
        'file_path.mimes' => ' file must be a document of type: pdf, xls, xlsx, doc, docx, txt, ppt, pptx, gif, jpg, jpeg, png.',
        'file_path.max' => ' document size must not exceed 2MB.',
        'cc_to.required' => 'CC To is required.',



    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function resetInputFields()
    {
        $this->category = '';
        $this->subject = '';
        $this->description = '';
        $this->file_path = '';
        $this->cc_to = '';
        $this->priority = '';
        $this->image = '';
    }

    protected function addErrorMessages($messages)
    {
        foreach ($messages as $field => $message) {
            $this->addError($field, $message[0]);
        }
    }

    public function openForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Open']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function selectPerson($personId)
    {
        $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

        if ($selectedPerson) {
            if (in_array($personId, $this->selectedPeople)) {
                $this->selectedPeopleNames[] = ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
            } else {
                $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')']);
            }
            $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
        }
    }


    public function submit()
    {
        $this->validate();

        try {


            if ($this->image) {
                $fileName = uniqid() . '_' . $this->image->getClientOriginalName();
                $this->image->storeAs('uploads/help-desk-images', $fileName, 'public');
                $filePath = 'uploads/help-desk-images/' . $fileName;
            } else {
                $filePath = 'N/A';
            }
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $this->image,
                'cc_to' => $this->cc_to,
                'priority' => $this->priority,
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
            ]);

            session()->flash('message', 'Request created successfully.');
            $this->reset();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }


    public function closePeoples()
    {
        $this->isRotated = false;
    }

    public function updatedSelectedPeople()
    {
        $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
    }


    public function toggleRotation()
    {
        $this->isRotated = true;

        $this->selectedPeopleNames = [];
        $this->cc_to = '';
    }

    public function filter()
    {
        $companyId = Auth::user()->company_id;
        $trimmedSearchTerm = trim($this->searchTerm);

        $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
            })
            ->get();

        $this->peopleFound = count($this->filteredPeoples) > 0;
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;

        $this->peoples = EmployeeDetails::where('company_id', $companyId)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = HelpDesks::all();

        $employee = auth()->guard('emp')->user();
        $employeeId = $employee->emp_id;
        $employeeName = $employee->first_name . ' ' . $employee->last_name . ' #(' . $employeeId . ')';

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.help-desk', [
            'peopleData' => $peopleData,
        ]);
    }
}
