/**
 * Detect the Users Browser agent and determine which OS version is used.
 * @returns {string}
 */
function detect_mobileOS() {

    var deviceAgent = navigator.userAgent;
    var is_android = ( deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /Android\s/i ));
    var is_ios = (deviceAgent.match( /iPad/i ) || deviceAgent.match( /iPhone/i ) || deviceAgent.match( /iPod/i ));
    var os = '';

    if (is_android) {
        os = 'android';
    } else if (is_ios) {
        os = 'ios';
    }

    return os;

}

/**
 * Detect the Users Browser agent and determine which Browser is used.
 * @returns {string}
 */
function detect_mobileBrowser() {

    var deviceAgent = navigator.userAgent;

    var is_chrome = (deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /AppleWebKit/i ) && deviceAgent.match( /Chrome/i ));
    var is_safari = (deviceAgent.match( /Mozilla\/5.0/i )  && deviceAgent.match( /AppleWebKit/i ) && deviceAgent.match( /Safari/i ));

    var browser = '';

    if (is_chrome) {
        browser = 'chrome';
    } else if (is_safari) {
        browser = 'safari';
    } else {
        browser = 'fallback_browser';
    }

    return browser;

}

/**
 * Based on OS and Browser version, to the HTML tag is added the corresponding class
 */
function init_deviceAgent() {

    $("html").addClass(detect_mobileOS());
    $("html").addClass(detect_mobileBrowser());

}


// Touchmove events are cancelled on Android KitKat when scrolling is possible on the touched element.
// Scrolling is always vertical in our app. Cancel the event when a touchmove is horizontal,
// so that all following touchmove events will be raised normally.
//
// Bug Ticket : https://code.google.com/p/android/issues/detail?id=19827

function swipe_android_fix() {

    if (detect_mobileOS() == 'android') {

        var startLoc = null;

        $( "body" ).on( "touchstart", function( e ) {
            if( e.originalEvent.touches.length == 1 ) { // one finger touch
                // Remember start location.
                var touch = e.originalEvent.touches[ 0 ];
                startLoc = { x : touch.pageX, y : touch.pageY };
            }
        } );


        $( "body" ).on( "touchmove", function( e ) {
            // Only check first move after the touchstart.
            if( startLoc ) {
                var touch = e.originalEvent.touches[ 0 ];
                // Check if the horizontal movement is bigger than the vertical movement.
                if( Math.abs( startLoc.x - touch.pageX ) >
                    Math.abs( startLoc.y - touch.pageY ) ) {
                    // Prevent default, like scrolling.
                    e.preventDefault();
                }
                startLoc = null;
            }
        });

    }

}