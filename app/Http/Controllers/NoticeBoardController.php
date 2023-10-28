<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notice_board;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class NoticeBoardController extends Controller
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
            $data = notice_board::all();
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
                                <input type="checkbox" id="noticeBoardStatus-'.$v->id.'" '.$checked.' onclick="return noticeBoardStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('pdf_file',function($v){
                        if($v->pdf_file)
                        {
                            $pdfName = notice_board::where('id',$v->id)->first();

                            $pdf_file = url('/backend/noticePdf/'.$pdfName->pdf_file);

                            return '<a href="'.$pdf_file.'" class="btn btn-sm btn-danger"><img src="'.url('/frontend/img/pdf.png').'" class="img-fluid">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('notice_board.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('notice_board.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','title','description','pdf_file','order_by','status','action'])
                    ->make(true);
        }
        return view('backend.notice_board.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.notice_board.create');
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
            'status'=>$request->status,
        );

        $file = $request->file('pdf_file');

        if($file)
        {
            $pdfName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/noticePdf/',$pdfName);

            $data['pdf_file'] = $pdfName;
        }

        $insert = notice_board::create($data);

        notice_board::find($insert->id)->update(['pdf_file'=>$pdfName]);

        Toastr::success(__('notice_board.create_message'), __('common.success'));
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
        $data = notice_board::find($id);
        return view('backend.notice_board.edit',compact('data'));
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
            'status'=>$request->status,
        );

        $file = $request->file('pdf_file');

        if($file)
        {
            $path = public_path().'/backend/noticePdf/'.$request->pdf_file;
            if(file_exists($path))
            {
                unlink($path);
            }

            $pdfName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/noticePdf/',$pdfName);

            $data['pdf_file'] = $pdfName;
        }

        $update = notice_board::find($id)->update($data);

        if($file)
        {
            notice_board::find($update->id)->update(['pdf_file'=>$pdfName]);
        }

        

        Toastr::success(__('notice_board.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function noticeBoardStatusChange($id)
    {
       $check = notice_board::find($id);

       if($check->status == 1)
       {
            notice_board::find($id)->update(['status'=>0]);
       }
       else
       {
            notice_board::find($id)->update(['status'=>1]);
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
        notice_board::find($id)->delete();
        Toastr::success(__('notice_board.delete_message'), __('common.success'));
        return redirect()->back();
    }

    public function retrive_notice_board($id)
    {
        notice_board::where('id',$id)->withTrashed()->restore();
        Toastr::success(__('notice_board.retrive_message'), __('common.success'));
        return redirect()->back();
    }

    public function notice_board_per_delete($id)
    {
        $pathPdf = notice_board::find($id);

        $path = public_path().'/backend/noticePdf/'.$pathPdf->pdf_file;
            if(file_exists($path))
            {
                unlink($path);
            }

        notice_board::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success(__('notice_board.permenant_delete'), __('common.success'));
        return redirect()->back();
    }
}
