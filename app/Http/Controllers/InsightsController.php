<?php

namespace App\Http\Controllers;

use App\Core\Request\InsightsRequest;
use App\Insight;
use Illuminate\Http\Request;

class InsightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insight = new InsightsRequest();

        return $insight->process();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Insight $insight
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Insight $insight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Insight $insight
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Insight $insight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Insight             $insight
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insight $insight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insight $insight
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insight $insight)
    {
        //
    }
}
