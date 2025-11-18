<?php

namespace App\Http\Controllers;

use App\Repositories\ProformaRepository;
use App\Transformers\GroupTransformer;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\ProformaUserGroups;
use App\Entities\ProformaGroups;
use App\Repositories\RepositoryHelperTrait;
use App\Entities\Users\User;



class GroupController extends Controller
{
    use Helpers;
    use RepositoryHelperTrait;
    protected $proformaRepository;

    protected $per_page = 10;

    public function __construct(ProformaRepository $proformaRepository)
    {
        $this->proformaRepository = $proformaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = app('Dingo\Api\Auth\Auth')->user();
        $userId = $user->id;

        $group = $this->proformaRepository->storeProformaGroup($request->group, $userId);

        $response = $this->response->item($group, new GroupTransformer(true, $userId));

        return response()->json([
            'data' => $response,
            'userDetails' => $user
        ]);
    }

    public function addUserToGroup(Request $request, $group_id)
    {
        $user = app('Dingo\Api\Auth\Auth')->user();
        $userId = $user->id;

        $addUser = $this->proformaRepository->addUserProformaGroup($request, $group_id);

        $response = $this->response->item($addUser, new GroupTransformer());

        return response()->json([
            'data' => $response,
            'userDetails' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $group = $this->proformaRepository->getGroupDetails($id);
        $response = $this->response->item($group, new GroupTransformer());
        
        return $response;
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group_id)
    {
        $group = $this->proformaRepository->updateProformaGroup($request, $group_id);

        $response = $this->response->item($group, new GroupTransformer());

        return $response;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteGroup = $this->proformaRepository->deleteGroup($id);
        return $deleteGroup;
    }
}
