<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Livewire\Component;

class ProjectsCounter extends Component
{
    public int $completed;

    private $phases = [
        "design"=> "",
        "deployment"=> "",
        "complete"=> "",
        "developing" => "",
        "testing" => "",
    ];
    /**
     * This method gets the count for the phases
     * @return void
     */
    public function getPhases(){
        $controller  = new ProjectsController(); 

        $phasesKeys = array_keys($this->phases);
    
        foreach( $phasesKeys as $phaseKey ){

            try{
                $success = $controller->getPhaseCount(auth()->id(), $phaseKey);
            }catch(\Exception $e){
            $this->dispatch('user-error', message: $e->getMessage());
            }
            $this->phases[$phaseKey] = $success;
           
        }
      
 
    }
    public function render()
    {
        $this->getPhases();
        $this->completed = $this->phases['complete'];
        return view('livewire.projects-counter');
    }
}
