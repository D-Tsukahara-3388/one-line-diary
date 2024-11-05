<?php
namespace App\Repositories;

use App\Models\Memory;
use Carbon\Carbon;
use PhpParser\Builder;

class MemoryRepository
{
    /**
     * 
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
}
