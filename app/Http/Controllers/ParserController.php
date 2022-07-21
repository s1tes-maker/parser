<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\Process\Process;


class ParserController extends Controller
{
    public function parse(Request $request) {
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        $input = $request->all();

        $rules = [
            'url' => 'required|string|url',
            'count' => 'required|integer|between:1,500',
            'suggest_price' => 'in:true,false',
            'suggest_price_message' => 'string',
            'discount.min' => 'required_if:suggest_price,true',
            'discount.max' => 'required_if:suggest_price,true'
        ];

        $messages = [
            'required' => 'Поле :attribute не должно быть пустым',
            'url' => 'Текст не является ссылкой',
            'integer' => 'Введите целое значение',
            'between' => 'Введите значение от :min до :max',
            'boolean' => ':attribute значение должно быть true или false',
            'required_if' => ':attribute заполните поле'
        ];

        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $key=>$value) {
                return response()->json([
                    'message'=>$value] )->setStatusCode(422);
            }
        }

        $deleted = DB::connection('mysql2')->table('configs')->whereNull('status')->delete();

        $config = Config::create([
            'avito_data' =>[
                'url' => $input['url'],
                'count' => $input['count'],
                'suggest_price' => $input['suggest_price'] == "true" ? 1 : 0,
                'suggest_price_message' => $input['suggest_price_message'] ?? '',
                'discount_min' => $input['discount']['min'],
                'discount_max' => $input['discount']['max']
                ],
            'process_id' => random_int(100000, 999999),
            'status' => 'transfer_control_to_parser',
            'user_id' => $user->id
            ]);

        chdir(\Config::get('app.path_to_python_parser_script'));

        $array_cmd = ( \Config::get('app.env') == 'local' ?
            ['start', '/B',\Config::get('app.run_python_filename'), $config->process_id] :
            ['./' . \Config::get('app.run_python_filename'), $config->process_id]);
        $process = new Process($array_cmd);

        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json([
                'status'=>422,
                'message'=>$process->getErrorOutput()] )->setStatusCode(422);
        }

        return response()->json([
            'status'=>200,
            'process_id'=>$config->process_id] );
    }

    public function process_statuses(Request $request) {
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        return response()->json([
            'status'=>200,
            'body'=>$user->python_processes] );
    }

    public function process_status(Request $request) {
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        return response()->json([
            'status'=>200,
            'body'=>$user->python_processes->where('process_id', $request->id)->first()] );
    }
}
