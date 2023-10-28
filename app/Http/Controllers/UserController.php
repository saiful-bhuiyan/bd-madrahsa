<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\role;
use App\Models\User;
use Hash;
use DataTables;

class UserController extends Controller
{
    protected $lang;

    protected $sl;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->lang = config ("app.locale");
        $this->sl = 0;
        if ($request->ajax()) {
            $data = User::all();
            // return $data;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($v){
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('role_id',function($v){
                        return $v->role_id;
                    })
                    ->addColumn('name',function($v){
                        return $v->name;
                    })
                    ->addColumn('mobile',function($v){
                        return $v->mobile;
                    })
                    ->addColumn('email',function($v){
                        return $v->email;
                    })
                    ->addColumn('status',function($v){
                        if($v->status == 1)
                        {
                            $checked = 'checked';
                        }
                        else
                        {
                            $checked = '';
                        }

                        return '<label class="switch rounded">
                                <input type="checkbox" id="userStatus-'.$v->id.'" '.$checked.' onclick="return userStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('user.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('user.destroy',$row->id).'" id="deleteForm">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button onclick="return confirmation();" class="dropdown-item" type="submit">
                                <i class="fa fa-trash"></i> '.__('common.delete').'
                            </button>
                            </form>
                            </li>

                        </ul>
                    </div>';

                    })
                    ->rawColumns(['sl','role_id','name','mobile','email','status','action'])
                    ->make(true);
        }
        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_role = role::all();

        // return $role;
        return view('backend.user.create',compact('user_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        $data = array(
            'role_id'=>$request->role_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'mobile'=>$request->mobile,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/UserImage/',$imageName);

            $data['image'] = $imageName;
        }

        // dd($imageName);

        $insert = User::create($data);

        User::find($insert->id)->update(['image'=>$imageName]);

        return redirect()->back();
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
        $data = User::find($id);
        $user_role = role::all();
        return view('backend.user.edit',compact('data','user_role'));
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
        $data = array(
            'role_id'=>$request->role_id,
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'status'=>$request->status,
        );

        User::find($id)->update($data);

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/img/UserImage/'.$request->image;
                if(file_exists($path))
                {
                    unlink($path);
                }
                $imageName = rand().'.'.$file->getClientOriginalExtension();

                $file->move(public_path().'/backend/img/UserImage/',$imageName);
    
                User::find($id)->update(['image'=>$imageName]);
        }else{

        }



        Toastr::success(__('user.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function userStatusChange($id)
    {
       $check = User::find($id);

       if($check->status == 1)
       {
            User::find($id)->update(['status'=>0]);
       }
       else
       {
            User::find($id)->update(['status'=>1]);
       }

       return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->back();
    }
}
