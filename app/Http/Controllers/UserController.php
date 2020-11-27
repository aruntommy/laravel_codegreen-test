<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\Mailer;
use App\User;
use App\UserDetails;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          try {
                 $user_id=auth()->user()->id;
            } catch (Exception $e) {
               echo "please log in";
            }
       
        $user=UserDetails::where('user_id',$user_id)->firstOrFail();
        return view('user_edit')->with('user',$user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate the form
          $this->validate($request,[
             'name' => ['required', 'string', 'max:255'],
             'username' => ['required', 'string','min:5', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_details'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['before:today','required'],
            'city' => ['required', 'string'],
             
        ]);
          //save date to user table
        $user= new User;
        $user->username=$request['username'];
        $user->password=Hash::make($request['password']);
        $user->save();
        //save user details to user_details table
         UserDetails::create([
            'user_id' => $user->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'dob' => $request['dob'],
            'city' => $request['city'],
        ]);
        //GENERATE OTP
        $otp= rand(1265,4756);
        //save otp and userid to session
    $request->session()->put('userid',$user->id);     
    $request->session()->put('otp',$otp);
    //send otp to user mail
     $data = [
        'title' => 'otp from newapp',
        'body' => 'confirm your email with given otp',
        'otp' => $otp,
        'recipient' =>$request['email']
    ];
    //creating mailer object to send  mail
    $mailer= new Mailer($data);
    //sending mail
    $mailer->sendmail();
    return redirect('/mail/create');
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
        
                //validate the form
          $this->validate($request,[
             'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'dob' => ['before:today','required'],
            'city' => ['required', 'string'],
             
        ]);
         $user=UserDetails::where('user_id',$id)->firstOrFail();
         //updating the values
         $user->name=$request->name;
         $user->email=$request->email;
         $user->dob=$request->dob;
         $user->city=$request->city;
         $user->save();
         //redirect to user profile page
          return Redirect::back()
          ->with('msg', 'details updated successfully');



    }

}
