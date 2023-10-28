<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nav_item;
use App\Models\sub_nav_item;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class NavItemController extends Controller
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
            $data = nav_item::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('nav_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->nav_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->nav_name_bn;
                        }
                    })
                    ->addColumn('route_name',function($v){
                        if($v->route_name != ""){
                            return $v->route_name;
                        }
                        else{
                            return '-';
                        }
                        
                    })
                    ->addColumn('order_by',function($v){
                        return $v->order_by;
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
                                <input type="checkbox" id="navItemStatus-'.$v->id.'" '.$checked.' onclick="return navItemStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('nav_item.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('nav_item.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','nav_name','route_name','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.nav_item.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = nav_item::max('order_by') + 1;
        return view('backend.nav_item.create',compact('order'));
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
            'nav_name_en'=>$request->nav_name_en,
            'nav_name_bn'=>$request->nav_name_bn,
            'route_name'=>$request->route_name,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        nav_item::create($data);
        Toastr::success(__('nav_item.create_message'), __('common.success'));
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
        $data = nav_item::find($id);
        return view('backend.nav_item.edit',compact('data'));
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
            'nav_name_en'=>$request->nav_name_en,
            'nav_name_bn'=>$request->nav_name_bn,
            'route_name'=>$request->route_name,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        nav_item::find($id)->update($data);
        Toastr::success(__('nav_item.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function navItemStatusChange($id)
    {
       $check = nav_item::find($id);

       if($check->status == 1)
       {
            nav_item::find($id)->update(['status'=>0]);
       }
       else
       {
            nav_item::find($id)->update(['status'=>1]);
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
        $sub_nav = sub_nav_item::where('nav_id',$id)->withTrashed()->count();
        if($sub_nav > 0)
        {
            Toastr::error(__('nav_item.error_message'), __('common.error'));
        }
        else
        {
            nav_item::find($id)->delete();
            Toastr::success(__('nav_item.delete_message'), __('common.success'));
        }
        
        return redirect()->back();
    }

    public function retrive_nav_item($id)
    {
        nav_item::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('nav_item.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function nav_item_per_delete($id)
    {
        nav_item::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('nav_item.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}