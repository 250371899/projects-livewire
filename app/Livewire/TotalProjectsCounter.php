<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Livewire\Component;

class TotalProjectsCounter extends Component
{
    public int $total = 0;

    private $phases = [
        "design"=> "",
        "deployment"=> "",
        "development" => "",
        "testing" => "",
    ];
    /**
     * This method gets the count of each phases except complete
     * @return void
     */
    public function getUncompleteProjectsCount(){
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
      

    $this->total += $this->phases['testing'];
    $this->total += $this->phases['development'];
    $this->total += $this->phases['deployment'];
    $this->total += $this->phases['design'];

    }
    public function render()
    {
        $this->getUncompleteProjectsCount();
        return view('livewire.total-projects-counter');
    }
}
