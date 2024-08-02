<?php

namespace Modules\Core\Policies;

use App\Policies\PsPolicy;
use Modules\Core\Constants\Constants;
use Modules\Core\Entities\LandingPage;

class PsxLandingPagePolicy extends PsPolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $module = Constants::landingPageModule;
        $model = LandingPage::class;
        parent::__construct($module, $model);
    }
}
