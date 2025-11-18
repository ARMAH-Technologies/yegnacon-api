<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 5/18/2016
 * Time: 3:31 PM
 */

namespace App\Entities\Traits;

use Illuminate\Http\Request;

trait UserTrait
{
    public function scopeSearchUser($query, Request $request){
        $query->searchByName($request);
    }

    public function scopeFilterUser($query, Request $request){
        $query->filterByProfileType($request);
        $query->filterByGrade($request);
        $query->filterByType($request);
        $query->filterByStatus($request);
        $query->filterByCategory($request);
        $query->filterByLocation($request);
        $query->filterByField($request);
        $query->filterByPackage($request);
    }

    public function scopeSearchByName($query, Request $request){
        if ($request->has('search')){
            $search_key = $request->get("search");
            return $query->where("name", "like", "%" . $search_key . "%");
        }
    }

    public function scopeFilterByPackage($query, Request $request){
        if($request->has('package')){
            $package = $request->get("package");
            $query = $query->whereHas('subscriptions.package',function($query) use ($package){
                $query = $query->where("package",'like','%'. $package. "%");
            });
        }
        return $query;
    }
    public function scopeFilterByProfileType($query, Request $request)
    {
        if ($request->has('profileType')) {
            $type = $request->get('profileType');
            $types = explode(",", $type);
            $query->whereIn('profile_type',$types);
        }

        return $query;
    }

    public function scopeFilterByGrade($query, Request $request)
    {
        if ($request->has('grade')) {
            $search_key = $request->get('grade');
            if ($request->has('profileType') &&
                ($request->get('profileType') == "Consultant"
                    || $request->get('profileType') == "Contractor")){

                $query = $query->whereHas(lcfirst($request->get('profileType')), function ($query) use ($search_key) {
                    $query->where("level", $search_key);
                });
                return $query;
            }
        }
        return $query;
    }

//    filter consultants and contractors by type

    public function scopeFilterByType($query, Request $request)
    {
        if ($request->has('type')) {
            $search_key = $request->get('type');
            if ($request->has('profileType') &&
                ($request->get('profileType') == "Consultant"
                    || $request->get('profileType') == "Contractor")) {

                $query = $query->whereHas(lcfirst($request->get('profileType')), function ($query) use ($search_key) {
                    $query->where("type", $search_key);
                });
            }
        }
        return $query;
    }

    public function scopeFilterByStatus($query, Request $request){
        
        if($request->has("status")) {
            $search_key = $request->get('status');
            return $query->where("status", $search_key);
        } 
    }

//    filter suppliers by category
    public function scopeFilterByCategory($query, Request $request)
    {
        if ($request->has('category') && $request->has('profileType') && $request->get('profileType') == "Supplier") {
            $search_key = $request->category;
            $query = $query->whereHas("supplier.proformaCategories", function($query) use ($search_key){
                $query->where("id", $search_key);
            });
        }
        return $query;
    }

//    filter users by location
    public function scopeFilterByLocation($query, Request $request)
    {
        if ($request->has('location') && $request->has('profileType') ) {
            if ($request->profileType == "Supplier" || $request->profileType == "Professional" || $request->profileType == "Consultant"
                    || $request->profileType == "Contractor" || $request->profileType == "ProjectOwner")
                $search_key = $request->location;
                $query = $query->whereHas("address", function($query) use ($search_key){
                    return $query->where("city", $search_key);
                });
        }
        return $query;
    }

//    filter professionals by field
    public function scopeFilterByField($query, Request $request){
        if ($request->has('field') && $request->has('profileType') && $request->get('profileType') == "Professional") {
            $search_key = $request->title;
            $query = $query->whereHas("professional", function($query) use ($search_key){
                $query->where("professional_title", $search_key);
            });
        }
        return $query;
    }

//    filter professionals by experience
//    public function scopeFilterByExperience($query, Request $request){
//        if ($request->has('experience') && $request->has('profileType') && $request->get('profileType') == "Professional") {
//            $search_key = $request->title;
//            $query = $query->whereHas("professional.experiences", function($query) use ($search_key){
//                $query->where("experience", $search_key);
//            });
//        }
//        return $query;
//    }






}
