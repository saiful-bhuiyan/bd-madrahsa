<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher_crud;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class TeacherCrudController extends Controller
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
            $data = teacher_crud::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('headline',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->headline_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->headline_bn;
                        }
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
                    ->addColumn('description',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->description_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->description_bn;
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
                                <input type="checkbox" id="teacherCrudStatus-'.$v->id.'" '.$checked.' onclick="return teacherCrudStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('image',function($v){
                        if($v->image)
                        {
                            $imageName = teacher_crud::where('id',$v->id)->first();

                            $image = url('/backend/TeacherCrudImage/'.$imageName->image);

                            return '<img src="'.$image.'" style="height : 60px; width : 90px;">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('teacher_crud.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('teacher_crud.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','title','headline','description','image','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.teacher_crud.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.teacher_crud.create');
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
            'headline_en'=>$request->headline_en,
            'headline_bn'=>$request->headline_bn,
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/teacherCrudImage/',$imageName);

            $data['image'] = $imageName;
        }

        $insert = teacher_crud::create($data);

        teacher_crud::find($insert->id)->update(['image'=>$imageName]);

        Toastr::success(__('teacher_crud.create_message'), __('common.success'));
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
        $data = teacher_crud::find($id);
        return view('backend.teacher_crud.edit',compact('data'));
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
            'headline_en'=>$request->headline_en,
            'headline_bn'=>$request->headline_bn,
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/TeacherCrudImage/'.$request->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/TeacherCrudImage/',$imageName);

            $data['image'] = $imageName;
        }

        $update = teacher_crud::find($id)->update($data);

        if($file)
        {
            teacher_crud::find($update->id)->update(['image'=>$imageName]);
        }

        

        Toastr::success(__('teacher_crud.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function teacherCrudStatusChange($id)
    {
       $check = teacher_crud::find($id);

       if($check->status == 1)
       {
            teacher_crud::find($id)->update(['status'=>0]);
       }
       else
       {
            teacher_crud::find($id)->update(['status'=>1]);
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
        teacher_crud::find($id)->delete();
        Toastr::success(__('teacher_crud.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_teacher_crud($id)
    {
        teacher_crud::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('teacher_crud.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function teacher_crud_per_delete($id)
    {
        $pathImage = teacher_crud::find($id);

        $path = public_path().'/backend/bannerImage/'.$pathImage->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            teacher_crud::where('id',$id)->withTrashed()->forceDelete();

        Toastr::success(__('teacher_crud.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
