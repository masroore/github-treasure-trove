<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TicketResource::collection(Ticket::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TicketStoreRequest $request)
    {
        $created_schedule = Ticket::create($request->validated());

        return new TicketResource($created_schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TicketResource(Ticket::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TicketStoreRequest $request, $id)
    {
        $ticket = Ticket::where('deleted', '<', 1)->findOrFail($id);
        $ticket->update($request->validated());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->deleted = (int) !$ticket->deleted;
        $ticket->update();

        return $ticket;
    }
}
