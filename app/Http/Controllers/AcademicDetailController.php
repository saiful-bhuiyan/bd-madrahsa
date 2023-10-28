<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\academic_detail;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class AcademicDetailController extends Controller
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
            $data = academic_detail::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('title',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->title_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->title_bn;
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
                                <input type="checkbox" id="academicDetailStatus-'.$v->id.'" '.$checked.' onclick="return academicDetailStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('image',function($v){
                        if($v->image)
                        {
                            $imageName = academic_detail::where('id',$v->id)->first();

                            $image = url('/backend/img/academicImage/'.$imageName->image);

                            return '<img src="'.$image.'" style="height : 60px; width : 90px;">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('academic_detail.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('academic_detail.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','title','image','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.academic_detail.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.academic_detail.create');
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
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/academicImage/',$imageName);

            $data['image'] = $imageName;
        }

        $insert = academic_detail::create($data);

        academic_detail::find($insert->id)->update(['image'=>$imageName]);

        Toastr::success(__('academic_detail.create_message'), __('common.success'));
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
        $data = academic_detail::find($id);
        return view('backend.academic_detail.edit',compact('data'));
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
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/img/academicImage/'.$request->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/academicImage/',$imageName);

            $data['image'] = $imageName;
        }

        $update = academic_detail::find($id)->update($data);

        if($file)
        {
            academic_detail::find($update->id)->update(['image'=>$imageName]);
        }

        

        Toastr::success(__('academic_detail.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function academicDetailStatusChange($id)
    {
       $check = academic_detail::find($id);

       if($check->status == 1)
       {
            academic_detail::find($id)->update(['status'=>0]);
       }
       else
       {
            academic_detail::find($id)->update(['status'=>1]);
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
        academic_detail::find($id)->delete();
        Toastr::success(__('academic_detail.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_academic_detail($id)
    {
        academic_detail::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('academic_detail.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function academic_detail_per_delete($id)
    {
        $pathImage = academic_detail::find($id);

        $path = public_path().'/backend/img/academicImage/'.$pathImage->image;
            if(file_exists($path))
            {
                unlink($path);
            }

        academic_detail::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('academic_detail.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
