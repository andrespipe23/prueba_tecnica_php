<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{
    public function listing()
    {
        $user = Auth::user();
        $task = Task::where('user_id', $user->id)->paginate(5);

        return response()->json([
            'success' => true,
            'data' => $task
        ], 200);
    }

    public function show($id)
    {
        try {
            $task = Task::findOrfail($id);

            return response()->json([
                'success' => true,
                'data' => $task
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "No se encontró la tarea en el sistema.",
                'success' => false,
                'data' => []
            ], 422);
        }
    }

    public function showWeather($id)
    {
        try {
            $task = Task::findOrfail($id);

            if($task && $task->due_date) {
                $task->weather = $this->weather();
            }

            return response()->json([
                'success' => true,
                'data' => $task
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "No se encontró la tarea en el sistema.",
                'success' => false,
                'data' => []
            ], 422);
        }
    }

    public function weather()
    {
        try {
            $data = array();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?lat=7.379684&lon=-72.648648&appid=" . config('app.weather'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "accept: */*",
                    "accept-language: en-US,en;q=0.8",
                    "content-type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            $response = json_decode($response);
            curl_close($curl);

            return [
                'success' => true,
                'data' => $response
            ];
        } catch (Exception $e) {
            return [
                'message' => "Ocurrio un error al consultar la API de OpenWeatherMap API.",
                'success' => false,
                'data' => []
            ];
        }
    }

    public function store(TaskStoreRequest $request)
    {
        $task = Task::create($request->all());
        
        return response()->json([
            'message' => "La tarea " . $task->title . " se almaceno correctamente.",
            'success' => true
        ], 201);
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        try {
            $task = Task::findOrfail($id);
            $task->fill($request->all());
            $task->save();

            return response()->json([
                'message' => "La tarea " . $task->title . " se editó correctamente.",
                'success' => true
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Ocurrio un error: No se encontró la tarea en el sistema.",
                'success' => false
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $task = Task::findOrfail($id);
            $task->delete();

            return response()->json([
                'message' => "La tarea se elimino correctamente.",
                'success' => true
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Ocurrio un error: No se encontró la tarea en el sistema.",
                'success' => false
            ], 422);
        }
    }
}
