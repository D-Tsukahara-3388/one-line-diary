<?php
namespace App\Services;

use App\Models\Memory;
use App\Repositories\MemoryRepository;

class MemoryService
{
    private MemoryRepository $memoryRepository;
    
    /**
     * 
     */
    public function __construct(
        MemoryRepository $memoryRepository
    ) {
        $this->memoryRepository = $memoryRepository;
    }
    
    /**
     * 
     * @param int $user_id
     * @param array $payload
     */
    public function getList(int $user_id, array $payload) 
    {
       $search = $payload['search']; 
       return $this->memoryRepository->getList(
           page: $payload['page'],
           perPage: $payload['per_page'],
           userId: $user_id,
           freeWord: $search['free_word'],
           recordedDateFrom: $search['recorded_date_from'],
           recordedDateTo: $search['recorded_date_to'],
       );
    }
    
    /**
     * 
     * @param Memory $memory
     */
    public function delete(Memory $memory)
    {
        // TODO:
        $memory->delete();
    }
    
}

