<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Entities\ProformaGroups;
use App\Entities\ProformaUserGroups;
use App\Repositories\RepositoryHelperTrait;
use App\Entities\Users\User;
use Illuminate\Support\Facades\DB;
use App\Entities\Supplier;

class GroupTransformer extends TransformerAbstract
{
	use TransformerHelperTrait;
	use RepositoryHelperTrait;

	protected $userDetailsInclude;
	protected $repositoryHelperTrait;
	protected $supplierId;
	protected $userId;
	
	public function __construct($userDetailInclude = false, $userId = 0)
	{
		$this->userDetailsInclude = $userDetailInclude;
		$this->userId = $userId;
	}

	public function transform(ProformaGroups $proformaGroups)
	{
        $proformaUserGroups = ProformaUserGroups::where('group_id', $proformaGroups->id)->get();

        $users = collect();

        if (count($proformaUserGroups)) {
        	foreach ($proformaUserGroups as $group) {
        		$supplier = Supplier::find($group->user_id);
        		if ($supplier->count()) {
        			$users->push(['id' => $supplier->id, 'name' => $supplier->user->name]);
        		}
        	}
        }
        
		return [
			'id' => $proformaGroups->id,
			'type' => $proformaGroups->type,
			'name' => $proformaGroups->name,
			'created_by' => $proformaGroups->created_by,
			'supplier_count' => $proformaUserGroups->count(),
			'users' => $users,
			'updated_at' => Carbon::parse($proformaGroups->updated_at)->toDateString()
		];
	}

	public function includeUserDetail(ProformaGroups $proformaGroups)
	{
		if ($proformaGroups->created_by) {
			$user = User::findOrFail($this->userId);
			return $this->item($user, new UserDetailTransformer(false));
		}
	}
}