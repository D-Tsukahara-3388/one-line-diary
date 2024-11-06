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
     * 日記一覧
     * @param GetMemoryListRequest $request
     * @return unknown
     */
    public function index(GetMemoryListRequest $request)
    {
        // TODO: 検索を入れたかったが至らず
        $memories = $this->memoryService->getList(auth::getUser()->id, $request->validated()); 
        return view('memory.index', compact(['memories']));
    }
    

    /**
     * 新規投稿
     * @return unknown
     */
    public function add()
    {
        return view('memory.add');
    }

    /**
     * 登録処理
     * @param CreateMemoryRequest $request
     * @return unknown
     */
    public function create(CreateMemoryRequest $request)
    {
        $this->memoryService->create(auth::getUser()->id, $request->validated());
        return redirect()->route('memory.index')->with('success', '日記が投稿されました。');
    }

    /**
     * 投稿編集
     * @param Memory $memory
     * @return unknown
     */
    public function edit(Memory $memory)
    {
        // ログインしているユーザIDと一致しなければ閲覧できない
        if (auth::getUser()->id != $memory->user_id) {
            abort(404); 
        }
        return view('memory.edit', compact(['memory']));
    }
    
    /**
     * 更新処理
     * @param Memory $memory
     * @param UpdateMemoryRequest $request
     * @return unknown
     */
    public function update(Memory $memory, UpdateMemoryRequest $request)
    {
        // ログインしているユーザIDと一致しなければ処理できない
        if (auth::getUser()->id != $memory->user_id) {
            abort(404);
        }        
        $this->memoryService->update($memory, $request->validated());
        return redirect()->route('memory.index')->with('success', '日記が更新されました。');
    }
    
    /**
     * 削除処理
     * @param Memory $memory
     * @return unknown
     */
    public function delete(Memory $memory)
    {
        // TODO:　画像も消したい 
        $this->memoryService->delete($memory);
        return redirect()->route('memory.index')->with('success', '日記が削除されました。');
    }
    
}
