<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\role;
use App\Models\menu;
use App\Models\module_has_permission;
use App\Models\parent_has_permission;

class RoleController extends Controller
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
            $data = role::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($v){
                        return $v->sl;
                    })
                    ->addColumn('role_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->role_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->role_name_bn;
                        }
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
                                <input type="checkbox" id="roleStatus-'.$v->id.'" '.$checked.' onclick="return roleStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('permission',function($row){
                        return '<a 
                        class="btn btn-info btn-sm"
                        href="'.url('permissions').'/'.$row->id.'"
                        >
                        <i class="fa fa-key"></i>
                        </a>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('role.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('role.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','role_name','status','action','permission'])
                    ->make(true);
        }
        return view('backend.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array(
            'sl'=>$request->sl,
            'role_name_en'=>$request->role_name_en,
            'role_name_bn'=>$request->role_name_bn,
            'status'=>$request->status,
        );

        role::create($data);

        Toastr::success(__('role.create_message'), __('common.success'));
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
        $data = role::find($id);
        return view('backend.role.edit',compact('data'));
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
            'sl'=>$request->sl,
            'role_name_en'=>$request->role_name_en,
            'role_name_bn'=>$request->role_name_bn,
            'status'=>$request->status,
        );

        role::find($id)->update($data);
        Toastr::success(__('role.update_message'), __('common.success'));
        return redirect()->back();
    }


    public function roleStatusChange($id)
    {
       $check = role::find($id);

       if($check->status == 1)
       {
            role::find($id)->update(['status'=>0]);
       }
       else
       {
            role::find($id)->update(['status'=>1]);
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
        role::find($id)->delete();
        Toastr::success(__('role.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function permissions($id)
    {
        $parent_menu = menu::where('type',1)->where('status',1)->get();
        $sub_menu = menu::where('type',2)->where('parent_id','>',0)->get();
        $module = menu::where('type',2)->where('parent_id','=','0')->get();
        $role_id = $id;
        return view('backend.role.permission',compact('parent_menu','sub_menu','module','role_id'));
    }

    public function setPermission(Request $request)
    {
        // dd($request->all());

        //parent_insert 


        parent_has_permission::where('role_id',$request->role_id)->delete();
        module_has_permission::where('role_id',$request->role_id)->delete();
        if($request->parent_menu)
        {
            for ($i=0; $i < count($request->parent_menu) ; $i++) 
            { 
                parent_has_permission::create([
                    'role_id'=>$request->role_id,
                    'parent_id'=>$request->parent_menu[$i],
                ]);
            }
        }

        // moduel_insert 
        if($request->module)
        {
            for($i=0; $i < count($request->module) ; $i++)
            {
                module_has_permission::create([
                    'role_id'=>$request->role_id,
                    'module_id'=>$request->module[$i],
                ]);
            }
        }

        Toastr::success(__('role.permission_success'), __('common.success'));
        return redirect()->back();
    }
}
