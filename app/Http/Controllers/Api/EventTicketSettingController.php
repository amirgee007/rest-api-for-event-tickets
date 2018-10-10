<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResponseResource;
use App\Models\EventTicketSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class EventTicketSettingController extends Controller
{
    public function index()
    {
        try {

            $response = new ResponseResource(EventTicketSetting::all());
            $response->setHttpCode(200);
            $response->setMessage('List of All Event Ticket Setting.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function show($event_id)
    {
        try {
            // Get Event ticket setting.
            $ticketSetting = EventTicketSetting::where('event_id',$event_id)->first();

            if ( !$ticketSetting) {
                throw new NotFoundResourceException('Event Ticket Setting not found.');
            }

            $response = new ResponseResource($ticketSetting);
            $response->setHttpCode(200);
            $response->setMessage('Event Ticket Setting found.');

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
                throw new InvalidParameterException('Unable to Create Event Ticket Setting. '.$validator->errors()->first());
            }

            // Create Event Ticket Setting.
            $ticket = EventTicketSetting::create($request->all());

            $response = new ResponseResource($ticket);
            $response->setHttpCode(200);
            $response->setMessage('Event Ticket Setting created Successfully.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource($request);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }

    public function update($event_id , Request $request)
    {
        try {

            $ticketSetting = EventTicketSetting::where('event_id',$event_id)->first();

            $validator = validator($request->all(), $this->validationRules());

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to Update Event Ticket Setting. '.$validator->errors()->first());
            }

            $ticketSetting->update($request->all());
            $response = new ResponseResource($ticketSetting);
            $response->setHttpCode(200);
            $response->setMessage('Event Ticket Setting Updated Successfully.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource($request);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }

    public function destroy($event_id)
    {
        try {

            $ticketSetting = EventTicketSetting::where('event_id',$event_id)->first();

            if ( ! $ticketSetting) {
                throw new \Exception('Event Ticket Setting not found.');
            }

            $isDeleted = $ticketSetting->delete();

            if ( ! $isDeleted) {
                throw new \Exception('Unable to delete Event Ticket Setting.');
            }

            $response = new ResponseResource([]);
            $response->setHttpCode(200);
            $response->setMessage('Event Ticket Setting Deleted Successfully.');

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
            'currency' => 'required|string|max:3',
            'country' => 'required|string|max:3',
            'payment_account' => 'required|integer',
            'show_remaining' => 'required|boolean',
            'sale_start_time' => 'required|date',
            'sale_end_time' => 'required|date',
        ];
    }
}

