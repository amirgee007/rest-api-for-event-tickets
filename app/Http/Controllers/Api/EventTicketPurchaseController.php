<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResponseResource;
use App\Models\Order;
use App\Models\PurchaseOrderLog;
use App\Models\Ticket;
use App\Models\TicketStub;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class EventTicketPurchaseController extends Controller
{
    public function generateBarcode() {

        $barcode = mt_rand(1000000000, 9999999999);

        // call the same function if the barcode exists already
        if (TicketStub::whereBarcode($barcode)->exists()) {
            return generateBarcodeNumber();
        }

        return $barcode;
    }

    public function purchaseTicket(Request $request){

        try {

            $validator = validator($request->all(), [
                'ticket_id' => 'required|integer',
                'user_id' => 'required|integer',
                ]);

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to Purchase Ticket. '.$validator->errors()->first());
            }


            $ticket = Ticket::find($request->ticket_id);

            if ( ! $ticket) {
                throw new \Exception('Ticket not found.');
            }

            $orderLogSavableData = $request->all();
            $orderLogSavableData['status'] = 'awaiting_payment';

            // Create Order Log.
            PurchaseOrderLog::create($orderLogSavableData);

            // Create Ticket Stub //todo: how data will calculate for those columns
            $ticketStub = TicketStub::create([
                'ticket_id' => $request->ticket_id,
                'user_id' => $request->user_id,
                'barcode' => $this->generateBarcode(),
                'row_number' => 112233,
                'section_number' => 112233,
                'group' => 'it will be group',
            ]);

            $response = new ResponseResource($ticketStub);
            $response->setHttpCode(200);
            $response->setMessage('Ticket Purchased Successfully .');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }
    }


    public function confirmTicketPayment($order_id, Request $request){

        try {

            $validator = validator($request->all(), [
                'payment_token' => 'required|min:10',
            ]);

            if ($validator->fails()) {
                throw new InvalidParameterException('Unable to Confirm payment. '.$validator->errors()->first());
            }

            $purchaseOrderLog = PurchaseOrderLog::find($order_id);

            if ( ! $purchaseOrderLog) {
                throw new \Exception('Purchase order not found.');
            }

            //update orderLogs or delete that entry
            $purchaseOrderLog->update([
               'status' => 'payment_received',
               'payment_token' => $request->payment_token,
            ]);

            // Create Order Data.
            $order = Order::create([
                'ticket_id' => $purchaseOrderLog->ticket_id,
                'user_id' => $purchaseOrderLog->user_id,
                'status' => 'payment_received',
                'payment_token' => $request->payment_token,
            ]);


            $response = new ResponseResource($order);
            $response->setHttpCode(200);
            $response->setMessage('Confirm Ticket Payment Successfully .');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function allPurchaseOrderLogs()
    {
        try {

            $response = new ResponseResource(PurchaseOrderLog::paginate(25));
            $response->setHttpCode(200);
            $response->setMessage('List of All Purchase Order Logs.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function allOrders()
    {
        try {

            $response = new ResponseResource(Order::paginate(25));
            $response->setHttpCode(200);
            $response->setMessage('List of All Orders.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

    public function allTicketStubs()
    {
        try {

            $response = new ResponseResource(TicketStub::paginate(25));
            $response->setHttpCode(200);
            $response->setMessage('List of All Ticket Stubs.');

            return $response;

        } catch (\Exception $e) {

            $response = new ResponseResource([]);
            $response->setHttpCode(400);
            $response->setMessage($e->getMessage());

            return $response->response()->setStatusCode($response->getHttpCode());
        }

    }

}
