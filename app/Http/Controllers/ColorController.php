<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\color;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class ColorController extends Controller
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
            $data = color::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('color_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->color_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->color_name_bn;
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
                                <input type="checkbox" id="colorStatus-'.$v->id.'" '.$checked.' onclick="return colorStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('action', function($row){



                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('color.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('color.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','color_name','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.color.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.color.create');
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
            'color_name_en'=>$request->color_name_en,
            'color_name_bn'=>$request->color_name_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        color::create($data);
        Toastr::success(__('color.create_message'), __('common.success'));
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
        $data = color::find($id);
        return view('backend.color.edit',compact('data'));
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
            'color_name_en'=>$request->color_name_en,
            'color_name_bn'=>$request->color_name_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );
        color::find($id)->update($data);
        Toastr::success(__('color.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function colorStatusChange($id)
    {
       $check = color::find($id);

       if($check->status == 1)
       {
            color::find($id)->update(['status'=>0]);
       }
       else
       {
            color::find($id)->update(['status'=>1]);
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
        color::find($id)->delete();
        Toastr::success(__('color.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_color($id)
    {
        color::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('color.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function color_per_delete($id)
    {
        color::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('color.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
