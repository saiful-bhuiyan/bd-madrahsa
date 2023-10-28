<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nav_item;
use App\Models\sub_nav_item;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class SubNavItemController extends Controller
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
            $data = sub_nav_item::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('nav_name',function($v){
                        if($v->nav_id > 0)
                        {
                            $nav_name = nav_item::where('id',$v->nav_id)->first();
                        }
                        else
                        {
                            $nav_name = '-';
                        }

                        if($v->nav_id > 0)
                        {
                            if($this->lang == 'en')
                            {
                                return $nav_name->nav_name_en;
                            }
                            elseif($this->lang == 'bn')
                            {
                                return $nav_name->nav_name_bn;
                            }
                        }
                        else
                        {
                            return $nav_name = '-';
                        }

                    })
                    ->addColumn('sub_nav_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->sub_nav_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->sub_nav_name_bn;
                        }
                    })
                    ->addColumn('route_name',function($v){
                        if($v->route_name != "")
                        {
                            return $v->route_name;
                        }
                        else{
                            return '-';
                        }
                        
                    })
                    ->addColumn('order_by',function($v)
                    {
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
                                <input type="checkbox" id="subNavItemStatus-'.$v->id.'" '.$checked.' onclick="return subNavItemStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('sub_nav_item.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('sub_nav_item.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','nav_name','sub_nav_name','route_name','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.sub_nav_item.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nav = nav_item::all();
        return view('backend.sub_nav_item.create',compact('nav'));
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
            'nav_id'=>$request->nav_id,
            'sub_nav_name_en'=>$request->sub_nav_name_en,
            'sub_nav_name_bn'=>$request->sub_nav_name_bn,
            'route_name'=>$request->route_name,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        sub_nav_item::create($data);
        Toastr::success(__('sub_nav_item.create_message'), __('common.success'));
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
        $nav = nav_item::all();
        $data = sub_nav_item::find($id);
        return view('backend.sub_nav_item.edit',compact('nav','data'));
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
            'nav_id'=>$request->nav_id,
            'sub_nav_name_en'=>$request->sub_nav_name_en,
            'sub_nav_name_bn'=>$request->sub_nav_name_bn,
            'route_name'=>$request->route_name,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        sub_nav_item::find($id)->update($data);
        Toastr::success(__('sub_nav_item.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function subNavItemStatusChange($id)
    {
       $check = sub_nav_item::find($id);

       if($check->status == 1)
       {
           sub_nav_item::find($id)->update(['status'=>0]);
       }
       else
       {
           sub_nav_item::find($id)->update(['status'=>1]);
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
        sub_nav_item::find($id)->delete();
        Toastr::success(__('sub_nav_item.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_sub_nav_item($id)
    {
        sub_nav_item::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('sub_nav_item.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function sub_nav_item_per_delete($id)
    {
        sub_nav_item::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('sub_nav_item.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}