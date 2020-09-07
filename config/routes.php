<?php

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\App;
use App\Action;

return function (App $app) {
    $app->redirect('/releases/AA_GLOBAL/latest[/[index.html]]', '/classes', 301);
    $app->get('/releases/{release:(?:0.9|0.95|1.0|1.0.1|1.0.2)}', Action\HistoricalReleasesAction::class . ':index');
    $app->get('/releases/{release:(?:0.9|0.95|1.0|1.0.1|1.0.2)}/{asset:.+}', Action\HistoricalReleasesAction::class . ':assets');
    $app->get('/releases/UML/latest/{asset:.*}', Action\UMLViewerAction::class . ':assets');
    $app->get('/releases/{component:ITS-XML|ITS-JSON}/{release}/components[/[{asset:.+}]]', Action\ITSDirViewerAction::class);
    $app->get('/releases/{component}/{alias:open_issues|roadmap|history|crs}', Action\RedirectAction::class . ':jira');
    $app->get('/releases/{component}/{release}/{alias:issues|changes}', Action\RedirectAction::class . ':jira');
    $app->get('/releases/{component}[/[{release}[/[index[.html]]]]]', Action\SpecViewerAction::class . ':index');
    $app->get('/releases/{component}/{release}/UML/{asset:.+\.mdzip}', Action\SpecViewerAction::class . ':uml');
    $app->get('/releases/{component}/{release}/{asset:.+\.(?:png|svg|html|xml|drawio|docx|g|jj)}', Action\SpecViewerAction::class . ':assets');
    $app->get('/releases/{component}/{release}/{spec}', Action\SpecViewerAction::class . ':specs');
    $app->get('/[working_baseline]', Action\WorkingBaselineAction::class);
    $app->get('/classes[/{class}]', Action\WorkingBaselineAction::class . ':classes');
    $app->get('/manifest', Action\WorkingBaselineAction::class . ':manifest');
    $app->get('/search', Action\SearchAction::class);
    $app->get('/latest_releases', Action\ReleasesAction::class);
    $app->get('/historical_releases', Action\HistoricalReleasesAction::class);
    // hooks
    $app->get('/hook/populate_releases', Action\HookAction::class . ':populate_releases');
    $app->get('/scripts/spec_populate_releases[.php]', Action\HookAction::class . ':populate_releases');
    // redirects
    $app->redirect('/wiki/display/spec/Specifications+Home', 'https://openehr.atlassian.net/wiki/spaces/spec/overview', 301);
    $app->redirect('/Services+Landscape+for+e-Health', 'https://openehr.atlassian.net/wiki/spaces/spec/pages/357957633/Services+Landscape+for+e-Health', 301);
};

