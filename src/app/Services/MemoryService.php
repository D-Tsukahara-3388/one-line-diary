<?php
namespace App\Services;

use App\Models\Memory;
use App\Repositories\MemoryRepository;
use Carbon\Carbon;

class MemoryService
{
    private MemoryRepository $memoryRepository;
    
    public function __construct(
        MemoryRepository $memoryRepository
    ) {
        $this->memoryRepository = $memoryRepository;
    }
    
    /**
     * 一覧取得
     * @param int $user_id
     * @param array $payload
     */
    public function getList(int $userId, array $payload) 
    {
       $search = $payload['search']; 
       return $this->memoryRepository->getList(
           page: $payload['page'],
           perPage: $payload['per_page'],
           userId: $userId,
           freeWord: $search['free_word'],
           recordedDateFrom: $search['recorded_date_from'],
           recordedDateTo: $search['recorded_date_to'],
       );
    }
    
    /**
     * 登録
     * @param int $userId
     * @param array $payload
     */
    public function create(int $userId, array $payload)
    {
        $this->memoryRepository->create(
            userId: $userId,
            recordedDate: $payload['recorded_date'],
            sentence: $payload['sentence'],
            imageFilePath: $this->uploadImage($userId, $payload['image_file_path']),
        );
    }
    
    /**
     * 更新
     * @param Memory $memory
     * @param array $payload
     */
    public function update(Memory $memory, array $payload)
    {
        $this->memoryRepository->update(
            id: $memory->id,
            userId: $memory->user_id,
            recordedDate: Carbon::parse($memory->recorded_date),
            sentence: $payload['sentence'],
            imageFilePath: $this->uploadImage($memory->user_id, $payload['image_file_path']),
        );
    }
   
    /**
     * 削除
     * @param Memory $memory
     */
    public function delete(Memory $memory)
    {
        // TODO: repository側までいって処理するべきか
        $memory->delete();
    }
    
    /**
     * 画像登録処理
     * @param unknown $userId
     * @param unknown $image
     * @return NULL|string
     */
    private function uploadImage($userId, $image) {
        $imageFilePath = null;
        
        // 画像がアップロードされた場合
        if (is_a($image, 'Illuminate\Http\UploadedFile')) {
            // ユニークなファイル名を生成（時間 + ユニークID + 拡張子）
            $fileName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // プライベートディスクに保存
            $image->storeAs("private/images/{$userId}", $fileName);
            
            // DBにファイル名のみ保存
            $imageFilePath = $fileName;
        }
        
        return $imageFilePath;
    }
    
}

