<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Exception;
use Livewire\Component;

class AddProject extends Component
{
    public $title, $description, $phase, $startDate, $endDate;
    /**
     * Rules for user validation
     */
    protected $rules = [
        'title' => ['required', 'string', 'min:10', 'max:30'],
        'description' => ['required', 'string', 'min:50', 'max:255'],
        'phase' => ['required', 'in:0,1,2,3,4,5'],
        'startDate' => ['required', 'date', 'after:yesterday'],
        'endDate' => ['required', 'date', 'after:startDate'],
        ];

  
    /**
     * This function adds the project to db
     * @return true All good
     * @return false Error
     */
    public function saveProject(){

        // validate user inputs 
        $this->validate();

        $controller = new ProjectsController();
        try{
            $success = $controller->saveProject($this->title, $this->description, $this->phase, $this->startDate, $this->endDate);
        }catch(Exception $e){
            $this->dispatch('user-error', message: $e->getMessage());
            return false;
        }

        if($success instanceof Exception){
            $this->dispatch('user-error', message: $success->getMessage());
        }else{
        $this->dispatch('user-message', message: "Your project has been saved successfully");
            return true;
        }
        
        return false;
    }
        /**
         * This method reset the inputs fields in the page 
         * @return void
         */
        public function resetForm(){
            $this->reset(); 

            $this->resetValidation();
        }
    public function render()
    {
        return view('livewire.add-project');
    }
}
