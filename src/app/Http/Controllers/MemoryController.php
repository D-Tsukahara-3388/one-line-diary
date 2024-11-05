<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetMemoryListRequest;
use App\Models\Memory;
use App\Services\MemoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoryController extends Controller
{
    private MemoryService $memoryService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        MemoryService $memoryService
    ) {
        $this->memoryService = $memoryService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(GetMemoryListRequest $request)
    {
        $memories = $this->memoryService->getList(auth::getUser()->id, $request->validated()); 
        return view('memory.index', compact(['memories']));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add()
    {
        return view('memory.add');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('memory.index');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        return view('memory.index');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update()
    {
        return view('memory.index');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Memory $memory)
    {
        // TODO: 
        $this->memoryService->delete($memory);
        return redirect()->route('memory.index')->with('success', '日記が削除されました。');
    }
    
}
