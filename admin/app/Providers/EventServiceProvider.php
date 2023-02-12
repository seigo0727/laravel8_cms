<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\SideMenuItem;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $items = $this->getSideMenuItems();

            if($items['master']->isNotEmpty()) {
                $event->menu->add('マスター');
                foreach($items['master'] as $item) {
                    if($item->type === 'link') {
                        $event->menu->add([
                            'text' => $item->title,
                            'url' => 'master/' . $item->route,
                            'icon' => $item->icon,
                        ]);    
                    }
                }
            }

        });
    }

    public function getSideMenuItems()
    {
        $items = [
            'default' => null,
            'master' => null,
        ];

        $items['master'] = SideMenuItem::query()->whereNull('parent_id')->where('belong_to', '=', 'master')
            ->orderBy('sort_num')->get();

            return $items;
    }
}
