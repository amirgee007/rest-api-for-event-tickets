<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResponseResource;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TicketsController extends Controller
{
    public function index()
    {
        try {

            $response = new ResponseResource(Ticket::paginate(25));
            $response->setHttpCode(200);
            $response->setMessage('List of All Tickets.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function show($id)
    {
        try {

            // Get ticket.
            $ticket = Ticket::find($id);

            if ( !$ticket) {
                throw new NotFoundResourceException('Ticket not found.');
            }

            $response = new ResponseResource($ticket);
            $response->setHttpCode(200);
            $response->setMessage('Ticket found.');

            return $response;
        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function store(Request $request){

        try {

            $validator = validator($request->all(), $this->validationRules());

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to Create Ticket. '.$validator->errors()->first());
            }

            // Create Ticket.
            $ticket = Ticket::create($request->all());

            $response = new ResponseResource($ticket);
            $response->setHttpCode(200);
            $response->setMessage('Ticket created Successfully.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }

    public function update($id , Request $request)
    {
        try {

            $ticket = Ticket::find($id);

            $validator = validator($request->all(), $this->validationRules());

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to Update Ticket. '.$validator->errors()->first());
            }

           //update ticket we can also done by fill method as well as with array method too
            $ticket->update($request->all());
            $response = new ResponseResource($ticket);
            $response->setHttpCode(200);
            $response->setMessage('Ticket Updated Successfully.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }

    public function destroy($id)
    {
        try {

            $ticket = Ticket::find($id);
            if ( ! $ticket) {
                throw new \Exception('Ticket not found.');
            }

            $isDeleted = $ticket->delete();

            if ( ! $isDeleted) {
                throw new \Exception('Unable to delete Ticket.');
            }

            $response = new ResponseResource([]);
            $response->setHttpCode(200);
            $response->setMessage('Ticket Deleted Successfully.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }


    public function validationRules(){

        return [
            'uid' => 'required|string',
            'event_id' => 'required|integer',
            'event_ticket_id' => 'required|integer',
            'is_free' => 'required|boolean',
            'title' => 'required|string',
            'description' => 'required|string',
            'ticket_price_tag' => 'required|string',
            'service_charge' => 'required|string',
            'is_fee_absorbed' => 'required|boolean',
            'has_sale_date' => 'required|boolean',
            'sale_start_time' => 'required|date',
            'sale_end_time' => 'required|date',
            'ticket_sell_limit' => 'required|integer',
            'ticket_buy_limit' => 'required|boolean',
        ];
    }
}
