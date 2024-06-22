<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\accounting_tree;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function get_journal_entries()
    {
        return view('client.journal.index');
    }

    public function create_journal_entries()
    {
        $accounts = accounting_tree::all();
        return view('client.journal.create',compact('accounts'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
