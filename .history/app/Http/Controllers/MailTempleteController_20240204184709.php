<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\MailTempleDataTable;
use Spatie\MailTemplates\Models\MailTemplate;

class MailTempleteController extends Controller
{
    public function index(MailTempleDataTable $dataTable)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador") {
            return $dataTable->render('mailtemplete.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::guard('api')->user()->rol == "Administrador") {
            return view('mailtemplete.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador") {
            request()->validate([
                'mailable' => 'required',
                'subject' => 'required',
                'html_template' => 'required',
            ]);
            MailTemplate::create(['mailable' => $request->mailable, 'subject' => $request->subject, 'html_template' => $request->html_template]);
            return redirect()->route('mailtemplate.index')
                ->with('success', __('Email templete created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
            $mailtemplate = Mailtemplate::find($id);
            return view('mailtemplete.edit', compact('mailtemplate'));
       
    }

    public function update(Request $request, $id)
    {
            request()->validate([
                'mailable' => 'required',
                'subject' => 'required',
                'html_template' => 'required',
            ]);
            $mailtemplete = Mailtemplate::find($id);
            $mailtemplete->mailable = $request->mailable;
            $mailtemplete->subject = $request->subject;
            $mailtemplete->html_template = $request->html_template;
            $mailtemplete->update();
            return redirect()->route('mailtemplate.index')->with('success', __('Email templete updated successfully.'));
    }

    public function destroy($id)
    {
        if (\Auth::guard('api')->user()->can('delete-mailtemplate')) {
            $mailtemplete = Mailtemplate::find($id);
            $mailtemplete->delete();
            return redirect()->route('mailtemplate.index')->with('success', __('Email template deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
