<?php

namespace App\Http\Controllers;

use App\Models\ProjectsModel;


class ProjectsController extends Controller
{
    /**
     * This method saves the project param to DB
     * @param mixed $title
     * @param mixed $description
     * @param mixed $phase
     * @param mixed $startDate
     * @param mixed $endDate
     * @return bool|\Exception
     */
    public function saveProject($title,$description,$phase,$startDate,$endDate){
        // create new object model
        $model = new ProjectsModel();
        try{
            $success = $model->saveProject($title,$description,$phase,$startDate,$endDate);
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }


    /**
     * This method gets all projects from
     * @param mixed $user_id
     * @return \Exception|\Illuminate\Support\Collection
     */
    public function getAll($user_id = null, $filter=null, $sortBy, $sortDirection, $paginate){
    // create new object model
        $model = new ProjectsModel();
        try{
            if($user_id){
                $success = $model->getAll($user_id, $filter, $sortBy, $sortDirection, $paginate);
            }else{
                $success = $model->getAll(null, $filter, $sortBy, $sortDirection, $paginate);
            }
            
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
    /**
     * This method gets the pèram of the project by its id
     * @param mixed $projectId
     */
    public function getById($projectId)
    {
        $model = new ProjectsModel();
        try{
            $success = $model->getById($projectId);
        }catch(\Exception $e){
            return $e;
        
        }   
    return $success;
    }

    public function updateProject($selectedItem){
        $model = new ProjectsModel();
        try{
            $success = $model->updateProject($selectedItem);
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
    /**
     * This method deletes the project selected
     * @param $projectId The project id to delete
     * @return $success The response from the DB
     * @return $e The error from the DB
     */
    public function deleteProject($project_id){
        $model = new ProjectsModel();
        try{
            $success = $model->deleteProject($project_id);
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    } 
    /**
     * This method deletes all project of current user logged in 
     * @return $success The response from the DB
     * @return $e The error from the DB
     */
    public function deleteAll(){
        $model = new ProjectsModel();
        try{
            $success = $model->deleteAll();
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    } 
    
    /**
     * This method search the paramater in the database
     * @param $search The search parameter
     * @return $success The query result
     * @return $e The error from the DB
     */
    public function search($search,$sortBy, $sortDirection, $paginate, $uid=null){
        $model = new ProjectsModel();
        try{
            $success = $model->search($search, $sortBy, $sortDirection, $paginate,$uid);
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
    /**
     * This method gets the pase passed in param count
     * @param mixed $uid
     * @param mixed $phase
     * @return int|\Exception
     */
    public function getPhaseCount($uid, $phase){
        $model = new ProjectsModel();
        try{
            $success = $model->getPhaseCount($uid, $phase);
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
}