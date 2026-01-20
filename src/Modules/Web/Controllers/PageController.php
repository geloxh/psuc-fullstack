<?php
namespace App\Modules\Web\Controllers;

use App\Web\Controllers\BaseController;

class PageController extends BaseController {
    public function about() {
        return $this->render('pages/about', [
            'title' => 'Straight Collaboration - USC Forum'
        ]);
    }
}