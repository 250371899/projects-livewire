<?php

namespace App\Livewire;

use App\Http\Controllers\ProjectsController;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ViewProjects extends Component
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

    // selected item for edit or delete
    public $selectedItem = [
        'id' => '',
        'title' => '',
        'description' => [],
        'phase'=> '',  
        'startDate'=> '',
        'endDate'=> '',
    ];
   /**
     * Rules for user validation
     */
    protected $rules = [
        'selectedItem.title' => ['required', 'string', 'min:10', 'max:30'],
        'selectedItem.description' => ['required', 'string', 'min:50', 'max:255'],
        'selectedItem.phase ' => 'required|in:design,development,testing,deployment,complete',
        'selectedItem.startDate' => ['required', 'date', 'after:yesterday'],
        'selectedItem.endDate' => ['required', 'date', 'after:startDate'],
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

    public function setFilter(){
   
        // dd($this->filter);
    }
    
    // method to display items in the table 

    #[\Livewire\Attributes\Computed]    
    public function getProjects(){       
      
        $controller = new ProjectsController();
        
        try{
            $success= $controller->getAll(auth()->id(),$this->filter, $this->sortBy, $this->sortDirection, $this->paginate);
      
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
     * This method display the edit modal with the project selected variables
     * @param mixed $id
     * @return void
     */
    public function editShow($id){
        $this->selectedItem['id'] = $id;
        $controller = new ProjectsController();
        // query data for this id and pass it as placeholder
        try{
            $query = $controller->getById($id);
        }catch(\Exception $e){
            $this->dispatch('user-error', message: $e->getMessage());
        }
        if($query instanceof Exception){
            $this->dispatch('user-error', message: $query->getMessage());
        }else{
            
            // get the param of the project
            $this->selectedItem['title' ]= $query->title;
            $this->selectedItem['description'] = $query->description;
            $this->selectedItem['phase'] = $query->phase;
            $this->selectedItem['startDate']=$query->start_date;
            $this->selectedItem['endDate']=$query->end_date; 

            // dispatch the modal 
            $this->dispatch('modal-show', name: "edit-modal");

            
        }    


    }
    /**
     * This method updates the project selected
     */
    public function updateProject($id){
        // validate the user input
        $this->validate();
        // call for the update
        $controller = new ProjectsController();
        try{
            $success = $controller->updateProject($this->selectedItem);
        }catch(\Exception $e){
            $this->dispatch('modal-close', name: "edit-modal");
            $this->dispatch("user-error", message: $e->getMessage());
        }
        if($success instanceof Exception)
            $this->dispatch("user-error", message: $success->getMessage());
        else{
            $this->dispatch("user-message", message: "Project updated successfully");
        }        
        $this->dispatch('modal-close', name: "edit-modal");

    }
    /**
     * This method deletes the project
     * @param mixed $id
     * @return void
     */
    public function deleteProject($id){
        $controller = new ProjectsController();
        try{
            $success = $controller->deleteProject($id);
        }catch(\Exception $e){
            $this->dispatch("user-error", message: $e->getMessage());
        }
        if($success instanceof Exception){
            $this->dispatch("user-error", message: $e->getMessage());
        }else{
            if ($success == true){
                 $this->dispatch("user-message", message:"Project deleted successfully");
            
            }
   
        }
        }
        /**
         * This method search project by project id
         * @param mixed $uid
         * @return Exception|\Illuminate\Contracts\Pagination\LengthAwarePaginator
         */
        public function searchProject($uid){
            $controller = new ProjectsController();
            try{
                $success = $controller->search($this->search,$this->sortBy, $this->sortDirection, $this->paginate,$uid);
            }catch(\Exception $e){
                $this->dispatch("user-error", message: $e->getMessage());   
            }
            if($success instanceof Exception){
                $this->dispatch("user-error", message: $e->getMessage());
            }
            return $success;
        }

    public function render()
    {   
        if (strlen($this->search) >= 1) {
                $projects = $this->searchProject(auth()->id());
                // dd($projects->get());
            }else {
                $projects = $this->getProjects();
            }

            return view('livewire.view-projects', [
                'projects' => $projects,
            ]);

    }
}
