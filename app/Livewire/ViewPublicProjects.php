<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ViewPublicProjects extends Component
{  
    use WithPagination;

    // Default sortby preference for table
    public $sortBy = 'start_date';   
    // Default sort direction for columns 
    public $sortDirection = 'desc';

    // Default filter value
    public $filter = [];

    //Search variable
    public $search = '';
    // project info for modal
    public $projectInfo = [
        'title'=> '',
        'description'=> '',
        'start_date'=> '',
        'end_date'=> '',
        'phase'=> '',
        'email'=> '',

    ];

    // Default value for items in page
    public $paginate = 10;
    /**
     * This function sorts the row items by the column selected
     * @param mixed $column
     * @return void
     */
    public function sort($column) {
        if ($this->sortBy === $column) {            
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else {
            $this->sortBy = $column; 
            $this->sortDirection = 'asc';
        }
        $this->resetPage();     
    }
    /**
     * This method is empty and makes possible the selection for filter
     * @return void
     */
    public function setFilter(){
   
        // dd($this->filter);
    }
    
    /**
     * This method shows all project 
     */

    #[\Livewire\Attributes\Computed]    
    public function getProjects(){       
      
        $controller = new ProjectsController();
        
        try{
            $success= $controller->getAll(null,$this->filter, $this->sortBy, $this->sortDirection, $this->paginate);
      
        }catch(\Exception $e){
            $this->dispatch('user-error', message: $e->getMessage());
        }
        if($success instanceof Exception){
            $this->dispatch('user-error', message:$success->getMessage());
        }else{
            return $success;
        }
 
    }


    /**
     * This method search across title and date from search bar
     * @param mixed $uid
     * @return Exception|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProject($uid=null){
        $controller = new ProjectsController();
        try{
            $success = $controller->search($this->search,$this->sortBy, $this->sortDirection, $this->paginate,$uid);
        }catch(\Exception $e){
            $this->dispatch("user-error", message: $e->getMessage());   
        }
        if($success instanceof Exception){
            $this->dispatch("user-error", message: $success->getMessage());
        }
        return $success;
    }
 
    public function render()
    {   
        if (strlen($this->search) >= 1) {
                $projects = $this->searchProject(null);
               
            }else {
                $projects = $this->getProjects();
            
            }

            return view('livewire.view-public-projects', [
                'projects' => $projects,
            ]);

    }
    /**
     * This method gets the details of project selected and fills in the modal
     * @param mixed $id
     * @return void
     */
    public function viewProjectDetailsModal($id){
        $controller = new ProjectsController();
        try{
            $success = $controller->getById($id);
        }catch(\Exception $e){
            $this->dispatch('user-error', message: $e->getMessage());
        }
        if($success instanceof Exception){
            $this->dispatch('user-error', message: $success->getMessage());
        }else{
          
            // pass the result to this attribute $projectInfo for modal retriaval
            
                
            $this->projectInfo['title'] = $success->title;
            $this->projectInfo['description'] = $success->description;
            $this->projectInfo['start_date'] = \Carbon\Carbon::parse($success->start_date)->format('d m Y');;
            $this->projectInfo['end_date'] =\Carbon\Carbon::parse($success->end_date)->format('d m Y');;
            $this->projectInfo['phase'] = $success->phase;
            $this->projectInfo['email'] = $success->email;

            // dd($this->projectInfo);
            // all good dispatch the modal with the infos of the project
             $this->dispatch('modal-show', name: 'project-info');
            
 
        }

}
}