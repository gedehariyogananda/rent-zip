<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CostumService;
use App\Models\Category;
use Illuminate\Http\Request;

class CostumController extends Controller
{
    protected CostumService $costumService;

    public function __construct(CostumService $costumService)
    {
        $this->costumService = $costumService;
    }

    public function index()
    {
        $costums = $this->costumService->getAll();
        $sourceCategories = Category::where("type", "source_anime")->get();
        $brandCategories = Category::where("type", "brand")->get();
        return view(
            "member.costums.index",
            compact("costums", "sourceCategories", "brandCategories"),
        );
    }

    public function show($id)
    {
        $costum = $this->costumService->find($id);
        return view("member.costums.show", compact("costum"));
    }
}
