<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\banner_image;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class BannerImageController extends Controller
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
            $data = banner_image::all();
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
                                <input type="checkbox" id="bannerImageStatus-'.$v->id.'" '.$checked.' onclick="return bannerImageStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('image',function($v){
                        if($v->image)
                        {
                            $imageName = banner_image::where('id',$v->id)->first();

                            $image = url('/backend/bannerImage/'.$imageName->image);

                            return '<img src="'.$image.'" style="height : 60px; width : 90px;">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('banner_image.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('banner_image.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','title','description','image','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.banner_image.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner_image.create');
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
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/bannerImage/',$imageName);

            $data['image'] = $imageName;
        }

        $insert = banner_image::create($data);

        banner_image::find($insert->id)->update(['image'=>$imageName]);

        Toastr::success(__('banner_image.create_message'), __('common.success'));
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
        $data = banner_image::find($id);
        return view('backend.banner_image.edit',compact('data'));
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
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'order_by'=>$request->order_by,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/bannerImage/'.$request->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/bannerImage/',$imageName);

            $data['image'] = $imageName;
        }

        $update = banner_image::find($id)->update($data);

        if($file)
        {
            banner_image::find($update->id)->update(['image'=>$imageName]);
        }

        

        Toastr::success(__('banner_image.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function bannerImageStatusChange($id)
    {
       $check = banner_image::find($id);

       if($check->status == 1)
       {
            banner_image::find($id)->update(['status'=>0]);
       }
       else
       {
            banner_image::find($id)->update(['status'=>1]);
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
        banner_image::find($id)->delete();
        Toastr::success(__('banner_image.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_banner_image($id)
    {
        banner_image::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('banner_image.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function banner_image_per_delete($id)
    {
        $pathImage = banner_image::find($id);

        $path = public_path().'/backend/bannerImage/'.$pathImage->image;
            if(file_exists($path))
            {
                unlink($path);
            }

        banner_image::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('banner_image.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
