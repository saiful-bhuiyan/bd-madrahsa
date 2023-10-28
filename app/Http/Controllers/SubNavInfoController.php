<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\nav_item;
use App\Models\sub_nav_information;
use App\Models\sub_nav_item;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\DB;

class SubNavInfoController extends Controller
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
            $data = sub_nav_information::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sl',function($row){
                        // $i = 1;
                        return $this->sl = $this->sl+1;
                    })
                    ->addColumn('nav_id',function($v){
                        if($v->nav_id > 0)
                        {
                            $nav_item = nav_item::where('id',$v->nav_id)->first();
                        }
                        else
                        {
                            $nav_item = '-';
                        }

                        if($v->nav_id > 0)
                        {
                            if($this->lang == 'en')
                            {
                                return $nav_item->nav_name_en;
                            }
                            elseif($this->lang == 'bn')
                            {
                                return $nav_item->nav_name_bn;
                            }
                        }
                        else
                        {
                            return $nav_item = '-';
                        }

                    })
                    ->addColumn('sub_nav_id',function($v){
                        if($v->sub_nav_id > 0)
                        {
                            $sub_nav_item = sub_nav_item::where('id',$v->sub_nav_id)->first();
                        }
                        else
                        {
                            $sub_nav_item = '-';
                        }

                        if($v->sub_nav_id > 0)
                        {
                            if($this->lang == 'en')
                            {
                                return $sub_nav_item->sub_nav_name_en;
                            }
                            elseif($this->lang == 'bn')
                            {
                                return $sub_nav_item->sub_nav_name_bn;
                            }
                        }
                        else
                        {
                            return $sub_nav_item = '-';
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
                                <input type="checkbox" id="subNavInfoDetailStatus-'.$v->id.'" '.$checked.' onclick="return subNavInfoStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('image',function($v){
                        if($v->image)
                        {
                            $imageName = sub_nav_information::where('id',$v->id)->first();

                            $image = url('/backend/img/subNavInformation/'.$imageName->image);

                            return '<img src="'.$image.'" style="height : 60px; width : 90px;">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('sub_nav_information.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('sub_nav_information.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','nav_id','sub_nav_id','title','description','image','status','action'])
                    ->make(true);
        }
        return view('backend.sub_nav_information.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $nav = nav_item::get();
        return view('backend.sub_nav_information.create',compact('nav'));
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
            'sub_nav_id'=>$request->sub_nav_id,
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

            $file->move(public_path().'/backend/img/subNavInformation/',$imageName);

            $data['image'] = $imageName;
        }

        $insert = sub_nav_information::create($data);

        sub_nav_information::find($insert->id)->update(['image'=>$imageName]);

        Toastr::success(__('sub_nav_information.create_message'), __('common.success'));
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
        $nav = nav_item::get();
        $data = sub_nav_information::find($id);
        $check_sub_nav = sub_nav_item::where('id',$data->sub_nav_id)->first();
        return view('backend.sub_nav_information.edit',compact('data','nav','check_sub_nav'));
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
            'sub_nav_id'=>$request->sub_nav_id,
            'title_en'=>$request->title_en,
            'title_bn'=>$request->title_bn,
            'description_en'=>$request->description_en,
            'description_bn'=>$request->description_bn,
            'status'=>$request->status,
        );

        $file = $request->file('image');

        if($file)
        {
            $path = public_path().'/backend/img/subNavInformation/'.$request->image;
            if(file_exists($path))
            {
                unlink($path);
            }

            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/img/subNavInformation/',$imageName);

            $data['image'] = $imageName;
        }

        $update = sub_nav_information::find($id)->update($data);

        if($file)
        {
            sub_nav_information::find($update->id)->update(['image'=>$imageName]);
        }

        

        Toastr::success(__('sub_nav_information.update_message'), __('common.success'));
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
        $pathImage = sub_nav_information::find($id);

        $path = public_path().'/backend/img/subNavInformation/'.$pathImage->image;
        if(file_exists($path))
        {
            unlink($path);
        }

        sub_nav_information::find($id)->delete();
        Toastr::success(__('sub_nav_information.delete_message'), __('common.success'));
        return redirect()->back();
    }



    // To load sub nav item

    public function loadSubNavItem($nav_id)
    {
        $this->lang = config('app.locale');

        $data = DB::table('sub_nav_items')
        ->select('*')
        ->whereNotExists(function ($query) {
            $query->from('sub_nav_informations')
                ->select('*')
                ->where('sub_nav_items.id','=',DB::raw('sub_nav_informations.sub_nav_id'));
        })
        ->where('nav_id','=',$nav_id)
        ->get();
        
        if($this->lang == 'en')
        {
            $sl_data = '<option value="">Select One</option>';
        }
        elseif($this->lang == 'bn')
        {
            $sl_data = '<option value="">নির্বাচন করুন</option>';
        }


        foreach($data as $v)
        {
            if($this->lang == 'en')
            {
                $sl_data .= '<option value="'.$v->id.'">'.$v->sub_nav_name_en.'</option>';
            }
            elseif($this->lang == 'bn')
            {
                $sl_data .= '<option value="'.$v->id.'">'.$v->sub_nav_name_bn.'</option>';
            }
        }
        return $sl_data;
        
    }
}
