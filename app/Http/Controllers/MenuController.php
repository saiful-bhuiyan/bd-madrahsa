<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App;

class MenuController extends Controller
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
            $data = menu::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('parent',function($v){
                        if($v->parent_id > 0)
                        {
                            $parent_name = menu::where('id',$v->parent_id)->first();
                        }
                        else
                        {
                            $parent_name = '-';
                        }

                        if($v->parent_id > 0)
                        {
                            if($this->lang == 'en')
                            {

                                return $parent_name->menu_name_en;
                            }
                            elseif($this->lang == 'bn'){
                                return $parent_name->menu_name_bn;
                            }
                        }
                        else
                        {
                            $parent_name = '-';
                        }

                    })
                    ->addColumn('menu_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->menu_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->menu_name_bn;
                        }
                    })
                    ->addColumn('icon',function($v){
                        return '<i class="'.$v->icon.'"></i>';
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
                                <input type="checkbox" id="menuStatus-'.$v->id.'" '.$checked.' onclick="return menuStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('menu.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('menu.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['action','sl','parent','menu_name','icon','status'])
                    ->make(true);
        }
        return view('backend.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = menu::where('type',1)->get();
        return view('backend.menu.create',compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $data = array(
            'parent_id'=>$request->parent_id,
            'menu_name_en'=>$request->menu_name_en,
            'menu_name_bn'=>$request->menu_name_bn,
            'route_name'=>$request->route_name,
            'icon'=>$request->icon,
            'order_by'=>$request->order_by,
            'type'=>$request->type,
            'status'=>$request->status,
        );

        menu::create($data);


        Toastr::success(__('menu.create_message'), __('common.success'));
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
        $parent = menu::where('type',1)->get();
        $data = menu::find($id);
        return view('backend.menu.edit',compact('parent','data'));
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
            'parent_id'=>$request->parent_id,
            'menu_name_en'=>$request->menu_name_en,
            'menu_name_bn'=>$request->menu_name_bn,
            'route_name'=>$request->route_name,
            'icon'=>$request->icon,
            'order_by'=>$request->order_by,
            'type'=>$request->type,
            'status'=>$request->status,
        );

        menu::find($id)->update($data);
        Toastr::success(__('menu.update_message'), __('common.success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;

        menu::find($id)->delete();
        Toastr::success(__('menu.delete_message'), __('common.success'));
        return redirect()->back();

    }

    public function menuStatusChange($id)
    {
       $check = menu::find($id);

       if($check->status == 1)
       {
            menu::find($id)->update(['status'=>0]);
       }
       else
       {
            menu::find($id)->update(['status'=>1]);
       }

       return 1;
    }

    public function retrive_menu($id)
    {
        menu::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('menu.retrive_message'), __('common.success'));
        return redirect()->back();
    }
    public function menu_per_delete($id)
    {
        menu::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('menu.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
