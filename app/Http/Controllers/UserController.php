<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Libraries\BaseApi;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api = new BaseApi;
        $users = $api->index('/user');

        if(request('page')){
            $users = $api->index('/user',['page' => request('page')]);
        }
        // $users = (new BaseApi)->index('/user');
        return view('user.index')->with(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('user.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // buat variable baru untuk menset parameter agar sesuai dengan documentasi
				$payload = [
                    'firstName' => $request->input('nama_depan'),
                    'lastName' => $request->input('nama_belakang'),
                    'email' => $request->input('email'),
                ];
        
                $baseApi = new BaseApi;
                $response = $baseApi->create('/user/create', $payload);
        
                        // handle jika request API nya gagal
                // diblade nanti bisa ditambahkan toast alert
                if ($response->failed()) {
                                // $response->json agar response dari API bisa di akses sebagai array
                    $errors = $response->json('data');
                    redirect()->route('users.create')->withErrors($errors);
        
                    // $messages = "<ul>";
        
                    // foreach ($errors as $key => $msg) {
                    //     $messages .= "<li>$key : $msg</li>";
                    // }
        
                    // $messages .= "</ul>";
        
                    // $request->session()->flash(
                    //     'message',
                    //     "Data gagal disimpan
                    //     $messages",
                    // );
        
                    // return redirect()->back();
                }
        
                $request->session()->flash(
                    'message',
                    'Data berhasil disimpan',
                );
        
                return redirect()->route('users.index'); 
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //kalian bisa coba untuk dd($response) untuk test apakah api nya sudah benar atau belum
    //sesuai documentasi api detail user akan menshow data detail seperti `email` yg tidak dimunculkan di api list index
            $response = (new BaseApi)->detail('/user', $id);
                return view('user.edit')->with([
                'user' => $response->json()
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
//column yg bisa di update sesuai dengan documentasi dummyapi.io hanyalah
// `fisrtName`, `lastName`
    $payload = [
        'firstName' => $request->input('nama_depan'),
        'lastName' => $request->input('nama_belakang'),
    ];

    $response = (new BaseApi)->update('/user', $id, $payload);
    if ($response->failed()) {
        $errors = $response->json();
        // $messages = "<ul>";

        // foreach ($errors as $key => $msg) {
        //     $messages .= "<li>$key : $msg</li>";
        // }

        // $messages .= "</ul>";

        // $request->session()->flash(
        //     'message',
        //     "Data gagal disimpan
        //     $messages",
        // );

        return redirect('users');
    }

    $request->session()->flash(
        'message',
        'Data berhasil disimpan',
    );

    return redirect('users');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $response = (new BaseApi)->delete('/user', $id);

        if ($response->failed()) {
            $request->session()->flash(
                'message',
                'Data gagal dihapus'
            );

            return redirect('users');
        }

        $request->session()->flash(
            'message',
            'Data berhasil dihapus',
        );

        return redirect('users');

    }
}
