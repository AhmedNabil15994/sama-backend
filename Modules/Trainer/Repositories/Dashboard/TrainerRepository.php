<?php

namespace Modules\Trainer\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Trainer\Entities\Trainer;
use Modules\User\Entities\User;

class TrainerRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Trainer::class);

        $this->fileAttribute = ['image'=>'image'];
    }

    /*
    * Get All Normal Trainers with Trainer Roles
    */
    public function getAll($order = 'id', $sort = 'desc')
    {
        $trainers = $this->model->whereHas('roles.permissions', function ($query) {
            $query->where('name', 'trainer_access');
        })->orderBy($order, $sort)->get();

        return $trainers;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $trainer = $this->model->withDeleted()->find($id);

        return $trainer;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $trainer = $this->model->where('email', $email)->first();

        return $trainer;
    }

    /*
    * Create New Object & Insert to DB
    */

    public function modelCreated($model, $request, $is_created = true): void
    {
        if ($request['roles'] != null) {
            $this->saveRoles($model, $request);
        }

        $this->createOrUpdateProfile($model, $request);
    }

    public function modelUpdated($model, $request): void
    {
        if ($request['roles'] != null) {
            $this->saveRoles($model, $request);
        }
        $this->createOrUpdateProfile($model, $request);
    }

    public function saveRoles($trainer, $request)
    {
        $user = User::find($trainer->id);
        $user->syncRoles($request['roles']);
//        $trainer->roles()->update(['model_type'=>'Modules\User\Entities\User']);

        return true;
    }

    public function createOrUpdateProfile($trainer, $request)
    {
        $profile = $trainer->profile()->updateOrCreate(
            [
                'trainer_id' => $trainer['id'],
            ],
            [
                'status' => true,
                'job_title' => $request['job_title'],
                'about' => $request['about'],
                'country' => $request['country'],
            ]
        );

        $profile->save();

        return $profile;
    }


    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = User::where('id', '!=', auth()->id())->whereHas('roles.permissions', function ($query) {
            $query->where('name', 'trainer_access');
        })->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function getTrainersProfit($request){
        return $this->model->whereHas('orderCourse')->withCount([
            'orderCourse AS order_courses_profit' => function ($query) {
                $query->select(\DB::raw("SUM(total) as paidsum"))->whereHas('order',function($orderQuery) {
                    $orderQuery->where('order_status_id',1);
                    if(request()->has('req.from') && request()->has('req.to')){
                        $orderQuery->whereBetween('created_at',[request()->req['from'],request()->req['to']]);
                    }
                });
            }
        ])->orWhereHas('orderNote')->withCount([
            'orderNote AS order_notes_profit' => function ($query) use($request){
                $query->select(\DB::raw("SUM(total) as paidsum"))->whereHas('order',function($orderQuery) use($request){
                    $orderQuery->where('order_status_id',1);
                });
            }
        ]);
    }
}
