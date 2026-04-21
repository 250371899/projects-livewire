<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Database\Factories\ProjectsModelFactory;

class ProjectsModel extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'phase', 'uid', 'created_at', 'updated_at'];
    
    protected $table = 'projects';
    

    /**
     * This method saves the projects params to DB
     * @param mixed $title
     * @param mixed $description
     * @param mixed $phase
     * @param mixed $startDate
     * @param mixed $endDate
     * @return bool|\Exception
     */
      public function saveProject($title,$description,$phase,$startDate,$endDate){
        
        
        try{
            $success = DB::table($this->table)->insert([
                "title"=>$title,
                "description"=>$description,
                "phase"=>$phase,
                "start_date"=>$startDate,
                "end_date"=>$endDate,
                "uid" => auth()->id(), // assign the id of the current user to this project uid
                "created_at" => now(),
                ]);
               
        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
    /**
     * This method gets all projects from DB
     * @param mixed $user_id
     * @return DB::Table The query result
     * @return $e The DB error
     */
    public function getAll($user_id = null, $filter=null, $sortBy, $sortDirection, $paginate){
        try{
           if($user_id){
                return DB::table($this->table)
                         ->where('uid',$user_id) // show only the user'projects
                         ->when($filter, function($query, $filter){
                return $query->whereIn('phase', $filter);
                })
                ->orderBy($sortBy, $sortDirection)
                ->paginate($paginate);
           }else{
            // this shows all projects for all users
                return DB::table($this->table)
               
                        ->when($filter, function($query, $filter){
                return $query->whereIn('phase', $filter);
                })
                ->orderBy($sortBy, $sortDirection)
                ->paginate($paginate);
           }
        }catch(\Exception $e){
            return $e;
        }
       
    }

    /**
     * This method gets the pèram of the project by its id
     * @param mixed $project_id
     * @return $success The db result
     * @return $e The DB error
     */
    public function getById($project_id)
    {

        try{
             return DB::table($this->table)
            ->join('users', $this->table . '.uid', '=', 'users.id')
            ->select($this->table . '.*', 'users.id', 'users.email')
            ->where($this->table . '.id', $project_id)
            ->first();

        }catch(\Exception $e){
            return $e;
        
        }   
   
    }
    /**
     * This method updated the project variables in the DB
     * @param $projectId The project id
     * @return $success The db result
     * @return $e The DB error
     */
    public function updateProject($selectedItem){

        try{
           return DB::table($this->table)
           ->where('uid',auth()->id())
           ->where('id',$selectedItem['id'])
           ->update([
            'title' => $selectedItem['title'],
            'description'=> $selectedItem['description'],
            'phase'=> $selectedItem['phase'],
            'start_date'=> $selectedItem['startDate'],
            'end_date'=> $selectedItem['endDate'],
            'updated_at' => now(),
           ]);

        }catch(\Exception $e){
            return $e;
        }
        return $success;
    }
    /**
     * This method deletes the project by the projectId given as param
     * @param mixed $projectId
     * @return int|\Exception
     */
    public function deleteProject($projectId){
        try{
            return DB::table($this->table)
            ->where('uid',auth()->id()) // always check that the projects belongs to the user
            ->where('id',$projectId)->delete();
        }catch (\Exception $e){
            return $e;
        }
    }
/**
 * This method deletes all project of the current user 
 * @param null
 * @return DB::table  The table instance
 * @return $e The error exception
 */
    public function deleteAll(){
        try{
            return DB::table($this->table)
            ->where('uid', auth()->id()) // only projects that belongs to the logged in user
            ->delete();
        }catch(\Exception $e){
            return $e;
        }
    }
/**
 * This method search the paramater in the database
 * @param $search The search parameter
 * @return DB:table The query result
 * @return $e The error from the DB
 */
    public function search($search, $sortBy, $sortDirection, $paginate, $uid=null){
        try{
            if($uid){
                // search for user project only
            return DB::table($this->table)
            ->where('uid',$uid) // always check that the projects belongs to the user

            ->where('title','like','%'.$search.'%')
            ->orWhere('start_date', 'like', '%' . $search . '%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate);
            }else{
                // search for all userS projects
                return DB::table($this->table)

                    ->where(function ($query) use ($search) {
                        $query->where($this->table . '.title', 'like', '%' . $search . '%')
                            ->orWhere($this->table . '.start_date', 'like', '%' . $search . '%'); 
                    })
                    ->orderBy($sortBy, $sortDirection)
                    ->paginate($paginate);
            }

        }catch(\Exception $e){
            return $e;
        }

    }
    /**
     * Get the count of the phase param
     * @param mixed $userId
     * @param mixed $phase
     * @return int|\Exception
     */
    public function getPhaseCount($userId, $phase){
        try{
            return DB::table($this->table)
            ->where('uid',$userId)
            ->where('phase', $phase)
            ->count();
        }catch (\Exception $e){
            return $e;
        };
        

}    

}