<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Utilities\Output;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use App\Utilities\logger\AppLogger;
use App\Http\Controllers\Controller;
use App\Services\SubscriberService;

class SubscriberApi extends Controller
{
    public function __construct()
    {
        DB::beginTransaction();
    }

    public function index(Request $request)
    {
        try {
            $data = [];
            
            DB::commit();
            return Output::success("Api is working fine", $data);
        } catch (ApiException $e) {
            DB::rollBack();
            return Output::error($e->getMessage());
        } catch (Exception $e) {
            AppLogger::error($e);
            DB::rollBack();
            return Output::fatal();
        }
    }

    public function subscribe(Request $request)
    {
        try {
            $email = trim($request->input("email"));
            $full_name = trim($request->input("full_name"));
            $url = trim($request->input("url"));

            $data = [];
            SubscriberService::add($email, $full_name, $url);
            
            DB::commit();
            return Output::success("you have subscribed.", $data);
        } catch (ApiException $e) {
            DB::rollBack();
            return Output::error($e->getMessage());
        } catch (Exception $e) {
            AppLogger::error($e);
            DB::rollBack();
            return Output::fatal();
        }
    }
}