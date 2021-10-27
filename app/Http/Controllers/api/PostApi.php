<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Utilities\Output;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use App\Utilities\logger\AppLogger;
use App\Http\Controllers\Controller;
use App\Services\SubscriberService;

class PostApi extends Controller
{
    public function __construct()
    {
        DB::beginTransaction();
    }

    public function add(Request $request)
    {
        try {
            $url = trim($request->input("url"));
            $title = trim($request->input("title"));
            $description = trim($request->input("description"));

            $data = PostService::add($url, $title, $description);
            
            DB::commit();
            return Output::success("post has created.", $data);
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