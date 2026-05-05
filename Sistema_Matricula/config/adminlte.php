<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */
 'title' => ' Sistema de Gestión Académica',

   // 'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',
    'url'=>'/',
// <link rel="stylesheet" href="{{ asset('public/custom.css') }}">
    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<i class="fas fa-graduation-cap"></i> <b>Sistema de Gestión<br> Académica</b>',
   'logo_img' => null,
 'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
       'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
   ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-info',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    
    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */
///modificar panel del costado
    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-navy elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',


    'plugins' => [
    'CustomCSS' => [
        'active' => true,
        'files' => [
            [
                'type' => 'css',
                'asset' => false,
                'location' => '/css/estilos.css',
            ],
        ],
    ],
],

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

 'menu' => [
        // Navbar items:

        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        [
            'text' => 'Inicio',
            'url' => '/',
            'icon' => 'fas fa-home',
            'icon_color' => 'cyan',
        ],

        ['header' => 'GESTIÓN ACADÉMICA'],
        [
            'text' => 'Estudiantes',
            'url' => '/estudiantes',
            'icon' => 'fas fa-user-graduate',
            'icon_color' => 'blue',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Matrículas',
            'url' => '/matriculas',
            'icon' => 'fas fa-clipboard-list',
            'icon_color' => 'green',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Notas',
            'url' => '/notas',
            'icon' => 'fas fa-chart-bar',
            'icon_color' => 'orange',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Solicitudes de Notas',
            'url' => '/admin/solicitudes-notas',
            'icon' => 'fas fa-bell',
            'icon_color' => 'warning',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Asignaturas',
            'url' => '/asignaturas',
            'icon' => 'fas fa-book',
            'icon_color' => 'purple',
            'can' => 'admin-only',
        ],

        ['header' => 'ESTRUCTURA EDUCATIVA'],
        [
            'text' => 'Grados',
            'url' => '/grados',
            'icon' => 'fas fa-layer-group',
            'icon_color' => 'indigo',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Secciones',
            'url' => '/grupos',
            'icon' => 'fas fa-users',
            'icon_color' => 'teal',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Aulas',
            'url' => '/aulas',
            'icon' => 'fas fa-school',
            'icon_color' => 'brown',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Horarios',
            'url' => '/horarios',
            'icon' => 'fas fa-calendar-alt',
            'icon_color' => 'pink',
            'can' => 'admin-only',
        ],

        ['header' => 'PERSONAL'],
        [
            'text' => 'Docentes',
            'url' => '/docentes',
            'icon' => 'fas fa-chalkboard-teacher',
            'icon_color' => 'red',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Padres/Tutores',
            'url' => '/padres',
            'icon' => 'fas fa-user-friends',
            'icon_color' => 'yellow',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Usuarios',
            'url' => '/usuarios',
            'icon' => 'fas fa-user-cog',
            'icon_color' => 'gray',
            'can' => 'admin-only',
        ],

        ['header' => 'CONFIGURACIÓN'],
        [
            'text' => 'Configuración',
            'icon' => 'fas fa-cogs',
            'icon_color' => 'navy',
            'submenu' => [
                [
                    'text' => 'Modalidades',
                    'url' => '/modalidades',
                    'icon' => 'fas fa-cubes',
                ],
                [
                    'text' => 'Especialidades',
                    'url' => '/especialidades',
                    'icon' => 'fas fa-laptop-code',
                ],
                [
                    'text' => 'Turnos',
                    'url' => '/turnos',
                    'icon' => 'fas fa-clock',
                ],
                [
                    'text' => 'Períodos Académicos',
                    'url' => '/periodo',
                    'icon' => 'fas fa-calendar-check',
                ],
                [
                    'text' => 'Cortes Evaluativos',
                    'url' => '/cortes',
                    'icon' => 'fas fa-cut',
                ],
                [
                    'text' => 'Comarcas',
                    'url' => '/comarcas',
                    'icon' => 'fas fa-map-marked-alt',
                ],
            ],
            'can' => 'admin-only',
        ],

        ['header' => 'REPORTES'],
        [
            'text' => 'Reportes',
            'url' => '/reportesadm',
            'icon' => 'fas fa-chart-line',
            'icon_color' => 'success',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Reportes',
            'url' => '/reportes',
            'icon' => 'fas fa-chart-line',
            'icon_color' => 'success',
            'can' => 'docente-only',
        ],

        ['header' => 'ÁREA DOCENTE'],
        [
            'text' => 'Mi Horario',
            'url' => '/mi-horario',
            'icon' => 'fas fa-calendar-day',
            'icon_color' => 'warning',
            'can' => 'docente-only',
        ],
        [
            'text' => 'Mis Estudiantes',
            'url' => '/mis-estudiantes',
            'icon' => 'fas fa-user-graduate',
            'icon_color' => 'info',
            'can' => 'docente-only',
        ],
        [
            'text' => 'Cargar Notas',
            'url' => '/docente/notas/create',
            'icon' => 'fas fa-chart-bar',
            'icon_color' => 'orange',
            'can' => 'docente-only',
        ],

        ['header' => 'SISTEMA'],
        [
            'text' => 'Administradores',
            'url' => '/admins',
            'icon' => 'fas fa-user-shield',
            'icon_color' => 'danger',
            'can' => 'admin-only',
        ],
        [
            'text' => 'Ayuda',
            'icon' => 'fas fa-question-circle',
            'icon_color' => 'secondary',
            'submenu' => [
                [
                    'text' => 'Guía del Sistema',
                    'url' => '/guia-sistema',
                    'icon' => 'fas fa-book',
                ],
                [
                    'text' => 'Políticas de Privacidad',
                    'url' => '/guia-politicas',
                    'icon' => 'fas fa-user-shield',
                ],
            ],
        ],

        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
