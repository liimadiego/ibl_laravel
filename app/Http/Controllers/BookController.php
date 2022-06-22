<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->getAuthorizationHeader()){
            print(Books::all());
        }else{
            echo 'invalid token';
        }
    }
    public function getFiltered($search){
        if($this->getAuthorizationHeader()){
            if($search == 'empty'){
                print(Books::all());
            }else{
                print(Books::where('title', 'like', '%' . $search . '%')
                ->orwhere('author', 'like', '%' . $search . '%')
                ->orwhere('isbn', 'like', '%' . $search . '%')
                ->orwhere('pages', 'like', '%' . $search . '%')
                ->orwhere('edition', 'like', '%' . $search . '%')
                ->orwhere('publishingCompany', 'like', '%' . $search . '%')
                ->get());
            }
        }else{
            echo 'invalid token';
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->getAuthorizationHeader()){
            $data = $request->all();

            Books::create($data);

            echo 'success';
        }else{
            echo 'invalid token';
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($this->getAuthorizationHeader()){
            print(Books::where('id', $id)
                ->get());
        }else{
            echo 'invalid token';
        }   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->getAuthorizationHeader()){
            $data = $request->all();

            Books::where('id', $id)
                ->update($data);

            echo 'success';
        }else{
            echo 'invalid token';
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->getAuthorizationHeader()){
            Books::where('id', $id)
                ->forceDelete();
            
            echo 'success';
        }else{
            echo 'invalid token';
        }
    }

    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return str_replace("Bearer ", "", $headers) === env('APP_API_KEY');
    }
}
