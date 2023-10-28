<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\board_final_result;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class BoardFinalResultController extends Controller
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
            $data = board_final_result::all();
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
                                <input type="checkbox" id="boardFinalResultStatus-'.$v->id.'" '.$checked.' onclick="return boardFinalResultStatusChange('.$v->id.')">
                                <span class="slider round"></span>
                            </label>';
                    })
                    ->addColumn('pdf_file',function($v){
                        if($v->pdf_file)
                        {
                            $pdfName = board_final_result::where('id',$v->id)->first();

                            $pdf_file = url('/backend/boardResultPdf/'.$pdfName->pdf_file);

                            return '<a href="'.$pdf_file.'" class="btn btn-sm btn-danger"><img src="'.url('/frontend/img/pdf.png').'" class="img-fluid">';
                        }
                    })
                    ->addColumn('action', function($row){

                        return '<div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> '.__('common.action').' <i class="fa fa-angle-down"></i></button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="'.route('board_final_result.edit',$row->id).'"><i class="fa fa-edit"></i> '.__('common.edit').'</a>
                            </li>
                            <li>
                            <form method="post" action="'.route('board_final_result.destroy',$row->id).'" id="deleteForm">
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
                    ->rawColumns(['sl','title','pdf_file','status','action'])
                    ->make(true);
        }
        return view('backend.board_final_result.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.board_final_result.create');
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

            $file->move(public_path().'/backend/boardResultPdf/',$pdfName);

            $data['pdf_file'] = $pdfName;
        }

        $insert = board_final_result::create($data);

        board_final_result::find($insert->id)->update(['pdf_file'=>$pdfName]);

        Toastr::success(__('board_final_result.create_message'), __('common.success'));
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
        $data = board_final_result::find($id);
        return view('backend.board_final_result.edit',compact('data'));
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
            $path = public_path().'/backend/boardResultPdf/'.$request->pdf_file;
            if(file_exists($path))
            {
                unlink($path);
            }

            $pdfName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/backend/boardResultPdf/',$pdfName);

            $data['pdf_file'] = $pdfName;
        }

        $update = board_final_result::find($id)->update($data);

        if($file)
        {
            board_final_result::find($update->id)->update(['pdf_file'=>$pdfName]);
        }

        

        Toastr::success(__('board_final_result.update_message'), __('common.success'));
        return redirect()->back();
    }

    public function boardFinalResultStatusChange($id)
    {
       $check = board_final_result::find($id);

       if($check->status == 1)
       {
            board_final_result::find($id)->update(['status'=>0]);
       }
       else
       {
            board_final_result::find($id)->update(['status'=>1]);
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
        $pathPdf = board_final_result::find($id);

        $path = public_path().'/backend/boardResultPdf/'.$pathPdf->pdf_file;
        if(file_exists($path))
        {
            unlink($path);
        }

        board_final_result::find($id)->delete();
        Toastr::success(__('board_final_result.delete_message'), __('common.success'));
        return redirect()->back();
    }
}
