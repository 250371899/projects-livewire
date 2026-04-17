<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class ProjectsChart extends Component
{
    private $pieChartModel;

    private $phases = [
        "design"=> "",
        "deployment"=> "",
        "development" => "",
        "testing" => "",
    ];


    

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
    public function mount(){
        $this->buildTaskChart();
    }
    /**
     * This method bulds the pie chart shown in dashboard
     * @return void
     */
    public function buildTaskChart(){
        
        $this->getPhases();


        $this->pieChartModel = (new PieChartModel())
            ->setTitle('Your projects')
            ->addSlice('Design', $this->phases['design'], '#f6ad55')
            ->addSlice('Deployment', $this->phases['deployment'], '#fc5681')
            ->addSlice('Developing', $this->phases['development'], '#fc6511')
            ->addSlice('Testing', $this->phases['testing'], '#fd5852')
            ->setAnimated(true)
            ->withOnSliceClickEvent('onSliceClick'); 
    }
    public function render()
    {
        
        $this->buildTaskChart();


        return view('livewire.projects-chart', [
             'pieChartModel' => $this->pieChartModel,
        ]);
    }
}
