<?php

    // Replace this string your opt_name
    $opt_name = 'redux_extensions_demo';

    Redux::setExtensions( 'redux_demo', dirname( __FILE__ ) . '../extensions/advanced_customizer' );
    Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '../extensions/advanced_customizer' );

    // Replace this string your opt_name
    $opt_name = 'redux_extensions_demo';

    Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/extensions/' );


