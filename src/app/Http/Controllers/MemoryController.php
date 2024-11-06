<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMemoryRequest;
use App\Http\Requests\GetMemoryListRequest;
use App\Http\Requests\UpdateMemoryRequest;
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
    public function create(CreateMemoryRequest $request)
    {
        $this->memoryService->create(auth::getUser()->id, $request->validated());
        return redirect()->route('memory.index')->with('success', '日記が投稿されました。');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Memory $memory)
    {
        if (auth::getUser()->id != $memory->user_id) {
            abort(404); 
        }
        return view('memory.edit', compact(['memory']));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Memory $memory, UpdateMemoryRequest $request)
    {
        if (auth::getUser()->id != $memory->user_id) {
            abort(404);
        }        
        $this->memoryService->update($memory, $request->validated());
        return redirect()->route('memory.index')->with('success', '日記が更新されました。');
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
