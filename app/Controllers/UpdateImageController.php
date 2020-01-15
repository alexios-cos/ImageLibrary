<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Models\ImageUpdater;

class UpdateImageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function process($params)
    {
        $imageUpdater = new ImageUpdater();
        $status = $imageUpdater->updateViews((int)$params['imageId']);

        if (!$status) {
            // log
        }
    }
}
