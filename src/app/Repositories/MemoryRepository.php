<?php
namespace App\Repositories;

use App\Models\Memory;
use Carbon\Carbon;
use PhpParser\Builder;

class MemoryRepository
{
    /**
     * 一覧検索
     * @param int $page
     * @param int $perPage
     * @param int $user_id
     * @param string $freeWord
     * @param Carbon $recordedDateFrom
     * @param Carbon $recordedDateTo
     * @return unknown
     */
    public function getList(
        int $page,
        int $perPage,
        int $userId,
        ?string $freeWord,
        ?Carbon $recordedDateFrom,
        ?Carbon $recordedDateTo,
    ) {
        $query = Memory::query()->where('user_id', $userId);
        
        // freeWord が指定されていれば検索
        if (!empty($freeWord)) {
            $query->where('sentence', 'LIKE', "%{$freeWord}%");
        }
        
        // recordedDateFrom が指定されていればフィルタ
        if ($recordedDateFrom !== null) {
            $query->where('recorded_date', '>=', $recordedDateFrom);
        }
        
        // recordedDateTo が指定されていればフィルタ
        if ($recordedDateTo !== null) {
            $query->where('recorded_date', '<=', $recordedDateTo);
        }
        
        // 最新順に並べる
        $query->orderBy('id', 'DESC');
        
        // ページネーション
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    
    /**
     * 登録
     * @param int $userId
     * @param Carbon $recordedDate
     * @param string $sentence
     * @param string $imageFilePath
     */
    public function create(
        int $userId,
        Carbon $recordedDate,
        string $sentence,
        ?string $imageFilePath,
    ){
        $memory = new Memory();
        $memory['user_id'] = $userId;
        $memory['recorded_date'] = $recordedDate;
        $memory['sentence'] = $sentence;
        $memory['image_file_path'] = $imageFilePath;
        $memory->save();
    }
    
    /**
     * 更新
     * @param int $id
     * @param int $userId
     * @param Carbon $recordedDate
     * @param string $sentence
     * @param string $imageFilePath
     */
    public function update(
        int $id,
        int $userId,
        Carbon $recordedDate,
        string $sentence,
        ?string $imageFilePath,
    ){
        $memory = Memory::findOrFail($id);
        $memory['user_id'] = $userId;
        $memory['recorded_date'] = $recordedDate;
        $memory['sentence'] = $sentence;
        if (!is_null($imageFilePath)) {
            $memory['image_file_path'] = $imageFilePath;
        }        
        $memory->save();
    }
    
}
