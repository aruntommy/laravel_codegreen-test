<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\UserDetails;
class MailController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
       
        return view('otp_varification');
    }

  
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate the form
         $data= $this->validate($request,[
            'otp'=>'required',
             
        ]);
         //fetch userid
        $userid=$request->session()->get('userid');
         //fetching user details
       $user=UserDetails::where('user_id',$userid)->firstOrFail();

       if($request->session()->get('otp')!=$request->otp)
       {
         return Redirect::back()->with('msg', 'otp didnt match');
       }
       //updating user as a verified user
         $user->verified=1;
         $user->save();
       //remove session data
       $request->session()->forget('otp');
       $request->session()->forget('userid');
       return Redirect('/login');
    }

 
}
