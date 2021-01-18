<?php

return [
    // Register create multiple pages in a pagetree
    'pagetree_new' => [
        'path'   => '/pagetree/new',
        'target' => \MichielRoos\WizardCrpagetree\Controller\NewPagetreeController::class . '::mainAction'
    ]
];
