<?php

namespace App\Http\Controllers;

use App\Http\Requests\Faq\FaqRequest;
use App\Models\FaqsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    public function index()
    {
        $active = 'faq';
        $data = FaqsModel::get();
        return view('admin.page.blog', compact('active', 'data'));
    }

    public function store(Request $request)
    {
        $messages = [
            'question.required' => 'pertanyaan harus diisi',
            'answer.required' => 'jawaban harus diisi',
        ];

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required'
        ], $messages);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        FaqsModel::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => true
        ]);

        Alert::toast('Sukses menambah FAQ', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $messages = [
            'question.required' => 'pertanyaan harus diisi',
            'answer.required' => 'jawaban harus diisi',
        ];

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }
        $data = FaqsModel::findOrFail($request->id);
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->save();

        Alert::toast('Sukses merubah FAQ', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        FaqsModel::findOrFail($request->id)->delete();
        Alert::toast('Sukses menghapus FAQ', 'success');
        return back();
    }
}
