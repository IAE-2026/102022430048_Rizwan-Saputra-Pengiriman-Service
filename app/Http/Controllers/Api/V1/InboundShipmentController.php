<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InboundShipment;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Services\IaeCentralService;

class InboundShipmentController extends Controller
{
    private function formatResponse($status, $message, $data = null, $code = 200)
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if ($status === 'success') {
            $response['data'] = $data;
            $response['meta'] = [
                'service_name' => 'Expedition-Service',
                'api_version' => 'v1'
            ];
        } else {
            $response['errors'] = $data;
        }

        return response()->json($response, $code);
    }

    #[OA\Get(path: "/api/v1/inbound-shipments", summary: "Mengambil daftar seluruh kargo", tags: ["Shipments"], security: [["ApiKeyAuth" => []]])]
    #[OA\Response(response: 200, description: "Berhasil mengambil data")]
    public function index()
    {
        $shipments = InboundShipment::all();
        return $this->formatResponse('success', 'Data armada logistik berhasil diambil', $shipments);
    }

    #[OA\Get(path: "/api/v1/inbound-shipments/{id}", summary: "Melacak status spesifik kargo", tags: ["Shipments"], security: [["ApiKeyAuth" => []]])]
    #[OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))]
    #[OA\Response(response: 200, description: "Berhasil mengambil detail")]
    #[OA\Response(response: 404, description: "Data tidak ditemukan")]
    public function show($id)
    {
        $shipment = InboundShipment::find($id);
        if (!$shipment) {
            return $this->formatResponse('error', 'Kargo tidak ditemukan', null, 404);
        }
        return $this->formatResponse('success', 'Detail kargo berhasil diambil', $shipment);
    }

    #[OA\Post(path: "/api/v1/inbound-shipments", summary: "Menerima data manifest", tags: ["Shipments"], security: [["ApiKeyAuth" => []]])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(properties: [new OA\Property(property: "supplier_name", type: "string"), new OA\Property(property: "manifest_data", type: "string")]))]
    #[OA\Response(response: 201, description: "Berhasil membuat data")]
    public function store(Request $request, IaeCentralService $iaeService)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string',
            'manifest_data' => 'required|string',
        ]);

        $validated['tracking_number'] = 'TRK-' . strtoupper(uniqid());
        $validated['status'] = 'on_the_way';
        $validated['estimated_arrival'] = now()->addDays(3);
        $validated['current_position'] = 'Menunggu diberangkatkan';

        $shipment = InboundShipment::create($validated);

        $logData = [
            'shipment_id' => $shipment->id,
            'tracking_number' => $shipment->tracking_number,
            'supplier_name' => $shipment->supplier_name,
            'manifest_data' => $shipment->manifest_data
        ];

        $auditResponse = $iaeService->sendAudit('InboundShipmentCreated', $logData);

        preg_match('/<iae:ReceiptNumber>(.*?)<\/iae:ReceiptNumber>/', $auditResponse, $matches);
        $receiptNumber = $matches[1] ?? null;

        if ($receiptNumber) {
            $shipment->legacy_receipt_number = $receiptNumber;
            $shipment->save();
        }

        $eventPayload = [
            'event_name' => 'InboundShipmentCreated',
            'service_name' => 'Expedition-Service',
            'api_version' => 'v1',
            'occurred_at' => now()->toIso8601String(),
            'sender' => 'TEAM-03',
            'shipment_data' => $shipment->toArray()
        ];

        $rabbitResponse = $iaeService->publishEvent([
            'routing_key' => 'shipment.created',
            'message' => $eventPayload
        ]);
    
        $responseData = [
            'shipment' => $shipment,
            'legacy_receipt' => $receiptNumber,
            'rabbitmq_status' => $rabbitResponse
        ];

        return $this->formatResponse('success', 'Data manifest diterima, jadwal dan resi berhasil diterbitkan', $responseData, 201);
    }
}