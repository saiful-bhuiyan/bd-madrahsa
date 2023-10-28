<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\academic_detail;
use App\Models\sub_academic_detail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use DataTables;

class SubAcademicDetailController extends Controller
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
            $data = sub_academic_detail::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('academic_detail',function($v){
                        if($v->ad_id > 0)
                        {
                            $academic_detail = academic_detail::where('id',$v->ad_id)->first();
                        }
                        else
                        {
                            $academic_detail = '-';
                        }

                        if($v->ad_id > 0)
                        {
                            if($this->lang == 'en')
                            {
                                return $academic_detail->title_en;
                            }
                            elseif($this->lang == 'bn')
                            {
                                return $academic_detail->title_bn;
                            }
                        }
                        else
                        {
                            return $academic_detail = '-';
                        }

                    })
                    ->addColumn('item_name',function($v){
                        if($this->lang == 'en')
                        {
                            return $v->item_name_en;
                        }
                        elseif($this->lang == 'bn')
                        {
                            return $v->item_name_bn;
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
                            $desc = Str::limit($v->description_en, 20);
    
                            return $desc;
                        }
                        elseif($this->lang == 'bn')
                        {
                            $desc = Str::limit($v->description_bn, 20);
    
                            return $desc;
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
                                <input type="checkbox" id="subAcademicDetailStatus-'.$v->id.'" '.$checked.' onclick="return subAcademicDetailStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('image',function($v){
                        if($v->image)
                        {
                            $imageName = sub_academic_detail::where('id',$v->id)->first();

                            $image = url('/backend/img/subAcademicImage/'.$imageName->image);

                            return '<img src="'.$image.'" style="height : 60px; width : 90px;">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('sub_academic_detail.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('sub_academic_detail.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','academic_detail','item_name','title','description','image','status','action'])
                    ->make(true);
        }
        return view('backend.sub_academic_detail.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academic = academic_detail::where('status',1)->get();

        return view('backend.sub_academic_detail.create',compact('academic'));
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
            'ad_id'=>$request->ad_id,
            'item_name_en'=>$request->item_name_en,
            'item_name_bn'=>$request->item_name_bn,
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/subAcademicImage/',$imageName);

            $data['image'] = $imageName;
        }

        $insert = sub_academic_detail::create($data);

        sub_academic_detail::find($insert->id)->update(['image'=>$imageName]);

        Toastr::success(__('sub_academic_detail.create_message'), __('common.success'));
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
        $academic = academic_detail::where('status',1)->get();
        $data = sub_academic_detail::find($id);
        return view('backend.sub_academic_detail.edit',compact('data','academic'));
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
            'ad_id'=>$request->ad_id,
            'item_name_en'=>$request->item_name_en,
            'item_name_bn'=>$request->item_name_bn,
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/img/subAcademicImage/'.$request->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/subAcademicImage/',$imageName);

            $data['image'] = $imageName;
        }

        $update = sub_academic_detail::find($id)->update($data);

        if($file)
        {
            sub_academic_detail::find($update->id)->update(['image'=>$imageName]);
        }

        

        Toastr::success(__('sub_academic_detail.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function subAcademicDetailStatusChange($id)
    {
       $check = sub_academic_detail::find($id);

       if($check->status == 1)
       {
            sub_academic_detail::find($id)->update(['status'=>0]);
       }
       else
       {
            sub_academic_detail::find($id)->update(['status'=>1]);
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
        sub_academic_detail::find($id)->delete();
        Toastr::success(__('sub_academic_detail.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_sub_academic_detail($id)
    {
        sub_academic_detail::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('sub_academic_detail.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function sub_academic_detail_per_delete($id)
    {
        $pathImage = sub_academic_detail::find($id);

        $path = public_path().'/backend/img/subAcademicImage/'.$pathImage->image;
            if(file_exists($path))
            {
                unlink($path);
            }

        sub_academic_detail::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('sub_academic_detail.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
