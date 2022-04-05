<?php

namespace App\Http\Controllers;

use App\Models\MessageTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TicketsController extends Controller
{
    // permite ver la vista de creacion del ticket

    public function create()
    {
        return view('tickets.create');
    }

    // permite la creacion del ticket

    public function store(Request $request)
    {
        Ticket::create([
            'iduser' => Auth::id(),
            'issue' => request('issue'),
            'priority' => request('priority'),

        ]);

        $ticket_create = Ticket::where('iduser', Auth::id())->orderby('created_at', 'DESC')->take(1)->get();
        $id_ticket = $ticket_create[0]->id;

        $ticket_create = Ticket::where('iduser', Auth::id())->orderby('created_at', 'DESC')->take(1)->get();
        $id_ticket = $ticket_create[0]->id;

        MessageTicket::create([
            'id_user' => Auth::id(),
            'id_admin' => '1',
            'id_ticket' => $id_ticket,
            'type' => '0',
            'message' => request('message'),
        ]);

        return redirect()->route('ticket.list-user')->with('msj-success', 'El Ticket se creo Exitosamente');
    }

    // permite editar el ticket

    public function editUser($id)
    {
        $ticket = Ticket::find($id);
        $message = MessageTicket::where('id_ticket', $id)->orderby('created_at', 'ASC')->get();

        return view('tickets.componenteTickets.user.edit-user')
            ->with('ticket', $ticket)
            ->with('message', $message);
    }

    // permite actualizar el ticket

    public function updateUser(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->update($request->all());
        $ticket->save();

        MessageTicket::create([
            'id_user' => Auth::id(),
            'id_admin' => '1',
            'id_ticket' => $ticket->id,
            'type' => '0',
            'message' => request('message'),
        ]);

        return redirect()->back();
    }

    // permite ver la lista de tickets

    public function listUser(Request $request)
    {
        $ticket = Ticket::where('iduser', Auth::id())->get();

        return view('tickets.componenteTickets.user.list-user')
            ->with('ticket', $ticket);
    }

    // permite ver el ticket

    public function showUser($id)
    {
        $ticket = Ticket::find($id);
        $message = MessageTicket::all()->where('id_ticket', $id);

        return view('tickets.componenteTickets.user.show-user')
            ->with('ticket', $ticket)
            ->with('message', $message);
    }

    // permite editar el ticket

    public function editAdmin($id)
    {
        $ticket = Ticket::find($id);
        $message = MessageTicket::where('id_ticket', $id)->orderby('created_at', 'ASC')->get();

        return view('tickets.componenteTickets.admin.edit-admin')
            ->with('ticket', $ticket)
            ->with('message', $message);
    }

    // permite actualizar el ticket

    public function updateAdmin(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->update($request->all());
        $ticket->save();

        MessageTicket::create([
            'id_user' => $ticket->iduser,
            'id_admin' => Auth::id(),
            'id_ticket' => $ticket->id,
            'type' => '1',
            'message' => request('message'),
        ]);

        return redirect()->back();
    }

    // permite ver la lista de tickets

    public function listAdmin()
    {
        $ticket = Ticket::all();

        return view('tickets.componenteTickets.admin.list-admin')
            ->with('ticket', $ticket);
    }

    // permite ver el ticket

    public function showAdmin($id)
    {
        $ticket = Ticket::find($id);
        $message = MessageTicket::all()->where('id_ticket', $id);

        return view('tickets.componenteTickets.admin.show-admin')
            ->with('ticket', $ticket)
            ->with('message', $message);
    }

    /**
     * Permite obtener la cantidad de Tickets que tiene un usuario.
     *
     * @param int $iduser
     */
    public function getTotalTickets($iduser): int
    {
        try {
            $Tickets = Ticket::where('iduser', $iduser)->get()->count('id');
            if ($iduser == 1) {
                $Tickets = Ticket::all()->count('id');
            }

            return $Tickets;
        } catch (Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite obtener el total de Tickets por meses.
     *
     * @param int $iduser
     */
    public function getDataGraphiTickets($iduser): array
    {
        try {
            $totalTickets = [];
            if (Auth::user()->admin == 1) {
                $Tickets = Ticket::select(DB::raw('COUNT(id) as Tickets'))
                    ->where([
                        ['status', '>=', 0],
                    ])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            } else {
                $Tickets = Ticket::select(DB::raw('COUNT(id) as Tickets'))
                    ->where([
                        ['iduser', '=',  $iduser],
                        ['status', '>=', 0],
                    ])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            }
            foreach ($Tickets as $ticket) {
                $totalTickets[] = $ticket->Tickets;
            }

            return $totalTickets;
        } catch (Throwable $th) {
            dd($th);
        }
    }
}
