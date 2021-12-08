<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate(25);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first' => 'required|max:255',
            'last' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|unique:users|max:255'
        ]);


        $errors = $validator->errors();

        if ($errors->count() > 0) {
            return response()->json([
                'msg' => 'Ups something is wrong, please check your form',
                'code' => 400,
                'errors' => $errors->toArray()
            ]);
        }

        try {

            User::create([
                'first_name' => $request->input('first'),
                'last_name' => $request->input('last'),
                'address' => $request->input('address'),
                'email' => $request->input('email')
            ]);

            return response()->json(['msg' => 'The user has been registered', 'code' => 200]);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Ups something is wrong', 'code' => 500]);
        }

    }
}
