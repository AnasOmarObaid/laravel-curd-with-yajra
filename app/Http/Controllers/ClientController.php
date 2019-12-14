<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            return datatables()->of(Client::latest()->get())->addColumn('action', function ($data) {
                $button = '<button  type = "button" class = "edit btn btn-primary btn-sm" name = "edit" data-id = " ' . $data->id  . ' " > <i class="fas fa-user-edit fa-fw"></i> Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button  type = "button" class = "delete btn btn-danger btn-sm" data-toggle="modal" name = "delete" data-id = " ' . $data->id  . ' " > <i class="fas fa-user-minus fa-fw"></i> Delete</button>';
                return $button;
            })->rawColumns(['action'])->make(true);
        } //-- end request

        return view('clients.index');
    } //-- end index function

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rule = [
            'first_name'   => ['required', 'string', 'max:20', 'min:2'],
            'last_name'    => ['required', 'string', 'max:20', 'min:2'],
            'email'        => ['required', 'unique:clients,email'],
            'phone'        => ['required'],
        ];

        $msg = [
            'first_name.required' => 'You Must Enter The First Name',
            'last_name.required' => 'You Must Enter The Last Name',
            'email.required' => 'We Need The Email Address',
            'phone.required' => 'We Need The Phone Number',
        ];

        $form_data = $request->except(['_token', 'create_clent', 'image']);

        if (request()->file('image')) {

            $new_name = time() . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->move(public_path('images/'), $new_name);

            $form_data['image'] = $new_name;
        } //-- end if

        $errors = Validator::make($request->all(), $rule, $msg);

        if ($errors->fails())
            return response()->json([
                'errors'    => $errors->errors()->all()
            ]);

        Client::create($form_data);

        return response()->json([
            'success'   => 'Create Client Successfully'
        ]);
    } //-- end store function

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $client = Client::where('id', $id)->get()->first();
            return response()->json([
                'status' => true,
                'data'   => $client

            ]);
        } //-- end if statement
    } //-- end edit function

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rule = [
            'first_name'   => ['required', 'string', 'max:20', 'min:2'],
            'last_name'    => ['required', 'string', 'max:20', 'min:2'],
            //'email'        => ['required', Rule::unique('clients')->ignore($id)],
            'phone'        => ['required'],
        ];

        $msg = [
            'first_name.required' => 'You Must Enter The First Name',
            'last_name.required' => 'You Must Enter The Last Name',
            // 'email.required' => 'We Need The Email Address',
            'phone.required' => 'We Need The Phone Number',
        ];

        $form_data = $request->except(['_token', 'create_clent', 'image']);

        if (request()->file('image')) {
            if (request()->file('image')->getClientOriginalName() != 'default') {
                Storage::disk('image')->delete("\\" . request()->file('image')->getClientOriginalName() . '.' . request()->file('image')->getClientOriginalExtension());
            } //-- end if statement to delete the image
            $new_name = time() . '.' . request()->file('image')->getClientOriginalExtension();

            request()->file('image')->move(public_path('images/'), $new_name);

            $form_data['image'] = $new_name;
        } //-- end if

        $errors = Validator::make($request->all(), $rule, $msg);

        if ($errors->fails())
            return response()->json([
                'errors'    => $errors->errors()->all()
            ]);

        // update the client
        Client::whereId($id)->update($form_data);

        return response()->json([
            'success'   => 'Update Client Successfully'
        ]);
    } //-- end update function

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Client::findOrFail($id);
        if ($data->get('image') != 'default.png') {
            Storage::disk('image')->delete($data->get('image'));
        } //-- end if statement to delete the image
        $data->delete();
    } //-- end destroy function
}
