<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller {

    private const nullPointer = "Null Pointer Exception";
    private const dataIncorrect = "Algunos datos no se han procesado correctamente";

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse Salida para la base de datos.
     */
    public function index(): JsonResponse {
        $message = DB::select(DB::raw("SELECT * FROM `message` WHERE userReceiver IS NULL"));

        try {
            return response()->json($message);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse Salida para la base de datos.
     */
    public function store(Request $request): JsonResponse {
        $message = Message::create($request->all());

        if ($message === null) {
            return response()->json(['error' => self::nullPointer]);
        }

        try {
            return response()->json(['message' => $message]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {
        $message = DB::select(DB::raw("SELECT f.*, (SELECT COUNT(*) FROM `call` c WHERE c.idFriend = f.id) AS times FROM `friend` f WHERE f.id = '$id'"));

        if (!$message) {
            return response()->json(['error' => self::nullPointer]);
        }

        try {
            return response()->json($message);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {
        $message = Message::find($id);

        if ($message === null) {
            return response()->json(['error' => self::nullPointer]);
        }

        $result = $message->update($request->all());

        if ($result === false) {
            return response()->json(['error' => self::dataIncorrect]);
        }

        try {
            return response()->json(['result' => true]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $result = Message::destroy($id);

        if ($result === null) {
            return response()->json(['error' => self::nullPointer]);
        }

        try {
            return response()->json(['result' => $result]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Destroy every message of the DB.
     *
     * @return JsonResponse Salida para la base de datos.
     */
    public function destroyAllMSG(): JsonResponse {
        $message = DB::select(DB::raw("DELETE FROM `message`"));

        try {
            return response()->json($message);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Get private messages from Sender and Receiver.
     *
     * @param string $userSend
     * @param string $userReceiver
     *
     * @return JsonResponse Salida para la base de datos.
     */
    public function getPrivateMessage(string $userSend, string $userReceiver): JsonResponse {
        $message = DB::select(DB::raw("SELECT * FROM message WHERE ((userSend = '$userReceiver' AND userReceiver = '$userSend')
                                 OR (userSend = '$userSend' AND userReceiver = '$userReceiver'))"));

        try {
            return response()->json($message);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception]);
        }
    }
}
