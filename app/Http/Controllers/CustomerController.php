<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(Request $request){
        $perPage=$request->perPage ?? 5;
        $keyword=$request->keyword ?? "";

        $query=Customer::query();
        if($keyword){
            $query=$query->where("name","like","%".$keyword."%");
                    $query->orWhere("email","like","%".$keyword."%");
        }
        $customers=$query->orderByDesc("id")->paginate($perPage)->withQueryString();
        return $customers;
        
    }
    public function store(Request $request){
        try{
            Customer::create($request->input());
            return response()->json(["status"=>"success","message"=>"Customer created successfully"]);
        }catch(Exception $exception){
            return response()->json(["status"=>false,"message"=>$exception->getMessage()]);
        }
    }


    public function show( $id){
        try{
            $customer=Customer::findOrFail($id);
            return $customer;
        }catch(Exception $exception){
            return response()->json(["status"=>"fail","message"=>$exception->getMessage()]);
        }
    }

    public function update(Request $request,$id){
        $customer=Customer::findOrFail($id);
        $customer->update($request->input());
        return response()->json(["status"=>"success","message"=>"Customer updated successfully"]);
    }
    public function destroy(Customer $id){
        try{
            $id->delete();
            return response()->json(["status"=>"success","message"=>"Customer deleted successfully"]);
        }catch(Exception $exception){
            return response()->json(["status"=>false,"message"=>$exception->getMessage()]);
        }
    }
}
