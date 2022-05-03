<?php
/**
 * Only handle App\ namespace.
 * Slendie\ namespace is handled by BASE autoload.php
 */
spl_autoload_register(function ($class) {
    if ( startsWith('App', $class) ) {
        // if ( $class != 'App\App' && $class != 'App\Http\Controllers\AppController' && $class != 'App\Controller' && $class != 'App\Models\Task' && $class != 'App\Model' ) {
        //     dd(['autoload', $class]);
        // }
        $path_to = explode('\\', $class);
        $last_ix = count( $path_to ) - 1;
        $package_path = SITE_FOLDER;
        $is_first = true;
        $class_name = "";

        foreach( $path_to as $i => $path ) {
            if ( !$is_first ) {
                $package_path .= DIRECTORY_SEPARATOR;
            }
            if ( $i == $last_ix ) {
                $class_name = $path;
            } else {
                $package_path .= strtolower( $path );
            }
            $is_first = false;
        }

        $class_path = $package_path . DIRECTORY_SEPARATOR . $class_name . ".php";
        $class_path = str_replace( DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $class_path );

        // if ( !startsWith('C:\Web\Php\slendie\app', $class_path ) ) {
        //    dd(['spl_autoload_register', $class, $class_path]);
        // }

        require_once( $class_path );
    }
});