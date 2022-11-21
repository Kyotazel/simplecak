
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | General settings
     |--------------------------------------------------------------------------
     |
     | General settings for configuring the PageBuilder.
     | If you install phpb with Composer, general.assets_url line must be:
     | 'assets_url' => '/vendor/hansschouten/phpagebuilder/dist',
     |  type :
     | (1 = Master data), (2 = Transaksi), (3 = Laporan), (4 = CMS), (5 = Setting & Configuration) 
     */
    'general' => [
        'name' => 'examination',
        'description' => 'No description',
        'type'=>0
    ],

    /*
     |--------------------------------------------------------------------------
     | Routing Credential settings
     |--------------------------------------------------------------------------
     |
     | We have 4 kind of credential for each route
     | 1. public = everyone can see
     | 2. create = for create access
     | 3. edit = for edit access
     | 4. delete = for delete access 
     |
     */
    'routes' => [
        'index' => 'public',
    ]
];
    
            