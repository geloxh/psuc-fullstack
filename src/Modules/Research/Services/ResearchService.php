<?php
namespace App\Modules\Research\Services;

use App\Core\Database\Repository;

class ResearchService extends Repository {
    protected $table = 'research_collaborations';

    public function getOpenCollaborations() {
        return $this->query("SELECT * FROM {$this->table} WHERE status = 'open' ORDER BY created_at DESC");
    }
}