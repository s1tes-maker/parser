<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParserController extends Controller
{
    public function parse(Request $request) {

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

        $deleted = DB::connection('mysql2')->table('configs')->whereNull('processing')->delete();

        $config = Config::create([
            'avito_data' =>[
                'url' => $input['url'],
                'count' => $input['count'],
                'suggest_price' => $input['suggest_price'] == "true" ? 1 : 0,
                'suggest_price_message' => $input['suggest_price_message'] ?? null,
                'discount_min' => $input['discount']['min'],
                'discount_max' => $input['discount']['max']
                ]
            ]);

        return response()->json([
            'status'=>200] );
    }
}
