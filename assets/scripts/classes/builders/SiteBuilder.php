<?php
    //Builds the opening and closing of the site
    namespace builders {
        class SiteBuilder {
            //OPENING
            public static function BuildOpening($title){
                self::_buildOpening($title, false);
            }

            public static function BuildOpeningSubpage($title){
                self::_buildOpening($title, true);
            }

            private static function _buildOpening($title, $isSubpage){
                $cssAddress = ($isSubpage)?'../assets/css/styles.css':'assets/css/styles.css';
                echo "<!doctype html>\n";
                echo "<html lang='en'>\n";
                echo "\t<head>\n";
                echo "\t\t<meta charset='utf-8' />\n";
                echo "\t\t<link rel='stylesheet' href='$cssAddress' />\n";
                echo "\t\t<title>$title</title>\n";
                echo "\t</head>\n";
                echo "\t<body>\n";
                echo "\t\t<div id='siteWrapper'>\n";
                echo "\t\t\t<header id='mainHeader'>\n";
                echo "\t\t\t\t<h1>$title</h1>\n";
                echo "\t\t\t</header>\n";
                echo "\t\t\t<div id='content'>\n";
            }

            //CLOSING
            public static function BuildClosing(){
                self::_buildClosingJS(null);
            }

            public static function BuildClosingJS($subJSfiles){
                self::_buildClosingJS($subJSfiles);
            }

            private static function _buildClosingJS($subJSfiles){
                echo "\t\t\t</div><!-- content -->\n";
                echo "\t\t\t<footer id='mainFooter'>\n";
                echo "\t\t\t\t<p>The footer</p>\n";
                echo "\t\t\t</footer>\n";
                echo "\t\t</div><!-- siteWrapper -->\n";
                echo "\t\t<script src='assets/js/main.js'></script>\n";
                if (!empty($subJSfiles)){
                    foreach ($subJSfiles as $file){
                        echo "\t\t<script src='assets/js/$file.js'></script>\n";
                    }
                }
                echo "\t</body>\n";
                echo "</html>\n";
            }
        }
    }