
Markei FileSystemOperations
===========================

Add "Markei\\FileSystemOperations\\Composer::run" to a script section.

In the extra section add an array with the operations. Each operation is an array, the first item is the method of a [Symfony Filesystem class](http://symfony.com/doc/current/components/filesystem.html), the next items are used as parameters.


Example: Setup WordPress core, themes and plugins via composer.

    {
        "name": "my-company/my-wordpress-site",
        "autoload": {
            "psr-4": { "": "src/" }
        },
        "repositories": [
            {
                "type":"composer",
                "url":"https://wpackagist.org"
            }
        ],
        "require": {
            "johnpbloch/wordpress": "4.6.1",
            "wpackagist-plugin/debug-bar" : "~0.8",
            "markei/filesystemoperations" : "dev-default",
        },
        "scripts": {
            "post-install-cmd": ["@wordpress-install"],
            "post-update-cmd": ["@wordpress-install"],
            "wordpress-install": ["Markei\\FileSystemOperations\\Composer::run"]
        },
        "extra": {
            "wordpress-install-dir": "vendor/johnpbloch/wordpress",
            "installer-paths": {
                "wwwroot/wordpress/wp-content/plugins/{$name}": ["type:wordpress-plugin"],
                "wwwroot/wordpress/wp-content/themes/{$name}": ["type:wordpress-theme"]
            },
            "markei-filesystemoperations": [
                ["mkdir", "wwwroot/wordpress"],
                ["mirror", "vendor/johnpbloch/wordpress/wp-admin", "wwwroot/wordpress/wp-admin", null, {"delete": true}],
                ["mirror", "vendor/johnpbloch/wordpress/wp-includes", "wwwroot/wordpress/wp-includes", null, {"delete": true}],
                ["copy", "vendor/johnpbloch/wordpress/index.php", "wwwroot/wordpress/index.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-activate.php", "wwwroot/wordpress/wp-activate.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-blog-header.php", "wwwroot/wordpress/wp-blog-header.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-comments-post.php", "wwwroot/wordpress/wp-comments-post.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-cron.php", "wwwroot/wordpress/wp-cron.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-links-opml.php", "wwwroot/wordpress/wp-links-opml.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-load.php", "wwwroot/wordpress/wp-load.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-login.php", "wwwroot/wordpress/wp-login.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-mail.php", "wwwroot/wordpress/wp-mail.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-settings.php", "wwwroot/wordpress/wp-settings.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-signup.php", "wwwroot/wordpress/wp-signup.php", true],
                ["copy", "vendor/johnpbloch/wordpress/wp-trackback.php", "wwwroot/wordpress/wp-trackback.php", true],
                ["copy", "vendor/johnpbloch/wordpress/xmlrpc.php", "wwwroot/wordpress/xmlrpc.php", true],
                ["copy", "vendor/johnpbloch/wordpress/license.txt", "wwwroot/wordpress/license.txt", true]
            ]
        }
    }
    
